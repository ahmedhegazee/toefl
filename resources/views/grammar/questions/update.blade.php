@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('grammar.update',['grammar'=>$grammar])}}" method="post">
            @include('grammar.questions.form')
            @method('put')
            <button type="submit" class="btn btn-primary">
                {{ __('Update Grammar Question') }}
            </button>
        </form>
    </div>
@endsection
