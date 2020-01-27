@extends('cpanel')

@section('content')
    <div class="container ">

{{--        <a href="{{route('student.create')}}" class="btn btn-primary">Add New Student</a>--}}
        <form action="{{route('student.search')}}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                       placeholder="Search students by number"> <span class="input-group-btn">
            <button type="submit" class="btn btn-primary">Search
            </button>
        </span>
            </div>
        </form>
        @if(session()->has('details'))
            <h1>The search results</h1>
            <table border="2px">
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Arabic Full Name</th>
                    <th>Phone</th>
                    <th>verified</th>
                </tr>
                @foreach(session()->get('details') as $student)
                    <tr>
                        <td>{{$student->id}}</td>
                        <td>{{$student->user()->name}}</td>
                        <td>{{$student->arabic_name}}</td>
                        <td>{{$student->phone}}</td>
                        <td>{{$student->verified}}</td>

                    </tr>
                @endforeach
            </table>
        @elseif(session()->has('message'))
            <div class="row alert alert-danger">{{session()->get('message')}}</div>
        @else
            @include('layouts.students')
        @endif
        <div class="row">
            {{$students->links()}}
        </div>
    </div>
@endsection
