@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <div class="row justify-content-between p-2">
                            <a href="{{route('audio.index')}}" class="btn btn-primary ">Audios</a>
                            <a href="{{route('listening.exam.index')}}" class="btn btn-primary ">Exams </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
