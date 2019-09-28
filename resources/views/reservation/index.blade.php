@extends('layouts.app')

@section('content')
    <div class="container ">
        <h2>Reservations </h2>
        <a href="{{route('res.create')}}" class="btn btn-primary">Add Reservation</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Start</th>
                <th>End</th>
                <th></th>
            </tr>
            @foreach($reservations as $res)
                <tr>
                    <td>{{$res->id}}</td>
                    <td>{{$res->start}}</td>
                    <td>{{$res->end}}</td>
                    <td>
{{--                        <a href="{{route('res.show',['res'=>$res])}}" class="btn btn-primary">Show</a>--}}
                        <a href="{{route('res.edit',['re'=>$res])}}" class="btn btn-success">Edit</a>
                        <form style="display: inline;" method="post" action="{{route('res.destroy',['re'=>$res])}}">
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                            @csrf
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
@endsection
