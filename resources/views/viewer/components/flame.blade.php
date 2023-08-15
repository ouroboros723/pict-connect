@section('meta')
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{asset('css/app.css')}}">

        <link rel=”icon” href="/favicon.ico"/>

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

        <title>{{Config::get('app.name')}}</title>
    </head>
@endsection

@section('header')
    <nav id="title-nav" class="navbar navbar-toggleable-md navbar-light bg-faded gnav">
        <span id="app-title" class="navbar-brand">
            {{Config::get('app.name')}}
        </span>
        <button id="user-icon" type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="bottom" data-content='
            <div class="list-group">
                <a href="/user/edit" class="list-group-item list-group-item-action">ユーザー設定</a>
                <a href="/auth/twitter/logout" class="list-group-item list-group-item-action">ログアウト</a>
            </div>'
        >
            <img src="@if(isset($user_info['avatar']))
                data:image/@if($user_info['avatar_ext'] === 'jpg')jpeg @else {{$user_info['avatar_ext']}}@endif;base64,{{$user_info['avatar']}}
            @else
                {{asset('img/common/anonman.svg')}}
            @endif
                " />
        </button>
    </nav>
@endsection

@section('side-menu')
    {{--TODO:共通サイトメニューを記述--}}
@endsection

@section('footer')
    {{--footerを作る必要があればここに記述--}}
    </html>
@endsection

@section('commonscript')
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

        window.Echo.connector.socket.on('connect', function(){
            iziToast.success({ message: 'サーバーに接続しました。' , position: 'bottomCenter',});
        });
        window.Echo.connector.socket.on('disconnect', function(){
            iziToast.warning({ message: 'サーバーから切断されました。' , position: 'bottomCenter',});
        });
    $(function () {
        $('#user-icon').popover({'html': true});
        $('#app-title').on('click', () => {
            $('#main-container').animate({scrollTop: 0}, 200);
        });
    });
    </script>
@endsection
