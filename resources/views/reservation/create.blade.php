@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('res.store')}}" method="post">
            @include('reservation.form')
            <div class="form-group row">
                <label for="max_students" class="col-md-4 col-form-label text-md-right">{{ __('Maximum number of students') }}</label>

                <div class="col-md-6">
                    <input id="max_students" type="number" class="form-control @error('max_students') is-invalid @enderror" name="max_students"  min="0" value="{{  $re->max_students?? 0 }}" required  autofocus>
                    @error('start')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                {{ __('Add Reservation') }}
            </button>
        </form>
    </div>
@endsection
