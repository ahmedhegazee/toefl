@extends('layouts.app')

@section('content')
    <div class="container ">
        <h2>Vocab Questions in this Exam</h2>
{{--        <form action="{{route('reading.exam.store.vocab',compact('exam'))}}" method="post">--}}
{{--        <table border="2px solid">--}}
{{--            <tr>--}}
{{--                <th><input type="checkbox"></th>--}}

{{--                <th>ID</th>--}}
{{--                <th>Question</th>--}}
{{--                <th>First Option</th>--}}
{{--                <th>Second Option</th>--}}
{{--                <th>Third Option</th>--}}
{{--                <th>Fourth Option</th>--}}
{{--                <th>Correct Answer</th>--}}
{{--                <th></th>--}}

{{--            </tr>--}}
{{--            @foreach($questions as $question)--}}
{{--                <tr>--}}
{{--                    <td><input type="checkbox" name="questions[]" value="{{$question->id}}" {{$exam->vocabQuestions->contains($question->id)?'checked':''}}></td>--}}
{{--                    <td>{{$question->id}}</td>--}}
{{--                    <td>{{$question->content}}</td>--}}
{{--                    @foreach($question->options as $option)--}}
{{--                        <td>{{$option->content}}</td>--}}

{{--                    @endforeach--}}
{{--                    @foreach($question->options as $option)--}}
{{--                        @if($option->correct)--}}
{{--                            <td>{{$option->getCorrectOption($option->id%4==0?4:$option->id%4 )}}</td>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                    <td>--}}
{{--                        <a href="{{route('vocab.edit',['vocab'=>$question])}}" class="btn btn-success">Edit</a>--}}

{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--        </table>--}}
{{--            <button type="submit" class="btn btn-primary">Add Questions</button>--}}
{{--            @csrf--}}
{{--        </form>--}}
{{--        {{$questions->links()}}--}}
        <display-questions-panel
            exams="{{$questions1}}"
            route="{{route('vocab.store')}}"
            store-route="{{route('reading.exam.vocab.store',compact('exam'))}}"
            is-paragraph="false"
            can-choose="true"
            checked="{{$checked}}"
            redirect-route="{{route('reading.exam.show.vocab',compact('exam'))}}"
        ></display-questions-panel>
    </div>
@endsection
