<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'pict-connect') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        window.addEventListener('load', () => {
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker
                    .register('{{asset('js/sw.js')}}')
                    .then(registration => console.log('registered', registration))
                    .catch(error => console.log('error', error));
            }
        });

        registerInstallAppEvent(document.getElementById("InstallBtn"));

        function registerInstallAppEvent(elem) {
            window.addEventListener('beforeinstallprompt', function (event) {
                console.log("beforeinstallprompt: ", event);
                event.preventDefault();
                elem.promptEvent = event;
                elem.style.display = "block";
                return false;
            });

            function installApp() {
                if (elem.promptEvent) {
                    elem.promptEvent.prompt();
                    elem.promptEvent.userChoice.then(function (choice) {
                        elem.style.display = "none";
                        elem.promptEvent = null;
                    });
                }
            }

            elem.addEventListener("click", installApp);
        }
    </script>

    <link rel=”icon” href="/favicon.ico"/>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Manifest -->
    <link rel="manifest" href="/manifest.webmanifest"/>

    <!-- ↓iPhone用にURLバーを表示しない設定を追加↓ -->
    <meta name="apple-mobile-web-app-capable" content="yes">

    <link rel="manifest" href="manifest.webmanifest"/>


    <!-- ↓iPhone用にアイコン設定を追加↓ -->
    <link rel="apple-touch-icon" href="img/common/logo.svg"/>
    <!-- ↓iPhone用にスプラッシュ画面の設定を追加↓ -->
    <link
        rel="apple-touch-startup-image"
        href="img/common/logo.svg"
        media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
    />
    <link
        rel="apple-touch-startup-image"
        href="img/common/logo.svg"
        media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
    />
    <link
        rel="apple-touch-startup-image"
        href="img/common/logo.svg"
        media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
    />
    <link
        rel="apple-touch-startup-image"
        href="img/common/logo.svg"
        media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
    />
    <link
        rel="apple-touch-startup-image"
        href="img/common/logo.svg"
        media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
    />
    <link
        rel="apple-touch-startup-image"
        href="img/common/logo.svg"
        media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
    />
    <link
        rel="apple-touch-startup-image"
        href="img/common/logo.svg"
        media="(device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
    />
    <link
        rel="apple-touch-startup-image"
        href="img/common/logo.svg"
        media="(device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
    />
</head>
<body>
<button id="InstallBtn" class="installbotton" style="display:none;">
    アプリをインストールする
</button>
<div id="app">
    <nav id="title-nav" class="navbar navbar-toggleable-md navbar-light bg-faded gnav">
        @switch(Route::getCurrentRoute()->uri())
            @case('register')
                <span id="app-title" class="navbar-brand">
                            {{Config::get('app.name')}}
                        </span>
                <button id="user-icon" type="button" class="btn btn-secondary" data-container="body"
                        data-toggle="popover" data-placement="bottom" data-content='
                <div class="list-group">
                    <a href="/login" class="list-group-item list-group-item-action">ログイン</a>
                </div>'
                >
                    <span id="guest-dropdown-icon">▼</span>
                </button>
                @break
            @case('login')
            @case('welcome')
                <span id="app-title" class="navbar-brand">
                            {{Config::get('app.name')}}
                        </span>
                @break
            @case('user/edit')
            @case('event/create')
                <button id="back-icon" type="button" class="btn btn-secondary" onClick="history.back()">
                    <span><</span>
                </button>
                <span id="app-title" class="navbar-brand">
                            {{Config::get('app.name')}}
                        </span>
                <button id="user-icon" type="button" class="btn btn-secondary" data-container="body"
                        data-toggle="popover" data-placement="bottom" data-content='{{"
                    <div class=\"list-group\">
                                       <span id=\"menu-logout\" class=\"dropdown-item\" href=\"#\" onClick=\"event.preventDefault();document.getElementById('logout-form').submit();\">
                                        <span>ログアウト</span>
                                    </span>
                    </div>"}}'
                >
                    <span id="guest-dropdown-icon">▼</span>
                </button>
                @break
            @default
                @if(Str::startsWith(Request::path(), 'event/edit/'))
                    <button id="back-icon" type="button" class="btn btn-secondary" onClick="history.back()">
                        <span><</span>
                    </button>
                    <span id="app-title" class="navbar-brand">
                                {{Config::get('app.name')}}
                            </span>
                    <button id="user-icon" type="button" class="btn btn-secondary" data-container="body"
                            data-toggle="popover" data-placement="bottom" data-content='{{"
                        <div class=\"list-group\">
                                           <span id=\"menu-logout\" class=\"dropdown-item\" href=\"#\" onClick=\"event.preventDefault();document.getElementById('logout-form').submit();\">
                                            <span>ログアウト</span>
                                        </span>
                        </div>"}}'
                    >
                        <span id="guest-dropdown-icon">▼</span>
                    </button>
                @else
                    <a id="app-title" class="navbar-brand" href="#">{{Config::get('app.name')}}</a>
                    <button id="user-icon" type="button" class="btn btn-secondary" data-container="body"
                            data-toggle="popover" data-placement="bottom" data-content='
                <div class="list-group">
                    <a href="/user/edit" class="list-group-item list-group-item-action">ユーザー設定</a>
                    <a href="/event/create" class="dropdown-item list-group-item list-group-item-action">新規イベント作成</a>
                    <a href="/event/joined" class="dropdown-item list-group-item list-group-item-action">参加済みイベント一覧</a>
                    <a href="/auth/twitter/logout" class="list-group-item list-group-item-action">ログアウト</a>
                </div>'
                    >
                        <img src="@if(isset($user_info['avatar']))
                    data:image/@if($user_info['avatar_ext'] === 'jpg')jpeg @else {{$user_info['avatar_ext']}}@endif;base64,{{$user_info['avatar']}}
                @else
                    {{asset('img/common/anonman.svg')}}
                @endif
                    "/>
                    </button>
                @endif
        @endswitch


    </nav>
    <main id="main-container" class="py-4" style="padding-top: 0 !important;">
        @yield('content')
    </main>
</div>
<form id="logout-form" action="{{ route('logout') }}?pass_code={{Config::get('auth.access_code')}}" method="POST"
      style="display: none;">
    @csrf
</form>
<script>
    $(function () {
        $('#user-icon').popover({'html': true});
    });
</script>
</body>
</html>
