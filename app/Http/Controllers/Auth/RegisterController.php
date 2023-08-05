<?php

namespace App\Http\Controllers\Auth;

use App\Model\SnsIdList;
use App\Model\User;
use App\Http\Controllers\Controller;
use Auth;
use Config;
use Cookie;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        if (!(Config::get('auth.access_code', null) === '') && $request->pass_code !== Config::get('auth.access_code', null)) {
            echo "Unauthorize";
            exit;
        }

        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'screen_name' => ['required', 'string', 'max:255', 'unique:users,screen_name'],
            'view_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'min:8', 'email:rfc', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_icon' => ['nullable', 'file'], //mimetypeが正しく判定できないのでいったん解除
        ]);
    }


    /**
     * @param array $data
     * @return Model|User
     */
    protected function create(array $data)
    {
        $next_user_id = User::maxOrigUserID() + 1;
        return User::create([
            'user_id' => $next_user_id,
            'screen_name' => $data['screen_name'],
            'view_name' => $data['view_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'token' => User::makeToken(),
            'token_sec' => User::makeToken(),
            'user_icon_path' => $data['user_icon_path'],
            'is_from_sns' => false,
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function register(Request $request)
    {
        $params = $request->all();

        $this->validator($params)->validate();

        $store_dir = 'user-icon/'.$request->screen_name;
        if(!is_null($request->file('user_icon'))) {
            $user_icon_path = $request->file('user_icon')->store($store_dir);
        } else {
            $user_icon_path = null;
        }

        $params['user_icon_path'] = $user_icon_path;

        event(new Registered($user = $this->create($params)));

        $this->guard()->login($user);
        Cookie::queue(Cookie::make('X-User-Token', $user->token));
        Cookie::queue(Cookie::make('X-User-Token-Sec', $user->token_sec));

        return $this->registered($request, $user)
            ?: redirect('/login?pass_code='.Config::get('auth.access_code'));
    }
}
