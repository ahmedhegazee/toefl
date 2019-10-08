@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('audio.store')}}" method="post" enctype="multipart/form-data">
            @include('listening.audio.form')
            <button type="submit" class="btn btn-primary">
                {{ __('Add Audio') }}
            </button>
        </form>
    </div>
@endsection
