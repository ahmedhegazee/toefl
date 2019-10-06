@extends('layouts.app')

@section('content')
    <div class="container ">
        <h2>{{$paragraph->title}}</h2>
        <p>
            {{$paragraph->content}}
        </p>
        <a href="{{route('paragraph.question.create',['paragraph'=>$paragraph])}}" class="btn btn-primary mb-5">Add Paragraph Question</a>

        <table border="2px solid">

            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>First Option</th>
                <th>Second Option</th>
                <th>Third Option</th>
                <th>Fourth Option</th>
                <th>Correct Answer</th>
                <th></th>


            </tr>
            @foreach($questions as $question)
                <tr>
                    <td>{{$question->id}}</td>
                    <td>{{$question->content}}</td>
                    @foreach($question->options as $option)
                        <td>{{$option->content}}</td>

                    @endforeach
                    @foreach($question->options as $option)
                        @if($option->correct)
                            <td>{{$option->getCorrectOption($option->id%4==0?4:$option->id%4)}}</td>
                        @endif
                    @endforeach
                    <td>
                        <a href="{{route('paragraph.question.edit',['question'=>$question,'paragraph'=>$paragraph])}}" class="btn btn-success">Edit</a>
                        <form style="display: inline;" method="post" action="{{route('paragraph.question.destroy',['question'=>$question,'paragraph'=>$paragraph])}}">
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                            @csrf
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
{{$questions->links()}}
    </div>

@endsection
