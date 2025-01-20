<?php
namespace App\Services\impl;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\RefreshToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthServiceImpl implements AuthService{
    public $refreshTokenTTL = 60 * 24 * 30;
    public function login($request){
       try {
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        if(!$token){
            throw new HttpResponseException(response()->badRequest('invalid credentials'));
        }
        $refreshToken = $this->generateRefreshToken($request);
        return [
            'access_token'=>$token,
            'refresh_token'=>$refreshToken
        ];
       } catch (\Throwable $th) {
        throw $th;
       }
    }

    public function refreshToken(Request $request){
        $ttl = auth('api')->factory()->getTTL();
        // $token = $request->cookie('refresh_token');
        $token = $request->header('X-REFRESH-TOKEN');
        $refreshToken = $this->getActiveRefreshToken($token);
       
        if(!$refreshToken){
            throw new HttpResponseException(response()->unAuthorized('invalid credentials'));
        }

        $user = User::find($refreshToken->user_id);
        $refreshToken = auth('api')->setTTL($this->refreshTokenTTL)->login($user);

        return [
            'access_token'=>$refreshToken,
            'expires_in' => now()->addMinutes($ttl)
        ];
    }

    public function logout($request){
        JWTAuth::invalidate(JWTAuth::getToken());
        RefreshToken::where('token', JWTAuth::getToken())->delete();

        return response()->ok('User successfully logged out');
    }


    protected function generateRefreshToken(Request $request){
        $credentials = $request->only('email', 'password');
        $refeshToken = JWTAuth::attempt($credentials);
        JWTAuth::factory()->setTTL($this->refreshTokenTTL);
        if ($refeshToken) {
            RefreshToken::create([
               'user_id' => 1,
               'token' => $refeshToken,
               'expires_at' => Carbon::now()->addMinute($this->refreshTokenTTL)
            ]);
        }
        return $refeshToken;
    }

    protected function getActiveRefreshToken($token){
        auth('api')->logout();
        $refreshToken = RefreshToken::where('token', $token)->where('expires_at', '>', now())->orderBy('id', 'desc')->first();
        return $refreshToken;
    }
}