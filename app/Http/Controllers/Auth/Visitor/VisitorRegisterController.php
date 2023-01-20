<?php

namespace App\Http\Controllers\Auth\Visitor;

use App\Http\Controllers\Controller;
use App\Http\Resources\VisitorResource;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VisitorRegisterController extends Controller
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
            $validated = $this->validate($request, [
                'username' => 'required|unique:visitors|max:25',
                'email' => 'required|email|unique:visitors',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'required|unique:visitors'
            ]);

            $validated['password'] = bcrypt($request->password);
            Visitor::create($validated);

            $visitor = Visitor::where('username', $request->username)->first();
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
