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

<div id="upload-confirm-dialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4><div class="modal-title" id="myModalLabel">投稿しますか？</div></h4>
            </div>
            <div class="modal-body">
                <label>view photo preview</label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
                <button type="button" class="btn btn-danger">アップロード</button>
            </div>
        </div>
    </div>
</div>

<a id="upload-confirm-dialog-trigger" class="btn btn-primary" data-toggle="modal" data-target="#upload-confirm-dialog" style="display: none"></a>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script>
    document.getElementById("camera-button").addEventListener("change", function(){uploadConfirmDialog();});
    document.getElementById("photo-add-button").addEventListener("change", function(){uploadConfirmDialog();});


    function uploadConfirmDialog() {
        if (document.getElementById("camera-input").value !== "" && document.getElementById("photo-add-input").value !== "" ) {
            var element = document.getElementById("upload-confirm-dialog-trigger");
            if (document.createEvent) {
                // IE以外
                var evt = document.createEvent("HTMLEvents");
                evt.initEvent("click", true, true ); // event type, bubbling, cancelable
                return element.dispatchEvent(evt);
            } else {
                // IE
                var evt = document.createEventObject();
                return element.fireEvent("onclick", evt)
            }
        }
    }
</script>
@yield('footer')
