@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('grammar.store')}}" method="post">
            @include('grammar.questions.form')
            <button type="submit" class="btn btn-primary">
                {{ __('Add Grammar Question') }}
            </button>
        </form>
    </div>
@endsection
