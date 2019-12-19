@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->has('error'))
            <div class="alert alert-danger mb-3">
                {{session()->get('error')}}
            </div>
        @endif
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <h5 class="card-title">Welcome ,{{$fullName}}</h5>
                        <p>Arabic Name : {{$student->arabic_name}}</p>

                        <p>Reservation : {{$student->reservation->start}}</p>
                        <p>Group : {{$student->group->type->type}}</p>
                    </div>
                    <div class="col-9">
                        <img src="/storage/{{$student->personalimage}}" class="w-100" alt="">
                    </div>
                </div>


                <a href="{{route('grammar.exam.start')}}" class="btn btn-primary">Go to Exam</a>
            </div>
        </div>

    </div>

@endsection
