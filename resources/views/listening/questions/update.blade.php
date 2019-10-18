@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('listening.question.update',['question'=>$question,'audio'=>$audio])}}" method="post">
            @include('layouts.questions')
            @method('put')
            <button type="submit" class="btn btn-primary">
                {{ __('Update Listening Question') }}
            </button>
        </form>
    </div>
@endsection
