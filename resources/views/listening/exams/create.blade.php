@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('listening.exam.store')}}" method="post">
            @include('layouts.exams')
            <button type="submit" class="btn btn-primary">
                {{ __('Add Exam') }}
            </button>
        </form>
    </div>
@endsection
