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
        .body {
            background-color: black
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
    </style>
    <title>slide show</title>
</head>


<body id="event-lib-slideshow">
<div class='container'>
    <div class='slider'>
        <div>
            <img src="https://unsplash.it/630/400">
        </div>
        <div>
            <img src="https://unsplash.it/630/400">
        </div>
        <div>
            <img src="https://unsplash.it/630/400">
        </div>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css"
      crossorigin="anonymous">
<script src="{{asset('js/app.js')}}"></script>

<script>
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
        var $slider = $('.slider');

        // スライダーの設定
        $slider.slick({
            lazyLoad: 'ondemand',
            pauseOnHover: false,
            pauseOnFocus: false,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 4000,
            accessibility: true, // 高さを合わせる
            useTransform: true,
            fade: true,
            centerMode: true, // 中央揃え
            speed: 5000,
            rows: 1,
        });

        // 新規のスライドを追加
        var imgList = [];
        $slider.on('afterChange', function (event, slick, currentSlide, nextSlide) {
            // if (prev_photo_ajax_status) {
            //     $.ajax(
            //         {
            //             url: '/api/media/photo/prev_list?event_id=1&begin_photo_id=' + begin_photo_id,
            //             type: 'GET',
            //             processData: false,
            //             contentType: false,
            //             headers: {
            //                 'X-User-Token': user_info.token,
            //                 'X-User-Token-Sec': user_info.token_sec,
            //             },
            //             data: {
            //                 "event_id": '1',
            //             },
            //             beforeSend: function () {
            //                 prev_photo_ajax_status = false;
            //                 // $("#loading").css("display", "block");
            //             },
            //         }
            //     )
            $.getJSON('imgList.json', function (imgListJSON) {
                let imgListAdd = getArrayDiff(imgListJSON, imgList);
                let imgListRemove = getArrayDiff(imgList, imgListJSON);
                let pathToImg = '/path/to/img_dir/'; // 写真を保存するディレクトリ
                let k = 1;
                for (let i = 0; i < imgListAdd.length; i++) {
                    $slider.slick("slickAdd", '<div><img data-lazy = "' + pathToImg + imgListAdd[i].src + '"></div>', currentSlide + k);
                    k++;
                }
                var slick_obj = $slider.slick('getSlick');
                    imgList = imgListJSON;
                });
            });
    });
</script>
</body>
</html>
