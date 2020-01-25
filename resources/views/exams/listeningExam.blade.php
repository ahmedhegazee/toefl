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
        <input type="hidden" id="time" value="{{$time}}">
        <form action="{{$route}}" method="post">
        @csrf

        <!--- Short Conversations-->
            @foreach($shortConversations as $shortConversation)
                <div class="short d-none row">
                    <div class="row justify-content-center">
                        <h1>Short Conversation </h1>
                        <audio  class="audio"  muted="muted" onended="showQuestion();" preload="auto">
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
                                                  name="questions" value="{{$question->id}}">
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

                        <audio  class="audio " muted="muted" onended="showQuestion();">
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
                                               name="questions" value="{{$question->id}}">
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

                        <audio  class="audio " muted="muted" onended="showQuestion();">
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
                                               name="questions" value="{{$question->id}}">
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

            <div class="row justify-content-center">
                <button type="button" onclick="nextQuestion();" id="next" class="btn btn-primary d-none">Next Question
                </button>
                <button class="btn btn-primary d-none " id="submit">Submit Answers</button>

            </div>
        </form>

    </div>
@endsection
<script src="{{asset('js/listeningExam.js')}}"></script>
