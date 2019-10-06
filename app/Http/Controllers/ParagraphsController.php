<?php

namespace App\Http\Controllers;

use App\Reading\Paragraph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ParagraphsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paragraphs=Paragraph::paginate(15);
        return view('reading.paragraph.index',compact('paragraphs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reading.paragraph.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $paragraph=Paragraph::create($this->validateData());
        return Redirect::route('paragraph.question.create',['paragraph'=>$paragraph]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Paragraph  $paragraph
     * @return \Illuminate\Http\Response
     */
    public function show(Paragraph $paragraph)
    {
        $questions=$paragraph->questions()->paginate(15);
        return view ('reading.paragraph.show',compact('paragraph','questions'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paragraph  $paragraph
     * @return \Illuminate\Http\Response
     */
    public function edit(Paragraph $paragraph)
    {
        return view ('reading.paragraph.update',compact('paragraph'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paragraph  $paragraph
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Paragraph $paragraph)
    {
        $paragraph->update($this->validateData());
        return Redirect::route('paragraph.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paragraph  $paragraph
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Paragraph $paragraph)
    {
        foreach ($paragraph->questions as $question){
            $question->options()->delete();
        }
        $paragraph->questions()->delete();
        $paragraph->delete();
        return Redirect::route('paragraph.index');

    }

    public function validateData()
    {
        return \request()->validate([
            'title'=>'required|string',
            'content'=>'required|string',
        ]);
    }
}
