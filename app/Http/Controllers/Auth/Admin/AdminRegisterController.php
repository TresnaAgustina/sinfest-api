<?php

namespace App\Http\Controllers\Auth\Admin;

use Exception;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminRegisterController extends Controller
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
            $validated = $this->validate(
                $request,
                [
                    'username' => 'required|unique:admins|max:20',
                    'email' => 'required|email|unique:admins',
                    'password' => 'required|string|min:8|confirmed'
                ]
            );

            $validated['password'] = bcrypt($request->password);
            Admin::create($validated);

            $admin = Admin::where('username', $request->username)->first();
            $token = $admin->createToken(env('APP_KEY'))->plainTextToken;

            return (new AdminResource($admin))->additional([
                'token_type' => 'Bearer',
                'access_token' => $token,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
