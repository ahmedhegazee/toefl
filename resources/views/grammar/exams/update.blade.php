@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Update Grammar Exam</h1>
        <form action="{{route('grammar.exam.update',['exam'=>$exam])}}" method="post">
            @method('put')
            @include('layouts.exams')

            <button type="submit" class="btn btn-primary">
                {{ __('Update Exam') }}
            </button>
        </form>
    </div>
@endsection
