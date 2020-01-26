@extends('cpanel')

@section('content')
    <div class="container ">
        <h2>Reading Exams </h2>
        <a href="{{route('reading.exam.create')}}" class="btn btn-primary">Add Exam</a>
        {{--        <table border="2px solid">--}}
        {{--            <tr>--}}
        {{--                <th>ID</th>--}}
        {{--                <th>Reservation Date</th>--}}
        {{--                <th>Group Type</th>--}}

        {{--                <th>Vocab Questions</th>--}}
        {{--                <th>Paragraphs</th>--}}

        {{--                <th>Actions</th>--}}
        {{--            </tr>--}}
        {{--            @foreach($exams as $exam)--}}
        {{--                <tr>--}}
        {{--                    <td>{{$exam->id}}</td>--}}
        {{--                    <td>{{$exam->reservation->start}}</td>--}}
        {{--                    <td>{{$exam->groupType->type}}</td>--}}

        {{--                    <td>{{$exam->vocabQuestions()->count()}}</td>--}}
        {{--                    <td>{{$exam->paragraphs()->count()}}</td>--}}

        {{--                    <td>--}}
        {{--                        <a href="{{route('reading.live.exam.start',['exam'=>$exam])}}" class="btn btn-primary">Live Exam</a>--}}
        {{--                        <a href="{{route('reading.exam.show.paragraphs',['exam'=>$exam])}}" class="btn btn-primary">Show Paragraphs</a>--}}
        {{--                        <a href="{{route('reading.exam.show.vocab',['exam'=>$exam])}}" class="btn btn-primary">Show Vocab Questions</a>--}}
        {{--                        <a href="{{route('reading.exam.edit',['exam'=>$exam])}}" class="btn btn-success">Edit</a>--}}
        {{--                        <form style="display: inline;" method="post" action="{{route('reading.exam.destroy',['exam'=>$exam])}}">--}}
        {{--                            @method('delete')--}}
        {{--                            <button type="submit" class="btn btn-danger">Delete</button>--}}
        {{--                            @csrf--}}
        {{--                        </form>--}}
        {{--                    </td>--}}
        {{--                </tr>--}}
        {{--            @endforeach--}}
        {{--        </table>--}}
        {{--<div class="row">{{$exams->links()}}</div>--}}
        <display-exams-panel
            exams="{{$jsonExams}}"
            live-route="{{route('reading.live.exam.submit')}}"
            route="{{route('reading.exam.store')}}"
            is-reading="true"

        ></display-exams-panel>
    </div>
@endsection
