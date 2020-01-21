<?php

namespace App\Http\Controllers\ListeningControllers;

use App\Http\Controllers\Controller;
use App\Listening\Audio;
use App\Listening\ListeningQuestion;
use App\Logging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListeningQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Audio $audio
     * @return void
     */
    public function create(Audio $audio)
    {
        $options = [
            0=>'First Option',
            1=>'Second Option',
            2=>'Third Option',
            3=>'Fourth Option',
        ];
        return view('listening.questions.create',compact('audio','options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Audio $audio
     * @return void
     */
    public function store(Request $request,Audio $audio)
    {
        $this->validator($request->all())->validate();

        $question= $audio->questions()->create([
            'content'=>$request['content'],
        ]);
        $message=" add new listening question with id {".$question->id."}";
        Logging::logProfessor(auth()->user(),$message);
        foreach($request->options as $option){
            $question->options()->create([
                'content'=>$option
            ]);
        }
        $question->options[$request->correct-1]->update(['correct'=>1]);
        return redirect(route('audio.show',['audio'=>$audio]));
    }

    /**
     * Display the specified resource.
     *
     * @param ListeningQuestion $listeningQuestion
     * @return void
     */
    public function show(ListeningQuestion $listeningQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ListeningQuestion $question
     * @return void
     */
    public function edit(Audio $audio,ListeningQuestion $question)
    {
        $previous=url()->previous();
        session([
            'previous'=>$previous,
        ]);
        $options = [
            0=>'First Option',
            1=>'Second Option',
            2=>'Third Option',
            3=>'Fourth Option',
        ];
        return view('listening.questions.update',compact('audio','question','options','previous'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Audio $audio
     * @param ListeningQuestion $question
     * @return void
     */
    public function update(Request $request, Audio $audio,ListeningQuestion $question)
    {
        $this->validator($request->all())->validate();
        $message=" update listening question with id {".$question->id."} ";
        Logging::logProfessor(auth()->user(),$message);
        $question->update(['content'=>$request['content']]);
        $question->options()->delete();

        foreach($request->options as $option){
            $question->options()->create([
                'content'=>$option,
            ]);
        }
        $question->options[$request->correct-1]->update(['correct'=>1]);
        if(session()->has('previous'))
            return \redirect()->to(session()->get('previous'));
        else
        return redirect()->to($request['previous']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Audio $audio
     * @param ListeningQuestion $question
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Audio $audio,ListeningQuestion $question)
    {
        $check=false;
        if($question->exam()->count()==0){
            $message=" delete listening question with id {".$question->id."} ";
            Logging::logProfessor(auth()->user(),$message);
            $question->options()->delete();
            $question->delete();
            $check=true;
        }
        return response()->json(['success'=>$check]);
//        return redirect(route('audio.show',['audio'=>$audio]));
    }
    public function validator( $data)
    {
        $message=[
            'options.0.required'=>'First Option field is required.',
            'options.1.required'=>'Second Option field is required.',
            'options.2.required'=>'Third Option field is required.',
            'options.3.required'=>'Fourth Option field is required.',
            'content.required'=>'Question Content field is required.',

        ];
        $roles =[
            'content' => 'required|string',
            'options' => 'required|array|min:4',
            'options.*' => 'required|string|distinct',
            'correct'=>'required|numeric',
        ];
        return Validator::make($data,$roles,$message);

    }
}
