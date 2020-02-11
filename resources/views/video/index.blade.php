@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Videos
                    @if(auth()->user()->isLeader())
                        <a class="btn btn-outline-primary" href="{{ route('youtube.index') }}">Add more</a>
                    @endif
                </div>

                <div class="card-body">
                    @forelse($videos as $video)
                        <div class="media">
                            <img src="{{ $video->photo }}" class="mr-3" alt="...">
                            <div class="media-body">
                                <h5 class="mt-0">{{ $video->title }}</h5>
                                <p>{{ Str::words($video->description, 50) }} </p>
                            </div>
                            <div>
                                @can('delete', $video)
                                    <form action="{{ route('videos.destroy', $video) }}" method="post">
                                        @csrf
                                        @method('delete')

                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <p class="text-muted d-flex justify-content-between align-content-center mt-1">
                            <span>Uploaded by: {{ $video->user->name }}</span>
                            <span>{{ $video->created_at->diffForHumans() }}</span>
                        </p>
                        @if(!$loop->last) <hr> @endif
                    @empty
                        Video list is empty
                    @endforelse
                    {{ $videos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
