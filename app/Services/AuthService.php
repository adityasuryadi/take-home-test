<?php
namespace App\Services;

interface AuthService {
    public function login($request);
    public function refreshToken($request);
    public function logout($request);
}