{{--Basecode from https://qiita.com/tommy-hayashida/items/d54530c2a515d1c35a90--}}
@include('viewer.components.flame')

    <!DOCTYPE html>
<html>
<head>
    @yield('meta')
    <met a charset="utf-8"></met>
    {{--        <link rel="stylesheet" type="text/css" href="slick.css"/>--}}
    {{--        <link rel="stylesheet" type="text/css" href="slick-theme.css"/>--}}
    <style>
        body {
            background-color: black;
            height: 100vh;
        }

        .container {
            margin: 0 auto;
            padding: 10px;
            width: 95%;
            color: #333;
            background: black;
        }

        .slider {
            text-align: center;
            color: #419be0;
            background: black;
        }

        .slider img {
            padding: 10px;
            background: black;
            width: auto;
            height: 300px;
            margin: 0 auto;
        }
        .photo-info-area img.user-icon {
            position: absolute;
            display: inline;
            height: 100% !important;
            left: 50px;
        }

        .photo-info-area {
            height: 20vh;
            position: relative;
        }

        .photo-info-area .user-name {
            position: absolute;
            left: 250px;
            top: 50%;
            transform: translate(0, -50%);
            font-size: xx-large;
            color: white;
        }
    </style>
    <title>slide show</title>
</head>


<body id="event-lib-slideshow">
<div class='container'>
    <div id='photo-contents' class='slider'>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css"
      crossorigin="anonymous">
<script src="{{asset('js/app.js')}}"></script>

<script>
    var user_info = @json($user_info);
    var ajax_status = true;
    var currentSlide = null;

    window.Echo.channel('event-lib')
        .listen('PublicEvent', (e) => {
            // console.log(e.message);
            if (e.message === 'new_photo_posted' && ajax_status) {
                getPhotos();
            } else if (e.message === 'photo_deleted' && ajax_status) {
                getPhotos();
            }
        });

    iziToast.settings({
        transitionIn: 'fadeInDown',
        transitionOut: 'fadeOutUp',
    });

    //写真取得
    function getPhotos() {
        if (ajax_status) {
            $.ajax(
                {
                    url: '/api/media/photo/text-list?event_id={{$event_id}}',
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

                        // 削除された写真をDOMから削除
                        $('.photo-data').each((index, el) => {
                            // console.log(el);
                            if(data.photos.findIndex((element) => Number(element.photo_id) === Number(el?.getAttribute('data-photo-id'))) === -1) {
                                $('.slider').slick("slickRemove", index);
                                // console.log('deleted: ', el?.getAttribute('data-photo-id'));
                            }
                            // console.log('not deleted: ', el?.getAttribute('data-photo-id'));
                        });

                        let k = 1;
                        data.photos.map((value, index) =>{
                            // console.log($('[data-photo-id="' + value.photo_id + '"]'));
                            if($('[data-photo-id="' + value.photo_id + '"]')?.length <= 0) {
                                $('.slider').slick("slickAdd", '<div class="photo-data" data-photo-id="' + value.photo_id + '">' +
                                    '<img data-lazy = "/api/media/photo/' + value.photo_id + '">' +
                                    '<div class="photo-info-area">' +
                                        '<img class="user-icon" data-lazy="/api/media/profile-icon/' + value.user_info.user_id + '" />' +
                                        '<span class="user-name">' + value.user_info.view_name + '</span>' +
                                        '</div>' +
                                    '</div>', currentSlide + k + 1);
                                k ++;
                                // console.log('added!');
                            }
                        });
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

    function getArrayDiff(arr1, arr2) {
        // arr1にarr2の要素がなかったらarrに加える
        let arr = [];
        for (k = 0; k < arr1.length; k++) {
            for (l = 0; l < arr2.length; l++) {
                if (arr1[k].src == arr2[l].src) {
                    break;
                }
            }
            if (l == arr2.length) {
                arr.push(arr1[k]);
            }
        }
        return arr;
    }


    $(function () {
        $.ajax(
            {
                url: '/api/media/photo/text-list?event_id={{$event_id}}',
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
                        for (let i = 0; i < data.photos.length; i++) {
                            $('.slider').append('<div class="photo-data" data-photo-id="' + data.photos[i].photo_id + '">' +
                                    '<img data-lazy = "/api/media/photo/' + data.photos[i].photo_id + '">' +
                                    '<div class="photo-info-area">' +
                                        '<img class="user-icon" data-lazy="/api/media/profile-icon/' + data.photos[i].user_info.user_id + '" />' +
                                        '<span class="user-name">' + data.photos[i].user_info.view_name + '</span>' +
                                    '</div>' +
                                '</div>');
                        }

                    // スライダーの設定
                    $('.slider').slick({
                        lazyLoad: 'ondemand',
                        pauseOnHover: true,
                        pauseOnFocus: false,
                        arrows: false,
                        autoplay: true,
                        autoplaySpeed: 6000,
                        accessibility: true, // 高さを合わせる
                        useTransform: true,
                        fade: true,
                        centerMode: true, // 中央揃え
                        speed: 5000,
                        rows: 1,
                        infinite: true,
                    });
                    $('.slider').on('beforeChange', function (event, slick, thisCurrentSlide, nextSlide) {
                        currentSlide = thisCurrentSlide;
                        // console.log('currentSlide: ' + currentSlide);
                    });
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
    });
</script>
</body>
</html>
