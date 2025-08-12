@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('イベント編集') }}</div>

                    <div class="card-body">
                        <form id="update-form" method="POST" action="#" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="eventName" class="col-md-4 col-form-label text-md-right">{{ __('イベント名') }}</label>

                                <div class="col-md-6">
                                    <input id="eventName" type="text" class="form-control @error('eventName') is-invalid @enderror" name="eventName" value="{{ $event->event_name }}" required autocomplete="eventName" autofocus>

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
                                    <textarea id="eventDetail" class="form-control @error('eventDetail') is-invalid @enderror" name="eventDetail" rows="4">{{ $event->event_detail }}</textarea>

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
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ $event->description }}</textarea>

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
                                    <input id="eventPeriodStart" type="datetime-local" class="form-control @error('eventPeriodStart') is-invalid @enderror" name="eventPeriodStart" value="{{ $event->event_period_start->format('Y-m-d\TH:i') }}" required>

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
                                    <input id="eventPeriodEnd" type="datetime-local" class="form-control @error('eventPeriodEnd') is-invalid @enderror" name="eventPeriodEnd" value="{{ $event->event_period_end->format('Y-m-d\TH:i') }}" required>

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

                                    <img id="img" alt="アイコンプレビュー" src="@if($event_icon){{ $event_icon }}@else{{ asset('img/common/anonman.svg') }}@endif" style="max-width: 200px; margin-top: 10px;" />
                                </div>
                            </div>

                            <div id="submit-area" style="display: block; text-align: center">
                                <button type='button' onclick="eventUpdate()" class="btn btn-primary">
                                    {{ __('更新') }}
                                </button>
                                <a href="/event/joined" class="btn btn-secondary">
                                    {{ __('キャンセル') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script>
        var user_info = @json($user_info) ?? null;
        var event_id = {{ $event->event_id }};

        // ポップオーバーの初期化
        $(function () {
            $('#user-icon').popover({'html': true});
        });

        $('#update-form').on('change', '#icon', function (e) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#img").attr('src', e.target.result);
            }
            if (e.target.files && e.target.files[0]) {
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        const eventUpdate = () => {
            if(!confirm('イベントを更新してよろしいですか？')) {
                return;
            }
            const fd = new FormData(document.forms['update-form']);
            $.ajax(
                {
                    url: '/api/event/update/' + event_id,
                    type: 'POST', // Laravel では PUT メソッドを POST で送信し、_method で指定
                    data: fd,
                    processData: false,
                    contentType: false,
                    async: true,
                    headers: {
                        'X-User-Token': user_info.token,
                        'X-User-Token-Sec': user_info.token_sec,
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    beforeSend: function () {
                        $('#submit-area button').prop('disabled', true);
                    },
                    success: function (data) {
                        alert('イベントを更新しました。');
                        window.location.href = '/event/joined';
                    },
                    error: function (xhr) {
                        var message = 'イベントの更新に失敗しました。';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        alert(message);
                        if (xhr.status === 401) {
                            window.location.href = '/login?pass_code={{Config::get('auth.access_code')}}';
                        }
                    },
                    complete: function () {
                        $('#submit-area button').prop('disabled', false);
                    }
                }
            );
        }
    </script>
@endsection
