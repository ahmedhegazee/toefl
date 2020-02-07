@extends('cpanel')

@section('content')
    <div class="container">
    <students-panel
    data-route="{{route('student.index')}}"
    ></students-panel>
    </div>
@endsection
