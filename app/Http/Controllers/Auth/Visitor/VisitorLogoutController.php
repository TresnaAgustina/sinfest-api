<?php

namespace App\Http\Controllers\Auth\Visitor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitorLogoutController extends Controller
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
            $visitor = Auth::user();
            $visitor->tokens()->where(
                'tokenable_id',
                $visitor->currentAccessToken()->tokenable_id
            )->delete();

            return response()->json([
                'message' => "You're Logout",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
