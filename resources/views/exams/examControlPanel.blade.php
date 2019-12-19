@extends('layouts.app')

@section('content')
    <div class="container ">

        <control-panel></control-panel>
{{--        @if(session()->has('details'))--}}
{{--            <h1>The search results</h1>--}}
{{--            <table border="2px">--}}
{{--                <tr>--}}
{{--                    <th>ID</th>--}}
{{--                    <th>Full Name</th>--}}
{{--                    <th>Arabic Full Name</th>--}}
{{--                    <th>Phone</th>--}}
{{--                    <th>verified</th>--}}
{{--                </tr>--}}
{{--                @foreach(session()->get('details') as $student)--}}
{{--                    <tr>--}}
{{--                        <td>{{$student->id}}</td>--}}
{{--                        <td>{{$student->user()->name}}</td>--}}
{{--                        <td>{{$student->arabic_name}}</td>--}}
{{--                        <td>{{$student->phone}}</td>--}}
{{--                        <td>{{$student->verified}}</td>--}}

{{--                    </tr>--}}
{{--                @endforeach--}}
{{--            </table>--}}
{{--        @elseif(session()->has('message'))--}}
{{--            <div class="row alert alert-danger">{{session()->get('message')}}</div>--}}
{{--        @else--}}
{{--            @include('layouts.students')--}}
{{--        @endif--}}
{{--        <div class="row">--}}
{{--            {{$students->links()}}--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
