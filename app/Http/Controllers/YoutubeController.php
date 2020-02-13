<?php

namespace App\Http\Controllers;

use App\Services\Youtube;
use Illuminate\Http\Request;
use App\Http\Resources\YoutubeVideo;

class YoutubeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param Youtube $youtube
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Youtube $youtube, Request $request)
    {
        $currentChannel = $request->channel;
        $data = [
            'channels' => $youtube->getChannels(),
            'videos' => $youtube->getVideos($currentChannel, $request->page),
            'currentChannel' => $currentChannel,
            'pages' => $youtube->getPagesInfo(),
        ];

        if(\request()->expectsJson()){
            return response()->json([
                'videos' => $data['videos'],
                'channels' => $data['channels'],
                'pages' => $data['pages'],
                'currentChannel' => $currentChannel,
            ]);
        }

        return view('youtube.index', $data);
    }

    /**
     * Redirects user to oauth login
     *
     * @param Youtube $youtube
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(Youtube $youtube)
    {
        return $youtube->logIn();
    }

    /**
     * OAuth login callback
     *
     * @param Youtube $youtube
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function callback(Youtube $youtube, Request $request)
    {
        if($request->code) {
            if(session('state') == $request->state) {
                return $youtube->auth($request->code);
            } else throw new \Exception('State does not match');
        }
    }
}
