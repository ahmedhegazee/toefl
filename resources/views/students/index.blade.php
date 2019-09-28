@extends('layouts.app')

@section('content')
    <div class="container ">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>verified</th>
                <th></th>
            </tr>
            @foreach($students as $student)
                <tr>
                    <td>{{$student->id}}</td>
                    <td>{{$student->user()->name}}</td>
                    <td>{{$student->verified}}</td>
                    <td>
                        <a href="{{route('student.show',['student'=>$student])}}" class="btn btn-primary">Show</a>
                    </td>
                </tr>
                @endforeach
        </table>

    </div>
@endsection
