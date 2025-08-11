<?php

namespace App\Http\Controllers\MediaDistributor;

use App\Http\Controllers\Controller;
use App\Model\AlbumAccessAuthority;
use App\Model\GuestLogin;
use App\Model\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetPhotosController extends Controller
{
    /**
     * Twitterログインユーザー向けの共有写真を取得
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View|object
     */
    public function index(Request $request)
    {
        // Twitterからログインしたユーザーのスクリーンネームを取得
        $GuestLogin = GuestLogin::where('guest_token', $request->cookie('X-Guest-Token'))->firstOrFail();

        if (!($GuestLogin instanceof GuestLogin)) {
            return redirect('/login/twitter');
        }

        // スクリーンネームに一致するアルバムアクセス権限を持つ写真を取得
        $sharedPhotos = AlbumAccessAuthority::where('sns_screen_name', $GuestLogin->sns_screen_name)
            ->with(['albumPhoto.photo'])
            ->get()
            ->map(function ($authority) {
                return $authority->albumPhoto->photo;
            })
            ->filter()
            ->unique('photo_id');

        return view('event.guest-photos', [
            'photos' => $sharedPhotos,
            'isGuestUser' => true
        ]);
    }

    /**
     * ゲストログアウト処理
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // X-Guest-Tokenクッキーを削除
        return redirect('/welcome')->withCookie(cookie()->forget('X-Guest-Token'));
    }
}
