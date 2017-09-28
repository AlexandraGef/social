<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\profile;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

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
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:60',
            'gender' => 'required|string|max:60',
            'role' => 'required|string|max:60',
            'birthday'=> 'required|date',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if ($data['gender'] == 'kobieta') {
            $pic_path = 'http://localhost:8000/img/female.gif';
        } else {
            $pic_path = 'http://localhost:8000/img/male.gif';
        }
        if ($data['role'] == 'user') {
            $role = 2;
        } else {
            $role = 3;
        }

        $rand = rand(0, 10000);

        $user = User::create([
            'name' => $data['name'],
            'gender' => $data['gender'],
            'role_id' => $role,
            'pic' => $pic_path,
            'birthday' => $data['birthday'],
            'slug' => str_slug($data['name'], '-').$rand,
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        Profile::create(['user_id' => $user->id]);

        return $user;
    }


}
