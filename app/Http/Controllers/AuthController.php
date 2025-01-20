<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function login(Request $request){
        $result = $this->authService->login($request);

        if (! $result) {
            return response()->badRequest('invalid credentials');
        }

        return response()->ok($result);
    }

    public function refreshToken(){
        $result = $this->authService->refreshToken(request());
        if (!$result) {
            return response()->unaAuthorized('invalid credentials');
        }

        return response()->ok($result); 
    }

    public function logout(Request $request){
        $this->authService->logout($request);
        return response()->ok('User successfully logged out');
    }
}
