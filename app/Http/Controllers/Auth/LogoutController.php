<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
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
            auth()->logout();

            return $this->successResponse([], 'Logout successful');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
