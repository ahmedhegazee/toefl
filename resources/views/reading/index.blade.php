@extends('cpanel')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <div class="row justify-content-between p-2">
                            <a href="{{route('reading.questions.index')}}" class="btn btn-primary ">Questions</a>
                            <a href="{{route('reading.exam.index')}}" class="btn btn-primary ">Exams </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
