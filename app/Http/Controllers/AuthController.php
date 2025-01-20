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
/*************  ✨ Codeium Command ⭐  *************/
    /**
     * Logs in a user with the given credentials
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
/******  1ba71ef2-a954-45d2-962b-535bca0fa963  *******/
    public function login(Request $request){
        $result = $this->authService->login($request);

        return response()->ok($result);
    }

    public function refreshToken(){

    }

    public function logout(Request $request){
        $this->authService->logout($request);
        return response()->ok('User successfully logged out');
    }
}
