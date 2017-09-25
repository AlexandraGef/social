<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\service;

class NotiController extends Controller
{
    public function noti(){

        $service = service::with('profile', 'user', 'post', 'comment','answer','group')
            ->get();
        return $service;

    }
}
