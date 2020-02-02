@extends('cpanel')

@section('content')
    <div class="container">
        <h1>Add New Grammar Exam</h1>
        <form action="{{route('grammar.exam.store')}}" method="post">
            @include('layouts.exams')
            <div class="row justify-content-end pr-5">
            <button type="submit" class="btn btn-primary">
                {{ __('Add Exam') }}
            </button>
            </div>
        </form>
    </div>
@endsection
