<?php

namespace Bevy\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Mail;


class AuthController extends Controller
{
    public function setToken(Request $request)
    {
        $email = $request->email_address;
        //check any user have this email adress

        $checkEmail = DB::table('users')->where('email', $email)->get();
        if (count($checkEmail) == 0) {
            echo "Podany adres email ne istnieje !";
        } else {
 $to = $email;
 $subject = "Reset Hasła";
 $message= "chuj";
  $headers =  'MIME-Version: 1.0' . "\r\n";
 $headers .= 'From: Your name <info@address.com>' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

 mail($to,$subject,$message,$headers);

        }
    }
}