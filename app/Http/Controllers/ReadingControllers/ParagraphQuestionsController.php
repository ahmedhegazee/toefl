<?php

namespace App\Http\Controllers\ReadingControllers;

use App\Http\Controllers\Controller;
use App\Reading\Paragraph;
use App\Reading\ParagraphQuestion;
use App\Reading\VocabQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParagraphQuestionsController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Paragraph $paragraph)
    {
        $options = [
            0=>'First Option',
            1=>'Second Option',
            2=>'Third Option',
            3=>'Fourth Option',
        ];
        return view('reading.questions.create',compact('options','paragraph'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Paragraph $paragraph
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Paragraph $paragraph,Request $request)
    {
        $this->validator($request->all())->validate();

        $question= $paragraph->questions()->create([
            'content'=>$request['content'],
        ]);

        foreach($request->options as $option){
            $question->options()->create([
                'content'=>$option
            ]);
        }
        $question->options[$request->correct-1]->update(['correct'=>1]);
        return redirect(route('paragraph.show',['paragraph'=>$paragraph]));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Paragraph $paragraph
     * @param VocabQuestion $question
     * @return void
     */
    public function edit(Paragraph $paragraph, ParagraphQuestion $question)
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
        return view('reading.questions.update',compact('paragraph','question','options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Paragraph $paragraph
     * @param VocabQuestion $question
     * @return void
     */
    public function update(Request $request, Paragraph $paragraph, ParagraphQuestion $question)
    {
        $this->validator($request->all())->validate();

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
        return redirect(route('paragraph.show',['paragraph'=>$paragraph]));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Paragraph $paragraph
     * @param VocabQuestion $question
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Paragraph $paragraph, ParagraphQuestion $question)
    {
        $check=false;
        if($paragraph->exam()->count()==0){
            $question->options()->delete();
            $question->delete();
            $check=true;
        }
        return response()->json(['success'=>$check]);
//        return redirect(route('paragraph.show',['paragraph'=>$paragraph]));
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
