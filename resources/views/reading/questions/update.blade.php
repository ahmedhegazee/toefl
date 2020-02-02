@extends('cpanel')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('paragraph.question.update',['question'=>$question,'paragraph'=>$paragraph])}}" method="post">
            @include('layouts.questions')
            @method('put')
            <div class="row justify-content-end pr-5">

            <button type="submit" class="btn btn-primary">
                {{ __('Update Paragraph Question') }}
            </button>
            </div>
        </form>
    </div>
@endsection
