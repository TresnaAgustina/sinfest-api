<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
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

            if (auth()->attempt($validated)) {
                $admin = auth()->user();

                $admin->tokens()->delete();
                $token = $admin->createToken($request->username, ["*"])->plainTextToken;

                return (new AdminResource($admin))->additional([
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
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
