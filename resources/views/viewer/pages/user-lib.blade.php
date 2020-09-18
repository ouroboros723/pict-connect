@include('viewer.components.flame')

@yield('meta')
<body>
@yield('header')
@yield('side-menu')
<nav id="func-menu-nav" class="navbar navbar-toggleable-md navbar-light bg-faded gnav">
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="/">イベントアルバム</a>
            </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/users">ユーザーアルバム</a>
                        </li>
            {{--            <li class="nav-item">--}}
            {{--                <a class="nav-link active">ユーザーhogeのアルバム</a>--}}
            {{--            </li>--}}
            {{--                <li class="nav-item">--}}
            {{--                    <a class="nav-link">タブ4</a>--}}
            {{--                </li>--}}
        </ul>
    </div>
</nav>
<nav id="func-menu-nav" class="navbar navbar-toggleable-md navbar-light bg-faded gnav">
    <div class="container">
        <p id="user-name">ユーザーhogeのアルバム</p>
    </div>
</nav>
<div id="photo-cards-non-button" class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">text</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">text</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">text</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">text</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">text</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">text</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">text</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">text</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">text</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">text</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">text</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">text</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">text</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">text</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">text</p>
                </div>
            </div>
        </div>
    </div>
    @yield('footer')
</div>

<script src="{{asset('js/app.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" crossorigin="anonymous">

@yield('commonscript')
