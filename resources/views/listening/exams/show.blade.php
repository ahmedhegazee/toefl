@extends('cpanel')

@section('content')
    <div class="container ">
        <h2>Audios in this Exam</h2>
        <a href="{{route('listening.exam.audio.index',compact('exam'))}}" class="btn btn-primary">Add Audios to this Exam</a>
{{--        <table border="2px solid">--}}
{{--            <tr>--}}
{{--                <th>ID</th>--}}
{{--                <th>title</th>--}}
{{--                <th>type</th>--}}
{{--                <th>Questions </th>--}}

{{--                <th></th>--}}

{{--            </tr>--}}
{{--            @foreach($audios as $audio)--}}
{{--                <tr>--}}
{{--                    <td>{{$audio->id}}</td>--}}
{{--                    <td>{{$audio->title}}</td>--}}
{{--                    <td>{{$audio->type->type}}</td>--}}
{{--                    <td>{{$audio->questions->count()}}</td>--}}

{{--                    <td>--}}
{{--                        <a href="{{route('audio.show',['audio'=>$audio])}}" class="btn btn-primary">Show</a>--}}
{{--                        <a href="{{route('audio.edit',['audio'=>$audio])}}" class="btn btn-success">Edit</a>--}}
{{--                        <form style="display: inline;" method="post" action="{{route('listening.exam.audios.destroy',['audio'=>$audio,'exam'=>$exam])}}">--}}
{{--                            @method('delete')--}}
{{--                            <button type="submit" class="btn btn-danger">Remove Audio</button>--}}
{{--                            @csrf--}}
{{--                        </form>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--        </table>--}}
{{--        <div class="row">--}}
{{--            {{$audios->links()}}--}}
{{--        </div>--}}
        <display-questions-panel
            exams="{{$audios}}"
            route="{{route('audio.store')}}"
            delete-route="{{route('listening.exam.audio.store',compact('exam'))}}"
            is-paragraph=true
            can-choose=false
        ></display-questions-panel>
    </div>
@endsection
