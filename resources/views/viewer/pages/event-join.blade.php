@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('イベント参加') }}</div>

                    <div class="card-body">
                        <form id="register-form" method="POST" action="#" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    このイベントに参加しますか？
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <img id="eventIcon" alt="イベントアイコン" src="{{asset('img/common/anonman.svg')}}" />
                                </div>
                            </div>
                            <div class="form-group row">

                                <label for="eventName" class="col-md-4 col-form-label text-md-right">{{ __('イベント名') }}</label>

                                <div class="col-md-6">
                                    <span id="eventName"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="eventDetail" class="col-md-4 col-form-label text-md-right">{{ __('イベント詳細') }}</label>

                                <div class="col-md-6">
                                    <span id="eventDetail"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="eventPeriodStart" class="col-md-4 col-form-label text-md-right">{{ __('開催期間（開始）') }}</label>

                                <div class="col-md-6">
                                    <span id="eventPeriodStart"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="eventPeriodEnd" class="col-md-4 col-form-label text-md-right">{{ __('開催期間（終了）') }}</label>

                                <div class="col-md-6">
                                    <span id="eventPeriodEnd"></span>
                                </div>
                            </div>

                            <div id="submit-area" style="display: block; text-align: center">
                                <button type='button' onclick="eventJoin()" class="btn btn-primary">
                                    {{ __('参加する') }}
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
        const user_info = @json($user_info);
        $(document).ready(() => {
            getEventDetail();
        });
        const getEventDetail = () => {
            $.ajax(
                {
                    url: '/api/event/detail/join-token/{{$join_token}}',
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
                    $('#eventIcon').attr('src', '/api/media/event-icon/join-token/{{$join_token}}');
                }
                $('#eventName').html(data.body?.eventName);
                $('#eventDetail').html(data.body?.eventDetail);
                $('#eventPeriodStart').html(data.body?.eventPeriodStart);
                $('#eventPeriodEnd').html(data.body?.eventPeriodEnd);
            }).fail(() => {
                alert('イベント情報の取得に失敗しました')
            });
        }

        const eventJoin = () => {
            if(!confirm('参加してよろしいですか？')) {
                return;
            }
            // const fd = new FormData(document.forms['register-form']);
            $.ajax(
                {
                    url: '/api/event/join/{{$join_token}}',
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
                    headers: {
                        'X-User-Token': user_info.token,
                        'X-User-Token-Sec': user_info.token_sec,
                    },
                    // data: fd, //FormDataオブジェクトはそのままdataとして渡す。
                    // beforeSend: function () {
                    //     // $("#loading").css("display", "block");
                    //     upload_status = false;
                    // },
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
