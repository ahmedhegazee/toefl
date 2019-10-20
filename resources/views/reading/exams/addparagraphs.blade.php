@extends('layouts.app')

@section('content')
    <div class="container ">
        <form action="{{route('reading.exam.store.paragraphs',compact('exam'))}}" method="post">
        <table border="2px solid">
            <tr>
                <th><input type="checkbox"></th>
                <th>ID</th>
                <th>title</th>
                <th>Questions </th>

                <th></th>

            </tr>
            @foreach($paragraphs as $paragraph)
                <tr>
                    <td><input type="checkbox" name="paragraphs[]" value="{{$paragraph->id}}" {{$exam->paragraphs->contains($paragraph->id)?'checked':''}}></td>
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
            <button type="submit" class="btn btn-primary">Add Paragraphs</button>
            @csrf
        </form>
<div class="row">
    {{$paragraphs->links()}}
</div>
    </div>
@endsection
