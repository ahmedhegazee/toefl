@extends('layouts.app')

@section('content')
    <div class="container ">
        <h2>Groups in this Reservation </h2>
        <a href="{{route('group.create',['re'=>$re])}}" class="btn btn-primary">Add Group</a>

        <table border="2px solid">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Students Count</th>
                <th></th>
            </tr>
            @foreach($groups as $group)
                <tr>
                    <td>{{$group->id}}</td>
                    <td>{{$group->name}}</td>
                    <td>{{$group->students->count()}}</td>
                    <td>
{{--                        <a href="{{route('grammarExam.show',['grammarExam'=>$group->exam])}}" class="btn btn-primary">Show Grammar Exam</a>--}}
                        <a href="{{route('group.show',['group'=>$group])}}" class="btn btn-primary">Show Students</a>
                        <a href="{{route('group.edit',['group'=>$group])}}" class="btn btn-success">Edit Group</a>
                                                <form style="display: inline;" method="post" action="{{route('group.generate.exam',['group'=>$group])}}">

                                                    <button type="submit" class="btn btn-danger">Generate Exam</button>
                                                    @csrf
                                                </form>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
@endsection
