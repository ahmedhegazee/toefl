@extends('layouts.app')

@section('content')
    <div class="container ">
        <h2>Grammar Questions in this Exam </h2>

        <table border="2px solid">
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Question Type</th>
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
                    <td>{{$question->type->name}}</td>
                    @foreach($question->options as $option)
                        <td>{{$option->content}}</td>

                    @endforeach
                    @foreach($question->options as $option)
                        @if($option->correct)
                            <td>{{$option->getCorrectOption($option->id%4==0?4:$option->id%4)}}</td>
                        @endif
                    @endforeach
                    <td>
                        <a href="{{route('grammar.question.edit',['question'=>$question])}}" class="btn btn-success">Edit Question</a>
{{--                        <form style="display: inline;" method="post" action="{{route('grammar.destroy',['grammar'=>$question->id])}}">--}}
{{--                            @method('delete')--}}
{{--                            <button type="submit" class="btn btn-danger">Delete</button>--}}
{{--                            @csrf--}}
{{--                        </form>--}}
                    </td>
                </tr>
            @endforeach
        </table>
<div class="row">
    {{$questions->links()}}
</div>
    </div>
@endsection
