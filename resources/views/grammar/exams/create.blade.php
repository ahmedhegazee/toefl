@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('group.store')}}" method="post">
            @include('group.form')
            <button type="submit" class="btn btn-primary">
                {{ __('Add Group') }}
            </button>
        </form>
    </div>
@endsection
