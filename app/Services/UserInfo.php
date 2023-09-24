<?php

namespace App\Services;

use App\Model\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserInfo
{
    /**
     * ユーザー情報を取得します。
     * @param Request $request
     * @return User|null
     */
    public static function get(Request $request): ?User
    {
        return User::whereToken($request->userToken ?? '')->whereTokenSec($request->userTokenSec ?? '')->first();
    }

    /**
     * ユーザー情報を取得します。見つからない場合はNotFountを返します。
     * @param Request $request
     * @return User
     * @throws NotFoundHttpException
     */
    public static function getOrFail(Request $request): User
    {
        $userInfo = self::get($request);
        if (is_null($userInfo)) {
            throw new NotFoundHttpException('user_info_not_found');
        }
        return $userInfo;
    }
}
