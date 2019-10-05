@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('paragraph.store')}}" method="post">
            @include('reading.paragraph.form')
            <button type="submit" class="btn btn-primary">
                {{ __('Add Paragraph') }}
            </button>
        </form>
    </div>
@endsection
