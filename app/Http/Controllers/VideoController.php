<?php

namespace App\Http\Controllers;

use App\Services\Youtube;
use Illuminate\Http\Request;

class VideoController extends Controller
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
}
