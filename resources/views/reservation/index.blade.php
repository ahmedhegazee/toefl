@extends('cpanel')

@section('content')
    <div class="container ">
        <h2>Reservations </h2>
{{--        <a href="{{route('res.create')}}" class="btn btn-primary">Add Reservation</a>--}}
{{--        <table border="2px solid">--}}
{{--            <tr>--}}
{{--                <th>ID</th>--}}
{{--                <th>Start</th>--}}
{{--                <th>Students Count</th>--}}
{{--                <th>Max Students Count</th>--}}
{{--                <th>open/close</th>--}}
{{--                <th>Actions</th>--}}
{{--            </tr>--}}
{{--            @foreach($reservations as $res)--}}
{{--                <tr>--}}
{{--                    <td>{{$res->id}}</td>--}}
{{--                    <td>{{$res->start}}</td>--}}
{{--                    <td>{{$res->students->count()}}</td>--}}
{{--                    <td>{{$res->max_students}}</td>--}}
{{--                    <td>{{$res->done}}</td>--}}

{{--                    <td>--}}
{{--                        <a href="{{route('res.show',['re'=>$res])}}" class="btn btn-primary">Show</a>--}}
{{--                        <a href="{{route('res.edit',['re'=>$res])}}" class="btn btn-success">Edit</a>--}}
{{--                        <form action="{{route('res.generate.group',['re'=>$res])}}" class="d-inline" method="post">--}}
{{--                            @csrf--}}
{{--                            <button type="submit" class="btn btn-primary">Generate Groups</button>--}}
{{--                        </form>--}}
{{--                        --}}{{--                        <form style="display: inline;" method="post" action="{{route('res.destroy',['re'=>$res])}}">--}}
{{--                            @method('delete')--}}
{{--                            <button type="submit" class="btn btn-danger">Delete</button>--}}
{{--                            @csrf--}}
{{--                        </form>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--        </table>--}}
<reservations-panel
res="{{$reservations}}"
></reservations-panel>
    </div>
@endsection
