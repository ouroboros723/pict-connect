@include('viewer.components.flame')

@yield('meta')
@yield('header')
@yield('side-menu')
<nav id="func-menu-nav" class="navbar navbar-toggleable-md navbar-light bg-faded gnav">
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="/">イベントアルバム</a>
            </li>
                        <li class="nav-item">
                            <a class="nav-link active">ユーザーアルバム</a>
                        </li>
            {{--                <li class="nav-item">--}}
            {{--                    <a class="nav-link">タブ3</a>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item">--}}
            {{--                    <a class="nav-link">タブ4</a>--}}
            {{--                </li>--}}
        </ul>
    </div>
</nav>

<ul class="list-group">
    <li class="list-group-item"><a href="/user-lib?id=1">ユーザー1</a></li>
    <li class="list-group-item"><a href="/user-lib?id=2">ユーザー2</a></li>
    <li class="list-group-item"><a href="/user-lib?id=3">ユーザー3</a></li>
    <li class="list-group-item"><a href="/user-lib?id=4">ユーザー4</a></li>
    <li class="list-group-item"><a href="/user-lib?id=5">ユーザー5</a></li>
    <li class="list-group-item"><a href="/user-lib?id=6">ユーザー6</a></li>
</ul>
@yield('footer')
