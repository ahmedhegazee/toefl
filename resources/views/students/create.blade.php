@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Student</h1>
        <form action="{{route('student.store')}}" method="post" enctype="multipart/form-data">
            @include('students.form')
            <button type="submit" class="btn btn-primary">
                {{ __('Add New Student') }}
            </button>
        </form>
    </div>
@endsection
