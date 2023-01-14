<?php

namespace App\Http\Controllers\Auth\Admin;

use Exception;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            //code...
            $this->validate($request, [
                'username' => 'required',
                'password' => 'required'
            ]);

            $admin = Admin::where('username', $request->username)->first();

            if(!$admin || !hash::check(
                $request->password,
                $admin->password
            )){
                throw ValidationException::withMessages([
                 'username' => [" The credentials are incorrect"]
                ]);
            };

            $admin->token()->delete();
            $token = $admin->createToken(env('APP_KEY'))->plainTextToken;

            return (new AdminResource($admin))->additional([
                'token_type' => 'Bearer ',
                'access_token' => $token
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
