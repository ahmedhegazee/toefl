@extends('layouts.app')

@section('content')
    <div class="container ">
        <h2>Paragraphs in {{$exam->group->name}} Exam</h2>
        <table border="2px solid">
            <tr>
                <th>ID</th>
                <th>title</th>
                <th>Questions </th>

                <th></th>

            </tr>
            @foreach($paragraphs as $paragraph)
                <tr>
                    <td>{{$paragraph->id}}</td>
                    <td>{{$paragraph->title}}</td>
                    <td>{{$paragraph->questions->count()}}</td>

                    <td>
                        <a href="{{route('paragraph.show',['paragraph'=>$paragraph])}}" class="btn btn-primary">Show</a>
                        <a href="{{route('paragraph.edit',['paragraph'=>$paragraph])}}" class="btn btn-success">Edit</a>

                    </td>
                </tr>
            @endforeach
        </table>
<div class="row">
    {{$paragraphs->links()}}
</div>
    </div>
@endsection
