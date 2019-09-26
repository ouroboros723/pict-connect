@include('viewer.components.flame')

@yield('meta')
@yield('header')
@yield('side-menu')
<nav id="func-menu-nav" class="navbar navbar-toggleable-md navbar-light bg-faded gnav">
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active">イベントアルバム</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/users">ユーザーアルバム</a>
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
<div id="photo-cards" class="container">
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
</div>
<button type="button" id="camera-button" class="btn btn-primary rounded-circle p-0"> <input id="camera-input" class="photo-input-hidden" type="file" name="image" accept="image/*" capture="enviroment"><label for="camera-input"><img src="{{ asset('img/common/camera.png') }}" /></label></button>
<button type="button" id="photo-add-button" class="btn btn-primary rounded-circle p-0"><input id="photo-add-input" class="photo-input-hidden" type="file" name="image" accept="image/*"><label for="photo-add-input"><img src="{{ asset('img/common/photos.png') }}" /></label></button>
@yield('footer')
