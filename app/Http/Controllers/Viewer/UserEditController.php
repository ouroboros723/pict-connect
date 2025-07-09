<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use File;
use HttpException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserEditController extends Controller
{
    /**
     * @param UserUpdateRequest $request
     * @return Application|bool|Redirector|RedirectResponse
     * @throws HttpException
     */
    public function update(UserUpdateRequest $request)
    {
        $store_dir = 'user-icon/'.$request->screen_name;
        if(!empty($request->file('user_icon'))) {
            $user_icon_path = $request->file('user_icon')->store($store_dir);
        }

        $User = User::findOrFail(Auth::id());
        if(empty($request->password)) {
            unset($request->password);
        }
        $params = $request->validated();
        unset($params['user_icon']);
        $User = $User->fill($params);
        if(!empty($user_icon_path)) {
            $User->user_icon_path = $user_icon_path;
        }
        if(!empty($request->password)) {
            $User->password = Hash::make($request->password);
        }

        $result = $User->save();

        if(!$result){
            throw new HttpException('update_failed');
        }

        return redirect('/user/edit');
    }

    /**
     * @return Application|Factory|View
     * @throws FileNotFoundException
     */
    public function show() {
        $user_info = Auth::user()->toArray();
        if(!empty(Storage::exists($user_info['user_icon_path']))){
            $user_icon = Storage::get($user_info['user_icon_path']);
            $user_icon_ext = File::extension($user_info['user_icon_path']);
            $user_info['avatar'] = base64_encode($user_icon);
            $user_info['avatar_ext'] = $user_icon_ext;
        } else {
            $user_info['avatar'] = null;
        }

        return view('viewer.pages.user-edit', ['user_info' => $user_info]);
    }
}
