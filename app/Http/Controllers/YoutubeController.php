<?php

namespace App\Http\Controllers;

use App\Services\Youtube;
use Illuminate\Http\Request;

class YoutubeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param Youtube $youtube
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Youtube $youtube, Request $request)
    {
        $currentChannel = $request->channel;

        return view('youtube.index', [
            'channels' => $youtube->getChannels(),
            'videos' => $youtube->getVideos($currentChannel),
            'currentChannel' => $currentChannel,
        ]);
    }

    public function login(Youtube $youtube)
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
