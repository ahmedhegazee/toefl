<?php

namespace App\Http\Controllers\ReadingControllers;

use App\Exam;
use App\GroupType;
use App\Http\Controllers\Controller;
use App\Question;
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
//        $exams = ReadingExam::paginate(15);
        $exams = ReadingExam::all();
        $jsonExams = $exams->map(function ($exam) {
            return [
                'id' => $exam->id,
                'Reservation Date' => $exam->reservation->start,
                'Vocab Questions	' => $exam->vocabQuestions()->count(),
                'Paragraphs' => $exam->paragraphs()->count(),
                'actions' => '',
            ];
        })->values()->toArray();
        $jsonExams = json_encode($jsonExams);
        return view('reading.exams.index', compact('jsonExams'));
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

//        $types=GroupType::all();
//        return view('reading.exams.create',compact('reservations','types'));
        return view('reading.exams.create',compact('reservations'));


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
//        $type=intval($request['type']);
//        $count =ReadingExam::where('reservation_id',$res)->where('group_type_id',$type)->count();
        $count =ReadingExam::where('reservation_id',$res)->count();

        if($count==0){
            ReadingExam::create([
                'reservation_id'=>$res,
//                'group_type_id'=>$type,
            ]);
            return redirect()->to(route('reading.exam.index'));
        }
        else{
            return redirect()->back()->with('error','You have made exam to this reservation');
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
//        $types=GroupType::all();
//        return view('reading.exams.update',compact('exam','reservations','types'));
        return view('reading.exams.update',compact('exam','reservations'));

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
//        $type=intval($request['type']);
//        $count =ReadingExam::where('reservation_id',$res)->where('group_type_id',$type)->count();
        $count =ReadingExam::where('reservation_id',$res)->count();

        if($count==0){
            $exam->update([
                'reservation_id'=>intval($request['reservation']),
//                'group_type_id'=>intval($request['type']),
            ]);
            return redirect()->to(route('reading.exam.index'));        }
        else{
            return redirect()->back()->with('error','You have made exam to this reservation ');
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
        return redirect()->to(route('reading.exam.index'));
    }

    public function showParagraphs(ReadingExam $exam)
    {
        $paragraphs =Paragraph::getParagraphs($exam->paragraphs()->get());
        $paragraphs=json_encode($paragraphs);

        return view('reading.exams.paragraphs',compact('paragraphs','exam'));
    }
    public function showVocab(ReadingExam $exam)
    {
        $questions=Question::getQuestions($exam->vocabQuestions()->get());
        $questions=json_encode($questions);
        return view('reading.exams.vocab',compact('questions','exam'));
    }



}
