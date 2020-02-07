<?php

namespace App\Http\Controllers\ReadingControllers;

use App\Exam;
use App\GroupType;
use App\Http\Controllers\Controller;
use App\Logging;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
//        $exams = ReadingExam::paginate(15);
        $exams = ReadingExam::paginate(50)
            ->map(function ($exam) {
            return [
                'id' => $exam->id,
                'Reservation Date' => $exam->reservation->start,
                'Vocab Questions	' => $exam->vocabQuestions()->count(),
                'Paragraphs' => $exam->paragraphs()->count(),
                'actions' => '',
            ];
        })->values()->toArray();
        $count=ReadingExam::all()->count();
        return response()->json(['exams'=>$exams,'count'=>$count]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reservations = Reservation::closed(1)->get();;
        $reservations=$reservations->filter(function($res){
            if(is_null($res->readingExam))
                return $res;
        });
        if (empty($reservations->toArray()))
            return redirect()->back()->with('error', 'No Reservation is Available and closed');

//        $types=GroupType::all();
//        return view('reading.exams.create',compact('reservations','types'));
        return view('reading.exams.create', compact('reservations'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $res = intval($request['reservation']);
//        $type=intval($request['type']);
//        $count =ReadingExam::where('reservation_id',$res)->where('group_type_id',$type)->count();
        $count = ReadingExam::where('reservation_id', $res)->count();

        if ($count == 0) {
            $exam = ReadingExam::create([
                'reservation_id' => $res,
//                'group_type_id'=>$type,
            ]);
            $message = " add new listening exam with id {" . $exam->id . "} for reservation with id {" . $res . "}";
            Logging::logProfessor(auth()->user(), $message);
            return redirect()->to(route('reading.exam.index'));
        } else {
            $message = " have made exam to this reservation with id {" . $res . "}";
            Logging::logProfessor(auth()->user(), $message);
            return redirect()->back()->with('error', 'You have made exam to this reservation');
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
        $reservations = Reservation::closed(1)->get();;
        $reservations=$reservations->filter(function($res){
            if(is_null($res->readingExam))
                return $res;
        });
        if (empty($reservations->toArray()))
            return redirect()->back()->with('error', 'No Reservation is Available and closed');

//        $types=GroupType::all();
//        return view('reading.exams.update',compact('exam','reservations','types'));
        return view('reading.exams.update', compact('exam', 'reservations'));

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
        $res = intval($request['reservation']);
//        $type=intval($request['type']);
//        $count =ReadingExam::where('reservation_id',$res)->where('group_type_id',$type)->count();
        $count = ReadingExam::where('reservation_id', $res)->count();

        if (!Exam::checkExamIsRunning($exam)) {
            if ($count == 0) {
                $message = " update reading exam with id {" . $exam->id . "} and old reservation is {" . $exam->reservation->id . "} and new reservation id is{" . $res . "}";
                Logging::logProfessor(auth()->user(), $message);
                $exam->update([
                    'reservation_id' => intval($request['reservation']),
//                'group_type_id'=>intval($request['type']),
                ]);
                return redirect()->to(route('reading.exam.index'));
            } else {
                $message = " have made exam to this reservation with id {" . $res . "}";
                Logging::logProfessor(auth()->user(), $message);
                return redirect()->back()->with('error', 'You have made exam to this reservation ');
            }
        } else {
            return redirect()->back()->with('error', 'You can\'t edit this exam because it is running ');

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
        if (!Exam::checkExamIsRunning($exam)) {
            $message = " delete reading exam with id {" . $exam->id . "} and  reservation id is {" . $exam->reservation->id . "}";
            Logging::logProfessor(auth()->user(), $message);
            $exam->paragraphs()->detach($exam->paragraphs);
            $exam->vocabQuestions()->detach($exam->vocabQuestions);
            $exam->delete();
//            return redirect()->to(route('reading.exam.index'));
        }
    }

    public function showParagraphs(ReadingExam $exam)
    {

        return view('reading.exams.paragraphs', compact( 'exam'));
    }

    public function showVocab(ReadingExam $exam)
    {
        return view('reading.exams.vocab', compact( 'exam'));
    }


}
