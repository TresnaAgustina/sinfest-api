<?php

namespace App\Http\Controllers\Auth\Admin;

use Exception;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminProfileController extends Controller
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
            $admin = $request->user();
            return new AdminResource($admin);
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
