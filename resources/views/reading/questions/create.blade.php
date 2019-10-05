@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('paragraph.question.store',['paragraph'=>$paragraph])}}" method="post">
            @include('layouts.questions')
            <button type="submit" class="btn btn-primary">
                {{ __('Add Reading Question') }}
            </button>
        </form>
    </div>
@endsection
