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

                            <!-- 参加トークン作成セクション -->
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('参加URL') }}</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="joinUrl" type="text" class="form-control" readonly placeholder="参加トークンを作成してください">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" onclick="copyJoinUrl()" id="copyBtn" disabled>
                                                {{ __('コピー') }}
                                            </button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">このURLを共有することで、他のユーザーがイベントに参加できます。</small>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-info btn-sm" onclick="createJoinToken()">
                                            {{ __('参加トークンを作成') }}
                                        </button>
                                        <div id="tokenInfo" class="mt-2" style="display: none;">
                                            <small class="text-success">参加トークンが作成されました。</small>
                                        </div>
                                    </div>
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

        // 参加トークン作成
        const createJoinToken = () => {
            if(!confirm('参加トークンを作成してよろしいですか？')) {
                return;
            }

            $.ajax({
                url: '/api/event/token/create/' + event_id,
                type: 'POST',
                processData: false,
                contentType: false,
                async: true,
                headers: {
                    'X-User-Token': user_info.token,
                    'X-User-Token-Sec': user_info.token_sec,
                },
                beforeSend: function () {
                    $('button[onclick="createJoinToken()"]').prop('disabled', true).text('作成中...');
                },
                success: function (data) {
                    console.log('API Response:', data); // デバッグ用ログ

                    if (data.success && data.body && data.body.eventJoinToken) {
                        const tokenData = data.body.eventJoinToken;
                        // 複数の可能性のあるプロパティ名をチェック
                        const joinToken = tokenData.joinToken || tokenData.join_token || tokenData.token;

                        console.log('Token Data:', tokenData, 'Join Token:', joinToken); // デバッグ用ログ

                        if (joinToken) {
                            const joinUrl = window.location.origin + '/event/join/' + joinToken;

                            $('#joinUrl').val(joinUrl);
                            $('#copyBtn').prop('disabled', false);
                            $('#tokenInfo').show();

                            alert('参加トークンを作成しました。URLをコピーして共有してください。');
                        } else {
                            console.error('Join token not found in response:', tokenData);
                            alert('参加トークンの取得に失敗しました。');
                        }
                    } else {
                        console.error('Invalid API response:', data);
                        alert('参加トークンの作成に失敗しました。');
                    }
                },
                error: function (xhr) {
                    var message = '参加トークンの作成に失敗しました。';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    alert(message);
                    if (xhr.status === 401) {
                        window.location.href = '/login?pass_code={{Config::get('auth.access_code')}}';
                    }
                },
                complete: function () {
                    $('button[onclick="createJoinToken()"]').prop('disabled', false).text('参加トークンを作成');
                }
            });
        }

        // 参加URL をクリップボードにコピー
        const copyJoinUrl = () => {
            const joinUrlInput = document.getElementById('joinUrl');
            joinUrlInput.select();
            joinUrlInput.setSelectionRange(0, 99999); // モバイル対応

            try {
                document.execCommand('copy');
                alert('参加URLをクリップボードにコピーしました。');
            } catch (err) {
                alert('コピーに失敗しました。手動でURLをコピーしてください。');
            }
        }
    </script>
@endsection
