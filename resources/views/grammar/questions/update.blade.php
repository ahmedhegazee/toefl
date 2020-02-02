@extends('cpanel')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('grammar.question.update',['question'=>$question])}}" method="post">
            @include('grammar.questions.form')
            @method('put')
            <div class="row justify-content-end pr-5">
                <button type="submit" class="btn btn-primary">
                    {{ __('Update Grammar Question') }}
                </button>

            </div>

             </form>
    </div>
@endsection
