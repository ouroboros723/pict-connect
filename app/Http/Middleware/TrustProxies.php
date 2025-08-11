<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * 信頼するプロキシ
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = '*'; // 例: '*', または ['10.0.0.0/8', '172.16.0.0/12'] などインフラに合わせて設定

    /**
     * プロキシ検出に使用するヘッダ
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
