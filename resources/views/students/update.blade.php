@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Update Group</h1>
        <form action="{{route('student.update',['student'=>$student])}}" method="post">
            @method('put')
            @include('students.form')


            <button type="submit" class="btn btn-primary">
                {{ __('Update Student') }}
            </button>
        </form>
    </div>
@endsection
