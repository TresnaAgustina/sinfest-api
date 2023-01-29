<?php

namespace App\Http\Controllers\Auth\Visitor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VisitorResource;
use Illuminate\Support\Facades\Auth;
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
            $validated = $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            if (Auth::guard('visitors')->attempt($validated)) {
                $visitor = Auth::guard('visitors')->user();

                $visitor->tokens()->delete();
                $token = $visitor->createToken($request->username, ['visitors'])->plainTextToken;

                return (new VisitorResource($visitor))->additional([
                    'token_type' => 'Bearer',
                    'access_token' => $token,
                ]);
            }

            return response()->json([
                'message' => 'Your Credentials are incorrect.'
            ], 401);
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
