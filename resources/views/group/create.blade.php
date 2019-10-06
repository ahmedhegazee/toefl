@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Group</h1>
        <form action="{{route('group.store',['re'=>$re])}}" method="post">
            @include('group.form')
            <button type="submit" class="btn btn-primary">
                {{ __('Add Group') }}
            </button>
        </form>
    </div>
@endsection
