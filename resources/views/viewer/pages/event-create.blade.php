@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('イベント新規作成') }}</div>

                    <div class="card-body">
                        <form id="register-form" method="POST" action="#" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="eventName" class="col-md-4 col-form-label text-md-right">{{ __('イベント名') }}</label>

                                <div class="col-md-6">
                                    <input id="eventName" type="text" class="form-control @error('eventName') is-invalid @enderror" name="eventName" value="{{ old('eventName') }}" required autocomplete="eventName" autofocus>

                                    @error('eventName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="eventDetail" class="col-md-4 col-form-label text-md-right">{{ __('イベント詳細') }}</label>

                                <div class="col-md-6">
                                    <input id="eventDetail" type="text" class="form-control @error('eventDetail') is-invalid @enderror" name="eventDetail" value="{{ old('eventDetail') }}" required autocomplete="eventDetail" autofocus>

                                    @error('eventDetail')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('備考') }}</label>

                                <div class="col-md-6">
                                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" autocomplete="description">

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="eventPeriodStart" class="col-md-4 col-form-label text-md-right">{{ __('開催期間（開始）') }}</label>

                                <div class="col-md-6">
                                    <input id="eventPeriodStart" type="datetime-local" class="form-control @error('eventPeriodStart') is-invalid @enderror" name="eventPeriodStart" value="{{ old('eventPeriodStart') }}" autocomplete="eventPeriodStart">

                                    @error('eventPeriodStart')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="eventPeriodEnd" class="col-md-4 col-form-label text-md-right">{{ __('開催期間（終了）') }}</label>

                                <div class="col-md-6">
                                    <input id="eventPeriodEnd" type="datetime-local" class="form-control @error('eventPeriodEnd') is-invalid @enderror" name="eventPeriodEnd" value="{{ old('eventPeriodEnd') }}" autocomplete="eventPeriodEnd">

                                    @error('eventPeriodEnd')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="icon" class="col-md-4 col-form-label text-md-right">{{ __('アイコン画像') }}</label>

                                <div class="col-md-6">
                                    <input style="height: 46px" id="icon" type="file" accept="image/*" class="form-control" name="icon">
                                    @error('icon')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <img id="img" alt="アイコンプレビュー" src="@if(isset($user_info['avatar']))
                data:image/@if($user_info['avatar_ext'] === 'jpg')jpeg @else {{$user_info['avatar_ext']}}@endif;base64,{{$user_info['avatar']}}
            @else
                {{asset('img/common/anonman.svg')}}
            @endif
                " />
                                </div>
                            </div>

                            <div id="submit-area" style="display: block; text-align: center">
                                <button type='button' onclick="eventSubmit()" class="btn btn-primary">
                                    {{ __('登録') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script>
        $('#register-form').on('change', function (e) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#img").attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files?.[0]);
        });
        const eventSubmit = () => {
            if(!confirm('イベントを登録してよろしいですか？')) {
                return;
            }
            const fd = new FormData(document.forms['register-form']);
            $.ajax(
                {
                    url: '/api/event/create',
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    async: true,
                    // xhr : function(){
                    //     var XHR = $.ajaxSettings.xhr();
                    //     if(XHR.upload){
                    //         XHR.upload.addEventListener('progress',function(e){
                    //             var progre = parseInt((e.loaded/e.total*100) + 1);
                    //             // console.log(progre);
                    //             if(progre >= 101){
                    //                 $('#uploading-toast .iziToast-message').text('写真を処理しています...');
                    //             } else {
                    //                 $('#uploading-toast .iziToast-message').text('写真をアップロードしています...'+progre+'%');
                    //             }
                    //         }, false);
                    //     }
                    //     return XHR;
                    // },
                    // todo: ヘッダにユーザー情報を渡すようにする
                    // headers: {
                    //     'X-User-Token': user_info.token,
                    //     'X-User-Token-Sec': user_info.token_sec,
                    // },
                    data: fd, //FormDataオブジェクトはそのままdataとして渡す。
                //     beforeSend: function () {
                //         // $("#loading").css("display", "block");
                //         upload_status = false;
                //     },
                }
            )
                // Ajaxリクエストが成功した時発動
                .done(
                    (data) => {
                        console.log('done after data:', data.body);
                        window.location.href = '/event/joined/'+data?.body?.eventId;
                    }
                )
                // Ajaxリクエストが失敗した時発動
                .fail(
                    (data) => {
                        console.log(data);
                        alert("エラーが発生しました。しばらくしてから再度お試しください。\n"+data.message);
                        {{--// console.log(data);--}}
                        {{--iziToast.error({message: '写真のアップロードに失敗しました。', position: 'topCenter', transitionInMobile: 'fadeInDown', transitionOutMobile: 'fadeOutUp',});--}}
                        {{--if (data.status == "unauthorized") {--}}
                        {{--    window.location.href = '/login?pass_code={{\Config::get('auth.access_code')}}';--}}
                        {{--}--}}
                    }
                )
                // Ajaxリクエストが成功・失敗どちらでも発動
                .always(
                    // (data) => {
                    //     document.getElementById("camera-input").value = "";
                    //     document.getElementById("photo-add-input").value = "";
                    //     // $("#loading").css("display", "none");
                    //     $('#uploading-toast .iziToast-close').trigger('click');
                    //     upload_status = true;
                    // }
                );

            return false;
        }

    </script>
@endsection
