<?php

namespace App\Http\Controllers\EventsManage;

use App\Http\Controllers\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventCreateRequest;
use App\Model\Event;
use App\Services\UserInfo;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class EventsManageController extends Controller
{
    use ApiResponseTrait;

    /**
     * イベントの新規登録
     * @param EventCreateRequest $request
     * @return JsonResponse
     */
    public function create(EventCreateRequest $request): JsonResponse
    {
        $userInfo = UserInfo::get($request);
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
}
