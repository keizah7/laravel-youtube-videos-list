@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div  class="card-header d-flex justify-content-between align-items-center">
                    Youtube videos
                    <a class="btn btn-outline-primary" href="{{ route('videos.index') }}">Back</a>
                </div>

                <div class="card-body">
                    @if($channels)
{{--                        <form action="" method="get">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col input-group">--}}
{{--                                    <select name="channel" class="form-control mr-2">--}}
{{--                                        @foreach($channels as $key => $channel)--}}
{{--                                            <option value="{{ $channel }}"@if($currentChannel == $channel) {{ ' selected' }}@endif>{{ camelCaseToNormal($key) }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                    <div class="">--}}
{{--                                        <button class="btn btn-outline-primary" type="submit">Show</button>--}}
{{--                                        <a class="btn btn-outline-danger" href="{{ route('videos.index') }}" type="submit">Clear</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}

                        <youtube-channels></youtube-channels>

                        <youtube-videos></youtube-videos>

{{--                        @if(isset($videos->items))--}}
{{--                            @forelse($videos->items as $video)--}}
{{--                                <div class="media--}}
{{--                                    @if($loop->last) mb-3 @endif--}}
{{--                                ">--}}
{{--                                    <img src="{{ $video->snippet->thumbnails->default->url }}" class="mr-3" alt="...">--}}
{{--                                    <div class="media-body">--}}
{{--                                        <h5 class="mt-0">{{ $video->snippet->title }}</h5>--}}
{{--                                        <p>{{ Str::words($video->snippet->description, 50) }} </p>--}}
{{--                                    </div>--}}
{{--                                    <div>--}}
{{--                                        <form action="{{ route('videos.store') }}" method="post">--}}
{{--                                            @csrf--}}
{{--                                            <input type="hidden" name="id" value="{{ $video->snippet->resourceId->videoId }}">--}}
{{--                                            <button class="btn btn-outline-success" type="submit">Save</button>--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                @if(!$loop->last)<hr>@endif--}}
{{--                            @empty--}}
{{--                                Playlist is empty--}}
{{--                            @endforelse--}}
{{--                        @else--}}
{{--                            Playlist is empty--}}
{{--                        @endif--}}
                    @else
                        <a class="btn btn-primary" href="{{ route('youtube.login') }}">Log to google</a>
                    @endif

{{--                    @include('layouts.pagination', [--}}
{{--                        'channel' => $currentChannel,--}}
{{--                        'pages' => $pages,--}}
{{--                        'route' => 'youtube.index',--}}
{{--                    ])--}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
