@extends('cpanel')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('grammar.question.store')}}" method="post">
            @include('grammar.questions.form')
            <div class="row justify-content-end pr-5">
                <button type="submit" class="btn btn-primary">
                    {{ __('Add Grammar Question') }}
                </button>
            </div>

        </form>
    </div>
@endsection
