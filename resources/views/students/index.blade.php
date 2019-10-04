@extends('layouts.app')

@section('content')
    <div class="container ">
        <a href="{{route('student.create')}}" class="btn btn-primary">Add New Student</a>
        <table border="2px">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>verified</th>
                <th></th>
            </tr>
            @foreach($students as $student)
                <tr>
                    <td>{{$student->id}}</td>
                    <td>{{$student->user()->name}}</td>
                    <td>{{$student->phone}}</td>
                    <td>{{$student->verified}}</td>
                    <td>
                        <a href="{{route('student.show',['student'=>$student])}}" class="btn btn-primary">Show</a>
                    </td>
                </tr>
                @endforeach
        </table>
        <div class="row">
            {{$students->links()}}
        </div>
    </div>
@endsection
