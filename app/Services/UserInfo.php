<?php

namespace App\Services;

use App\Model\User;
use Illuminate\Http\Request;

class UserInfo
{
    /**
     * 画像のMimeTypeから拡張子を判定して返します。
     * @param string $mimetype
     * @return string
     */
    public function get(Request $request): ?User
    {
        return User::whereToken($request->userToken)->whereTokenSec($request->userTokenSec)->first();
    }
}
