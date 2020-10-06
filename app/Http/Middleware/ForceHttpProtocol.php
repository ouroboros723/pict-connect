<?php

/** HTTPS強制ミドルウェア. */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use URL;

/**
 * HTTPS強制ミドルウェア
 */
class ForceHttpProtocol
{
    /**
     * Handle an incoming request.
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if (! empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) { //ロードバランサー経由の場合
        //     if ('HTTP' != strtoupper($_SERVER['HTTP_X_FORWARDED_PROTO'])) { //もしHTTPでアクセスされていなかったら
        //         return $next($request);
        //     }
        // }
        // リバースプロキシ経由のHTTP/HTTPS判定
        if (true === array_key_exists('HTTP_HOST', $_SERVER)) { //HTTP_HOSTの値があれば
            if (0 === preg_match('/^localhost(.*)$/', $_SERVER['HTTP_HOST'])) { //localhostでなければ
                if (true === array_key_exists('HTTP_X_FORWARDED_PROTO', $_SERVER)) { //ロードバランサー経由であれば
                    if ('HTTP' === strtoupper($_SERVER['HTTP_X_FORWARDED_PROTO'])) { //HTTPでアクセスされていた場合は
                        if (! $request->secure() && 'production' === config('app.env')) { //本番環境の場合は
                            return redirect()->secure($request->getRequestUri());
                        }
                        //テスト環境の場合は
                        // URL::forceScheme('http');
                        return redirect()->secure($request->getRequestUri());
                    }
                    //HTTPSでアクセスされれていた場合はすべてHTTPSにリダイレクト
                    URL::forceScheme('https');

                    return $next($request);
                } else { // ロードバランサーを使用していなければ
                    // if (!$request->secure() && config('app.env') === 'production') { //本番環境の場合は
                    if ($_SERVER['REQUEST_SCHEME'] == 'http') {
                        return redirect()->secure($request->getRequestUri()); //直接プロトコルを確認してHTTPならHTTPSへリダイレクト
                    }

                    return $next($request);
                    // } else {
                        // return $next($request);  //本番環境でない場合は何もしない
                    // }
                }
            }
        }

        return $next($request);
    }
}
