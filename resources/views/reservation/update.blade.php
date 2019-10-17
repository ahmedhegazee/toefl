@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('res.update',['re'=>$re])}}" method="post">
            @method('put')
            @include('reservation.form')
{{--            <div class="form-group row">--}}
{{--                <label for="done" class="col-md-4 col-form-label text-md-right">Status</label>--}}
{{--                <div class="col-md-6">--}}
{{--                    <select id="done" name="done" class="form-control">--}}
{{--                        <option value="" disabled>Select Reservation Status</option>--}}
{{--                        @foreach($re->doneOptions() as $activeOptionKey => $activeOptionValue)--}}
{{--                            <option value="{{$activeOptionKey}}" {{$re->done==$activeOptionValue?'selected':''}}>{{$activeOptionValue}}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                    @error('done')--}}
{{--                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                    @enderror--}}
{{--                </div>--}}

{{--            </div>--}}

            <button type="submit" class="btn btn-primary">
                {{ __('Update Reservation') }}
            </button>
        </form>

    </div>
@endsection
