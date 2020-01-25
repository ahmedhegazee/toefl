<?php

namespace App\Http\Controllers\ListeningControllers;

use App\Exam;
use App\GroupType;
use App\Http\Controllers\Controller;
use App\Listening\Audio;
use App\Listening\ListeningExam;
use App\Logging;
use App\Reservation;
use Illuminate\Http\Request;

class ListeningExamController extends Controller
{
    public function index()
    {
        $exams = ListeningExam::all()->map(function ($exam) {
            return [
                'id' => $exam->id,
                'Reservation Date' => $exam->reservation->start,
                'Audios Count' => $exam->audios->count(),
                'actions' => '',
            ];
        });
        $exams = json_encode($exams);
        return view('listening.exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reservations = Reservation::all();
        if (empty($reservations->toArray()))
            return redirect()->back()->with('error', 'No Reservation is Available');

//        $types=GroupType::all();
//        return view('listening.exams.create',compact('reservations','types'));
        return view('listening.exams.create', compact('reservations'));


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
//        $count =ListeningExam::where('reservation_id',$res)->where('group_type_id',$type)->count();
        $count = ListeningExam::where('reservation_id', $res)->count();

        if ($count == 0) {
            $exam = ListeningExam::create([
                'reservation_id' => $res,
//                'group_type_id'=>$type,
            ]);
            $message = " add new listening exam with id {" . $exam->id . "} for reservation with id {" . $res . "}";
            Logging::logProfessor(auth()->user(), $message);
            return redirect()->to(route('listening.index'));
        } else {
            $message = " have made exam to this reservation with id {" . $res . "}";
            Logging::logProfessor(auth()->user(), $message);
            return redirect()->back()->with('error', 'You have made exam to this reservation');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param ListeningExam $exam
     * @return void
     */
    public function show(ListeningExam $exam)
    {

        $audios = Audio::getAudios($exam->audios()->get());
        $audios = json_encode($audios);

        return view('listening.exams.show', compact('audios', 'exam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ListeningExam $exam
     * @return void
     */
    public function edit(ListeningExam $exam)
    {
        $reservations = Reservation::all();
//        $types=GroupType::all();
//        return view('listening.exams.update',compact('exam','reservations','types'));
        return view('listening.exams.update', compact('exam', 'reservations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ListeningExam $grammarExam
     * @return void
     */
    public function update(Request $request, ListeningExam $exam)
    {
        $res = intval($request['reservation']);
//        $type=intval($request['type']);
//        $count =ListeningExam::where('reservation_id',$res)->where('group_type_id',$type)->count();
        $count = ListeningExam::where('reservation_id', $res)->count();
        if (!Exam::checkExamIsRunning($exam)) {
            if ($count == 0) {
                $message = " update listening exam with id {" . $exam->id . "} and old reservation is {" . $exam->reservation->id . "} and new reservation id is{" . $res . "}";
                Logging::logProfessor(auth()->user(), $message);
                $exam->update([
                    'reservation_id' => intval($request['reservation']),
//                'group_type_id'=>intval($request['type']),
                ]);
                return redirect()->to(route('listening.index'));
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
     * @param ListeningExam $exam
     * @return void
     * @throws \Exception
     */
    public function destroy(ListeningExam $exam)
    {
        if (!Exam::checkExamIsRunning($exam)) {
            $message = " delete listening exam with id {" . $exam->id . "} and  reservation id is {" . $exam->reservation->id . "}";
            Logging::logProfessor(auth()->user(), $message);
            $exam->audios()->detach($exam->audios);
            $exam->delete();
//        return redirect()->action('ListeningExamController@index');
        }
    }


}
