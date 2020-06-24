<?php

namespace App\Http\Controllers\ListeningControllers;

use App\Config;
use App\Http\Controllers\Controller;
use App\Listening\Audio;
use App\Listening\ListeningExam;
use App\Logging;
use Illuminate\Http\Request;

class ListeningExamAudiosController extends Controller
{
    public function index(Request $request, ListeningExam $exam)
    {
        if ($request->get('showExam') == 'true') {
            $audios = Audio::getAudiosForChoose($exam->audios()->paginate(50));
            $count = $exam->audios()->count();
            return response()->json(['questions' => $audios, 'count' => $count]);
        } else {
            $audios = Audio::getAudiosForChoose(Audio::paginate(50));
            $checked = $exam->audios()->pluck('audio_id');
            $count = Audio::all()->count();
            $maxCountQuestions = Config::where('id', 12)->first()->value;

            return response()->json(['questions' => $audios, 'max_questions' => $maxCountQuestions, 'count' => $count, 'checked' => $checked]);
        }

        //        return view('listening.exams.audios', compact('audios', 'exam', 'checked'));
    }

    public function store(Request $request, ListeningExam $exam)
    {
        //        dd($request['questions']);
        $str = '';
        for ($i = 0; $i < sizeof($request['audios']); $i++) {
            $str .= $request['audios'][$i] . ',';
        }
        $audios = Audio::whereIn('id', $request['audios'])->get();
        $message = " add  audios {" . $str . "} to listening exam  with id {" . $exam->id . "} ";
        Logging::logProfessor(auth()->user(), $message);
        $exam->audios()->sync($audios);
        //        dd($exam->questions);
        //        return redirect()->back();
    }

    public function destroy(ListeningExam $exam, Audio $audio)
    {
        $message = " remove audio {" . $audio->id . "} from listening exam  with id {" . $exam->id . "} ";
        Logging::logProfessor(auth()->user(), $message);
        $exam->audios()->detach($audio);
        return response()->json(['success' => true]);
    }
}
