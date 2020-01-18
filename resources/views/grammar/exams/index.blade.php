@extends('layouts.app')

@section('content')
    <div class="container ">
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{session()->get('error')}}
            </div>
        @endif
        <h2>Grammar Exams </h2>
        <a href="{{route('grammar.exam.create')}}" class="btn btn-primary">Add Exam</a>
        <table border="2px solid">
            <tr>
                <th>ID</th>
                <th>Reservation Date</th>
{{--                <th>Group Type</th>--}}

                <th>Fill Questions Count</th>
                <th>Find Questions Count</th>

                <th>Actions</th>
            </tr>
            @foreach($exams as $exam)
                <tr>
                    <td>{{$exam->id}}</td>
                    <td>{{$exam->reservation->start}}</td>
{{--                    <td>{{$exam->groupType->type}}</td>--}}
                    <td>{{$exam->getFillQuestions()->count()}}</td>
                    <td>{{$exam->getFindQuestions()->count()}}</td>

                    <td>
                        <a href="{{route('grammar.live.exam.start',['exam'=>$exam])}}" class="btn btn-primary">Live Exam</a>
                        <a href="{{route('grammar.exam.show',['exam'=>$exam])}}" class="btn btn-primary">Show</a>
                        <a href="{{route('grammar.exam.edit',['exam'=>$exam])}}" class="btn btn-success">Edit</a>
                        <form style="display: inline;" method="post" action="{{route('grammar.exam.destroy',['exam'=>$exam])}}">
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                            @csrf
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
@endsection
