@include('viewer.components.flame')

@yield('meta')
<body>
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
    <div id="loading" style="display: none;"><img src="{{asset("img/common/loading.gif")}}"></div>
    <div id="main-container">
        <div id="photo-cards" class="">
            <div id="photo-list-top"></div>
{{--            <div class="row">--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <img class="card-img-top" src="" alt="Card image cap">--}}
{{--                        <div class="card-body">--}}
{{--                            <p class="card-text">text</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">--}}
{{--                        <div class="card-body">--}}
{{--                            <p class="card-text">text</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">--}}
{{--                        <div class="card-body">--}}
{{--                            <p class="card-text">text</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row">--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">--}}
{{--                        <div class="card-body">--}}
{{--                            <p class="card-text">text</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">--}}
{{--                        <div class="card-body">--}}
{{--                            <p class="card-text">text</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">--}}
{{--                        <div class="card-body">--}}
{{--                            <p class="card-text">text</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row">--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">--}}
{{--                        <div class="card-body">--}}
{{--                            <p class="card-text">text</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">--}}
{{--                        <div class="card-body">--}}
{{--                            <p class="card-text">text</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">--}}
{{--                        <div class="card-body">--}}
{{--                            <p class="card-text">text</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row">--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">--}}
{{--                        <div class="card-body">--}}
{{--                            <p class="card-text">text</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">--}}
{{--                        <div class="card-body">--}}
{{--                            <p class="card-text">text</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">--}}
{{--                        <div class="card-body">--}}
{{--                            <p class="card-text">text</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row">--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">--}}
{{--                        <div class="card-body">--}}
{{--                            <p class="card-text">text</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
{{--                        <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">--}}
{{--                        <div class="card-body">--}}
{{--                            <p class="card-text">text</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col">--}}
{{--                    <div class="card">--}}
            {{--                        <img class="card-img-top" src="https://unsplash.it/630/400" alt="Card image cap">--}}
            {{--                        <div class="card-body">--}}
            {{--                            <p class="card-text">text</p>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
        {{-- 写真選択・アップロードボタン --}}
        <button type="button" id="camera-button" class="btn btn-primary rounded-circle p-0"><input id="camera-input"
                                                                                                   class="photo-input-hidden"
                                                                                                   type="file"
                                                                                                   name="image"
                                                                                                   accept="image/jpeg, image/png"
                                                                                                   capture><label
                for="camera-input"><img src="{{ asset('img/common/camera.png') }}"/></label></button>
        <button type="button" id="photo-add-button" class="btn btn-primary rounded-circle p-0"><input
                id="photo-add-input" class="photo-input-hidden" type="file" name="image" accept="image/jpeg, image/png"><label
                for="photo-add-input"><img src="{{ asset('img/common/photos.png') }}"/></label></button>

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
                        <img src="https://unsplash.it/630/400" style="width: 100%"/>
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

    @yield('commonscript')

    <script>
        var user_info = @json($user_info);
        var last_photo_id = "";
        var photo_count = 0;
        var ajax_status = true;

        if( '' === user_info || null === user_info) {
                window.location.href = '/login';
        }

        window.addEventListener('load', function(){getPhotos();})

        document.getElementById("camera-button").addEventListener("change", function(){photoUploadExec(user_info);});
        document.getElementById("photo-add-button").addEventListener("change", function(){photoUploadExec(user_info);});

        $(document).ready(function () {
            window.Echo.channel('event-lib')
                .listen('PublicEvent', (e) => {
                    if(e.message = 'new_photo_posted' && ajax_status){
                        getPhotos();
                    }
                });
        });

        //写真取得
        function getPhotos() {
            $.ajax(
                {
                    url:'/api/media/photo/list?event_id=1&last_photo_id='+last_photo_id,
                    type:'GET',
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-User-Token': user_info.token,
                        'X-User-Token-Sec': user_info.token_sec,
                    },
                    data: {
                        "event_id": '1',
                    },
                    beforeSend: function() {
                        ajax_status = false;
                        $("#loading").css("display","block");
                    },
                }
            )
            // Ajaxリクエストが成功した時発動
                .done(
                    (data) => {
                        console.log(data.photos);
                        if(data.photos.length === 0){
                            return;
                        }
                        last_photo_id = data.photos[0].photo_id;
                        var photo_list_elements = '';

                        Object.keys(data.photos).forEach(function(key){
                            console.log(key);
                            if(photo_count == 0){
                                // photo_list_elements += '<div class="row">'
                            }
                            photo_list_elements +=

                                '<div id="photo_'+data.photos[key].photo_id+'" class="col photo-cell">\n' +
                                '                    <div class="card p-3">\n' +
                                '                        <img class="card-img-top" src="data:'+data.photos[key].mime_type+';base64,'+data.photos[key].photo_base64+'" />\n' +
                            '                        <div class="card-body">\n' +
                            '                            <p class="card-text">'+data.photos[key].user_info.view_name+'</p>\n' +
                            '                        </div>\n' +
                            '                    </div>\n' +
                            '                </div>';

                            photo_count ++;
                        });
                        $("#photo-list-top").after(
                            photo_list_elements
                        );

                    }
                )
                // Ajaxリクエストが失敗した時発動
                .fail(
                    (data) => {
                        console.log(data);
                        if(data.status == "unauthorized"){
                            window.location.href = '/login';
                        }
                        iziToast.error({ title: 'pict-viewer', message: '写真の取得に失敗しました。しばらくしてから再度お試しください。' });
                    }
                )
                // Ajaxリクエストが成功・失敗どちらでも発動
                .always(
                    (data) => {
                        document.getElementById("camera-input").value = "";
                        document.getElementById("photo-add-input").value = "";

                        ajax_status = true;
                        $("#loading").css("display","none");
                    }
                );
        }

        //アップロード確認ダイアログ(今回使用しない)
        function uploadConfirmDialog() {
            // console.log(document.getElementById("camera-input").value);
            // console.log(document.getElementById("photo-add-input").value);
            if (document.getElementById("camera-input").value != "" || document.getElementById("photo-add-input").value != "" ) {

                if (document.getElementById("camera-input").value != ""){
                    var photo_input_path = document.getElementById("camera-input").value;
                }
                else if (document.getElementById("photo-add-input").value != ""){
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

        function photoUploadExec(user_info) {
            var fd = new FormData();
            if (document.getElementById("camera-input").value !== ""){
                var photo_data = document.querySelector('#camera-input').files;
                console.log(document.querySelector('#camera-input').files);
                console.log(photo_data);
            }
            else if (document.getElementById("photo-add-input").value != ""){
                var photo_data = document.querySelector('#photo-add-input').files;
                console.log(document.querySelector('#photo-add-input').files);
                console.log(photo_data);
            } else {
                var photo_data = "";
            }

            if (photo_data !== ""){
                fd.append("photo_data", photo_data[0]); //(key(form name), data) 複数渡すときはここを拡張
                fd.append("event_id", "1");

                $.ajax(
                    {
                        url:'/api/uploader/photo-upload',
                        type:'POST',
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-User-Token': user_info.token,
                            'X-User-Token-Sec': user_info.token_sec,
                        },
                        data:fd, //FormDataオブジェクトはそのままdataとして渡す。
                        beforeSend: function() {
                            $("#loading").css("display","block");
                        },
                    }
                )
                // Ajaxリクエストが成功した時発動
                .done(
                    (data) => {
                        console.log(data);
                        iziToast.success({ title: 'pict-throw', message: '写真のアップロードに成功しました。' });
                        getPhotos();
                    }
                )
                // Ajaxリクエストが失敗した時発動
                .fail(
                    (data) => {
                        console.log(data);
                        iziToast.error({ title: 'pict-throw', message: '写真のアップロードに失敗しました。' });
                        if(data.status == "unauthorized"){
                            window.location.href = '/login';
                        }
                    }
                )
                // Ajaxリクエストが成功・失敗どちらでも発動
                .always(
                    (data) => {
                        document.getElementById("camera-input").value = "";
                        document.getElementById("photo-add-input").value = "";
                        $("#loading").css("display","none");
                    }
                );
            }
        }
    </script>
</body>
