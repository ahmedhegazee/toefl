<?php

namespace App\Http\Controllers;

use App\Config;
use App\Grammar\GrammarExam;
use App\Grammar\GrammarOption;
use App\Grammar\GrammarQuestion;
use App\Listening\ListeningExam;
use App\Listening\ListeningOption;
use App\Reading\ParagraphQuestionOption;
use App\Reading\ReadingExam;
use App\Reading\VocabOption;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ExamsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check_student');

    }

    public function showStudentHome()
    {
        $student = auth()->user()->getStudent();
        $fullName = auth()->user()->name;
        $reservation = $student->reservation->id;
//        $groupType = $student->group->type->id;
        $grammarExam = GrammarExam::where('reservation_id', $reservation)->get()->first();
//        $grammarExam = GrammarExam::where('reservation_id', $reservation)
//            ->where('group_type_id', $groupType)->get()->first();
//        $readingExam = ReadingExam::where('reservation_id', $reservation)
//            ->where('group_type_id', $groupType)->get()->first();
        $readingExam = ReadingExam::where('reservation_id', $reservation)->get()->first();
//        $listeningExam = ListeningExam::where('reservation_id', $reservation)
//            ->where('group_type_id', $groupType)->get()->first();
        $listeningExam = ListeningExam::where('reservation_id', $reservation)->get()->first();
        session([
            'student' => $student,
            'grammarExam' => $grammarExam,
            'readingExam' => $readingExam,
            'listeningExam' => $listeningExam,
        ]);
        $student->attempts()->create([
            'group_id' => $student->group->id,
            'reservation_id' => $reservation,
        ]);
        return view('exams.home', compact('fullName', 'student'));
    }

    public function showGrammarExam()
    {
        if (!$this->checkSessionData())
            return redirect()->action('ExamsController@showStudentHome');
        $student = session()->get('student');
        if (session()->has('student-' . $student->id . '-grammar'))
            return redirect()->action('ExamsController@showReadingExam');
        elseif (session()->has('student-' . $student->id . '-reading'))
            return redirect()->action('ExamsController@showListeningExam');

        $grammarExam = session()->get('grammarExam');
        $fillQuestions = $grammarExam->getFillQuestions;
        $findQuestions = $grammarExam->getFindQuestions;
        $time = Config::find(2)->value;
        $route = route('grammar.exam.submit');
        return view('exams.grammarExam', compact('fillQuestions', 'findQuestions', 'time', 'route'));
    }

    public function storeGrammarExamAttempt(Request $request)
    {
        $student = session()->get('student');
        $answers = $request->get('answers');
        $marks = collect($answers)->map(function ($answer) {
            return GrammarOption::find($answer)->correct;
        })->sum();
       session(['student-' . $student->id . '-grammar'=> $marks]);
        return redirect()->action("ExamsController@showReadingExam");
    }

    public function showReadingExam()
    {
        if (!$this->checkSessionData())
            return redirect()->action('ExamsController@showStudentHome');
        $student = session()->get('student');
        if (session()->has('student-' . $student->id . '-reading'))
            return redirect()->action('ExamsController@showListeningExam');

        $readingExam = session()->get('readingExam');
        $vocabQuestions = $readingExam->vocabQuestions;
        $paragraphs = $readingExam->paragraphs;
        $time = Config::find(3)->value;
        $route = route('reading.exam.submit');
        return view('exams.readingExam', compact('vocabQuestions', 'paragraphs', 'time', 'route'));
    }

    public function storeReadingExamAttempt(Request $request)
    {
        $student = session()->get('student');
        $vocabAnswers = $request->get('vocabAnswers');
        $paragraphAnswers = $request->get('paragraphAnswers');
        $vocabMarks = collect($vocabAnswers)->map(function ($answer) {
            return VocabOption::find($answer)->correct;
        })->sum();
        $paragraphMarks = collect($paragraphAnswers)->map(function ($answer) {
            return ParagraphQuestionOption::find($answer)->correct;
        })->sum();
        $marks = $vocabMarks + $paragraphMarks;
        session(['student-' . $student->id . '-reading'=> $marks]);
        return redirect()->action("ExamsController@showListeningExam");
    }

    public function showListeningExam()
    {
        if (!$this->checkSessionData())
            return redirect()->action('ExamsController@showStudentHome');
        $listeningExam = session()->get('listeningExam');
        $shortConversations = $listeningExam->audios->where('audio_type_id', 1);
        $longConversations = $listeningExam->audios->where('audio_type_id', 2);
        $speeches = $listeningExam->audios->where('audio_type_id', 3);
        $time = Config::find(4)->value;
        $route = route('listening.exam.submit');
        return view('exams.listeningExam', compact('shortConversations', 'longConversations', 'speeches', 'time', 'route'));
    }

    public function storeListeningExamAttempt(Request $request)
    {
        $student = session()->get('student');
        $listeningAnswers = $request->get('listeningAnswers');
        $marks = collect($listeningAnswers)->map(function ($answer) {
            return ListeningOption::find($answer)->correct;
        })->sum();
        $student->sumAllMarks(session()->get('student-' . $student->id . '-grammar'), session()->get('student-' . $student->id . '-reading'), $marks);
        $this->logout();
        return redirect(route('success'))->with('message', 'You will know your grades soon');
    }

    public function logout()
    {
        $student = session()->get('student');
        Cache::forget('student-is-online-' . $student->id);
        session()->forget([ 'student-' . $student->id . '-grammar','student-' . $student->id . '-reading']);
        session()->forget(['student', 'grammarExam', 'readingExam', 'listeningExam']);
        auth()->logout();
    }

    public function checkSessionData()
    {
        return
            session()->has('student') &&
            session()->has('grammarExam') &&
            session()->has('readingExam') &&
            session()->has('listeningExam');
    }
}
