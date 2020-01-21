@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <div class="row justify-content-between p-2 mb-2">
                            {{--                            @can('viewAny',\App\Student::class)--}}
                            {{--                            <a href="{{route('student.index')}}" class="btn btn-primary ">Verify Students</a>--}}
                            {{--                            @endcan--}}
{{--                            <a href="{{route('group.index')}}" class="btn btn-primary ">Groups</a>--}}

{{--                            <a href="{{route('questions.index')}}" class="btn btn-primary ">Questions</a>--}}
                            <a href="{{route('cpanel.students-panel')}}" class="btn btn-primary ">Students</a>
                            <a href="{{route('res.index')}}" class="btn btn-primary ">Reservations </a>
{{--                            <a href="{{route('exams.index')}}" class="btn btn-primary ">Exams </a>--}}
                            <a href="{{route('grammar.index')}}" class="btn btn-primary ">Grammar Section </a>
                            <a href="{{route('reading.index')}}" class="btn btn-primary ">Reading Section </a>
                            <a href="{{route('listening.index')}}" class="btn btn-primary ">Listening Section </a>

                        </div>
                        <div class="row justify-content-between p-2">
                            <a href="{{route('cpanel.users-panel')}}" class="btn btn-primary ">Users Panel </a>
                            <a href="{{route('cpanel.configs-panel')}}" class="btn btn-primary ">Configs Panel  </a>
                            <a href="{{route('cpanel.exams-panel')}}" class="btn btn-primary ">Exams Panel </a>
                            <a href="{{route('cpanel.certificates-panel')}}" class="btn btn-primary ">Certificates Panel  </a>
                            <a href="{{route('cpanel.marks-panel')}}" class="btn btn-primary ">Marks Panel  </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
