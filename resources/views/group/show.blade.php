@extends('layouts.app')

@section('content')
    <div class="container ">
        <table border="2px">
            <h1>Students in {{$group->name}}</h1>
        <a href="{{route('group.students.show',['group'=>$group])}}" class="btn btn-primary">Add Students to this group</a>

            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th></th>
            </tr>
            @foreach($group->students as $student)
                <tr>
                    <td>{{$student->id}}</td>
                    <td>{{$student->user()->name}}</td>
                    <td>{{$student->phone}}</td>
                    <td>{{$student->user()->email}}</td>

                    <td>
                        <a href="{{route('student.show',['student'=>$student])}}" class="btn btn-primary">Show</a>
                    </td>
                </tr>
                @endforeach
        </table>

    </div>
@endsection
