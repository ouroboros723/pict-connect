<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <link rel="icon" href="/favicon.ico"/>

    <!-- Manifest -->
    <link rel="manifest" href="/manifest.webmanifest" />

    <!-- ↓iPhone用にURLバーを表示しない設定を追加↓ -->
    <meta name="apple-mobile-web-app-capable" content="yes">

    <link rel="manifest" href="manifest.webmanifest" />

    <!-- ↓iPhone用にアイコン設定を追加↓ -->
    <link rel="apple-touch-icon" href="img/common/logo.svg" />

    <title>{{Config::get('app.name')}}</title>
</head>
<body>
    <nav id="title-nav" class="navbar navbar-toggleable-md navbar-light bg-faded gnav">
        <span id="app-title" class="navbar-brand">
            {{Config::get('app.name')}}
        </span>
        <button id="user-icon" type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="bottom" data-content='
            <div class="list-group">
                <a href="/guest-logout" class="list-group-item list-group-item-action">ログアウト</a>
            </div>'
        >
            <img title="メニュー" src="{{asset('img/common/anonman.svg')}}" />
        </button>
    </nav>

<div id="loading" style="display: none;"><img src="{{asset("img/common/loading.gif")}}"></div>
<div id="main-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ゲストログイン - 共有されている写真</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        @forelse ($photos as $photo)
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="{{ route('get.photo', ['photo_id' => $photo->photo_id]) }}" class="card-img-top" alt="共有写真">
                                    <div class="card-body">
                                        <p class="card-text">{{ $photo->created_at->format('Y/m/d H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">共有されている写真はありません。</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<button id="InstallBtn" class="installbotton" style="display:none;">
    アプリをインストールする
</button>

<script src="{{asset('js/app.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" crossorigin="anonymous">

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

    $(function () {
        $('#user-icon').popover({'html': true});
        $('#app-title').on('click', () => {
            $('#main-container').animate({scrollTop: 0}, 200);
        });
    });
</script>
</body>
</html>
