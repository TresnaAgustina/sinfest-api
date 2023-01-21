<?php

namespace App\Http\Controllers\Auth\Visitor;

use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\VisitorResource;
use Illuminate\Validation\ValidationException;

class VisitorLoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required',
                'password' => 'required',
            ]);

            $visitor = Visitor::where('email', $request->email)->first();

            if (!$visitor || !Hash::check(
                $request->password,
                $visitor->password
            )) {
                throw ValidationException::withMessages([
                    'message' => ["The credentials are incorrect"]
                ]);
            }

            $visitor->tokens()->delete();
            $token = $visitor->createToken(env('APP_KEY'), ['*'])->plainTextToken;

            return (new VisitorResource($visitor))->additional([
                'token_type' => 'Bearer',
                'access_token' => $token,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
