<?php

namespace App\Http\Controllers;

use App\Reading\ReadingQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class VocabQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $questions=  ReadingQuestion::where('reading_question_type_id',1)->paginate(15);
      return view('reading.vocab.index',compact('questions'));
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

        $question= ReadingQuestion::create([
            'content'=>$request['content'],
            'reading_question_type_id'=>1,
        ]);

        foreach($request->options as $option){
            $question->options()->create([
                'content'=>$option
            ]);
        }
        $question->options[$request->correct-1]->update(['correct'=>1]);
        return Redirect::action('VocabQuestionsController@index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param ReadingQuestion $vocab
     * @return void
     */
    public function edit(ReadingQuestion $vocab)
    {
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
     * @param ReadingQuestion $vocab
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ReadingQuestion $vocab)
    {
        $this->validator($request->all())->validate();

        $question=$vocab;
        $question->update(['content'=>$request['content']]);
        $question->options()->delete();

        foreach($request->options as $option){
            $question->options()->create([
                'content'=>$option,
            ]);
        }
        $question->options[$request->correct-1]->update(['correct'=>1]);
        return Redirect::action('VocabQuestionsController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReadingQuestion $vocab
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(ReadingQuestion $vocab)
    {
        $question=$vocab;

        $question->options()->delete();
        $question->delete();
        return Redirect::action('VocabQuestionsController@index');

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
