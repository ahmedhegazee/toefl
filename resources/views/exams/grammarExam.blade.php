@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center"><p id="timer"></p></div>
        @if(!is_null(auth()->user()->getStudent()))
        <input type="hidden" class="form-control"
               id="id" value="{{auth()->user()->getStudent()->id}}">
            <input type="hidden" class="form-control"
               id="name" value="{{auth()->user()->name}}">
        @endif

        <input type="hidden" id="time" value="{{$time}}">
        <form action="{{$route}}" method="post">
            @csrf

                @foreach($fillQuestions as $question)
                    <div class="fl row justify-content-center d-none mb-2">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card ">
                                    <div class="card-header">
                                        <input type="hidden" class="form-control"
                                               name="questions" value="{{$question->id}}">
                                        <h2>{{$question->type->name}}</h2>
                                        <h3>{{$question->content}}</h3>
                                    </div>
                                    <div class="card-body">
                                        @foreach($question->options as $option)
                                            <div class="row form-group option">
                                                <div class="col-1 pr-0 ">
                                                    <input type="radio" class="form-control"
                                                           name="answers[{{$question->id}}]" value="{{$option->id}}">
                                                </div>
                                                <div class="col-11 pt-2">
                                                    {{$option->content}}
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach



                @foreach($findQuestions as $question)
                    <div class="fn row justify-content-center d-none mb-2">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card ">
                                    <div class="card-header">
                                        <input type="hidden" class="form-control"
                                               name="questions" value="{{$question->id}}">
                                        <h2>{{$question->type->name}}</h2>

                                        <h3>{{$question->content}}</h3>
                                    </div>
                                    <div class="card-body">
                                        @foreach($question->options as $option)
                                            <div class="row form-group option">
                                                <div class="col-1 pr-0 ">
                                                    <input type="radio" class="form-control"
                                                           name="answers[{{$question->id}}]" value="{{$option->id}}">
                                                </div>
                                                <div class="col-11 pt-2">
                                                    {{$option->content}}
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            <div class="row justify-content-center">
                <button type="button" onclick="nextQuestion();" id="next" class="btn btn-primary">Next Question</button>
                <button   class="btn btn-primary d-none " id="submit">Submit Answers</button>

            </div>
        </form>

    </div>
@endsection
<script src="{{asset('js/grammarExam.js')}}"></script>
