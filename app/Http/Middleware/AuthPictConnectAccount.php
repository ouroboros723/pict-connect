<?php

/** HTTPS強制ミドルウェア. */

namespace App\Http\Middleware;

use App\Model\User;
use Auth;
use Closure;
use Cookie;
use Crypt;
use Illuminate\Http\Request;
use URL;

/**
 * PictConnect専用認証ミドルウェア
 */
class AuthPictConnectAccount
{
    /**
     * Handle an incoming request.
     * @param Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // セッションを使ったログインチェック
        if(Auth::check()){
            $request->merge([
                'userToken' => Auth::user()->token,
                'userTokenSec' => Auth::user()->token_sec,
            ]);
            return $next($request);
        }

        // Cookieを使ったログインチェック
        $xUserToken = Cookie::get('X-User-Token', false) ? Cookie::get('X-User-Token') : null;
        $xUserTokenSec = Cookie::get('X-User-Token-Sec', false) ? Cookie::get('X-User-Token-Sec') : null;

        if(!empty($xUserToken) && !empty($xUserTokenSec) && User::whereToken($xUserToken)->whereTokenSec($xUserTokenSec)->exists()) {
            $request->merge([
                'userToken' => $xUserToken,
                'userTokenSec' => $xUserTokenSec,
            ]);
            return $next($request);
        }

        // ヘッダを使ったログインチェック
        $user_token = $request->header('X-User-Token');
        $user_token_sec = $request->header('X-User-Token-Sec');

        /*** @var User $User  ***/
        $result = User::whereToken($user_token)
            ->whereTokenSec($user_token_sec)
            ->exists();

        if (empty($user_token) || empty($user_token_sec) || !$result) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        $request->merge([
            'userToken' => $user_token,
            'userTokenSec' => $user_token_sec,
        ]);

        return $next($request);
    }
}
