@extends('cpanel')

@section('content')
    <div class="container ">
        <h2>Paragraphs in this Exam</h2>
        <a href="{{route('reading.exam.paragraph.add',compact('exam'))}}" class="btn btn-primary">Add Paragraphs to this Exam</a>
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
{{--                        <form style="display: inline;" method="post" action="{{route('reading.exam.destroy.paragraphs',['paragraph'=>$paragraph,'exam'=>$exam])}}">--}}
{{--                            @method('delete')--}}
{{--                            <button type="submit" class="btn btn-danger">Remove Paragraph</button>--}}
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
{{--            exams="{{$paragraphs}}"--}}
            route="{{route('paragraph.store')}}"
            delete-route="{{route('reading.exam.paragraph.store',compact('exam'))}}"
            is-paragraph=true
            can-choose=false

        ></display-questions-panel>
    </div>
@endsection
