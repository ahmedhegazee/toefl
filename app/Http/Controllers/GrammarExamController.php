<?php

namespace App\Http\Controllers;

use App\Grammar\GrammarExam;
use App\Grammar\GrammarQuestion;
use App\Group;
use App\GroupType;
use App\Reservation;
use Illuminate\Http\Request;

class GrammarExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $exams= GrammarExam::all();
       return view('grammar.exams.index',compact('exams'));
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
        return view('grammar.exams.create',compact('reservations','types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $res=intval($request['reservation']);
        $type=intval($request['type']);
        $count =GrammarExam::where('reservation_id',$res)->where('group_type_id',$type)->count();

        if($count==0){
            GrammarExam::create([
                'reservation_id'=>$res,
                'group_type_id'=>$type,
            ]);
            return redirect()->action('GrammarExamController@index');
        }
        else{
            return redirect()->back()->with('error','You have made exam to this reservation and group');
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
        $questions = $exam->questions()->paginate(15);
        return view('grammar.exams.show',compact('questions','exam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param GrammarExam $exam
     * @return void
     */
    public function edit(GrammarExam $exam)
    {
        $reservations =Reservation::all();
        $types=GroupType::all();
        return view('grammar.exams.update',compact('exam','reservations','types'));
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
        $res=intval($request['reservation']);
        $type=intval($request['type']);
        $count =GrammarExam::where('reservation_id',$res)->where('group_type_id',$type)->count();

        if($count==0){
        $exam->update([
            'reservation_id'=>intval($request['reservation']),
            'group_type_id'=>intval($request['type']),
        ]);
        return redirect()->action('GrammarExamController@index');
        }
        else{
            return redirect()->back()->with('error','You have made exam to this reservation and group');
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
        $exam->questions()->detach($exam->questions);
        $exam->delete();
        return redirect()->action('GrammarExamController@index');
    }
    public function showQuestions(GrammarExam $exam)
    {
//        dd('hello');
//        $questions = $grammarExam->questions()->orderBy('id', 'asc')->paginate(15);;
        $questions = GrammarQuestion::paginate(15);
        return view('grammar.exams.questions',compact('questions','exam'));
    }
    public function storeQuestions(Request $request,GrammarExam $exam)
    {
//        dd($request['questions']);
        $questions =GrammarQuestion::whereIn('id',$request['questions'])->get();

        $exam->questions()->syncWithoutDetaching($questions);
//        dd($exam->questions);
        return redirect()->back();
    }
    public function destroyQuestions(GrammarExam $exam,GrammarQuestion $question)
    {
        $exam->questions()->detach($question);
        return redirect()->action('GrammarExamController@show',compact('exam'));
    }
}
