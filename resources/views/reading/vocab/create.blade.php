@extends('cpanel')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('vocab.store')}}" method="post">
            @include('layouts.questions')
            <button type="submit" class="btn btn-primary">
                {{ __('Add Vocab Question') }}
            </button>
        </form>
    </div>
@endsection
