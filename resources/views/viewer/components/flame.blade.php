@section('meta')
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{asset('css/app.css')}}">

        <title>pict-connect</title>{{--TODO:configでサイト・ページタイトルが読み込まれるようにする--}}
    </head>
@endsection

@section('header')
    <nav id="title-nav" class="navbar navbar-toggleable-md navbar-light bg-faded gnav">
        <a id="app-title" class="navbar-brand" href="#">pict-connect</a>{{--TODO:configでサイトタイトルが読み込まれるようにする--}}
        <div id="user-icon"><img src="https://pbs.twimg.com/profile_images/1261692452261335045/fBbo2hhw_400x400.jpg" /></div>
    </nav>
@endsection

@section('side-menu')
    {{--TODO:共通サイトメニューを記述--}}
@endsection

@section('footer')
    {{--footerを作る必要があればここに記述--}}
    </html>
@endsection
