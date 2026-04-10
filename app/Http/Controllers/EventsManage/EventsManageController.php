<?php

namespace App\Http\Controllers\EventsManage;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventAdminListRequest;
use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventDeleteRequest;
use App\Http\Requests\EventJoinedListRequest;
use App\Http\Requests\EventJoinRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Requests\EventJoinTokenCreateRequest;
use App\Model\Event;
use App\Model\EventJoinToken;
use App\Model\EventParticipant;
use App\Model\Photo;
use App\Services\MimesToExt;
use App\Services\UserInfo;
use Carbon\Carbon;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Storage;
use STS\ZipStream\ZipStream;
use Symfony\Component\HttpFoundation\Response;
use Zip;

class EventsManageController extends Controller
{
    /**
     * 参加済みイベント一覧を表示
     * @param EventJoinedListRequest $request
     * @return JsonResponse
     */
    public function joinedList(EventJoinedListRequest $request): JsonResponse
    {
        $lastEventId = $request->lastEventId;

        $userInfo = UserInfo::getOrFail($request);
        $userId = $userInfo->user_id;

        if (empty($lastEventId)) { // 初回読み込み
            $events = EventParticipant::whereUserId($userId)
                ->withActiveEvents() // 削除されていないイベントのみ
                ->orderBy('event_participants_id', 'desc')
                ->with(['event', 'event.eventAdmin', 'user'])
                ->limit(20)
                ->get();
        } else { // 追加読み込み
            $events = EventParticipant::whereUserId($userId)
                ->withActiveEvents() // 削除されていないイベントのみ
                ->where('event_id', '<', $lastEventId)
                ->orderBy('event_id', 'desc')
                ->with(['event', 'event.eventAdmin', 'user'])
                ->limit(20)
                ->get();
        }

        return $this->sendResponse(array_key_camel($events->toArray()), 'ok');
    }

    /**
     * 管理イベント一覧を表示
     * @param EventAdminListRequest $request
     * @return JsonResponse
     */
    public function adminList(EventAdminListRequest $request): JsonResponse
    {
        $lastEventId = $request->lastEventId;

        $userInfo = UserInfo::getOrFail($request);
        $userId = $userInfo->user_id;

        if (empty($lastEventId)) { // 初回読み込み
            $events = Event::whereEventAdminId($userId)
                ->orderBy('event_id', 'desc')
                ->with(['participants', 'participants.user'])
                ->limit(20)
                ->get();
        } else { // 追加読み込み
            $events = Event::whereEventAdminId($userId)
                ->where('event_id', '<', $lastEventId)
                ->orderBy('event_id', 'desc')
                ->with(['participants', 'participants.user'])
                ->limit(20)
                ->get();
        }

        return $this->sendResponse(array_key_camel($events->toArray()), 'ok');
    }

    /**
     * イベント詳細
     * @param $eventId
     * @return JsonResponse
     */
    public function getEventDetail($eventId): JsonResponse
    {
        /** @var Event $event */
        $event = Event::with(['participants', 'photos'])->findOrFail($eventId);
        $eventArray = array_key_camel($event->toArray());
        $eventArray['eventPeriodStart'] = $event->event_period_start->format('Y年m月d日 H:i:s');
        $eventArray['eventPeriodEnd'] = $event->event_period_end->format('Y年m月d日 H:i:s');
        $eventArray['participantsCount'] = $event->participants->count() ?? 0;
        $eventArray['postedPhotosCount'] = $event->photos->count() ?? 0;
        return $this->sendResponse($eventArray, 'ok');
    }

    /**
     * イベント詳細(トークンから)
     * @param $joinToken string 参加トークン
     * @return JsonResponse
     */
    public function getEventDetailFromToken($joinToken): JsonResponse
    {
        $event = EventJoinToken::whereJoinToken($joinToken)->with(['event', 'event.participants', 'event.photos'])->firstOrFail()->event;
        $eventArray = array_key_camel($event->toArray());
        $eventArray['eventPeriodStart'] = $event->event_period_start->format('Y年m月d日 H:i:s');
        $eventArray['eventPeriodEnd'] = $event->event_period_end->format('Y年m月d日 H:i:s');
        $eventArray['participantsCount'] = $event->participants->count() ?? 0;
        $eventArray['postedPhotosCount'] = $event->photos->count() ?? 0;
        return $this->sendResponse($eventArray, 'ok');
    }

    /**
     * イベントの新規登録
     * @param EventCreateRequest $request
     * @return JsonResponse
     */
    public function create(EventCreateRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $userInfo = UserInfo::getOrFail($request);
            $fileName = Str::random(10);
            $newEvent = Event::create([
                'event_name' => $request->eventName,
                'event_admin_id' => $userInfo->user_id,
                'event_detail' => $request->eventDetail,
                'description' => $request->description,
                'event_period_start' => (new Carbon($request->eventPeriodStart))->format('Y-m-d H:i:s'),
                'event_period_end' => (new Carbon($request->eventPeriodEnd))->format('Y-m-d H:i:s'),
            ]);
            if($newEvent instanceof Event) {
                $eventIconPath = $request->icon->storeAs('eventicons', $fileName);
                $newEvent->icon_path = $eventIconPath;
                $Participant = EventParticipant::create([
                    'event_id' => $newEvent->event_id,
                    'user_id' => $userInfo->user_id,
                ]);

                if($Participant instanceof EventParticipant && $newEvent->save()) {
                    return $this->sendResponse(array_key_camel($newEvent->toArray()), 'ok');
                }
            }
            $this->throwErrorResponse('event_save_failed', Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    }

    /**
     * イベント参加トークン作成
     * @param EventJoinTokenCreateRequest $request
     * @param $eventId
     * @return JsonResponse
     */
    public function createJoinToken(EventJoinTokenCreateRequest $request, $eventId): JsonResponse
    {
        $eventJoinToken = new EventJoinToken();
        $eventJoinToken->makeEventJoinToken($eventId, $request->expiredAt ?? null, $request->limitTimes ?? null);
        if($eventJoinToken->save()) {
            return $this->sendResponse(['eventJoinToken' => $eventJoinToken], 'ok');
        }
        $this->throwErrorResponse('event_join_token_create_failed', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * イベント参加
     * @param EventJoinRequest $request イベント参加リクエスト
     * @param int $eventId イベントid
     * @return JsonResponse
     */
    public function joinEvent(EventJoinRequest $request, $joinToken): JsonResponse
    {
        $userInfo = UserInfo::getOrFail($request);
        $eventJoinToken = EventJoinToken::where('join_token', $joinToken)->with('event')->first();
        if($eventJoinToken instanceof EventJoinToken) {
            $eventParticipant = new EventParticipant();
            if($eventParticipant->joinEvent($eventJoinToken->event->event_id, $userInfo->user_id)) {
                return $this->sendResponse(['eventId' => $eventJoinToken->event->event_id], 'joined');
            }
            $this->throwErrorResponse('event_join_failed', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $this->throwErrorResponse('event_join_token_not_found', Response::HTTP_NOT_FOUND);
    }

    /**
     * イベントアルバム内の全写真をダウンロード
     * @param $eventId
     * @return ZipStream
     */
    public function getAllEventPhotos($eventId): ZipStream
    {
        // 対象File取得
        $Event = Event::findOrFail($eventId);

        // todo: 写真-イベントidのつながりを変更した際に改修が必要
        /** @var Photo[] $photos */
        $photos = Photo::with(['user'])->where('event_id', $eventId)
            ->where('deleted_at', null)
            ->orderBy('photo_id', 'desc')
            ->get();

        // zipファイルを指定ディレクトリに作成
        $ZipFile = Zip::create("$Event->event_name.zip");

        foreach($photos as $photo) {
            $ZipFile->add(Storage::path($photo->store_path), $photo->user->screen_name.'/'.basename($photo->store_path).'.'.MimesToExt::getImageExtFromMimeType(Storage::mimeType($photo->store_path)));
        }

        return $ZipFile;
    }

    /**
     * イベント削除（論理削除）
     * @param EventDeleteRequest $request
     * @param int $eventId
     * @return JsonResponse
     */
    public function deleteEvent(EventDeleteRequest $request, int $eventId): JsonResponse
    {
        $userInfo = UserInfo::getOrFail($request);

        // イベントを取得
        $event = Event::findOrFail($eventId);

        // イベント管理者かどうかチェック
        if ($event->event_admin_id !== $userInfo->user_id) {
            $this->throwErrorResponse('unauthorized', Response::HTTP_FORBIDDEN);
        }

        // 削除確認テキストのチェック（バリデーションで既にチェック済みだが念のため）
        if ($request->confirmText !== 'delete') {
            $this->throwErrorResponse('invalid_confirm_text', Response::HTTP_BAD_REQUEST);
        }

        // 論理削除実行
        $event->delete();

        return $this->sendResponse([], 'イベントを削除しました');
    }

    /**
     * イベント更新
     * @param EventUpdateRequest $request
     * @param int $eventId
     * @return JsonResponse
     */
    public function updateEvent(EventUpdateRequest $request, int $eventId): JsonResponse
    {
        return DB::transaction(function () use ($request, $eventId) {
            $userInfo = UserInfo::getOrFail($request);

            // イベントを取得
            $event = Event::findOrFail($eventId);

            // イベント管理者かどうかチェック
            if ($event->event_admin_id !== $userInfo->user_id) {
                $this->throwErrorResponse('unauthorized', Response::HTTP_FORBIDDEN);
            }

            // イベント情報を更新
            $event->event_name = $request->eventName;
            $event->event_detail = $request->eventDetail;
            $event->description = $request->description;
            $event->event_period_start = (new Carbon($request->eventPeriodStart))->format('Y-m-d H:i:s');
            $event->event_period_end = (new Carbon($request->eventPeriodEnd))->format('Y-m-d H:i:s');

            // アイコンが更新された場合
            if ($request->hasFile('icon')) {
                $fileName = Str::random(10);
                $eventIconPath = $request->icon->storeAs('eventicons', $fileName);
                $event->icon_path = $eventIconPath;
            }

            if ($event->save()) {
                return $this->sendResponse(array_key_camel($event->toArray()), 'イベントを更新しました');
            }

            $this->throwErrorResponse('event_update_failed', Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    }
}
