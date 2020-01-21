<?php

namespace App\Http\Controllers\ListeningControllers;

use App\Http\Controllers\Controller;
use App\Listening\Audio;
use App\Listening\ListeningExam;
use Illuminate\Http\Request;

class ListeningExamAudiosController extends Controller
{
    public function index(ListeningExam $exam)
    {
//        dd('hello');
//        $questions = $grammarExam->questions()->orderBy('id', 'asc')->paginate(15);;
        $audios = Audio::getAudiosForChoose(Audio::all());
        $checked=$exam->audios()->pluck('audio_id');
        $checked = json_encode($checked);
        $audios = json_encode($audios);
        return view('listening.exams.audios',compact('audios','exam','checked'));
    }
    public function store(Request $request,ListeningExam $exam)
    {
//        dd($request['questions']);
        $audios =Audio::whereIn('id',$request['audios'])->get();
        $exam->audios()->sync($audios);
//        dd($exam->questions);
//        return redirect()->back();
    }
    public function destroy(ListeningExam $exam,Audio $audio)
    {
        $exam->audios()->detach($audio);
        return response()->json(['success'=>true]);
    }
}
