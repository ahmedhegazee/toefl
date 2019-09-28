@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-6">
                <img src="/storage/{{$student->personalimage}}" style="height:400px;width:400px" alt="">
            </div>
            <div class="col-6">
                <img src="/storage/{{$student->nidimage}}" style="height:400px;width:400px" alt="">

            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <img src="/storage/{{$student->certificateimage}}" style="height:400px;width:400px" alt="">

            </div>
            <div class="col-6">
                <img src="/storage/{{$student->messageimage}}" style="height:400px;width:400px" alt="">

            </div>
        </div>
        <div class="row">
            <form action="{{route('student.update',['student'=>$student])}}" method="post">
                @method('put')
                <button type="submit" class="btn btn-primary">
                    Verify Student
                </button>
                @csrf
            </form>

        </div>
    </div>

    @endsection
