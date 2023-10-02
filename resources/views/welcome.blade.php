@extends('layouts.app')

@section('content')
    <div class="container">
        <nav id="func-menu-nav" class="navbar navbar-toggleable-md navbar-light bg-faded gnav">
            <div class="container">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="/login{!! empty(request()->query('redirect_url')) ? null : '?redirect_url='.urlencode(request()->query('redirect_url')) !!}">利用者の方</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active">はじめての方・写真受取り</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="login-card" class="card">
                    <div class="card-header">{{ __('写真の受け取り') }}</div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div id="twitter-login-box" class="other-login-box">
                                    <a href="/login/twitter?mode=get-photos"><img src="{{asset('/img/login/twitter_button.png')}}" alt="Twitterログイン"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="register-card" class="card">
                    <div class="card-header">{{ __('アカウント作成') }}</div>

                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div id="register-box" class="other-login-box">
                                    <a href="{{ route('register') }}?pass_code={{Config::get('auth.access_code')}}{!! empty(request()->query('redirect_url')) ? null : '&redirect_url='.urlencode(request()->query('redirect_url')) !!}"><img src="{{asset('/img/login/new_regist_button.png')}}" alt="新規登録ボタン"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
