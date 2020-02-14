<?php

namespace App\Http\Controllers\ReadingControllers;

use App\Http\Controllers\Controller;
use App\Logging;
use App\Question;
use App\Reading\VocabQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class VocabQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
//      $questions=  VocabQuestion::paginate(15);
        $questions = Question::getQuestions( VocabQuestion::paginate(50));
        $count=VocabQuestion::all()->count();
        return response()->json(['questions'=>$questions,'count'=>$count]);
//      return view('reading.vocab-panel',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $options = [
            0=>'First Option',
            1=>'Second Option',
            2=>'Third Option',
            3=>'Fourth Option',
        ];
        return view('reading.vocab.create',compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $question= VocabQuestion::create([
            'content'=>$request['content'],
        ]);
        $message=" add new vocab question with id {".$question->id."}";
        Logging::logProfessor(auth()->user(),$message);
        foreach($request->options as $option){
            $question->options()->create([
                'content'=>$option
            ]);
        }
        $question->options[$request->correct-1]->update(['correct'=>1]);
        return \redirect()->to(route('vocab-panel'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param VocabQuestion $vocab
     * @return void
     */
    public function edit(VocabQuestion $vocab)
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
        $question=$vocab;

        return view('reading.vocab.update',compact('options','question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param VocabQuestion $vocab
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, VocabQuestion $vocab)
    {
        $this->validator($request->all())->validate();

        $question=$vocab;
        $message=" update vocab question with id {".$question->id."} ";
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
            return \redirect()->to(route('vocab-panel'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param VocabQuestion $vocab
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(VocabQuestion $vocab)
    {
        $question=$vocab;
        $check=false;
        if($question->exam()->count()==0){
            $message=" delete vocab question with id {".$question->id."} ";
            Logging::logProfessor(auth()->user(),$message);
            $question->options()->delete();
            $question->delete();
            $check=true;
        }
        return response()->json(['success'=>$check]);

//        return Redirect::action('VocabQuestionsController@index');

    }

    public function showMultipleQuestions()
    {
        $title="Add Multiple Vocab Questions";
        $isGrammar='false';
        $storeRoute=route('vocab.multiple-questions.store');
        $redirectRoute=route('vocab-panel');
        return view('multiple-questions',compact('isGrammar','redirectRoute','storeRoute','title'));
    }
    public function storeMultipleQuestions(Request $request)
    {
//        dd(collect($request->questions));
        collect($request->questions)->map(function ($question) {
            $question1 = VocabQuestion::create([
                'content' => $question['question'],
            ]);
            $message = " add new vocab question with id {" . $question1->id . "}";
            Logging::logProfessor(auth()->user(), $message);
            $question1->options()->create([
                'content' => $question['First Option']
            ]);
            $question1->options()->create([
                'content' => $question['Second Option']
            ]);
            $question1->options()->create([
                'content' => $question['Third Option']
            ]);
            $question1->options()->create([
                'content' => $question['Fourth Option']
            ]);
            $question1->options[$question['correct'] - 1]->update(['correct' => 1]);

        });

    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
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
