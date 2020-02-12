<?php

namespace App\Http\Controllers;

use App\Services\Youtube;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Video as VideoResource;

class VideoController extends Controller
{
    /**
     * VideoController constructor.
     */
    public function __construct()
    {
//        $this->authorizeResource(Video::class, 'video');
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\View\View
     */
    public function index()
    {
        $videos = Video::with(['user' => function ($q) {
            $q->select(['id','name']);
        }])->orderByDesc('id')->paginate(5);

        if(\request()->expectsJson()){
            return VideoResource::collection($videos);
        }

        return view('video.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Youtube $youtube
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Youtube $youtube)
    {
        $video = $youtube->getVideo($request->id);
        $data = [
            'url' => $video->id,
            'title' => $video->snippet->title,
            'description' => $video->snippet->description,
            'photo' => $video->snippet->thumbnails->default->url,
        ];

        Validator::make($data, [
            'url' => 'required|unique:videos,url',
            'title' => 'required|max:255',
            'description' => 'required',
            'photo' => 'required|max:255',
        ])->validate();

        auth()->user()->videos()->create($data);

        return redirect()->back()->with('message', 'Video added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Video $video
     * @return VideoResource
     * @throws \Exception
     */
    public function destroy(Video $video)
    {
        if(\request()->expectsJson()){
            $video->delete();

            return new VideoResource($video);
        }

        $video->delete();

        return redirect()->back()->with('message', 'Video deleted successfully');
    }
}
