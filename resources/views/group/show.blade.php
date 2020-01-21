@extends('layouts.app')

@section('content')
    <div class="container ">
        <h1>Students in {{$group->name}}</h1>
{{--        <a href="{{route('group.students.show',['group'=>$group])}}" class="btn btn-primary">Add Students to this group</a>--}}

{{--            @include('layouts.students')--}}
{{--        <div class="row">--}}
{{--            {{$students->links()}}--}}
{{--        </div>--}}
        <display-students-panel
            data="{{$students}}"
        ></display-students-panel>
    </div>
@endsection
