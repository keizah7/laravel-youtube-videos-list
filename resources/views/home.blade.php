@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul class="list-group">
                        <li class="list-group-item">
                            <a href="{{ route('videos.index') }}">Videos</a> ({{ $videos_count }})
                        </li>
                        @if(auth()->user()->isLeader())
                            <li class="list-group-item">
                                <a href="{{ route('youtube.index') }}">Youtube videos</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
