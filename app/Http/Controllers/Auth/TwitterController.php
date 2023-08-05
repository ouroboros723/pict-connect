<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\SnsIdList;
use App\Model\User;
use Cookie;
use \File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use mysql_xdevapi\Exception;

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
//         ログイン処理
        $pc_user_id = SnsIdList::getOrigID($twitterUser->id);
        if (empty($pc_user_id)) {
            $user = false;
        } else {
            $user = User::where('user_id', $pc_user_id)->first();
        }
        //オリジナルサイズのプロフィール画像取得
        $original_url = str_replace("_normal.", ".", $twitterUser->user['profile_image_url_https']);
        $prof_icon_path = $this->_putProfileImage($twitterUser->id, $original_url);
        if (!$user) {
            DB::beginTransaction();
            try {
                //user_id重複対策(オートインクリメント)
                $next_user_id = User::maxOrigUserID() + 1;
                User::create([
                    'user_id' => $next_user_id,
                    'screen_name' => $twitterUser->nickname,
                    'view_name' => $twitterUser->name,
                    'description' => $twitterUser->user['description'],
                    'user_icon_path' => $prof_icon_path,
                    'token' => User::makeToken(),
                    'token_sec' => User::makeToken(),
                    'is_from_sns' => true,
                ]);
                SnsIdList::create([
                    'pc_user_id' => $next_user_id,
                    'sns_id' => $twitterUser->id,
                    'sns_type' => SnsIdList::SNS_TYPE_TWITTER,
                ]);
                $user = User::where('user_id', $next_user_id)->first();
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
            DB::commit();

        } else {
            //Twitterの情報が変わってたら新しい情報に更新

            $user->screen_name = $twitterUser->nickname;
            $user->view_name = $twitterUser->name;
            $user->description = $twitterUser->user['description'];
            $user->user_icon_path = $prof_icon_path;
            $user->save();
        }

        Auth::login($user);
        Cookie::queue(Cookie::make('X-User-Token', $user->token));
        Cookie::queue(Cookie::make('X-User-Token-Sec', $user->token_sec));

        return redirect('/');
    }

    // ログアウト
    public function logout()
    {
        // ログアウト処理
        Auth::logout();

        Cookie::queue(Cookie::forget('X-User-Token'));
        Cookie::queue(Cookie::forget('X-User-Token-Sec'));

        return redirect('/login?pass_code='.\Config::get('auth.access_code'));
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
