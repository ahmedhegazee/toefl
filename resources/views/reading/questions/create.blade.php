@extends('cpanel')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('paragraph.question.store',['paragraph'=>$paragraph])}}" method="post">
            @include('layouts.questions')
            <div class="row justify-content-end pr-5">

            <button type="submit" class="btn btn-primary">
                {{ __('Add Paragraph Question') }}
            </button>
            </div>
        </form>
    </div>
@endsection
