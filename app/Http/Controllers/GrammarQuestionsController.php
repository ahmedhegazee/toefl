<?php

namespace App\Http\Controllers;

use App\Grammar\GrammarQuestion;
use Illuminate\Http\Request;

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
            1=>'First Option',
            2=>'Second Option',
            3=>'Third Option',
            4=>'Fourth Option',
        ];
        $types=[
            0=>'Fill in the space',
            1=>'Find the mistake',
        ];
        return view('grammar.questions.create',compact('options','types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $question=GrammarQuestion::create([
           'question_text'=>$request->question_text,
           'grammar_question_type_id'=>$request['type']
       ]);
       foreach($request->options as $option){
           $question->options()->create([
               'option_text'=>$option
           ]);
       }
       $question->options[$request->correct-1]->update(['correct'=>1]);
        return redirect(route('grammar.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param GrammarQuestion $grammar
     * @return void
     */
    public function show(GrammarQuestion $grammar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param GrammarQuestion $grammar
     * @return \Illuminate\Http\Response
     */
    public function edit(GrammarQuestion $grammar)
    {
        $options = [
            1=>'First Option',
            2=>'Second Option',
            3=>'Third Option',
            4=>'Fourth Option',
        ];
        $types=[
            0=>'Fill in the space',
            1=>'Find the mistake',
        ];
        return view('grammar.questions.update',compact('grammar','options','types'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param GrammarQuestion $grammar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GrammarQuestion $grammar)
    {
        $grammar->update([
            'question_text'=>$request->question_text,
            'grammar_question_type_id'=>$request['type'],
            ]);
        foreach($request->options as $option){
            $grammar->options()->update([
                'option_text'=>$option,
                'correct'=>0,

            ]);
        }
        $grammar->options[$request->correct-1]->update(['correct'=>1]);
        return redirect(route('grammar.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GrammarQuestion $grammar
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(GrammarQuestion $grammar)
    {
        $grammar->options()->delete();
        $grammar->delete();
        return redirect(route('grammar.index'));

    }
//    public function validateData()
//    {
//
//
//        return request()->validate([
//            'question_text' => 'required|string',
//            'options' => 'required|array',
//            'correct'=>'required|numeric',
//        ]);
//    }
//
}
