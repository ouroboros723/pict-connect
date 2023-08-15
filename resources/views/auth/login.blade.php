@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="login-card" class="card">
                    <div class="card-header">{{ __('ログイン') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}?pass_code={{Config::get('auth.access_code')}}">
                            @csrf

                            <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('ユーザー名') }}</label>

                                <div class="col-md-6">
                                    <input id="screen_name" type="text" class="form-control @error('screen_name') is-invalid @enderror" name="screen_name" value="{{ old('screen_name') }}" required autocomplete="screen_name" autofocus>

                                    @error('screen_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('アカウントを記憶する') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('ログイン') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('パスワードをお忘れですか?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    TwitterAPIサスペンドに付き無効化--}}
    <div class="container">
        <div class="row justify-content-center">
            <div id="register-box">
                <a href="{{ route('register') }}?pass_code={{Config::get('auth.access_code')}}"><span style="width: 100%; display: block; height: 100%; color: white;font-size: 22px;">新規登録</span></a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div id="twitter-login-box">
                <a href="/login/twitter"><img src="{{asset('/img/login/twitter_button.png')}}" alt="Twitterボタン"></a>
            </div>
        </div>
    </div>
@endsection
