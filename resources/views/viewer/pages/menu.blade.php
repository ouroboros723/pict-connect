@include('viewer.components.flame')

@yield('meta')
<body>
@yield('header')
@yield('side-menu')

<div id="loading" style="display: none;"><img src="{{asset("img/common/loading.gif")}}"></div>
<div id="main-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>メニュー</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <a href="/event/joined" class="btn btn-primary btn-lg btn-block" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                    <div class="text-center">
                                        <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                                        <br>
                                        <span style="font-size: 1.2rem;">イベントアルバム</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="/user/joined" class="btn btn-success btn-lg btn-block" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                    <div class="text-center">
                                        <i class="fas fa-user fa-2x mb-2"></i>
                                        <br>
                                        <span style="font-size: 1.2rem;">ユーザーアルバム</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@yield('commonscript')

<script>
    var user_info = @json($user_info) ?? null;

    if ('' === user_info || null === user_info) {
        window.location.href = '/login?pass_code={{Config::get('auth.access_code')}}';
    }
</script>
</body>
