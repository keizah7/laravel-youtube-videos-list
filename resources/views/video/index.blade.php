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

                <video-files></video-files>
            </div>
        </div>
    </div>
</div>
@endsection
