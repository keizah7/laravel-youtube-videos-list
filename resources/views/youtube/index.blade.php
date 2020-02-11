@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Videos</div>

                <div class="card-body">
                    @if($channels)
                        <form action="" method="get">
                            <div class="row">
                                <div class="col input-group">
                                    <select name="channel" class="form-control mr-2">
                                        @foreach($channels as $key => $channel)
                                            <option value="{{ $channel }}"@if($currentChannel == $channel) {{ ' selected' }}@endif>{{ camelCaseToNormal($key) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="">
                                        <button class="btn btn-outline-primary" type="submit">Show</button>
                                        <a class="btn btn-outline-danger" href="{{ route('video.index') }}" type="submit">Clear</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                        @isset($videos->items)
                            @forelse($videos->items as $video)
                                <div class="media">
                                    <img src="{{ $video->snippet->thumbnails->default->url }}" class="mr-3" alt="...">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $video->snippet->title }}</h5>
                                        <p>{{ Str::words($video->snippet->description, 50) }} </p>
                                    </div>
                                </div>
                                @if(!$loop->last)<hr>@endif
                            @empty
                                Playlist is empty
                            @endforelse
                        @endisset
                    @else
                        <a class="btn btn-primary" href="{{ url('youtube/login') }}">Log to google</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
