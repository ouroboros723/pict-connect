@include('viewer.components.flame')

@yield('meta')
<body>
@yield('header')
@yield('side-menu')

<div id="loading" style="display: none;"><img src="{{asset("img/common/loading.gif")}}"></div>
<div id="main-container">
    <div id="photo-cards" class="">
        <div id="photo-list-top"></div>
        {{-- イベントがここに入る --}}
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

@yield('commonscript')

<script>
    var user_info = @json($user_info) ?? null;
    var events = @json($events) ?? [];

    if ('' === user_info || null === user_info) {
        window.location.href = '/login?pass_code={{Config::get('auth.access_code')}}';
    }

    window.addEventListener('load', function () {
        displayEvents();
    });

    $(document).ready(function () {
        iziToast.settings({
            transitionIn: 'fadeInDown',
            transitionOut: 'fadeOutUp',
        });
    });

    function displayEvents() {
        var event_list_elements = '';

        if (events.length === 0) {
            event_list_elements = '<div class="col-12"><div class="alert alert-info">参加したイベントはありません。</div></div>';
        } else {
            Object.keys(events).forEach(function (key) {
                event_list_elements +=
                    '<div id="event_' + events[key].event_id + '" class="col photo-cell">\n' +
                    '    <a href="/user/joined/' + events[key].event_id + '">\n' +
                    '        <img class="card-img-top lazyload" src="/img/common/photoloading.gif" data-src="/api/media/event-icon/' + events[key].event_id + '" />\n' +
                    '        <div class="card-body">\n' +
                    '            <span class="event-text">' + events[key].event_name + '</span>\n' +
                    '        </div>\n' +
                    '    </a>\n' +
                    '</div>';
            });
        }

        $("#photo-list-top").after(event_list_elements);
        
        $("img.lazyload").lazyload({
            placeholder: '/img/common/photoloading.gif',
        });
    }
</script>
</body>
