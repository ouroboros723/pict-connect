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

    <style>
        /* イベント一覧用のアイコンスタイル */
        @media screen and (max-width: 699px) {
            .photo-cell a img.edit-icon {
                width: 25px;
                height: 25px !important;
                position: absolute;
                top: 7px;
                left: 5px;
            }
            .photo-cell a img.trash-icon {
                width: 25px;
                height: 25px !important;
                position: absolute;
                top: 7px;
                left: calc(100% - 30px);
            }
        }
        @media screen and (min-width: 700px) and (max-width: 999px) {
            .photo-cell a img.edit-icon {
                width: 25px;
                height: 25px !important;
                position: absolute;
                top: 7px;
                left: 5px;
            }
            .photo-cell a img.trash-icon {
                width: 25px;
                height: 25px !important;
                position: absolute;
                top: 7px;
                left: calc(100% - 30px);
            }
        }
        @media screen and (min-width: 1000px) {
            .photo-cell a img.edit-icon {
                width: 25px;
                height: 25px !important;
                position: absolute;
                top: 7px;
                left: 5px;
            }
            .photo-cell a img.trash-icon {
                width: 25px;
                height: 25px !important;
                position: absolute;
                top: 7px;
                left: calc(100% - 30px);
            }
        }
    </style>

    <button id="InstallBtn" class="installbotton" style="display:none;">
        アプリをインストールする
    </button>

    @yield('commonscript')

    <script>
        var user_info = @json($user_info) ?? null;
        var last_event_id = "";
        var begin_event_id = "";
        var photo_count = 0;
        var ajax_status = true;
        var prev_photo_ajax_status = true;
        var upload_status = true;

        if ('' === user_info || null === user_info) {
            window.location.href = '/login?pass_code={{Config::get('auth.access_code')}}';
        }

        window.addEventListener('load', function () {
            getEvents();
        });
        window.addEventListener('focus', function () {
            getEvents();
            setTimeout(function () {
                window.Echo.channel('event-lib')
                    .listen('PublicEvent', (e) => {
                        // console.log(e.message);
                        if (e.message === 'new_photo_posted' && ajax_status) {
                            getEvents();
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

        $(document).ready(function () {
            window.Echo.channel('event-lib')
                .listen('PublicEvent', (e) => {
                    // console.log(e.message);
                    if (e.message === 'new_photo_posted' && ajax_status) {
                        getEvents();
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
        function getEvents() {
            if (ajax_status) {
                $.ajax(
                    {
                        url: '/api/event/list/joined?lastEventId=' + last_event_id,
                        type: 'GET',
                        processData: false,
                        contentType: false,
                        async: true,
                        headers: {
                            'X-User-Token': user_info.token,
                            'X-User-Token-Sec': user_info.token_sec,
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
                            console.log(data.body.length);
                            // return;
                            if (data.body.length === 0) {
                                return;
                            }
                            last_event_id = data.body[(data.body.length - 1)]?.event?.eventId ?? '';
                            var photo_list_elements = '';

                            Object.keys(data.body).forEach(function (key) {
                                // console.log(key);
                                if (photo_count == 0) {
                                    begin_event_id = data.body[data.body.length - 1].event.eventId;
                                }
                                photo_list_elements +=

                                    '<div id="photo_' + (data.body[key]?.event?.eventId ?? null) + '" class="col photo-cell">\n' +
                                    // '                    <div class="card">\n' +
                                    '                        <a href="/event/joined/' + (data.body[key]?.event?.eventId ?? null) + '" ><img class="card-img-top lazyload" src="/img/common/photoloading.gif" data-src="/api/media/event-icon/' + (data.body[key]?.event?.eventId ?? null) + '" />\n' +
                                    '                        <div class="card-body">\n' +
                                    '                            <span class="event-text">' + data.body[key].event.eventName + '</span>\n' +
                                    '                        </div></a>\n';

                                // ログイン中ユーザーがイベント管理者の場合、編集・削除アイコンを表示
                                // console.log('Debug info:', {
                                //     user_id: user_info.user_id,
                                //     user_id_type: typeof user_info.user_id,
                                //     event_admin_id: data.body[key].event.eventAdminId,
                                //     event_admin_id_type: typeof data.body[key].event.eventAdminId,
                                //     is_equal: user_info.user_id == data.body[key].event.eventAdminId,
                                //     is_strict_equal: user_info.user_id === data.body[key].event.eventAdminId,
                                //     event_name: data.body[key].event.eventName
                                // });

                                if (user_info && user_info.user_id && data.body[key].event && data.body[key].event.eventAdminId &&
                                    parseInt(user_info.user_id) === parseInt(data.body[key].event.eventAdminId)) {
                                    photo_list_elements +=
                                        '                        <a href="/event/edit/' + (data.body[key]?.event?.eventId ?? null) + '"><img class="edit-icon" src="/img/common/edit.svg" alt="編集"></a>\n' +
                                        '                        <a href="#" onclick="deleteEvent(' + (data.body[key]?.event?.eventId ?? null) + ')"><img class="trash-icon" src="/img/common/trash.svg" alt="削除"></a>\n';
                                }

                                photo_list_elements +=
                                    '                </div>';

                                photo_count++;
                            });
                            console.log(photo_list_elements);
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
                        url: '/api/event/list/joined?lastEventId=' + begin_event_id,
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
                            // console.log(data.photos);
                            if (data.photos.length === 0) {
                                return;
                            }
                            begin_event_id = data.photos[data.photos.length - 1].photo_id;
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


                            prev_photo_ajax_status = true;
                            // $("#loading").css("display", "none");
                        }
                    );
            }

        }

        //アップロード確認ダイアログ(今回使用しない)
        // function uploadConfirmDialog() {
        //     // console.log(document.getElementById("camera-input").value);
        //     // console.log(document.getElementById("photo-add-input").value);
        //     if (document.getElementById("camera-input").value != "" || document.getElementById("photo-add-input").value != "") {
        //
        //         if (document.getElementById("camera-input").value != "") {
        //             var photo_input_path = document.getElementById("camera-input").value;
        //         } else if (document.getElementById("photo-add-input").value != "") {
        //             var photo_input_path = document.getElementById("photo-add-input").value;
        //         } else {
        //             var photo_input_path = "";
        //         }
        //
        //         // console.log(photo_input_path);
        //
        //         var element = document.getElementById("upload-confirm-dialog-trigger");
        //         if (document.createEvent) {
        //             // IE以外
        //             var evt = document.createEvent("HTMLEvents");
        //             evt.initEvent("click", true, true ); // event type, bubbling, cancelable
        //
        //             // inputを初期化
        //             document.getElementById("camera-input").value = "";
        //             document.getElementById("photo-add-input").value = "";
        //
        //             // イベント発火
        //             return element.dispatchEvent(evt);
        //         } else {
        //             // IE
        //             var evt = document.createEventObject();
        //
        //             // inputを初期化
        //             document.getElementById("camera-input").value = "";
        //             document.getElementById("photo-add-input").value = "";
        //
        //             // イベント発火
        //             return element.fireEvent("onclick", evt);
        //         }
        //     }
        // }

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
            fd.append("event_id", "1");

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
                                getEvents();
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

                            // $("#loading").css("display", "none");
                            upload_status = true;
                        }
                    );
            }

        }

        function photoDeleteEvent(delete_target_id){
            $('#photo_'+delete_target_id).remove();
        }

        // イベント削除関数
        function deleteEvent(eventId) {
            // 削除確認のための文字列入力ダイアログを表示
            var confirmText = prompt('イベントを削除するには、「delete」と入力してください:');
            if (confirmText === null || confirmText === '') {
                return; // キャンセルまたは空の場合は処理を中止
            }

            if (confirmText !== 'delete') {
                alert('「delete」と正確に入力してください。');
                return;
            }

            // 削除確認
            if (!confirm('本当にこのイベントを削除しますか？この操作は取り消せません。')) {
                return;
            }

            // Ajax リクエストでイベント削除API を呼び出し
            $.ajax({
                url: '/api/event/delete/' + eventId,
                type: 'DELETE',
                data: {
                    confirmText: confirmText
                },
                headers: {
                    'X-User-Token': user_info.token,
                    'X-User-Token-Sec': user_info.token_sec,
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    // ローディング表示
                },
                success: function (data) {
                    iziToast.success({
                        message: 'イベントを削除しました。',
                        position: 'topCenter',
                        transitionInMobile: 'fadeInDown',
                        transitionOutMobile: 'fadeOutUp'
                    });
                    // イベントタイルを削除
                    $('#photo_' + eventId).remove();
                },
                error: function (xhr) {
                    var message = 'イベントの削除に失敗しました。';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    iziToast.error({
                        message: message,
                        position: 'topCenter',
                        transitionInMobile: 'fadeInDown',
                        transitionOutMobile: 'fadeOutUp'
                    });
                    if (xhr.status === 401) {
                        window.location.href = '/login?pass_code={{\Config::get('auth.access_code')}}';
                    }
                }
            });
        }
    </script>
</body>
