<?php

namespace App\Http\Controllers;

use App\GroupType;
use App\Reading\Paragraph;
use App\Reading\ReadingExam;
use App\Reading\VocabQuestion;
use App\Reservation;
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
        $reservations =Reservation::all();
        if(empty($reservations->toArray()))
            return redirect()->back()->with('error','No Reservation is Available');

        $types=GroupType::all();
        return view('reading.exams.create',compact('reservations','types'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $res=intval($request['reservation']);
        $type=intval($request['type']);
        $count =ReadingExam::where('reservation_id',$res)->where('group_type_id',$type)->count();

        if($count==0){
            ReadingExam::create([
                'reservation_id'=>$res,
                'group_type_id'=>$type,
            ]);
            return redirect()->action('ReadingExamsController@index');
        }
        else{
            return redirect()->back()->with('error','You have made exam to this reservation and group');
        }
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param ReadingExam $readingExam
     * @return void
     */
    public function edit(ReadingExam $exam)
    {
        $reservations =Reservation::all();
        $types=GroupType::all();
        return view('reading.exams.update',compact('exam','reservations','types'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ReadingExam $readingExam
     * @return void
     */
    public function update(Request $request, ReadingExam $exam)
    {
        $res=intval($request['reservation']);
        $type=intval($request['type']);
        $count =ReadingExam::where('reservation_id',$res)->where('group_type_id',$type)->count();

        if($count==0){
            $exam->update([
                'reservation_id'=>intval($request['reservation']),
                'group_type_id'=>intval($request['type']),
            ]);
            return redirect()->action('ReadingExamsController@index');
        }
        else{
            return redirect()->back()->with('error','You have made exam to this reservation and group');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReadingExam $readingExam
     * @return void
     */
    public function destroy(ReadingExam $exam)
    {
        $exam->paragraphs()->detach($exam->paragraphs);
        $exam->vocabQuestions()->detach($exam->vocabQuestions);
        $exam->delete();
        return redirect()->action('ReadingExamsController@index');

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
    public function addParagraphs(ReadingExam $exam)
    {
        $paragraphs = Paragraph::paginate(15);
        return view('reading.exams.addparagraphs',compact('paragraphs','exam'));
    }
     public function storeParagraphs(Request $request,ReadingExam $exam)
    {
        $paragraphs =Paragraph::whereIn('id',$request['paragraphs'])->get();
        $exam->paragraphs()->syncWithoutDetaching($paragraphs);
         return redirect()->back();
    }
    public function destroyParagraphs(ReadingExam $exam,Paragraph $paragraph)
    {
        $exam->paragraphs()->detach($paragraph);
        return redirect()->action('ReadingExamsController@showParagraphs',compact('exam'));
    }
    public function addVocabQuestions(ReadingExam $exam)
    {
        $questions = VocabQuestion::paginate(15);
        return view('reading.exams.addvocab',compact('questions','exam'));
    }
     public function storeVocabQuestions(Request $request,ReadingExam $exam)
    {
        $questions =VocabQuestion::whereIn('id',$request['questions'])->get();
        $exam->vocabQuestions()->syncWithoutDetaching($questions);
         return redirect()->back();
    }
    public function destroyVocabQuestions(ReadingExam $exam,VocabQuestion $question)
    {
        $exam->vocabQuestions()->detach($question);
        return redirect()->action('ReadingExamsController@showVocab',compact('exam'));
    }
}
