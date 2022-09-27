<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginResource;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $token = auth()->attempt($credentials);

            if (!$token) {
                return $this->errorResponse('Unauthorized', [], 401);
            }

            $response = new LoginResource(['token' => $token]);

            return $this->successResponse($response, 'Login successful');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), );
        }
    }
}
