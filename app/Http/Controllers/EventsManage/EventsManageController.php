<?php

namespace App\Http\Controllers\EventsManage;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventAdminListRequest;
use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventJoinedListRequest;
use App\Http\Requests\EventJoinRequest;
use App\Http\Requests\EventJoinTokenCreateRequest;
use App\Model\Event;
use App\Model\EventJoinToken;
use App\Model\EventParticipant;
use App\Services\UserInfo;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class EventsManageController extends Controller
{
    /**
     * 参加済みイベント一覧を表示
     * @param EventJoinedListRequest $request
     * @return JsonResponse
     */
    public function joinedList(EventJoinedListRequest $request): JsonResponse
    {
        $lastEventParticipantsId = $request->lastEventParticipantsId;

        $userInfo = UserInfo::getOrFail($request);
        $userId = $userInfo->user_id;

        if (empty($lastEventParticipantsId)) { // 初回読み込み
            $events = EventParticipant::whereUserId($userId)
                ->orderBy('event_participants_id', 'desc')
                ->with(['event', 'event.eventAdmin', 'user'])
                ->limit(20)
                ->get();
        } else { // 追加読み込み
            $events = EventParticipant::whereUserId($userId)
                ->where('event_participants_id', '<', $lastEventParticipantsId)
                ->orderBy('event_participants_id', 'desc')
                ->with(['event', 'event.eventAdmin', 'user'])
                ->limit(20)
                ->get();
        }

        return $this->sendResponse($events, 'ok');
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

        return $this->sendResponse($events, 'ok');
    }

    /**
     * イベントの新規登録
     * @param EventCreateRequest $request
     * @return JsonResponse
     */
    public function create(EventCreateRequest $request): JsonResponse
    {
        $userInfo = UserInfo::getOrFail($request);
        $eventIconPath = $request->icon->storeAs('eventicons', Str::random('16'));
        $newEvent = Event::create([
            'event_name' => $request->eventName,
            'event_admin_id' => $userInfo->user_id,
            'event_detail' => $request->eventDetail,
            'description' => $request->description,
            'icon_path' => $eventIconPath,
            'event_period_start' => (new Carbon($request->eventPeriodStart))->format('Y-m-d H:i:s'),
            'event_period_end' => (new Carbon($request->eventPeriodEnd))->format('Y-m-d H:i:s'),
        ]);
        if($newEvent instanceof Event) {
            return $this->sendResponse(array_key_camel($newEvent->toArray()), 'ok');
        }
        $this->throwErrorResponse('event_save_failed', Response::HTTP_INTERNAL_SERVER_ERROR);
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
    public function joinEvent(EventJoinRequest $request, $eventId): JsonResponse
    {
        $userInfo = UserInfo::getOrFail($request);
        $eventJoinToken = EventJoinToken::where('join_token', $request->joinToken)->first();
        if($eventJoinToken instanceof EventJoinToken) {
            $eventParticipant = new EventParticipant();
            if($eventParticipant->joinEvent($eventId, $userInfo->user_id)) {
                return $this->sendResponse(['eventId' => $eventId], 'joined');
            }
            $this->throwErrorResponse('event_join_failed', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $this->throwErrorResponse('event_join_token_not_found', Response::HTTP_NOT_FOUND);
    }
}
