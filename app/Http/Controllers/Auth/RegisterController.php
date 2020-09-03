<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use App\Http\Controllers\Controller;
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
    public function __construct()
    {
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
            'screen_name' => ['required', 'string', 'max:255'],
            'view_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_icon' => ['bail','mimes:jpeg,bmp,png,gif'],
        ]);
    }


    /**
     * @param array $data
     * @return mixed
     */
    protected function create(array $data)
    {
//        dd($data);

//        $store_dir = 'user-icon/'.$data['screen_name'];
//        $stored_path = $request->file('user_icon')->store($store_dir);

        return User::create([
            'screen_name' => $data['screen_name'],
            'view_name' => $data['view_name'],
            'password' => Hash::make($data['password']),
            'token' => User::makeToken(),
            'token_sec' => User::makeToken(),
//            'user_icon_path' => $stored_path,
        ]);
    }
}
