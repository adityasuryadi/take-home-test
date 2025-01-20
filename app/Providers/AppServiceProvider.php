<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as Resp;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('ok',function($data = [],$status = Resp::HTTP_OK){
            return response()->json(['data'=>$data,'code'=>$status,'status'=>Resp::$statusTexts[$status]],$status);
        });

        Response::macro('badRequest',function($data = [],$status = Resp::HTTP_BAD_REQUEST){
            return response()->json(['errors'=>$data,'code'=>$status,'status'=>Resp::$statusTexts[$status]],$status);
        });

        Response::macro('notFound',function($data = [],$status = Resp::HTTP_NOT_FOUND){
            return response()->json(['errors'=>$data,'code'=>$status,'status'=>Resp::$statusTexts[$status]],$status);
        });

        Response::macro('error',function($data = [],$status = Resp::HTTP_INTERNAL_SERVER_ERROR){
            return response()->json(['errors'=>$data,'code'=>$status,'status'=>Resp::$statusTexts[$status]],$status);
        });

        Response::macro('unAuthorized',function($data = [],$status = Resp::HTTP_UNAUTHORIZED){
            return response()->json(['errors'=>$data,'code'=>$status,'status'=>Resp::$statusTexts[$status]],$status);
        });
    }
}
