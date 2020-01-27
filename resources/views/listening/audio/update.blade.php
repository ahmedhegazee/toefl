@extends('cpanel')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('audio.update',['audio'=>$audio])}}" method="post" enctype="multipart/form-data">
            @include('listening.audio.form')
            @method('put')
            <button type="submit" class="btn btn-primary">
                {{ __('Update Audio') }}
            </button>
        </form>
    </div>
@endsection
