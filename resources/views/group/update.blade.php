@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Update Group</h1>
        <form action="{{route('group.update',['group'=>$group,'re'=>$re])}}" method="post">
            @method('put')
            @include('group.form')


            <button type="submit" class="btn btn-primary">
                {{ __('Update Group') }}
            </button>
        </form>
    </div>
@endsection
