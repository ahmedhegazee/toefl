<?php

namespace App\Http\Controllers\GrammarControllers;

use App\Grammar\GrammarExam;
use App\Grammar\GrammarQuestion;
use App\Http\Controllers\Controller;
use App\Question;
use Illuminate\Http\Request;

class GrammarExamQuestionsController extends Controller
{
    public function index(GrammarExam $exam)
    {
//        dd('hello');
//        $questions = $grammarExam->questions()->orderBy('id', 'asc')->paginate(15);;
//        $questions = GrammarQuestion::paginate(15);
        $questions1 = Question::getGrammarQuestionsForChoosePanel(GrammarQuestion::all());

        $checked=$exam->questions()->pluck('grammar_question_id');
        $checked = json_encode($checked);
        $questions1 = json_encode($questions1);
//        return view('grammar.exams.questions',compact('questions','exam','questions1','checked'));
        return view('grammar.exams.questions',compact('exam','questions1','checked'));
    }
    public function store(Request $request,GrammarExam $exam)
    {
//        dd($request['questions']);
        $questions =GrammarQuestion::whereIn('id',$request['questions'])->get();

        $exam->questions()->sync($questions);
//        dd($exam->questions);
//        return redirect()->back();
    }
    public function destroy(GrammarExam $exam,GrammarQuestion $question)
    {
        $exam->questions()->detach($question);
        return response()->json(['success'=>true]);

//        return redirect()->action('GrammarExamController@show',compact('exam'));
    }
}
