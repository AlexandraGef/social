<?php

namespace Bevy\Http\Controllers\Auth;

use Bevy\User;
use Bevy\profile;
use Bevy\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/home';

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
            'name' => 'required|string|max:60',
            'gender' => 'required|string|max:60',
            'role' => 'required|string|max:60',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Bevy\User
     */
    protected function create(array $data)
    {
        if($data['gender']=='kobieta')
        {
            $pic_path = 'http://localhost:8000/img/female.gif';
        }
        else
        {
            $pic_path = 'http://localhost:8000/img/male.gif';
        }

        $user =  User::create([
            'name' => $data['name'],
            'gender' => $data['gender'],
            'role' => $data['role'],
            'pic' => $pic_path,
            'slug' => str_slug($data['name'],'-'),
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        Profile::create(['user_id' => $user->id]);

        return $user;
    }


}
