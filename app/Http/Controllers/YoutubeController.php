<?php

namespace App\Http\Controllers;

use App\Services\Youtube;
use Illuminate\Http\Request;

class YoutubeController extends Controller
{
    public function log(Youtube $youtube)
    {
        return $youtube->logIn();
    }

    public function callback(Youtube $youtube, Request $request)
    {
        if($request->code) {
            if(session('state') == $request->state) {
                return $youtube->auth($request->code);
            } else throw new \Exception('State does not match');
        }
    }
}
