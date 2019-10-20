<?php

namespace App\Http\Controllers;

use App\GroupType;
use App\Listening\Audio;
use App\Listening\ListeningExam;
use App\Reservation;
use Illuminate\Http\Request;

class ListeningExamController extends Controller
{
    public function index()
    {
        $exams= ListeningExam::all();
        return view('listening.exams.index',compact('exams'));
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
        return view('listening.exams.create',compact('reservations','types'));


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
        $count =ListeningExam::where('reservation_id',$res)->where('group_type_id',$type)->count();

        if($count==0){
            ListeningExam::create([
                'reservation_id'=>$res,
                'group_type_id'=>$type,
            ]);
            return redirect()->action('ListeningExamController@index');
        }
        else{
            return redirect()->back()->with('error','You have made exam to this reservation and group');
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

        $audios = $exam->audios()->paginate(15);
        return view('listening.exams.show',compact('audios','exam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ListeningExam $exam
     * @return void
     */
    public function edit(ListeningExam $exam)
    {
        $reservations =Reservation::all();
        $types=GroupType::all();
        return view('listening.exams.update',compact('exam','reservations','types'));
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
        $res=intval($request['reservation']);
        $type=intval($request['type']);
        $count =ListeningExam::where('reservation_id',$res)->where('group_type_id',$type)->count();

        if($count==0){
            $exam->update([
                'reservation_id'=>intval($request['reservation']),
                'group_type_id'=>intval($request['type']),
            ]);
            return redirect()->action('ListeningExamController@index');
        }
        else{
            return redirect()->back()->with('error','You have made exam to this reservation and group');
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
        $exam->questions()->detach($exam->questions);
        $exam->delete();
        return redirect()->action('ListeningExamController@index');
    }
    public function showAudios(ListeningExam $exam)
    {
//        dd('hello');
//        $questions = $grammarExam->questions()->orderBy('id', 'asc')->paginate(15);;
        $audios = Audio::paginate(15);
        return view('listening.exams.audios',compact('audios','exam'));
    }
    public function storeAudios(Request $request,ListeningExam $exam)
    {
//        dd($request['questions']);
        $audios =Audio::whereIn('id',$request['audios'])->get();
        $exam->audios()->syncWithoutDetaching($audios);
//        dd($exam->questions);
        return redirect()->back();
    }
    public function destroyAudios(ListeningExam $exam,Audio $audio)
    {
        $exam->audios()->detach($audio);
        return redirect()->action('ListeningExamController@show',compact('exam'));
    }
}
