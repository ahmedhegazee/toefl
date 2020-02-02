@extends('cpanel')

@section('content')
    <div class="container">
        <h1>Update Group</h1>
        <form action="{{route('student.update',['student'=>$student])}}" method="post">
            @method('put')
            @include('students.form')

            <div class="row justify-content-end pr-5">

            <button type="submit" class="btn btn-primary">
                {{ __('Update Student') }}
            </button>
            </div>
        </form>
    </div>
@endsection
