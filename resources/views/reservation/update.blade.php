@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('res.update',['re'=>$re])}}" method="post">
            @method('put')
            @include('reservation.form')
            <button type="submit" class="btn btn-primary">
                {{ __('Update Reservation') }}
            </button>
        </form>
    </div>
@endsection
