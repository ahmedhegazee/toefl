@extends('cpanel')

@section('content')
    <div class="container">
        <h1>Add New Reading Exam</h1>
        <form action="{{route('reading.exam.store')}}" method="post">
            @include('layouts.exams')
            <div class="row justify-content">

            <button type="submit" class="btn btn-primary">
                {{ __('Add Exam') }}
            </button>
            </div>
        </form>
    </div>
@endsection
