@extends('cpanel')

@section('content')
    <div class="container ">
        <h2>Groups </h2>
        <a href="{{route('group.create')}}" class="btn btn-primary">Add Group</a>
        <table border="2px solid">
            <tr>
                <th>ID</th>
                <th>Name</th>

                <th>Students Count</th>

                <th>Actions</th>
            </tr>
            @foreach($groups as $group)
                <tr>
                    <td>{{$group->id}}</td>
                    <td>{{$group->name}}</td>
                    <td>{{$group->students->count()}}</td>

                    <td>
                        <a href="{{route('group.show',['group'=>$group])}}" class="btn btn-primary">Show</a>
                        <a href="{{route('group.edit',['group'=>$group])}}" class="btn btn-success">Edit</a>
{{--                        <form style="display: inline;" method="post" action="{{route('group.destroy',['group'=>$group])}}">--}}
{{--                            @method('delete')--}}
{{--                            <button type="submit" class="btn btn-danger">Delete</button>--}}
{{--                            @csrf--}}
{{--                        </form>--}}
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
@endsection
