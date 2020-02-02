@extends('cpanel')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('vocab.store')}}" method="post">
            @include('layouts.questions')
            <div class="row justify-content-end pr-5">

            <button type="submit" class="btn btn-primary">
                {{ __('Add Vocab Question') }}
            </button>
            </div>
        </form>
    </div>
@endsection
