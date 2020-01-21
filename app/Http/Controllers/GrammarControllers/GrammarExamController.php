<?php

namespace App\Http\Controllers\GrammarControllers;

use App\Grammar\GrammarExam;
use App\Grammar\GrammarQuestion;
use App\Group;
use App\GroupType;
use App\Http\Controllers\Controller;
use App\Logging;
use App\Question;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GrammarExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $exams = GrammarExam::all();
//       dd($exams);
        $jsonExams = $exams->map(function ($exam) {
            return [
                'id' => $exam->id,
                'Reservation Date' => $exam->reservation->start,
                'Fill Questions Count' => $exam->getFillQuestions()->count(),
                'Find Questions Count' => $exam->getFindQuestions()->count(),
                'actions' => '',
            ];
        })->values()->toArray();
        $jsonExams = json_encode($jsonExams);
//       return view('grammar.exams.index',compact('exams','jsonExams'));
        return view('grammar.exams.index', compact('jsonExams'));
    }


    public function create()
    {
        $reservations = Reservation::all();
        if (empty($reservations->toArray()))
            return redirect()->back()->with('error', 'No Reservation is Available');

//        $types=GroupType::all();
//        return view('grammar.exams.create',compact('reservations','types'));
        return view('grammar.exams.create', compact('reservations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $res = intval($request['reservation']);
//        $type=intval($request['type']);
//        $count =GrammarExam::where('reservation_id',$res)->where('group_type_id',$type)->count();
        $count = GrammarExam::where('reservation_id', $res)->count();

        if ($count == 0) {
           $exam= GrammarExam::create([
                'reservation_id' => $res,
//                'group_type_id'=>$type,
            ]);
            $message=" add new grammar exam with id {".$exam->id."} for reservation with id {".$res."}";
            Logging::logProfessor(auth()->user(),$message);
            return redirect()->to(route('grammar.exam.index'));
        } else {
            $message=" have made exam to this reservation with id {".$res."}";
            Logging::logProfessor(auth()->user(),$message);
            return redirect()->back()->with('error', 'You have made exam to this reservation');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param GrammarExam $exam
     * @return void
     */
    public function show(GrammarExam $exam)
    {

//        $questions = $grammarExam->questions()->orderBy('id', 'asc')->paginate(15);;
//        $questions = $exam->questions()->paginate(15);
        $questions1 = Question::getGrammarQuestions($exam->questions()->get());
        $questions1 = json_encode($questions1);
//        return view('grammar.exams.show', compact('questions', 'exam','questions1'));
        return view('grammar.exams.show', compact( 'exam','questions1'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param GrammarExam $exam
     * @return void
     */
    public function edit(GrammarExam $exam)
    {
        $reservations = Reservation::all();
//        $types=GroupType::all();
//        return view('grammar.exams.update',compact('exam','reservations','types'));
        return view('grammar.exams.update', compact('exam', 'reservations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param GrammarExam $grammarExam
     * @return void
     */
    public function update(Request $request, GrammarExam $exam)
    {
        $res = intval($request['reservation']);
//        $type=intval($request['type']);
//        $count =GrammarExam::where('reservation_id',$res)->where('group_type_id',$type)->count();
        $count = GrammarExam::where('reservation_id', $res)->count();

        if ($count == 0) {
            $message=" update grammar exam with id {".$exam->id."} and old reservation is {".$exam->reservation->id."} and new reservation id is{".$res."}";
            Logging::logProfessor(auth()->user(),$message);
            $exam->update([
                'reservation_id' => intval($request['reservation']),
//            'group_type_id'=>intval($request['type']),
            ]);
            return redirect()->to(route('grammar.exam.index'));
        } else {
            $message=" have made exam to this reservation with id {".$res."}";
            Logging::logProfessor(auth()->user(),$message);
            return redirect()->back()->with('error', 'You have made exam to this reservation ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GrammarExam $exam
     * @return void
     * @throws \Exception
     */
    public function destroy(GrammarExam $exam)
    {

        $message=" delete grammar exam with id {".$exam->id."} and  reservation id is {".$exam->reservation->id."}";
        Logging::logProfessor(auth()->user(),$message);
        $exam->questions()->detach($exam->questions);
        $exam->delete();
//        return redirect()->action('GrammarExamController@index');
    }

}
