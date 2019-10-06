@extends('layouts.app')

@section('content')
    <div class="container ">
        <h2>Vocab Questions </h2>
        <a href="{{route('vocab.create')}}" class="btn btn-primary">Add Vocab Question</a>
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
                        <td>{{$option->getCorrectOption($option->id%4==0?4:$option->id%4 )}}</td>
                    @endif
@endforeach
                    <td>
{{--                        <a href="{{route('res.show',['res'=>$res])}}" class="btn btn-primary">Show</a>--}}
                        <a href="{{route('vocab.edit',['vocab'=>$question])}}" class="btn btn-success">Edit</a>
                        <form style="display: inline;" method="post" action="{{route('vocab.destroy',['vocab'=>$question])}}">
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
