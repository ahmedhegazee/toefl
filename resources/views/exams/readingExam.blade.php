@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center"><p id="timer"></p></div>

        <input type="hidden" id="time" value="{{$time}}">
        <form action="{{route('reading.exam.submit')}}" method="post">
            @csrf

            @foreach($vocabQuestions as $question)
                <div class="vocab row justify-content-center  d-none mb-2">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card ">
                                <div class="card-header">
                                    <h3>{{$question->content}}</h3>
{{--                                    <input type="hidden" name="" value="{{$question->id}}">--}}
                                    <input type="hidden" name="vocabQuestions[]" value="{{$question->id}}">
                                </div>
                                <div class="card-body">
                                    @foreach($question->options as $option)
                                        <div class="row form-group option">
                                            <div class="col-1 pr-0 ">
                                                <input type="radio" class="form-control"
                                                       name="vocabAnswers[{{$question->id}}]" value="{{$option->id}}">
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



            @foreach($paragraphs as $paragraph)
                <div class="paragraph  d-none row">
                    <div class="row justify-content-center">
                        <input type="hidden" name="paragraphs[]" value="{{$paragraph->id}}">
                        <div class="col-12 "><p>{{$paragraph->content}}</p></div>
                    </div>
                    <div class="row questions justify-content-center">
                    @foreach($paragraph->questions as $question)
                        <div class="row question  d-none mb-2 col-md-8">
                            <div class="card ">
                                <div class="card-header">
{{--                                    <input type="text" name="pqid[]" disabled value="{{$question->id}}">--}}
                                    <h3>{{$question->content}}</h3>
                                    <input type="hidden" name="paragraphQuestions[{{$paragraph->id}}][questions][]" value="{{$question->id}}">
{{--                                    <input type="hidden" name="pqid[{{$question->id}}]" value="{{$paragraph->id}}">--}}
                                </div>
                                <div class="card-body">
                                    @foreach($question->options as $option)
                                        <div class="row form-group option">
                                            <div class="col-1 pr-0 ">
                                                <input type="radio" class="form-control"
                                                       name="paragraphAnswers[{{$paragraph->id}}][questions][{{$question->id}}]answer" value="{{$option->id}}">
                                            </div>
                                            <div class="col-11 pt-2">
                                                {{$option->content}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                    @endforeach
                    </div>
                </div>
            @endforeach


            <div class="row justify-content-center">
                <button type="button" onclick="nextQuestion();" id="next" class="btn btn-primary">Next Question</button>
                <button type="submit" class="btn btn-primary d-none " id="submit">Submit Answers</button>

            </div>
        </form>

    </div>
@endsection
<script src="{{asset('js/readingExam.js')}}"></script>
