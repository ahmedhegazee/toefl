<?php

namespace App\Http\Controllers\ReadingControllers;

use App\Config;
use App\Http\Controllers\Controller;
use App\Logging;
use App\Reading\Paragraph;
use App\Reading\ReadingExam;
use Illuminate\Http\Request;

class ReadingExamParagraphsController extends Controller
{
    public function index(Request $request, ReadingExam $exam)
    {

        if ($request->get('showExam') == 'true') {
            $paragraphs = Paragraph::getParagraphs($exam->paragraphs()->paginate(50));
            $count = $exam->paragraphs()->count();
            return response()->json(['questions' => $paragraphs, 'count' => $count]);
        } else {
            $paragraphs = Paragraph::getParagraphsForChoose(Paragraph::paginate(50));
            $checked = $exam->paragraphs()->pluck('paragraph_id');
            $count = Paragraph::all()->count();
            $maxCountQuestions = Config::where('id', 10)->first()->value;

            //            $checked = json_encode($checked);
            return response()->json(['questions' => $paragraphs, 'max_questions' => $maxCountQuestions, 'count' => $count, 'checked' => $checked]);
        }
    }

    public function store(Request $request, ReadingExam $exam)
    {
        $str = '';
        for ($i = 0; $i < sizeof($request['paragraphs']); $i++) {
            $str .= $request['paragraphs'][$i] . ',';
        }
        $message = " add  paragraphs {" . $str . "} to reading exam  with id {" . $exam->id . "} ";
        Logging::logProfessor(auth()->user(), $message);
        $paragraphs = Paragraph::whereIn('id', $request['paragraphs'])->get();
        $exam->paragraphs()->sync($paragraphs);
        //        return redirect()->back();
    }

    public function destroy(ReadingExam $exam, Paragraph $paragraph)
    {
        $message = " remove paragraph {" . $paragraph->id . "} from reading exam  with id {" . $exam->id . "} ";
        Logging::logProfessor(auth()->user(), $message);
        $exam->paragraphs()->detach($paragraph);
        return response()->json(['success' => true]);

        //        return redirect()->action('ReadingExamsController@showParagraphs',compact('exam'));
    }
}
