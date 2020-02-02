@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if(isset($message))
                    <div class='alert alert-success'> {{$message}} </div>
                @endif

                @if(session()->has('message'))
                    <div class='alert alert-success'> {{session()->get('message')}} </div>
                @endif
            </div>
        </div>
    </div>
@endsection
