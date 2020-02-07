@extends('cpanel')

@section('content')
    <div class="container ">
        <h2>Audios in this Exam </h2>
{{--        <form action="{{route('listening.exam.audios.store',compact('exam'))}}" method="post">--}}

{{--        <table border="2px solid">--}}
{{--            <tr>--}}
{{--                <th><input type="checkbox" ></th>--}}
{{--                <th>ID</th>--}}
{{--                <th>title</th>--}}
{{--                <th>type</th>--}}
{{--                <th>Questions </th>--}}
{{--                <th></th>--}}

{{--            </tr>--}}
{{--            @foreach($audios as $audio)--}}
{{--                <tr>--}}
{{--                    <td><input type="checkbox" name="audios[]" value="{{$audio->id}}" {{$exam->audios->contains($audio->id)?'checked':''}}></td>--}}
{{--                    <td>{{$audio->id}}</td>--}}
{{--                    <td>{{$audio->title}}</td>--}}
{{--                    <td>{{$audio->type->type}}</td>--}}
{{--                    <td>{{$audio->questions->count()}}</td>--}}
{{--                    <td>--}}
{{--                        <a href="{{route('audio.show',['audio'=>$audio])}}" class="btn btn-primary">Show</a>--}}
{{--                        <a href="{{route('audio.edit',['audio'=>$audio])}}" class="btn btn-success">Edit</a>--}}
{{--                        --}}{{--                        <form style="display: inline;" method="post" action="{{route('grammar.destroy',['grammar'=>$question->id])}}">--}}
{{--                            @method('delete')--}}
{{--                            <button type="submit" class="btn btn-danger">Delete</button>--}}
{{--                            @csrf--}}
{{--                        </form>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--        </table>--}}
{{--            <button type="submit" class="btn btn-primary">Add Audios</button>--}}
{{--            @csrf--}}
{{--        </form>--}}
{{--<div class="row justify-content-center">--}}
{{--    {{$audios->links()}}--}}
{{--    <br>--}}

{{--</div>--}}
        <display-questions-panel
{{--            exams="{{$audios}}"--}}
            route="{{route('audio.store')}}"
            store-route="{{route('listening.exam.audio.store',compact('exam'))}}"
            delete-route="{{route('listening.exam.audio.store',compact('exam'))}}"
            is-Audio="true"
            can-choose=true
{{--            checked="{{$checked}}"--}}
            redirect-route="{{route('listening.exam.show',compact('exam'))}}"
        ></display-questions-panel>
    </div>
@endsection
