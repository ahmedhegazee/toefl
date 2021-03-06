@extends('cpanel')

@section('content')

    <div class="container">

        <div class="row mb-4">
            <div class="col-5 p-3">
                <img src="/storage/{{$student->personalimage}}" style="height:300px;" alt="">
            </div>
            <div class="col-5 p-3">
                <img src="/storage/{{$student->nidimage}}" style="height:300px;" alt="">

            </div>
        </div>
        <div class="row mb-4">
            <div class="col-5 p-3">
                <img src="/storage/{{$student->documents->last()->certificate_document}}" style="height:300px;" alt="">

            </div>
            <div class="col-5 p-3">
                <img src="/storage/{{$student->documents->last()->message_document}}" style="height:300px;" alt="">

            </div>
        </div>

        <div class="row justify-content-end pr-5">
            <form action="{{route('student.verify',['student'=>$student])}}" method="post">
                @method('patch')
                {{--                <div class="form-group row">--}}
                {{--                    <label for="required_score" class="col-md-4 col-form-label text-md-right">Required Score</label>--}}

                {{--                    <div class="col-md-6">--}}
                {{--                        <input id="required_score" type="number" class="form-control @error('required_score') is-invalid @enderror" name="required_score" value="{{ old('required_score') }}" required  autofocus>--}}

                {{--                        @error('required_score')--}}
                {{--                        <span class="invalid-feedback" role="alert">--}}
                {{--                                        <strong>{{ $message }}</strong>--}}
                {{--                                    </span>--}}
                {{--                        @enderror--}}
                {{--                    </div>--}}
                <button type="submit" class="btn btn-primary">
                    Verify Student
                </button>
                @csrf
            </form>

        </div>
        </div>



    @endsection
