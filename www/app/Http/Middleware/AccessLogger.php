<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AccessLogger
{
    /**
     * リクエストの前後にアクセスログを記録するミドルウェア。
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // リクエスト処理前: HTTPメソッドとURLをログに記録
        Log::info('access start',[
            'method' => $request->method(),
            'url' => $request->url()
        ]);

        // 次のミドルウェア（またはコントローラー）にリクエストを渡し、レスポンスを受け取る
        // ここより前に書いた処理はコントローラーの実行「前」、後に書いた処理は「後」に実行される
        $response = $next($request);

        // リクエスト処理後: HTTPメソッドとURLをログに記録
        Log::info('access end',[
            'method' => $request->method(),
            'url' => $request->url()
        ]);

        return $response;
    }
}
