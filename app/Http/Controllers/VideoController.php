<?php

namespace App\Http\Controllers;

use App\Services\Youtube;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Youtube $youtube)
    {
        if($youtube->isLogged()) {
            return view('home');
        }
    }
}
