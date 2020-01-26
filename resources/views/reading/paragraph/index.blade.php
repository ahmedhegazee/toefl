@extends('cpanel')

@section('content')
    <div class="container ">
        <h2>Paragraphs</h2>
        <a href="{{route('paragraph.create')}}" class="btn btn-primary">Add Paragraph</a>
{{--        <table border="2px solid">--}}
{{--            <tr>--}}
{{--                <th>ID</th>--}}
{{--                <th>title</th>--}}
{{--                <th>Questions </th>--}}

{{--                <th></th>--}}

{{--            </tr>--}}
{{--            @foreach($paragraphs as $paragraph)--}}
{{--                <tr>--}}
{{--                    <td>{{$paragraph->id}}</td>--}}
{{--                    <td>{{$paragraph->title}}</td>--}}
{{--                    <td>{{$paragraph->questions->count()}}</td>--}}

{{--                    <td>--}}
{{--                        <a href="{{route('paragraph.show',['paragraph'=>$paragraph])}}" class="btn btn-primary">Show</a>--}}
{{--                        <a href="{{route('paragraph.edit',['paragraph'=>$paragraph])}}" class="btn btn-success">Edit</a>--}}
{{--                        <form style="display: inline;" method="post" action="{{route('paragraph.destroy',['paragraph'=>$paragraph])}}">--}}
{{--                            @method('delete')--}}
{{--                            <button type="submit" class="btn btn-danger">Delete</button>--}}
{{--                            @csrf--}}
{{--                        </form>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--        </table>--}}
{{--<div class="row">--}}
{{--    {{$paragraphs->links()}}--}}
{{--</div>--}}
       <display-questions-panel
        exams="{{$paragraphs}}"
        route="{{route('paragraph.store')}}"
        delete-route="{{route('paragraph.store')}}"
        is-paragraph=true

        ></display-questions-panel>
    </div>
@endsection
