@extends('cpanel')

@section('content')
    <div class="container">
        <h1>{{$title}}</h1>
        <multiple-questions
            is-grammar="{{$isGrammar}}"
            store-route="{{$storeRoute}}"
            redirect-route="{{$redirectRoute}}"
        >
        </multiple-questions>
    </div>
@endsection
