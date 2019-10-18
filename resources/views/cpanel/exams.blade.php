@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <div class="row justify-content-between p-2">
                            {{--                            @can('viewAny',\App\Student::class)--}}
                            {{--                            <a href="{{route('student.index')}}" class="btn btn-primary ">Verify Students</a>--}}
                            {{--                            @endcan--}}
{{--                            <a href="{{route('group.index')}}" class="btn btn-primary ">Groups</a>--}}

                            <a href="{{route('reading.exam.index')}}" class="btn btn-primary ">Reading Exams</a>
                            <a href="{{route('grammar.exam.index')}}" class="btn btn-primary ">Grammar Exams</a>
                            <a href="{{route('listening.exam.index')}}" class="btn btn-primary ">Listening Exams </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
