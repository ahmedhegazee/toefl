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

                            <a href="{{route('questions.index')}}" class="btn btn-primary ">Questions</a>
                            <a href="{{route('student.index')}}" class="btn btn-primary ">Students</a>
                            <a href="{{route('res.index')}}" class="btn btn-primary ">Reservations </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
