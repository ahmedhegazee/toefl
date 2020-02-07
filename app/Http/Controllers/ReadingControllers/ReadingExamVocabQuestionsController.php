<?php

namespace App\Http\Controllers\ReadingControllers;

use App\Http\Controllers\Controller;
use App\Logging;
use App\Question;
use App\Reading\ReadingExam;
use App\Reading\VocabQuestion;
use Illuminate\Http\Request;

class ReadingExamVocabQuestionsController extends Controller
{

    public function index(Request $request, ReadingExam $exam)
    {
        if ($request->get('showExam') == 'true') {
            $questions = Question::getQuestions($exam->vocabQuestions()->paginate(50));
            $count = $exam->vocabQuestions()->count();
            return response()->json(['questions' => $questions, 'count' => $count]);
        } else {
            $questions = Question::getQuestionsForChoosePanel(VocabQuestion::paginate(50));
            $checked = $exam->vocabQuestions()->pluck('vocab_question_id');
            $count = VocabQuestion::all()->count();
            return response()->json(['questions' => $questions, 'count' => $count, 'checked' => $checked]);
        }
    }

    public function store(Request $request, ReadingExam $exam)
    {
        $message = " add  vocab questions {" . $request['questions'] . "} to reading exam  with id {" . $exam->id . "} ";
        Logging::logProfessor(auth()->user(), $message);
        $questions = VocabQuestion::whereIn('id', $request['questions'])->get();
        $exam->vocabQuestions()->sync($questions);
//        return redirect()->back();
    }

    public function destroy(ReadingExam $exam, VocabQuestion $question)
    {
        $message = " remove vocab question {" . $question->id . "} from reading exam  with id {" . $exam->id . "} ";
        Logging::logProfessor(auth()->user(), $message);
        $exam->vocabQuestions()->detach($question);
        return response()->json(['success' => true]);
    }
}
