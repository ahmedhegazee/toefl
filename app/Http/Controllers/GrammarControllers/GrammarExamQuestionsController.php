<?php

namespace App\Http\Controllers\GrammarControllers;

use App\Grammar\GrammarExam;
use App\Grammar\GrammarQuestion;
use App\Http\Controllers\Controller;
use App\Logging;
use App\Question;
use Illuminate\Http\Request;

class GrammarExamQuestionsController extends Controller
{
    public function index(Request $request, GrammarExam $exam)
    {
        if ($request->get('showExam') == 'true') {
            $questions = Question::getGrammarQuestions($exam->questions()->paginate(50));
//        return view('grammar.exams.show', compact('questions', 'exam','questions1'));
            $count = $exam->questions()->count();
            return response()->json(['questions' => $questions, 'count' => $count]);
        } else {
            $questions = Question::getGrammarQuestionsForChoosePanel(GrammarQuestion::paginate(50));
            $checked = $exam->questions()->pluck('grammar_question_id');
            $count = GrammarQuestion::all()->count();
            return response()->json(['questions' => $questions, 'count' => $count, 'checked' => $checked]);

//            $checked = json_encode($checked);
//            $questions1 = json_encode($questions1);
//        return view('grammar.exams.questions',compact('questions','exam','questions1','checked'));
        }


    }

    public function store(Request $request, GrammarExam $exam)
    {
//        dd($request['questions']);
        $questions = GrammarQuestion::whereIn('id', $request['questions'])->get();
        $str='';
        for($i=0;$i<sizeof($request['questions']);$i++){
            $str.=$request['questions'][$i].',';
        }
        $message = " add grammar questions {" . $str . "} to grammar exam  with id {" . $exam->id . "} ";
        Logging::logProfessor(auth()->user(), $message);
        $exam->questions()->sync($questions);
//        dd($exam->questions);
//        return redirect()->back();
    }

    public function destroy(GrammarExam $exam, GrammarQuestion $question)
    {
        $message = " remove grammar question {" . $question->id . "} from grammar exam  with id {" . $exam->id . "} ";
        Logging::logProfessor(auth()->user(), $message);
        $exam->questions()->detach($question);
        return response()->json(['success' => true]);

//        return redirect()->action('GrammarExamController@show',compact('exam'));
    }
}
