<?php

namespace App\Http\Controllers;

use App\Reading\Paragraph;
use Illuminate\Http\Request;

class ParagraphsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paragraphs=Paragraph::all();
        return view('questions.reading.paragraph.index',compact('paragraphs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.reading.paragraph.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Paragraph::create($this->validateData());
        return redirect(route('paragraph.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Paragraph  $paragraph
     * @return \Illuminate\Http\Response
     */
    public function show(Paragraph $paragraph)
    {
        return view ('questions.reading.paragraph.show',compact('paragraph'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paragraph  $paragraph
     * @return \Illuminate\Http\Response
     */
    public function edit(Paragraph $paragraph)
    {
        return view ('questions.reading.paragraph.update',compact('paragraph'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paragraph  $paragraph
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paragraph $paragraph)
    {
        $paragraph->update($this->validateData());
        return redirect(route('paragraph.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paragraph  $paragraph
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paragraph $paragraph)
    {
        $paragraph->delete();
        return redirect(route('paragraph.index'));

    }

    public function validateData()
    {
        return \request()->validate([
            'title'=>'required|string',
            'content'=>'required|string',
        ]);
    }
}
