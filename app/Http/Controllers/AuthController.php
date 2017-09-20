<?php

namespace Bevy\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Mail;


class AuthController extends Controller
{


    public function setToken(Request $request)
    {

        $email = $request->email_address;
        //check any user have this email adress$data_toview = array();

        $checkEmail = DB::table('users')->where('email', $email)->get();
        $user = DB::table('users')->where('email', $email)->value('name');
        if (count($checkEmail) == 0) {
            echo "Podany adres email ne istnieje !";
        } else {
            $randomNumber = rand(1, 500);
            $token_sl = bcrypt($randomNumber);
            $token = str_replace('/', '', $token_sl);
            $baseUrl = 'http://localhost:8000/getToken/' . $token;
            $insert_token = DB::table('password_resets')->insert(['email' => $email, 'token' => $token, 'created_at'
            => \Carbon\Carbon::now()->toDateTimeString()]);

            Mail::send('auth.mail.mail', ['user' => $user, 'baseUrl' => $baseUrl], function ($message) use ($email, $user) {
                $message->from('admin@bevy.com', 'BEVY');
                $message->to($email, $user)->subject('Link resetujący hasło');

            });
            return back()->with('info', 'Link pozwalający zresetować hasło został wysłany na wybrany adres email.');


        }
    }

    public function setPass(Request $request)
    {
        $email = $request->email;
        $pass = $request->pass;
        $cpass = $request->confirm_pass;

        if ($pass == $cpass) {
            DB::table('users')->where('email', $email)->update(['password' => bcrypt($pass)]);
            DB::table('password_resets')->where('email', $email)->delete();
            return redirect('/login')->with('msg', 'Hasło zostało zresetowane. Możesz się zalogować.');
        } else {
            return back()->with('err', 'Hasła do siebie nie pasują !');
        }
    }

    public function getToken($token)
    {
        $getData = DB::table('password_resets')->where('token', $token)->get();
        if (count($getData) != 0) {
            return view('auth.setPassword')->with('data', $getData);
        } else {
            return redirect('/zapomnianeHaslo')->with('err', 'Podany token już wygasł !');
        }
    }
}