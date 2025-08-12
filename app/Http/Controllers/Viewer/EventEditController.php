<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Model\Event;
use App\Services\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class EventEditController extends Controller
{
    /**
     * イベント編集画面を表示
     * @param Request $request
     * @param int $eventId
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Request $request, int $eventId)
    {
        $userInfo = UserInfo::getOrFail($request);

        // イベントが存在するかチェック（論理削除されたものも含む）
        $event = Event::withTrashed()->find($eventId);
        if (!$event) {
            abort(404, 'Event not found');
        }

        // イベントが論理削除されている場合は404を返す
        if ($event->trashed()) {
            abort(404, 'Event has been deleted');
        }

        // イベント管理者かどうかチェック
        if ($event->event_admin_id !== $userInfo->user_id) {
            abort(Response::HTTP_FORBIDDEN, 'このイベントを編集する権限がありません。');
        }

        // ユーザーアイコンの処理
        if (!empty(Storage::exists($userInfo['user_icon_path']))) {
            $user_icon = Storage::get($userInfo['user_icon_path']);
            $user_icon_ext = \File::extension($userInfo['user_icon_path']);
            $userInfo['avatar'] = base64_encode($user_icon);
            $userInfo['avatar_ext'] = $user_icon_ext;
        } else {
            $userInfo['avatar'] = null;
        }

        // イベントアイコンの処理
        $event_icon = null;
        if (!empty($event->icon_path) && Storage::exists($event->icon_path)) {
            $event_icon_data = Storage::get($event->icon_path);
            $event_icon_ext = \File::extension($event->icon_path);
            $event_icon = 'data:image/' . ($event_icon_ext === 'jpg' ? 'jpeg' : $event_icon_ext) . ';base64,' . base64_encode($event_icon_data);
        }

        return view('viewer.pages.event-edit', [
            'user_info' => $userInfo,
            'event' => $event,
            'event_icon' => $event_icon
        ]);
    }
}
