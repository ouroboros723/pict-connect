<?php

namespace App\Http\Controllers\Viewer;

use App\Model\Event;
use App\Model\EventJoinToken;
use App\Model\EventParticipant;
use App\Model\User;
use App\Services\UserInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventLibController extends Controller
{
    public function index(Request $request)
    {
        $user_info = Auth::user();
        if(!empty(Storage::exists($user_info['user_icon_path']))){
            $user_icon = Storage::get($user_info['user_icon_path']);
            $user_icon_ext = \File::extension($user_info['user_icon_path']);
            $user_info['avatar'] = base64_encode($user_icon);
            $user_info['avatar_ext'] = $user_icon_ext;
        } else {
            $user_info['avatar'] = null;
        }

        switch($request->path()) {

            case 'event/joined':
                return view('viewer.pages.event-list', ['user_info' => $user_info]);

            case 'event-grid-show':
                return view('viewer.pages.event-lib-gridshow', ['user_info' => $user_info]);

            case '/':
            default:
                return view('viewer.pages.event-lib', ['user_info' => $user_info]);
        }
    }

    public function joinEvent(Request $request, $joinToken)
    {
        $userInfo = UserInfo::getOrFail($request);
        $eventId = EventJoinToken::with('event')->whereJoinToken($joinToken)->firstOrFail()->event_id;
        if(EventParticipant::whereUserId($userInfo->user_id)->whereEventId($eventId)->exists()) {
            return redirect("/event/joined/$eventId");
        }

        if(!empty(Storage::exists($userInfo['user_icon_path']))){
            $user_icon = Storage::get($userInfo['user_icon_path']);
            $user_icon_ext = \File::extension($userInfo['user_icon_path']);
            $userInfo['avatar'] = base64_encode($user_icon);
            $userInfo['avatar_ext'] = $user_icon_ext;
        } else {
            $userInfo['avatar'] = null;
        }

        return view('viewer.pages.event-join', ['user_info' => $userInfo, 'join_token' => $joinToken]);
    }

    public function joindEvent(Request $request, $eventId)
    {
        // イベントが存在するかチェック（論理削除されたものも含む）
        $event = Event::withTrashed()->find($eventId);
        if (!$event) {
            abort(404, 'Event not found');
        }

        // イベントが論理削除されている場合は404を返す
        if ($event->trashed()) {
            abort(404, 'Event has been deleted');
        }

        $user_info = Auth::user();
        if(!empty(Storage::exists($user_info['user_icon_path']))){
            $user_icon = Storage::get($user_info['user_icon_path']);
            $user_icon_ext = \File::extension($user_info['user_icon_path']);
            $user_info['avatar'] = base64_encode($user_icon);
            $user_info['avatar_ext'] = $user_icon_ext;
        } else {
            $user_info['avatar'] = null;
        }

        return view('viewer.pages.event-lib', ['user_info' => $user_info, 'event_id' => $eventId]);
    }

    public function slideShow(Request $request, $eventId)
    {
        // イベントが存在するかチェック（論理削除されたものも含む）
        $event = Event::withTrashed()->find($eventId);
        if (!$event) {
            abort(404, 'Event not found');
        }

        // イベントが論理削除されている場合は404を返す
        if ($event->trashed()) {
            abort(404, 'Event has been deleted');
        }

        $user_info = Auth::user();
        if(!empty(Storage::exists($user_info['user_icon_path']))){
            $user_icon = Storage::get($user_info['user_icon_path']);
            $user_icon_ext = \File::extension($user_info['user_icon_path']);
            $user_info['avatar'] = base64_encode($user_icon);
            $user_info['avatar_ext'] = $user_icon_ext;
        } else {
            $user_info['avatar'] = null;
        }

        return view('viewer.pages.event-lib-slideshow', ['user_info' => $user_info, 'event_id' => $eventId]);
    }

//    public function gridShow()
//    {
//        $user_info = Auth::user();
//        if(!empty(Storage::exists($user_info['user_icon_path']))){
//            $user_icon = Storage::get($user_info['user_icon_path']);
//            $user_icon_ext = \File::extension($user_info['user_icon_path']);
//            $user_info['avatar'] = base64_encode($user_icon);
//            $user_info['avatar_ext'] = $user_icon_ext;
//        } else {
//            $user_info['avatar'] = null;
//        }
//
//        return view('viewer.pages.event-lib-gridshow', ['user_info' => $user_info]);
//    }
}
