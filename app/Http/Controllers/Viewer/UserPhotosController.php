<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Model\Event;
use App\Model\EventParticipant;
use App\Model\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserPhotosController extends Controller
{
    /**
     * ユーザーが参加したイベント一覧を表示
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
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

        // ユーザーが参加したイベントを取得
        $participatedEvents = EventParticipant::where('user_id', $user_info->user_id)
            ->with('event')
            ->get()
            ->map(function ($participant) {
                return $participant->event;
            })
            ->filter()
            ->sortByDesc('created_at');

        return view('viewer.pages.user-events', [
            'user_info' => $user_info,
            'events' => $participatedEvents
        ]);
    }

    /**
     * 指定イベントでユーザーが撮影した写真一覧を表示
     *
     * @param Request $request
     * @param int $eventId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function showEventPhotos(Request $request, $eventId)
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

        // イベント情報を取得
        $event = Event::findOrFail($eventId);

        // ユーザーがそのイベントに参加しているかチェック
        $isParticipant = EventParticipant::where('user_id', $user_info->user_id)
            ->where('event_id', $eventId)
            ->exists();

        if (!$isParticipant) {
            abort(403, 'このイベントにアクセスする権限がありません。');
        }

        // ユーザーがそのイベントで撮影した写真を取得
        $photos = Photo::where('user_id', $user_info->user_id)
            ->where('event_id', $eventId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('viewer.pages.user-photos', [
            'user_info' => $user_info,
            'event' => $event,
            'photos' => $photos
        ]);
    }
}
