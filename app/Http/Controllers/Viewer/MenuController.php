<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * メニュー画面を表示
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

        return view('viewer.pages.menu', ['user_info' => $user_info]);
    }
}
