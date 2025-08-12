<?php

namespace App\Http\Middleware;

use App\Model\Event;
use App\Model\EventParticipant;
use App\Services\UserInfo;
use Closure;
use Illuminate\Http\Request;

class CheckEventJoined
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // ルートパラメータまたはクエリパラメータからeventIdを取得
        $eventId = $request->route('eventId') ?? $request->input('eventId') ?? $request->input('event_id');

        // デバッグ情報（一時的）
        \Log::debug('CheckEventJoined middleware', [
            'route_eventId' => $request->route('eventId'),
            'input_eventId' => $request->input('eventId'),
            'input_event_id' => $request->input('event_id'),
            'final_eventId' => $eventId,
            'url' => $request->url(),
            'query' => $request->query()
        ]);

        if (!$eventId) {
            abort(400, 'Event ID is required');
        }

        // イベントが存在するかチェック（論理削除されたものも含む）
        $event = Event::withTrashed()->find($eventId);
        if (!$event) {
            abort(404, "Event with ID {$eventId} not found");
        }

        // イベントが論理削除されている場合は404を返す
        if ($event->trashed()) {
            abort(404, "Event with ID {$eventId} has been deleted");
        }

        $userInfo = UserInfo::getOrFail($request);
        if(!EventParticipant::whereUserId($userInfo->user_id)->whereEventId($eventId)->withActiveEvents()->exists()) {
            EventParticipant::whereUserId($userInfo->user_id)->withActiveEvents()->where(function($query) use ($eventId){
                $query->where('event_id', $eventId);
            })->firstOrFail();
        }

        return $next($request);
    }
}
