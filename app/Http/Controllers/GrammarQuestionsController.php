<?php

namespace App\Http\Controllers;

use App\Grammar\GrammarQuestion;
use App\Grammar\GrammarQuestionType;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class GrammarQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = GrammarQuestion::with('options','type')->paginate(15);
        return view('grammar.questions.index',compact('questions'));
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
        $types=GrammarQuestionType::all();
        return view('grammar.questions.create',compact('options','types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $question=GrammarQuestion::create([
           'content'=>$request['content'],
           'grammar_question_type_id'=>$request['type']
       ]);
       foreach($request->options as $option){
           $question->options()->create([
               'content'=>$option
           ]);
       }
       $question->options[$request->correct-1]->update(['correct'=>1]);
        return Redirect::action('GrammarQuestionsController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param GrammarQuestion $question
     * @return void
     */
    public function show(GrammarQuestion $question)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param GrammarQuestion $question
     * @return \Illuminate\Http\Response
     */
    public function edit(GrammarQuestion $question)
    {

        $previous=url()->previous();
        $options = [
            0=>'First Option',
            1=>'Second Option',
            2=>'Third Option',
            3=>'Fourth Option',
        ];
        $types=GrammarQuestionType::all();
        return view('grammar.questions.update',compact('question','options','types','previous'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param GrammarQuestion $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, GrammarQuestion $question)
    {
        $this->validator($request->all())->validate();

        $question->update([
            'content'=>$request['content'],
            'grammar_question_type_id'=>$request['type'],
            ]);
        $question->options()->delete();
        foreach($request->options as $option){
            $question->options()->create([
                'content'=>$option,

            ]);
        }
        $question->options[$request->correct-1]->update(['correct'=>1]);
        return redirect()->to($request['previous']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GrammarQuestion $question
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(GrammarQuestion $question)
    {
        $question->options()->delete();
        $question->delete();
        return Redirect::action('GrammarQuestionsController@index');

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
            'type'=>'required|numeric'
        ];
       return Validator::make($data,$roles,$message);

    }

}
