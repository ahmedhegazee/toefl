@extends('cpanel')

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
