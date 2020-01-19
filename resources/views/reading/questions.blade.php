@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <div class="row justify-content-between p-2">

                            <a href="{{route('vocab.index')}}" class="btn btn-primary ">Vocab Questions</a>
                            <a href="{{route('paragraph.index')}}" class="btn btn-primary ">Paragraphs</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
