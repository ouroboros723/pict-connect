@include('viewer.components.flame')

@yield('meta')
<body>
@yield('header')
@yield('side-menu')

<div id="loading" style="display: none;"><img src="{{asset("img/common/loading.gif")}}"></div>
<div id="main-container">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>{{ $event->event_name }} - あなたの写真</h4>
                    <div>
                        <button id="select-all-btn" class="btn btn-secondary btn-sm">全選択</button>
                        <button id="deselect-all-btn" class="btn btn-secondary btn-sm">全解除</button>
                        <span id="selected-count" class="badge badge-primary">0</span> 枚選択中
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="photo-cards" class="">
        <div id="photo-list-top"></div>
        {{-- 写真がここに入る --}}
        <div id="photo-list-bottom"></div>
    </div>
</div>

@yield('footer')

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
<script src="{{asset('js/lity.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/lity.css')}}" crossorigin="anonymous">

@yield('commonscript')

<script>
    var user_info = @json($user_info) ?? null;
    var event = @json($event) ?? null;
    var photos = @json($photos) ?? [];
    var selectedPhotos = [];

    if ('' === user_info || null === user_info) {
        window.location.href = '/login?pass_code={{Config::get('auth.access_code')}}';
    }

    window.addEventListener('load', function () {
        displayPhotos();
    });

    $(document).ready(function () {
        iziToast.settings({
            transitionIn: 'fadeInDown',
            transitionOut: 'fadeOutUp',
        });

        // 全選択ボタン
        $('#select-all-btn').on('click', function() {
            $('.photo-checkbox').prop('checked', true);
            updateSelectedPhotos();
        });

        // 全解除ボタン
        $('#deselect-all-btn').on('click', function() {
            $('.photo-checkbox').prop('checked', false);
            updateSelectedPhotos();
        });
    });

    function displayPhotos() {
        var photo_list_elements = '';

        if (photos.length === 0) {
            photo_list_elements = '<div class="col-12"><div class="alert alert-info">このイベントで撮影した写真はありません。</div></div>';
        } else {
            Object.keys(photos).forEach(function (key) {
                photo_list_elements +=
                    '<div id="photo_' + photos[key].photo_id + '" class="col photo-cell" style="position: relative;">\n' +
                    '    <div class="photo-checkbox-container" style="position: absolute; top: 10px; left: 10px; z-index: 10;">\n' +
                    '        <input type="checkbox" class="photo-checkbox" data-photo-id="' + photos[key].photo_id + '" style="transform: scale(1.5);">\n' +
                    '    </div>\n' +
                    '    <a href="/api/media/photo/' + photos[key].photo_id + '" data-lity="data-lity">\n' +
                    '        <img class="card-img-top lazyload" src="/img/common/photoloading.gif" data-src="/api/media/photo/' + photos[key].photo_id + '" />\n' +
                    '        <div class="card-body">\n' +
                    '            <span class="card-text">' + formatDate(photos[key].created_at) + '</span>\n' +
                    '        </div>\n' +
                    '    </a>\n' +
                    '</div>';
            });
        }

        $("#photo-list-top").after(photo_list_elements);
        
        $("img.lazyload").lazyload({
            placeholder: '/img/common/photoloading.gif',
        });

        // チェックボックスのイベントリスナーを追加
        $('.photo-checkbox').on('change', function() {
            updateSelectedPhotos();
        });
    }

    function updateSelectedPhotos() {
        selectedPhotos = [];
        $('.photo-checkbox:checked').each(function() {
            selectedPhotos.push($(this).data('photo-id'));
        });
        $('#selected-count').text(selectedPhotos.length);
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.getFullYear() + '/' + 
               String(date.getMonth() + 1).padStart(2, '0') + '/' + 
               String(date.getDate()).padStart(2, '0') + ' ' +
               String(date.getHours()).padStart(2, '0') + ':' + 
               String(date.getMinutes()).padStart(2, '0');
    }
</script>
</body>
