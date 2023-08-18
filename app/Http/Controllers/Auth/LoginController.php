<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Config;
use Cookie;
use http\Env\Response;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function username() // このメソッドを追記
    {
        return 'screen_name'; // 対象のカラム名に。後述するように view も変えます
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            Cookie::queue(Cookie::make('X-User-Token', Auth::User()->token, 2147483647));
            Cookie::queue(Cookie::make('X-User-Token-Sec', Auth::User()->token_sec, 2147483647));
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|RedirectResponse|\Illuminate\Http\Response|Redirector
     * @throws BindingResolutionException
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        Cookie::queue(Cookie::forget('X-User-Token'));
        Cookie::queue(Cookie::forget('X-User-Token-Sec'));

        return $this->loggedOut($request) ?: redirect('/login?pass_code='.Config::get('auth.access_code'));
    }

}
