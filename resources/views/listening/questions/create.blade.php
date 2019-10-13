@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('audio.question.store',['audio'=>$audio])}}" method="post">
            @include('layouts.questions')
            <button type="submit" class="btn btn-primary">
                {{ __('Add Listening Question') }}
            </button>
        </form>
    </div>
@endsection
