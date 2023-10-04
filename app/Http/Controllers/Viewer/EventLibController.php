<?php

namespace App\Http\Controllers\Viewer;

use App\Model\Event;
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
        $user_info = Auth::user();
        if(!empty(Storage::exists($user_info['user_icon_path']))){
            $user_icon = Storage::get($user_info['user_icon_path']);
            $user_icon_ext = \File::extension($user_info['user_icon_path']);
            $user_info['avatar'] = base64_encode($user_icon);
            $user_info['avatar_ext'] = $user_icon_ext;
        } else {
            $user_info['avatar'] = null;
        }

        return view('viewer.pages.event-join', ['user_info' => $user_info, 'join_token' => $joinToken]);
    }

    public function joindEvent(Request $request, $eventId)
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

        return view('viewer.pages.event-lib', ['user_info' => $user_info, 'event_id' => $eventId]);
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
