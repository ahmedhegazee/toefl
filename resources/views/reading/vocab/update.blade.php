@extends('cpanel')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('vocab.update',['vocab'=>$question])}}" method="post">
            @include('layouts.questions')
            @method('put')
            <div class="row justify-content-end pr-5">

            <button type="submit" class="btn btn-primary">
                {{ __('Update Vocab Question') }}
            </button>
            </div>
        </form>
    </div>
@endsection
