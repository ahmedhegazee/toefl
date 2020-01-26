@extends('cpanel')

@section('content')
    <div class="container ">

        <h1>Add Students to {{$group->name}}</h1>
        <form action="{{route('student.search')}}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                       placeholder="Search students by number"> <span class="input-group-btn">
            <button type="submit" class="btn btn-primary">Search
            </button>
        </span>
            </div>
        </form>
        <form action="{{route('group.students.store',['group'=>$group])}}" method="post">
        @if(session()->has('details'))
            <h1>The search results</h1>
                <table border="2px">
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>verified</th>
                        <th>Group</th>
                    </tr>
                    @foreach(session()->get('details') as $student)
                        <tr>
                            <td><input type="checkbox" name="students[]" value="{{$student->id}}" {{$student->group->id==$group->id?'checked':''}}></td>
                            <td>{{$student->id}}</td>
                            <td>{{$student->user()->name}}</td>
                            <td>{{$student->phone}}</td>
                            <td>{{$student->verified}}</td>
                            <td>{{$student->group->name}}</td>

                        </tr>
                    @endforeach
                </table>
            @elseif(session()->has('message'))
            <div class="row alert alert-danger">{{session()->get('message')}}</div>
            @else
                <table border="2px">
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>verified</th>
                        <th>Group</th>
                    </tr>
                    @foreach($students as $student)
                        <tr>
                            <td><input type="checkbox" name="students[]" value="{{$student->id}}" {{$student->group->id==$group->id?'checked':''}}></td>
                            <td>{{$student->id}}</td>
                            <td>{{$student->user()->name}}</td>
                            <td>{{$student->phone}}</td>
                            <td>{{$student->verified}}</td>
                            <td>{{$student->group->name}}</td>

                        </tr>
                    @endforeach
                </table>
                <div class="row">
                    {{$students->links()}}
                </div>
                <button type="submit" class="btn btn-primary">
                    {{ __('Add Students') }}
                </button>
            @endif
            @csrf
        </form>
    </div>
@endsection
