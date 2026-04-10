<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\GuestLogin;
use App\Model\SnsIdList;
use App\Model\User;
use Cookie;
use \File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Str;
use Symfony\Component\HttpFoundation\Response;

class DiscordController extends Controller
{
    // ログイン
    public function redirectToProvider(Request $request)
    {
        $request->session()->put('discordLoginMode', $request->input('mode'));
        if (!empty($request->input('redirect_url'))) {
            $request->session()->put('redirectUrl', $request->input('redirect_url'));
        }
        return Socialite::driver('discord')->scopes(['identify', 'email'])->redirect();
    }

    // コールバック
    public function handleProviderCallback(Request $request)
    {
        try {
            $discordUser = Socialite::driver('discord')->user();
        } catch (Exception $e) {
            return redirect('auth/discord');
        }

        // ログイン処理
        $pc_user_id = SnsIdList::getOrigIDByDiscord($discordUser->getId());
        if (empty($pc_user_id)) {
            $user = false;
        } else {
            $user = User::where('user_id', $pc_user_id)->first();
        }

        $mode = $request->session()->pull('discordLoginMode');
        switch ($mode) {
            case 'login':
                $prof_icon_path = $this->_putProfileImage($discordUser->getId(), $discordUser->getAvatar());
                if (!$user) {
                    DB::beginTransaction();
                    try {
                        $next_user_id = User::maxOrigUserID() + 1;
                        User::create([
                            'user_id'        => $next_user_id,
                            'screen_name'    => $discordUser->getNickname() . '@discord.com',
                            'view_name'      => $discordUser->getName(),
                            'description'    => '',
                            'user_icon_path' => $prof_icon_path,
                            'token'          => User::makeToken(),
                            'token_sec'      => User::makeToken(),
                            'is_from_sns'    => true,
                        ]);
                        SnsIdList::create([
                            'pc_user_id' => $next_user_id,
                            'sns_id'     => $discordUser->getId(),
                            'sns_type'   => SnsIdList::SNS_TYPE_DISCORD,
                        ]);
                        $user = User::where('user_id', $next_user_id)->first();
                    } catch (Exception $e) {
                        DB::rollBack();
                        throw $e;
                    }
                    DB::commit();
                }

                Auth::login($user);
                Cookie::queue(Cookie::make('X-User-Token', $user->token, 2147483647));
                Cookie::queue(Cookie::make('X-User-Token-Sec', $user->token_sec, 2147483647));

                return is_null($request->session()->get('redirectUrl'))
                    ? redirect('/event/joined')
                    : redirect($request->session()->pull('redirectUrl'));

            case 'get-photos':
                $screenName = $discordUser->getNickname();
                $GuestLogin = GuestLogin::whereSnsScreenName($screenName)->first();
                if (is_null($GuestLogin)) {
                    $GuestLogin = GuestLogin::create([
                        'sns_screen_name' => $screenName,
                        'sns_type'        => GuestLogin::SNS_TYPE_DISCORD,
                        'guest_token'     => Str::random(64),
                    ]);

                    if (!($GuestLogin instanceof GuestLogin)) {
                        abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'guest_login_create_error');
                    }
                }
                Cookie::queue(Cookie::make('X-Guest-Token', $GuestLogin->guest_token, 2147483));
                return redirect('/get-photos');

            default:
                abort(Response::HTTP_BAD_REQUEST, 'invalid_request');
        }
    }

    // ログアウト
    public function logout()
    {
        Auth::logout();

        Cookie::queue(Cookie::forget('X-User-Token'));
        Cookie::queue(Cookie::forget('X-User-Token-Sec'));
        Cookie::queue(Cookie::forget('X-Guest-Token'));

        return redirect('/login?pass_code=' . \Config::get('auth.access_code'));
    }

    private function _putProfileImage($userid, $avatar_url)
    {
        if (empty($avatar_url)) {
            return null;
        }
        $img = file_get_contents($avatar_url);
        $img_ext = $this->_getImageExt($avatar_url);

        $prof_icon_path = 'proficons/' . $userid . '.' . $img_ext;
        if (File::exists($prof_icon_path)) {
            Storage::delete($prof_icon_path);
        }
        Storage::disk('local')->put($prof_icon_path, $img);
        return $prof_icon_path;
    }

    private function _getImageExt($photo_url)
    {
        list($img_width, $img_height, $mime_type, $attr) = getimagesize($photo_url);
        switch ($mime_type) {
            case IMAGETYPE_JPEG:
                return 'jpg';
            case IMAGETYPE_PNG:
                return 'png';
            case IMAGETYPE_GIF:
                return 'gif';
            default:
                return 'png';
        }
    }
}
