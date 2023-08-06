@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('ユーザー情報編集') }}</div>

                    <div class="card-body">
                        <form id="register-form" method="POST" action="/user/edit" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="screen_name" class="col-md-4 col-form-label text-md-right">{{ __('ユーザーID') }}</label>

                                <div class="col-md-6">
                                    <input id="screen_name" type="text" class="form-control @error('screen_name') is-invalid @enderror" name="screen_name" value="{{ old('screen_name') ?? $user_info['screen_name'] }}" required autocomplete="screen_name" autofocus>

                                    @error('screen_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="view_name" class="col-md-4 col-form-label text-md-right">{{ __('表示名') }}</label>

                                <div class="col-md-6">
                                    <input id="view_name" type="text" class="form-control @error('view_name') is-invalid @enderror" name="view_name" value="{{ old('view_name') ?? $user_info['view_name']}}" required autocomplete="view_name" autofocus>

                                    @error('view_name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('メールアドレス') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $user_info['email']}}" autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('パスワード(再入力)') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="icon" class="col-md-4 col-form-label text-md-right">{{ __('アイコン画像') }}</label>

                                <div class="col-md-6">
                                    <input style="height: 46px" id="user_icon" type="file" accept="image/*" class="form-control" name="user_icon">
                                    @error('user_icon')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <img id="img" alt="アイコンプレビュー" src="@if(isset($user_info['avatar']))
                data:image/@if($user_info['avatar_ext'] === 'jpg')jpeg @else {{$user_info['avatar_ext']}}@endif;base64,{{$user_info['avatar']}}
            @else
                {{asset('img/common/anonman.svg')}}
            @endif
                " />
                                </div>
                            </div>

                            <div id="submit-area" style="display: block; text-align: center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('更新') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script>
        $('#register-form').on('change', function (e) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#img").attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    </script>
@endsection
