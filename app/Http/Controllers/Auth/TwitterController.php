<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\User;
use \File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class TwitterController extends Controller
{

    // ログイン
    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    // コールバック
    public function handleProviderCallback()
    {
        try {
            $twitterUser = Socialite::driver('twitter')->user();
//            dd($twitterUser);
        } catch (Exception $e) {
            return redirect('auth/twitter');
        }
//         各自ログイン処理
        $user = User::where('user_id', $twitterUser->id)->first();
        //オリジナルサイズのプロフィール画像取得
        $original_url = str_replace("_normal.", ".", $twitterUser->user['profile_image_url_https']);;
        $prof_icon_path = $this->_putProfileImage($twitterUser->id, $original_url);
        if (!$user) {
            //TODO: pc用トークン発行処理
            User::create([
                'user_id' => $twitterUser->id,
                'screen_name' => $twitterUser->nickname,
                'view_name' => $twitterUser->name,
                'description' => $twitterUser->user['description'],
                'user_icon_path' => $prof_icon_path,
            ]);
            $user = User::where('user_id', $twitterUser->id)->first();
        } else {
            //TODO: Twitterの情報が変わってたら新しい情報に更新

            $user->screen_name = $twitterUser->nickname;
            $user->view_name = $twitterUser->name;
            $user->description = $twitterUser->user['description'];
            $user->user_icon_path = $prof_icon_path;
            $user->save();
        }
         Auth::login($user);
        return redirect('/');
    }

    // ログアウト
    public function logout(Request $request)
    {
        // 各自ログアウト処理
        // 例
        // Auth::logout();
        return redirect('/');
    }

    private function _putProfileImage($userid, $photo_url)
    {
        $img = file_get_contents($photo_url);
        $img_ext = $this->_getImageTypes($photo_url);

        //画像を保存
        $prof_icon_path = 'proficons/' . $userid . '.' . $img_ext;
        if (File::exists($prof_icon_path)) {
            Storage::delete($prof_icon_path);
        }
        Storage::disk('local')->put($prof_icon_path, $img);
        return $prof_icon_path;
    }

    private function _getImageTypes($photo_url)
    {
        //getimagesize関数で画像情報を取得する
        list($img_width, $img_height, $mime_type, $attr) = getimagesize($photo_url);
//list関数の第3引数にはgetimagesize関数で取得した画像のMIMEタイプが格納されているので条件分岐で拡張子を決定する
        switch ($mime_type) {
            //jpegの場合
            case IMAGETYPE_JPEG:
                //拡張子の設定
                $img_extension = "jpg";
                break;
            //pngの場合
            case IMAGETYPE_PNG:
                //拡張子の設定
                $img_extension = "png";
                break;
            //gifの場合
            case IMAGETYPE_GIF:
                //拡張子の設定
                $img_extension = "gif";
                break;
        }
//拡張子の出力
        return $img_extension;
    }
}
