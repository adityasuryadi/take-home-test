<?php
namespace App\Services\impl;

use App\Services\AuthService;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthServiceImpl implements AuthService{
    public function login($request){
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json(['token' => $token]);
    }

    public function refreshToken($request){
        
    }

    public function logout($request){
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->ok('User successfully logged out');
    }
}