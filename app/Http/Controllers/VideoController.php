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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Youtube $youtube, Request $request)
    {
        return view('youtube.index', [
            'chanells' => $youtube->getChannels(),
            'videos' => $youtube->getVideos(),
        ]);
    }
}
