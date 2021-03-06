@include('viewer.components.flame')

@yield('meta')
<body>
@yield('header')
@yield('side-menu')
{{--todo: メニューはユーザーアイコン部分に統一--}}
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
<div id="loading" style="display: none;"><img src="{{asset("img/common/loading.gif")}}"></div>
<div id="main-container">
    <div id="photo-cards" class="">
        <div id="photo-list-top"></div>
        {{-- 写真がここに入る --}}
        <div id="photo-list-bottom"></div>
    </div>
    {{-- 写真選択・アップロードボタン --}}
    <button type="button" id="camera-button" class="btn btn-primary rounded-circle p-0"><input id="camera-input"
                                                                                               class="photo-input-hidden"
                                                                                               type="file"
                                                                                               name="image"
                                                                                               accept="image/*"
                                                                                               capture><label
            for="camera-input"><img title="カメラを起動" src="{{ asset('img/common/camera.png') }}"/></label></button>
    <button type="button" id="photo-add-button" class="btn btn-primary rounded-circle p-0"><input multiple
                                                                                                  id="photo-add-input"
                                                                                                  class="photo-input-hidden"
                                                                                                  type="file"
                                                                                                  name="image"
                                                                                                  accept="image/*"><label
            for="photo-add-input"><img title="写真を選択してアップロード" src="{{ asset('img/common/photos.png') }}"/></label></button>

    <div id="event-detail-dialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>
                        <div class="modal-title" id="myModalLabel">イベント詳細</div>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-12">

                                            <div class="form-group row">
                                                <div style="width: 100%; text-align: center;">
                                                    <img id="eventIcon" alt="イベントアイコン" style="width: 128px" src="{{asset('img/common/anonman.svg')}}" />
                                                    <h2 style="padding-top: 10px" id="eventName"></h2>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="eventDetail" class="col-md-4 col-form-label text-md-right">{{ __('イベント詳細') }}</label>

                                                <div class="col-md-6 col-form-label">
                                                    <span id="eventDetail"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="eventPeriodStart" class="col-md-4 col-form-label text-md-right">{{ __('開催期間(開始)') }}</label>

                                                <div class="col-md-6 col-form-label">
                                                    <span id="eventPeriodStart"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="eventPeriodEnd" class="col-md-4 col-form-label text-md-right">{{ __('開催期間(終了)') }}</label>

                                                <div class="col-md-6 col-form-label">
                                                    <span id="eventPeriodEnd"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="participantsCount" class="col-md-4 col-form-label text-md-right">{{ __('参加者数') }}</label>

                                                <div class="col-md-6 col-form-label">
                                                    <span id="participantsCount"></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="postedPhotosCount" class="col-md-4 col-form-label text-md-right">{{ __('投稿写真数') }}</label>

                                                <div class="col-md-6 col-form-label">
                                                    <span id="postedPhotosCount"></span>
                                                </div>
                                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>
    <div id="upload-confirm-dialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>
                        <div class="modal-title" id="myModalLabel">投稿しますか？</div>
                    </h4>
                </div>
                <div class="modal-body">
{{--                    <img src="https://unsplash.it/630/400" style="width: 100%"/>--}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-danger">アップロード</button>
                </div>
            </div>
            </div>
        </div>

        <a id="upload-confirm-dialog-trigger" class="btn btn-primary" data-toggle="modal" data-target="#upload-confirm-dialog" style="display: none"></a>
        <a id="event-detail-dialog-trigger" class="btn btn-primary" data-toggle="modal" data-target="#event-detail-dialog" style=""></a>

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
    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
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
            getEventDetail();
            $('#title-nav').append('<a id="event-detail-dialog-trigger" class="btn btn-primary" data-toggle="modal" data-target="#event-detail-dialog" style=""><img id="event-detail-img" src="{{asset('img/common/info.svg')}}" title="イベント詳細" style="width: 30px" /></a>');
        });
        window.addEventListener('focus', function () {
            getPhotos();
            setTimeout(function () {
                window.Echo.channel('event-lib')
                    .listen('PublicEvent', (e) => {
                        // console.log(e.message);
                        if (e.message === 'new_photo_posted' && ajax_status) {
                            getPhotos();
                        } else if (e.message === 'photo_deleted' && ajax_status) {
                            // console.log(e.delete_target_id);
                            photoDeleteEvent(e.delete_target_id);
                        }
                    }).listen('PhotoDeleteEvent', (e) => {
                        alert();
                        if (e.message === 'photo_deleted') {
                            // console.log(e.delete_target_id);
                            photoDeleteEvent(e.delete_target_id);
                        }
                    });
            }, 500);
        });

        document.getElementById("camera-button").addEventListener("change", function () {
            photoUploadExec(user_info);
        });
        document.getElementById("photo-add-button").addEventListener("change", function () {
            photoUploadExec(user_info);
        });

        $(document).ready(function () {
            window.Echo.channel('event-lib')
                .listen('PublicEvent', (e) => {
                    // console.log(e.message);
                    if (e.message === 'new_photo_posted' && ajax_status) {
                        getPhotos();
                    } else if (e.message === 'photo_deleted' && ajax_status) {
                        // console.log(e.delete_target_id);
                        photoDeleteEvent(e.delete_target_id);
                    }
                }).listen('PhotoDeleteEvent', (e) => {
                    alert();
                    if (e.message === 'photo_deleted') {
                        // console.log(e.delete_target_id)
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
                        url: '/api/media/photo/text-list?event_id={{$event_id}}&last_photo_id=' + last_photo_id,
                        type: 'GET',
                        processData: false,
                        contentType: false,
                        async: true,
                        headers: {
                            'X-User-Token': user_info.token,
                            'X-User-Token-Sec': user_info.token_sec,
                        },
                        data: {
                            "event_id": {{$event_id}}, // todo: 現在参加中のイベントidを入れるようにする
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
                            // console.log(data.photos);
                            if (data.photos.length === 0) {
                                return;
                            }
                            last_photo_id = data.photos[0].photo_id;
                            var photo_list_elements = '';

                            Object.keys(data.photos).forEach(function (key) {
                                // console.log(key);
                                if (photo_count == 0) {
                                    begin_photo_id = data.photos[data.photos.length - 1].photo_id;
                                }
                                photo_list_elements +=

                                    '<div id="photo_' + data.photos[key].photo_id + '" class="col photo-cell">\n' +
                                    // '                    <div class="card">\n' +
                                    '                        <a href="/api/media/photo/' + data.photos[key].photo_id + '" data-lity="data-lity"><img class="card-img-top lazyload" src="/img/common/photoloading.gif" data-src="/api/media/photo/' + data.photos[key].photo_id + '/thumbnail" />\n' +
                                    '                        <div class="card-body">\n' +
                                    '                            <img class="user-icon lazyload" data-src="/api/media/profile-icon/' + data.photos[key].user_info.user_id + '" /><span class="card-text">' + data.photos[key].user_info.view_name + '</span>\n' +
                                    '                        </div></a>\n';
                                photo_list_elements +=
                                    '<a href="/api/media/photo/'+ data.photos[key].photo_id +'/download" ><img class="download-icon" src="/img/common/download.svg"></a>\n';
                                if (user_info.user_id == data.photos[key].user_info.user_id) {
                                    photo_list_elements +=
                                        '                    <a href="#" onclick="deletePhoto(' + data.photos[key].photo_id + ')"><img class="trash-icon" src="/img/common/trash.svg"></a>\n';
                                }
                                photo_list_elements +=
                                    '                </div>';

                                photo_count++;
                            });
                            $("#photo-list-top").after(
                                photo_list_elements
                            );
                            $("img.lazyload").lazyload({
                                placeholder: '/img/common/photoloading.gif',
                            });

                            // unloadと再lazyload設定の処理
                            $('#main-container').on('scroll', function() {
                                // 画像コンテナ内の全ての画像要素を取得
                                let images = $('.card-img-top');

                                // 画像要素ごとに処理を行う
                                images.each(function() {
                                    let image = $(this);
                                    // console.log('image: ', image);
                                    if (isOutOfViewport(image)) {
                                        // console.log(image.attr('src')+ 'was out of viewport.')
                                        image.attr('src', '/img/common/photoloading.gif'); // 画像を非表示
                                        image.lazyload(); // lazyload を再設定
                                    }
                                });
                            });

                            // Viewport外に出たかどうかを判定する関数
                            function isOutOfViewport($element) {
                                let elementOffset = $element.offset();
                                let elementHeight = $element.height();
                                let viewportTop = $(window).scrollTop();
                                let viewportBottom = viewportTop + $(window).height();

                                return (elementOffset.top + elementHeight < viewportTop || elementOffset.top > viewportBottom);
                            }

                            // 初期表示時にも1回スクロールイベントを発火して画像表示を更新
                            // $(window).trigger('scroll');
                        }
                    )
                    // Ajaxリクエストが失敗した時発動
                    .fail(
                        (data) => {
                            // console.log(data);
                            if(data.status == "unauthorized"){
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
                        url: '/api/media/photo/prev_list?event_id={{$event_id}}&begin_photo_id=' + begin_photo_id,
                        type: 'GET',
                        processData: false,
                        contentType: false,
                        async: true,
                        headers: {
                            'X-User-Token': user_info.token,
                            'X-User-Token-Sec': user_info.token_sec,
                        },
                        data: {
                            "event_id": {{$event_id}},
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
                            // console.log(data.photos);
                            if (data.photos.length === 0) {
                                return;
                            }
                            begin_photo_id = data.photos[data.photos.length - 1].photo_id;
                            var photo_list_elements = '';

                            Object.keys(data.photos).forEach(function (key) {
                                // console.log(key);
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
                            // console.log(data);
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

                // console.log(photo_input_path);

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

        function eventDetailDialog() {
            // console.log(document.getElementById("camera-input").value);
            // console.log(document.getElementById("photo-add-input").value);

                // console.log(photo_input_path);

                var element = document.getElementById("event-detail-dialog-trigger");
                if (document.createEvent) {
                    // IE以外
                    var evt = document.createEvent("HTMLEvents");
                    evt.initEvent("click", true, true ); // event type, bubbling, cancelable

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

        const getEventDetail = () => {
            $.ajax(
                {
                    url: '/api/event/detail/{{$event_id}}',
                    type: 'GET',
                    // processData: false,
                    // contentType: false,
                    async: true,
                    headers: {
                        'X-User-Token': user_info.token,
                        'X-User-Token-Sec': user_info.token_sec,
                    },
                    // beforeSend: function () {
                    //     ajax_status = false;
                    //     // $("#loading").css("display", "block");
                    // },
                }
            ).done((data) => {
                console.log(data);
                if(data.body?.iconPath) {
                    $('#eventIcon').attr('src', '/api/media/event-icon/{{$event_id}}');
                }
                $('#eventName').html(data.body?.eventName);
                $('#eventDetail').html(data.body?.eventDetail);
                $('#eventPeriodStart').html(data.body?.eventPeriodStart);
                $('#eventPeriodEnd').html(data.body?.eventPeriodEnd);
                $('#participantsCount').html(data.body?.participantsCount);
                $('#postedPhotosCount').html(data.body?.postedPhotosCount);
            }).fail(() => {
                alert('イベント情報の取得に失敗しました')
            });
        }

        function photoUploadExec(user_info) {
            var fd = new FormData();
            if (document.getElementById("camera-input").value !== "") {
                var photo_data = document.querySelector('#camera-input').files;
                // console.log(document.querySelector('#camera-input').files);
                // console.log(photo_data);
            } else if (document.getElementById("photo-add-input").value != "") {
                var photo_data = document.querySelector('#photo-add-input').files;
                // console.log(document.querySelector('#photo-add-input').files);
                // console.log(photo_data);
            } else {
                var photo_data = "";
            }

            iziToast.info(
                {
                    id: 'uploading-toast',
                    message: '写真をアップロードしています...',
                    position: 'topCenter', transitionInMobile: 'fadeInDown', transitionOutMobile: 'fadeOutUp',
                    close: 'false',
                    timeout: 0,
                }
            );
// debugger
//             console.log('photo_data:', photo_data);

            //todo: このappend部分をループさせるようにする
            //(key(form name), data) 複数渡すときはここを拡張

            var imgobj = [];
            for (i = 0; i < photo_data.length; i++) {
                fd.append('photo_data[' + i + ']', photo_data[i]);
            }
            // fd.append("photo_data", imgobj);
            fd.append("event_id", "{{$event_id}}");

            $.ajax(
                {
                    url: '/api/uploader/photo-upload',
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    async: true,
                    xhr : function(){
                        var XHR = $.ajaxSettings.xhr();
                        if(XHR.upload){
                            XHR.upload.addEventListener('progress',function(e){
                                var progre = parseInt((e.loaded/e.total*100) + 1);
                                // console.log(progre);
                                if(progre >= 101){
                                    $('#uploading-toast .iziToast-message').text('写真を処理しています...');
                                } else {
                                    $('#uploading-toast .iziToast-message').text('写真をアップロードしています...'+progre+'%');
                                }
                            }, false);
                        }
                        return XHR;
                    },
                    headers: {
                        'X-User-Token': user_info.token,
                        'X-User-Token-Sec': user_info.token_sec,
                    },
                    data: fd, //FormDataオブジェクトはそのままdataとして渡す。
                    beforeSend: function () {
                        // $("#loading").css("display", "block");
                        upload_status = false;
                    },
                }
            )
                // Ajaxリクエストが成功した時発動
                        .done(
                            (data) => {
                                // console.log(data);
                                iziToast.success({message: '写真のアップロードに成功しました。', position: 'topCenter', transitionInMobile: 'fadeInDown', transitionOutMobile: 'fadeOutUp',});
                                getPhotos();
                            }
                        )
                        // Ajaxリクエストが失敗した時発動
                        .fail(
                            (data) => {
                                // console.log(data);
                                iziToast.error({message: '写真のアップロードに失敗しました。', position: 'topCenter', transitionInMobile: 'fadeInDown', transitionOutMobile: 'fadeOutUp',});
                                if (data.status == "unauthorized") {
                                    window.location.href = '/login?pass_code={{\Config::get('auth.access_code')}}';
                                }
                            }
                        )
                        // Ajaxリクエストが成功・失敗どちらでも発動
                        .always(
                            (data) => {
                                document.getElementById("camera-input").value = "";
                                document.getElementById("photo-add-input").value = "";
                                // $("#loading").css("display", "none");
                                $('#uploading-toast .iziToast-close').trigger('click');
                                upload_status = true;
                            }
                        );

        }

        function deletePhoto(delete_target_id) {
            var res = confirm("削除しますか？");
            if( res == true ) {
                // console.log(delete_target_id);
                $.ajax(
                    {
                        url: '/api/uploader/photo-delete',
                        type:'POST',
                        dataType: 'json',
                        timeout:3000,
                        async: true,
                        headers: {
                            'X-User-Token': user_info.token,
                            'X-User-Token-Sec': user_info.token_sec,
                        },
                        data : {"delete_target_id" : delete_target_id},
                        beforeSend: function () {
                            // $("#loading").css("display", "block");
                            upload_status = false;
                        },
                    }
                )
                    // Ajaxリクエストが成功した時発動
                    .done(
                        (data) => {
                            // console.log(data);
                            iziToast.success({message: '写真の削除に成功しました。', position: 'topCenter', transitionInMobile: 'fadeInDown', transitionOutMobile: 'fadeOutUp',});
                            photoDeleteEvent(delete_target_id);
                        }
                    )
                    // Ajaxリクエストが失敗した時発動
                    .fail(
                        (data) => {
                            // console.log(data);
                            iziToast.error({message: '写真の削除に失敗しました。', position: 'topCenter', transitionInMobile: 'fadeInDown', transitionOutMobile: 'fadeOutUp',});
                            if (data.status == "unauthorized") {
                                window.location.href = '/login?pass_code={{\Config::get('auth.access_code')}}';
                            }
                        }
                    )
                    // Ajaxリクエストが成功・失敗どちらでも発動
                    .always(
                        (data) => {
                            document.getElementById("camera-input").value = "";
                            document.getElementById("photo-add-input").value = "";
                            // $("#loading").css("display", "none");
                            upload_status = true;
                        }
                    );
            }

        }

        function photoDeleteEvent(delete_target_id){
            $('#photo_'+delete_target_id).remove();
        }
    </script>
</body>
