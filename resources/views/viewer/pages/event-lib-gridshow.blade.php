@include('viewer.components.flame')

@yield('meta')
<body>
@yield('header')
@yield('side-menu')
{{--<nav id="func-menu-nav" class="navbar navbar-toggleable-md navbar-light bg-faded gnav">--}}
{{--    <div class="container">--}}
{{--        <ul class="nav nav-tabs">--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link active">イベントアルバム</a>--}}
{{--            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="/users">ユーザーアルバム</a>--}}
{{--                            </li>--}}
{{--            --}}{{--                <li class="nav-item">--}}
{{--            --}}{{--                    <a class="nav-link">タブ3</a>--}}
{{--            --}}{{--                </li>--}}
{{--            --}}{{--                <li class="nav-item">--}}
{{--            --}}{{--                    <a class="nav-link">タブ4</a>--}}
{{--            --}}{{--                </li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--</nav>--}}
    <style>
        .photo-cell {
            height: calc(50vh - 38px);
        }
    </style>
<div id="loading" style="display: none;"><img src="{{asset("img/common/loading.gif")}}"></div>
<div id="main-container">
    <div id="photo-cards" class="">
        <div id="photo-list-top"></div>
        {{-- 写真がここに入る --}}
        <div id="photo-list-bottom"></div>
    </div>
    {{-- 写真選択・アップロードボタン --}}
{{--    <button type="button" id="camera-button" class="btn btn-primary rounded-circle p-0"><input id="camera-input"--}}
{{--                                                                                               class="photo-input-hidden"--}}
{{--                                                                                               type="file"--}}
{{--                                                                                               name="image"--}}
{{--                                                                                               accept="image/*"--}}
{{--                                                                                               capture><label--}}
{{--            for="camera-input"><img src="{{ asset('img/common/camera.png') }}"/></label></button>--}}
{{--    <button type="button" id="photo-add-button" class="btn btn-primary rounded-circle p-0"><input multiple--}}
{{--                                                                                                  id="photo-add-input"--}}
{{--                                                                                                  class="photo-input-hidden"--}}
{{--                                                                                                  type="file"--}}
{{--                                                                                                  name="image"--}}
{{--                                                                                                  accept="image/*"><label--}}
{{--            for="photo-add-input"><img src="{{ asset('img/common/photos.png') }}"/></label></button>--}}

{{--    <div id="upload-confirm-dialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal"--}}
{{--         aria-hidden="true">--}}
{{--        <div class="modal-dialog">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h4>--}}
{{--                        <div class="modal-title" id="myModalLabel">投稿しますか？</div>--}}
{{--                    </h4>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <img src="https://unsplash.it/630/400" style="width: 100%"/>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>--}}
{{--                    <button type="button" class="btn btn-danger">アップロード</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <a id="upload-confirm-dialog-trigger" class="btn btn-primary" data-toggle="modal" data-target="#upload-confirm-dialog" style="display: none"></a>--}}

    @yield('footer')
</div>
{{--page unique scripts--}}
<script src="{{asset('js/app.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
<script src="{{asset('js/lity.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/lity.css')}}" crossorigin="anonymous">

<button id="InstallBtn" class="installbotton" style="display:none;">
    アプリをインストールする
</button>

@yield('commonscript')

<script>
    var user_info = @json($user_info);
    var last_photo_id = "";
    var begin_photo_id = "";
    var photo_count = 0;
    var ajax_status = true;
    var prev_photo_ajax_status = true;
    var upload_status = true;

    if ('' === user_info || null === user_info) {
        window.location.href = '/login?pass_code={{Config::get('auth.access_code')}}';
    }

    window.addEventListener('load', function () {
        getPhotos();
    });
    window.addEventListener('focus', function () {
        getPhotos();
        setTimeout(function () {
            window.Echo.channel('event-lib')
                .listen('PublicEvent', (e) => {
                    console.log(e.message);
                    if (e.message === 'new_photo_posted' && ajax_status) {
                        getPhotos();
                    } else if (e.message === 'photo_deleted' && ajax_status) {
                        console.log(e.delete_target_id);
                        photoDeleteEvent(e.delete_target_id);
                    }
                }).listen('PhotoDeleteEvent', (e) => {
                alert();
                if (e.message = 'photo_deleted') {
                    console.log(e.delete_target_id);
                    photoDeleteEvent(e.delete_target_id);
                }
            });
        }, 500);
    });

    $(document).ready(function () {
        window.Echo.channel('event-lib')
            .listen('PublicEvent', (e) => {
                console.log(e.message);
                if (e.message === 'new_photo_posted' && ajax_status) {
                    getPhotos();
                } else if (e.message === 'photo_deleted' && ajax_status) {
                    console.log(e.delete_target_id);
                    photoDeleteEvent(e.delete_target_id);
                }
            }).listen('PhotoDeleteEvent', (e) => {
            alert();
            if (e.message = 'photo_deleted') {
                console.log(e.delete_target_id)
                photoDeleteEvent(e.delete_target_id);
            }
        });
        iziToast.settings({
            transitionIn: 'fadeInDown',
            transitionOut: 'fadeOutUp',
        });
        // $('#main-container').on('scroll', function () {
        //     var scrollPosition = document.getElementById("main-container").scrollTop;
        //     // スクロール要素の高さ
        //     var scrollHeight = document.getElementById("main-container").scrollHeight;
        //     var mainHeight = $("#main-container").height();
        //     if (Math.floor(scrollHeight - (scrollPosition + mainHeight + 70)) <= 3) {
        //         getPrevPhotos();
        //     }
        // });
        setInterval("loadingIconSwitcher()", 100);
    });

    function loadingIconSwitcher() {
        // console.log(!ajax_status || !prev_photo_ajax_status || !upload_status);
        if (!ajax_status || !prev_photo_ajax_status || !upload_status) {
            $("#loading").css("display", "block");
        } else {
            $("#loading").css("display", "none");
        }
    }

    //写真取得
    function getPhotos() {
        if (ajax_status) {
            $.ajax(
                {
                    url: '/api/media/photo/text-list?event_id=1&last_photo_id=' + last_photo_id,
                    type: 'GET',
                    processData: false,
                    contentType: false,
                    async: true,
                    headers: {
                        'X-User-Token': user_info.token,
                        'X-User-Token-Sec': user_info.token_sec,
                    },
                    data: {
                        "event_id": '1', // todo: 現在参加中のイベントidを入れるようにする
                    },
                    beforeSend: function () {
                        ajax_status = false;
                        // $("#loading").css("display", "block");
                    },
                }
            )
                // Ajaxリクエストが成功した時発動
                .done(
                    (data) => {
                        console.log(data.photos);
                        if (data.photos.length === 0) {
                            return;
                        }
                        last_photo_id = data.photos[0].photo_id;
                        var photo_list_elements = '';

                        Object.keys(data.photos).forEach(function (key) {
                            console.log(key);
                            if (photo_count == 0) {
                                begin_photo_id = data.photos[data.photos.length - 1].photo_id;
                            }
                            photo_list_elements +=
                                '<div id="photo_' + data.photos[key].photo_id + '" class="col photo-cell">\n' +
                                // '                    <div class="card">\n' +
                                '                        <a href="/api/media/photo/' + data.photos[key].photo_id + '" data-lity="data-lity"><img class="card-img-top lazyload" data-src="/api/media/photo/' + data.photos[key].photo_id + '/thumbnail" />\n' +
                                '                        <div class="card-body">\n' +
                                '                            <img class="user-icon lazyload" data-src="/api/media/profile-icon/' + data.photos[key].user_info.user_id + '" /><span class="card-text">' + data.photos[key].user_info.view_name + '</span>\n' +
                                '                        </div></a>\n';
                            if (user_info.user_id == data.photos[key].user_info.user_id) {
                                photo_list_elements +=
                                    '                  <a href="#" onclick="deletePhoto(' + data.photos[key].photo_id + ')"><img class="trash-icon" src="/img/common/trash.svg"></a>\n';
                            }
                            photo_list_elements +=
                                '                </div>';

                            photo_count++;
                        });
                        $("#photo-list-top").after(
                            photo_list_elements
                        );
                        $("img.lazyload").lazyload();
                    }
                )
                // Ajaxリクエストが失敗した時発動
                .fail(
                    (data) => {
                        console.log(data);
                        if(data.status == "unauthorized"){
                            window.location.href = '/login?pass_code={{\Config::get('auth.access_code')}}';
                        }
                        iziToast.error({message: '写真の取得に失敗しました。しばらくしてから再度お試しください。', position: 'topCenter', transitionInMobile: 'fadeInDown', transitionOutMobile: 'fadeOutUp',});
                    }
                )
                // Ajaxリクエストが成功・失敗どちらでも発動
                .always(
                    (data) => {
                        ajax_status = true;
                        // $("#loading").css("display", "none");
                    }
                );
        }

    }

    //写真取得
    function getPrevPhotos() {
        if (prev_photo_ajax_status) {
            $.ajax(
                {
                    url: '/api/media/photo/prev_list?event_id=1&begin_photo_id=' + begin_photo_id,
                    type: 'GET',
                    processData: false,
                    contentType: false,
                    async: true,
                    headers: {
                        'X-User-Token': user_info.token,
                        'X-User-Token-Sec': user_info.token_sec,
                    },
                    data: {
                        "event_id": '1',
                    },
                    beforeSend: function () {
                        prev_photo_ajax_status = false;
                        // $("#loading").css("display", "block");
                    },
                }
            )
                // Ajaxリクエストが成功した時発動
                .done(
                    (data) => {
                        console.log(data.photos);
                        if (data.photos.length === 0) {
                            return;
                        }
                        begin_photo_id = data.photos[data.photos.length - 1].photo_id;
                        var photo_list_elements = '';

                        Object.keys(data.photos).forEach(function (key) {
                            console.log(key);
                            if (photo_count == 0) {
                                // photo_list_elements += '<div class="row">'
                            }
                            photo_list_elements +=

                                '<div id="photo_' + data.photos[key].photo_id + '" class="col photo-cell">\n' +
                                // '                    <div class="card">\n' +
                                '                        <a href="/api/media/photo/' + data.photos[key].photo_id + '" data-lity="data-lity"><img class="card-img-top lazyload" data-src="/api/media/photo/' + data.photos[key].photo_id + '" />\n' +
                                '                        <div class="card-body">\n' +
                                '                            <img class="user-icon lazyload" data-src="/api/media/profile-icon/' + data.photos[key].user_info.user_id + '" /><span class="card-text">' + data.photos[key].user_info.view_name + '</span>\n' +
                                '                        </div></a>\n';
                            if (user_info.user_id == data.photos[key].user_info.user_id) {
                                photo_list_elements +=
                                    '                    <a href="#" onclick="deletePhoto(' + data.photos[key].photo_id + ')"><img class="trash-icon" src="/img/common/trash.svg"></a>\n';
                            }
                            photo_list_elements +=
                                '                </div>';

                            photo_count++;
                        });
                        $("#photo-list-bottom").before(
                            photo_list_elements
                        );

                    }
                )
                // Ajaxリクエストが失敗した時発動
                .fail(
                    (data) => {
                        console.log(data);
                        if (data.status == "unauthorized") {
                            window.location.href = '/login?pass_code={{\Config::get('auth.access_code')}}';
                        }
                        iziToast.error({message: '写真の取得に失敗しました。しばらくしてから再度お試しください。', position: 'topCenter', transitionInMobile: 'fadeInDown', transitionOutMobile: 'fadeOutUp',});
                    }
                )
                // Ajaxリクエストが成功・失敗どちらでも発動
                .always(
                    (data) => {
                        document.getElementById("camera-input").value = "";
                        document.getElementById("photo-add-input").value = "";

                        prev_photo_ajax_status = true;
                        // $("#loading").css("display", "none");
                    }
                );
        }

    }

    //アップロード確認ダイアログ(今回使用しない)
    function uploadConfirmDialog() {
        // console.log(document.getElementById("camera-input").value);
        // console.log(document.getElementById("photo-add-input").value);
        if (document.getElementById("camera-input").value != "" || document.getElementById("photo-add-input").value != "") {

            if (document.getElementById("camera-input").value != "") {
                var photo_input_path = document.getElementById("camera-input").value;
            } else if (document.getElementById("photo-add-input").value != "") {
                var photo_input_path = document.getElementById("photo-add-input").value;
            } else {
                var photo_input_path = "";
            }

            console.log(photo_input_path);

            var element = document.getElementById("upload-confirm-dialog-trigger");
            if (document.createEvent) {
                // IE以外
                var evt = document.createEvent("HTMLEvents");
                evt.initEvent("click", true, true ); // event type, bubbling, cancelable

                // inputを初期化
                document.getElementById("camera-input").value = "";
                document.getElementById("photo-add-input").value = "";

                // イベント発火
                return element.dispatchEvent(evt);
            } else {
                // IE
                var evt = document.createEventObject();

                // inputを初期化
                document.getElementById("camera-input").value = "";
                document.getElementById("photo-add-input").value = "";

                // イベント発火
                return element.fireEvent("onclick", evt);
            }
        }
    }

    function photoDeleteEvent(delete_target_id){
        $('#photo_'+delete_target_id).remove();
    }
</script>
</body>
