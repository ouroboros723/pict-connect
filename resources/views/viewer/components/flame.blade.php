@section('meta')
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{asset('css/app.css')}}">

        <title>pict-connect</title>{{--TODO:configでサイト・ページタイトルが読み込まれるようにする--}}
    </head>
@endsection

@section('header')
    <nav id="title-nav" class="navbar navbar-toggleable-md navbar-light bg-faded gnav">
        <a id="app-title" class="navbar-brand" href="#">pict-connect</a>{{--TODO:configでサイトタイトルが読み込まれるようにする--}}
        <button id="user-icon" type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="bottom" data-content='
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action">ユーザー設定</a>
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
        window.Echo.connector.socket.on('connect', function(){
            iziToast.success({ message: 'サーバーに接続しました。' , position: 'bottomCenter',});
        });
        window.Echo.connector.socket.on('disconnect', function(){
            iziToast.warning({ message: 'サーバーから切断されました。' , position: 'bottomCenter',});
        });
    $(function () {
        $('#user-icon').popover({'html': true});
    });
    </script>
@endsection
