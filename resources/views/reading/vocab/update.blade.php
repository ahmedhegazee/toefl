@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('vocab.update',['vocab'=>$question])}}" method="post">
            @include('layouts.questions')
            @method('put')
            <button type="submit" class="btn btn-primary">
                {{ __('Update Vocab Question') }}
            </button>
        </form>
    </div>
@endsection
