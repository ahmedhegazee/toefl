@extends('layouts.app')
<link rel="stylesheet" href="{{asset('css/audioAnimation.css')}}">

@section('content')

    <div class="container">
        <div class="row justify-content-center"><p id="timer"></p></div>
        @if(!is_null(auth()->user()->getStudent()))
            <input type="hidden" class="form-control"
                   id="id" value="{{auth()->user()->getStudent()->id}}">
            <input type="hidden" class="form-control"
                   id="name" value="{{auth()->user()->name}}">
        @endif

        <input type="hidden" id="grammar-time" value="{{$grammarTime}}">
        <input type="hidden" id="reading-time" value="{{$readingTime}}">
        <input type="hidden" id="listening-time" value="{{$listeningTime}}">
        <form action="{{route('exam.store')}}" method="post">
            @csrf
            <div id="grammar-section">
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


            </div>
            <div id="reading-section" class="d-none">
                @foreach($vocabQuestions as $question)
                    <div class="vocab row justify-content-center  d-none mb-2">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card ">
                                    <div class="card-header">
                                        <input type="hidden" class="form-control"
                                               name="vocab" value="{{$question->id}}">
                                        <h3>{{$question->content}}</h3>
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
                            <div class="col-12 "><p>{{$paragraph->content}}</p></div>
                        </div>
                        <div class="row questions justify-content-center">
                            @foreach($paragraph->questions as $question)
                                <div class="row question  d-none mb-2 col-md-8">
                                    <div class="card ">
                                        <div class="card-header">
                                            <input type="hidden" class="form-control"
                                                   name="pq" value="{{$question->id}}">
                                            <h3>{{$question->content}}</h3>
                                        </div>
                                        <div class="card-body">
                                            @foreach($question->options as $option)
                                                <div class="row form-group option">
                                                    <div class="col-1 pr-0 ">
                                                        <input type="radio" class="form-control"
                                                               name="paragraphAnswers[{{$question->id}}]" value="{{$option->id}}">
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
            </div>
            <div id="listening-section" class="d-none">
                <!--- Short Conversations-->
                @foreach($shortConversations as $shortConversation)
                    <div class="short d-none row">
                        <div class="row justify-content-center">
                            <h1>Short Conversation </h1>
                            <audio  class="audio"   muted="muted" onended="showListeningQuestion();" >
                                <source src="/storage/{{$shortConversation->source}}" type="audio/ogg">
                                <source src="/storage/{{$shortConversation->source}}" type="audio/mpeg">
                                <source src="/storage/{{$shortConversation->source}}" type="audio/wav">
                                Your browser does not support the audio element.
                            </audio>

                        </div>
                        <div class="row justify-content-center">
                            <div class="animation ">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                        <div class="row questions justify-content-center">
                            @foreach($shortConversation->questions as $question)
                                <div class="row question  d-none mb-2 col-md-8">
                                    <div class="card " >
                                        <div class="card-header">
                                            <input type="hidden" class="form-control"
                                                   name="listeningQuestions" value="{{$question->id}}">
                                            <h3>{{$question->content}}</h3>
                                        </div>
                                        <div class="card-body">
                                            @foreach($question->options as $option)
                                                <div class="row form-group option">
                                                    <div class="col-1 pr-0 ">
                                                        <input type="radio" class="form-control"
                                                               name="listeningAnswers[{{$question->id}}]"
                                                               value="{{$option->id}}"></div>
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
            <!--Long Conversations-->
                @foreach($longConversations as $longConversation)
                    <div class="long  d-none row">
                        <div class="row justify-content-center">
                            <h1>Long Conversation </h1>

                            <audio  class="audio " muted="muted" onended="showListeningQuestion();" >
                                <source src="/storage/{{$longConversation->source}}" type="audio/ogg">
                                <source src="/storage/{{$longConversation->source}}" type="audio/mpeg">
                                <source src="/storage/{{$longConversation->source}}" type="audio/wav">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                        <div class="row justify-content-center">
                            <div class="animation ">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                        <div class="row questions justify-content-center">
                            @foreach($longConversation->questions as $question)
                                <div class="row question  d-none mb-2 col-md-8">
                                    <div class="card ">
                                        <div class="card-header">
                                            <input type="hidden" class="form-control"
                                                   name="listeningQuestions" value="{{$question->id}}">
                                            <h3>{{$question->content}}</h3>
                                        </div>
                                        <div class="card-body">
                                            @foreach($question->options as $option)
                                                <div class="row form-group option">
                                                    <div class="col-1 pr-0 ">
                                                        <input type="radio" class="form-control"
                                                               name="listeningAnswers[{{$question->id}}]"
                                                               value="{{$option->id}}"></div>
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

            <!--Speech-->
                @foreach($speeches as $speech)
                    <div class="speech  d-none row">
                        <div class="row justify-content-center">
                            <h1>Speech </h1>

                            <audio  class="audio " muted="muted" onended="showListeningQuestion();" >
                                <source src="/storage/{{$speech->source}}" type="audio/ogg">
                                <source src="/storage/{{$speech->source}}" type="audio/mpeg">
                                <source src="/storage/{{$speech->source}}" type="audio/wav">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                        <div class="row justify-content-center">
                            <div class="animation ">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                        <div class="row questions justify-content-center">
                            @foreach($speech->questions as $question)
                                <div class="row question  d-none mb-2 col-md-8">
                                    <div class="card ">
                                        <div class="card-header">
                                            <input type="hidden" class="form-control"
                                                   name="listeningQuestions" value="{{$question->id}}">
                                            <h3>{{$question->content}}</h3>
                                        </div>
                                        <div class="card-body">
                                            @foreach($question->options as $option)
                                                <div class="row form-group option">
                                                    <div class="col-1 pr-0 ">
                                                        <input type="radio" class="form-control"
                                                               name="listeningAnswers[{{$question->id}}]"
                                                               value="{{$option->id}}">
                                                    </div>
                                                    <div class="col-11 pt-2">
                                                        <div class="col-11 pt-2">
                                                            {{$option->content}}
                                                        </div>
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
            </div>
            <div class="row justify-content-center">
                <button type="button" onclick="nextQuestion();" id="next" class="btn btn-primary d-block">Next Question
                </button>
                <button type="button" class="btn btn-primary d-none " id="submit" onclick="finishSolving()">Submit Answers</button>

            </div>
        </form>

    </div>
@endsection
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="{{asset('js/exam.js')}}"></script>

