@extends('cpanel')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('paragraph.store')}}" method="post">
            @include('reading.paragraph.form')
            <div class="row justify-content-end pr-5">

            <button type="submit" class="btn btn-primary">
                {{ __('Add Paragraph') }}
            </button>
            </div>
        </form>
    </div>
@endsection
