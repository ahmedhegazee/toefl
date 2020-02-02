@extends('cpanel')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('paragraph.update',['paragraph'=>$paragraph])}}" method="post">
            @include('reading.paragraph.form')
            @method('put')
            <div class="row justify-content-end pr-5">

            <button type="submit" class="btn btn-primary">
                {{ __('Update Paragraph') }}
            </button>
            </div>
        </form>
    </div>
@endsection
