@extends('cpanel')

@section('content')
    <div class="container">
        <h1>Update Reading Exam</h1>
        <form action="{{route('reading.exam.update',['exam'=>$exam])}}" method="post">
            @method('put')
            @include('layouts.exams')
            <div class="row justify-content">

            <button type="submit" class="btn btn-primary">
                {{ __('Update Exam') }}
            </button>
            </div>
        </form>
    </div>
@endsection
