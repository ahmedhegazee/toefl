<?php

namespace App\Http\Controllers;

use App\Reading\ReadingExam;
use Illuminate\Http\Request;

class ReadingExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = ReadingExam::paginate(15);
        return view('reading.exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param ReadingExam $readingExam
     * @return void
     */
    public function show(ReadingExam $readingExam)
    {
        //
    }

    public function showParagraphs(ReadingExam $exam)
    {
        $paragraphs =$exam->paragraphs()->paginate(15);
        return view('reading.exams.paragraphs',compact('paragraphs','exam'));
    }

    public function showVocab(ReadingExam $exam)
    {
        $questions=$exam->vocabQuestions()->paginate(15);
        return view('reading.exams.vocab',compact('questions','exam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReadingExam $readingExam
     * @return void
     */
    public function edit(ReadingExam $readingExam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ReadingExam $readingExam
     * @return void
     */
    public function update(Request $request, ReadingExam $readingExam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReadingExam $readingExam
     * @return void
     */
    public function destroy(ReadingExam $readingExam)
    {
        //
    }
}
