@extends('cpanel')
@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('audio.store')}}" method="post" enctype="multipart/form-data">
            @include('listening.audio.form')
            <div class="row justify-content-end pr-5">

            <button type="submit" id="button" class="btn btn-primary">
                {{ __('Add Audio') }}
            </button>
            </div>
        </form>
    </div>
@endsection
