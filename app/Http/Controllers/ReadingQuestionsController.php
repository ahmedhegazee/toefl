<?php

namespace App\Http\Controllers;

use App\Reading\Paragraph;
use App\Reading\ReadingQuestion;
use Illuminate\Http\Request;

class ReadingQuestionsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

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
        return view('questions.reading.questions.create',compact('options','paragraph'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Paragraph $paragraph,Request $request)
    {
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
     * @param ReadingQuestion $question
     * @return void
     */
    public function edit(Paragraph $paragraph,ReadingQuestion $question)
    {
        $options = [
            0=>'First Option',
            1=>'Second Option',
            2=>'Third Option',
            3=>'Fourth Option',
        ];
        return view('questions.reading.questions.update',compact('paragraph','question','options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Paragraph $paragraph
     * @param ReadingQuestion $question
     * @return void
     */
    public function update(Request $request,Paragraph $paragraph, ReadingQuestion $question)
    {
        $question->update(['content'=>$request['content']]);
        foreach($request->options as $option){
            $question->options()->update([
                'content'=>$option,
                'correct'=>0,
            ]);
        }
        $question->options[$request->correct-1]->update(['correct'=>1]);
        return redirect(route('paragraph.show',['paragraph'=>$paragraph]));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Paragraph $paragraph
     * @param ReadingQuestion $question
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Paragraph $paragraph,ReadingQuestion $question)
    {
        $question->options()->delete();
        $question->delete();
        return redirect(route('paragraph.show',['paragraph'=>$paragraph]));
    }
}
