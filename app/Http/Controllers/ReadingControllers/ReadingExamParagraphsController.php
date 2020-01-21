<?php

namespace App\Http\Controllers\ReadingControllers;

use App\Http\Controllers\Controller;
use App\Reading\Paragraph;
use App\Reading\ReadingExam;
use Illuminate\Http\Request;

class ReadingExamParagraphsController extends Controller
{
    public function index(ReadingExam $exam)
    {
        $paragraphs = Paragraph::getParagraphsForChoose(Paragraph::all());
        $paragraphs = json_encode($paragraphs);
        $checked=$exam->paragraphs()->pluck('paragraph_id');
        $checked = json_encode($checked);
        return view('reading.exams.addparagraphs',compact('paragraphs','exam','checked'));
    }
    public function store(Request $request,ReadingExam $exam)
    {
        $paragraphs =Paragraph::whereIn('id',$request['paragraphs'])->get();
        $exam->paragraphs()->sync($paragraphs);
//        return redirect()->back();
    }
    public function destroy(ReadingExam $exam,Paragraph $paragraph)
    {
        $exam->paragraphs()->detach($paragraph);
        return response()->json(['success'=>true]);

//        return redirect()->action('ReadingExamsController@showParagraphs',compact('exam'));
    }
}
