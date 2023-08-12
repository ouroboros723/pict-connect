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
        function registerInstallAppEvent(elem){
            window.addEventListener('beforeinstallprompt', function(event){
                console.log("beforeinstallprompt: ", event);
                event.preventDefault();
                elem.promptEvent = event;
                elem.style.display = "block";
                return false;
            });
            function installApp() {
                if(elem.promptEvent){
                    elem.promptEvent.prompt();
                    elem.promptEvent.userChoice.then(function(choice){
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
    <link rel="manifest" href="/manifest.webmanifest" />

    <!-- ↓iPhone用にURLバーを表示しない設定を追加↓ -->
    <meta name="apple-mobile-web-app-capable" content="yes">

    <link rel="manifest" href="manifest.webmanifest" />


    <!-- ↓iPhone用にアイコン設定を追加↓ -->
    <link rel="apple-touch-icon" href="img/common/logo.svg" />
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
        <nav id="title-nav" class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    @if (Route::getCurrentRoute()->uri() === 'user/edit')
                        <b><</b>
                        <a id="app-title" class="navbar-brand" href="#">ユーザー設定</a>
                    @else
                        <span style="color: whitesmoke">{{ config('app.name', 'Laravel') }}</span>
                    @endif
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::getCurrentRoute()->uri() === 'login')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}?pass_code={{Config::get('auth.access_code')}}">{{ __('新規登録') }}</a>
                                </li>
                            @else(Route::getCurrentRoute()->uri() === 'register')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}?pass_code={{Config::get('auth.access_code')}}">{{ __('ログイン') }}</a>
                                </li>
                            @endif
                        @else
                            <li>
                                <div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('ログアウト') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}?pass_code={{Config::get('auth.access_code')}}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
