@extends('cpanel')

@section('content')
    <div class="container">
        <h1>Update Grammar Exam</h1>
        <form action="{{route('listening.exam.update',['exam'=>$exam])}}" method="post">
            @method('put')
            @include('layouts.exams')
            <div class="row justify-content-end pr-5">

            <button type="submit" class="btn btn-primary">
                {{ __('Update Exam') }}
            </button>
            </div>
        </form>
    </div>
@endsection
