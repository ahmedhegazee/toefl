<?php

namespace App\Http\Controllers\ReadingControllers;

use App\Http\Controllers\Controller;
use App\Question;
use App\Reading\ReadingExam;
use App\Reading\VocabQuestion;
use Illuminate\Http\Request;

class ReadingExamVocabQuestionsController extends Controller
{

    public function index(ReadingExam $exam)
    {
        $questions1 = Question::getQuestionsForChoosePanel(VocabQuestion::all());

        $checked=$exam->vocabQuestions()->pluck('vocab_question_id');
        $checked = json_encode($checked);
        $questions1 = json_encode($questions1);
        return view('reading.exams.addvocab',compact('questions1','exam','checked'));
    }
    public function store(Request $request,ReadingExam $exam)
    {
        $questions =VocabQuestion::whereIn('id',$request['questions'])->get();
        $exam->vocabQuestions()->sync($questions);
//        return redirect()->back();
    }
    public function destroy(ReadingExam $exam,VocabQuestion $question)
    {
        $exam->vocabQuestions()->detach($question);
        return response()->json(['success'=>true]);
    }
}
