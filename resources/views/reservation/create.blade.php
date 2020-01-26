@extends('cpanel')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('res.store')}}" method="post">
            @include('reservation.form')

            <button type="submit" class="btn btn-primary">
                {{ __('Add Reservation') }}
            </button>
        </form>
    </div>
@endsection
