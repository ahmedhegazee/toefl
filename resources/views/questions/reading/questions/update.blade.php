@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('reading.update',['question'=>$question,'paragraph'=>$paragraph])}}" method="post">
            @include('questions.reading.questions.form')
            @method('put')
            <button type="submit" class="btn btn-primary">
                {{ __('Update Reading Question') }}
            </button>
        </form>
    </div>
@endsection
