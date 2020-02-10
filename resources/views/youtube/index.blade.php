@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Videos</div>

                <div class="card-body">
                    @if($chanells)
                        <form action="" method="get">
                            <div class="row">
                                <div class="col input-group">
                                    <select name="channel" class="form-control mr-2">
                                        @foreach($chanells as $key => $channel)
                                            <option value="{{ $channel }}">{{ camelCaseToNormal($key) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="">
                                        <button class="btn btn-outline-primary" type="submit">Show</button>
                                        <a class="btn btn-outline-danger" href="{{ route('video.index') }}" type="submit">Clear</a>
                                    </div>
                                </div>
                            </div>
                        </form>

                    @else
                        <a class="btn btn-primary" href="{{ url('youtube/login') }}">Log to google</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
