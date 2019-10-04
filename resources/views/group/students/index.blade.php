@extends('layouts.app')

@section('content')
    <div class="container ">
        <h1>Add Students to {{$group->name}}</h1>
        <form action="{{route('group.students.store',['group'=>$group])}}" method="post">
        <table border="2px">
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>verified</th>
                <th>Group</th>
            </tr>
            @foreach($students as $student)
                <tr>
                    <td><input type="checkbox" name="students[]" value="{{$student->id}}" {{$student->group->id==$group->id?'checked':''}}></td>
                    <td>{{$student->id}}</td>
                    <td>{{$student->user()->name}}</td>
                    <td>{{$student->phone}}</td>
                    <td>{{$student->verified}}</td>
                    <td>{{$student->group->name}}</td>

                </tr>
                @endforeach
        </table>
            <div class="row">
                {{$students->links()}}
            </div>
            <button type="submit" class="btn btn-primary">
                {{ __('Add Students') }}
            </button>
            @csrf
        </form>
    </div>
@endsection
