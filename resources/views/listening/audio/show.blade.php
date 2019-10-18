@extends('layouts.app')

@section('content')
    <div class="container ">
        <h2>{{$audio->title}}</h2>
        <audio controls>
            <source src="/storage/{{$audio->source}}" type="audio/wav">
            Your browser does not support the audio element.
        </audio>
        <a href="{{route('listening.question.create',['audio'=>$audio])}}" class="btn btn-primary mb-5">Add Audio Question</a>


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
                    @endforeach                    <td>
                        <a href="{{route('listening.question.edit',['question'=>$question,'audio'=>$audio])}}" class="btn btn-success">Edit</a>
                        <form style="display: inline;" method="post" action="{{route('listening.question.destroy',['question'=>$question,'audio'=>$audio])}}">
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
