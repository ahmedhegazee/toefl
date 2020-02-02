@extends('cpanel')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('res.store')}}" method="post">
            @include('reservation.form')
            <div class="row justify-content-end pr-5">

            <button type="submit" class="btn btn-primary">
                {{ __('Add Reservation') }}
            </button>
            </div>
        </form>
    </div>
@endsection
