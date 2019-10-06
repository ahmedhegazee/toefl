@extends('layouts.app')

@section('content')
    <div class="container ">
        <h2>Reading Exams </h2>
{{--        <a href="{{route('grammarExam.create')}}" class="btn btn-primary">Add Exam</a>--}}
        <table border="2px solid">
            <tr>
                <th>ID</th>
                <th>Name</th>

                <th>Vocab Questions</th>
                <th>Paragraphs</th>

                <th>Actions</th>
            </tr>
            @foreach($exams as $exam)
                <tr>
                    <td>{{$exam->id}}</td>
                    <td>{{$exam->group->name}}</td>

                    <td>{{$exam->vocabQuestions()->count()}}</td>
                    <td>{{$exam->paragraphs()->count()}}</td>

                    <td>
                        <a href="{{route('reading.exam.show.paragraphs',['exam'=>$exam])}}" class="btn btn-primary">Show Paragraphs</a>
                        <a href="{{route('reading.exam.show.vocab',['exam'=>$exam])}}" class="btn btn-primary">Show Vocab Questions</a>
{{--                        <a href="{{route('grammarExam.edit',['grammarExam'=>$exam])}}" class="btn btn-success">Edit</a>--}}
{{--                        <form style="display: inline;" method="post" action="{{route('grammarExam.destroy',['grammarExam'=>$exam])}}">--}}
{{--                            @method('delete')--}}
{{--                            <button type="submit" class="btn btn-danger">Delete</button>--}}
{{--                            @csrf--}}
{{--                        </form>--}}
                    </td>
                </tr>
            @endforeach
        </table>
<div class="row">{{$exams->links()}}</div>
    </div>
@endsection
