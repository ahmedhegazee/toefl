@extends('layouts.app')

@section('content')
    <div class="container">
        <h1></h1>
        <form action="{{route('paragraph.update',['paragraph'=>$paragraph])}}" method="post">
            @include('reading.paragraph.form')
            @method('put')
            <button type="submit" class="btn btn-primary">
                {{ __('Update Paragraph') }}
            </button>
        </form>
    </div>
@endsection
