<?php

namespace App\Http\Controllers;

use App\Attempt;
use App\Config;
use App\Exam;
use App\Grammar\GrammarExam;
use App\Grammar\GrammarOption;
use App\Grammar\GrammarQuestion;
use App\Jobs\storeStudentResult;
use App\Listening\ListeningExam;
use App\Listening\ListeningOption;
use App\Logging;
use App\Reading\ParagraphQuestionOption;
use App\Reading\ReadingExam;
use App\Reading\VocabOption;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class ExamsController extends Controller
{

    public function showStudentHome()
    {
        $student = auth()->user()->getStudent();
        $fullName = auth()->user()->name;
//        $reservation = $student->reservation->id;
//        $groupType = $student->group->type->id;
//        $grammarExam = GrammarExam::where('reservation_id', $reservation)->get()->first();
        $grammarExam = $student->reservation->grammarExam;
//        $grammarExam = GrammarExam::where('reservation_id', $reservation)
//            ->where('group_type_id', $groupType)->get()->first();
//        $readingExam = ReadingExam::where('reservation_id', $reservation)
//            ->where('group_type_id', $groupType)->get()->first();
//        $readingExam = ReadingExam::where('reservation_id', $reservation)->get()->first();
        $readingExam =$student->reservation->readingExam;
//        $listeningExam = ListeningExam::where('reservation_id', $reservation)
//            ->where('group_type_id', $groupType)->get()->first();
//        $listeningExam = ListeningExam::where('reservation_id', $reservation)->get()->first();
        $listeningExam = $student->reservation->listeningExam;
        session([
            'student' => $student,
            'grammarExam' => $grammarExam,
            'readingExam' => $readingExam,
            'listeningExam' => $listeningExam,
        ]);
        $count =Attempt::where('student_id',$student->id)
            ->where('reservation_id',$student->reservation->id)
            ->where('group_id',$student->group->id)->count();
        if($count==0){
            $attempt =$student->attempts()->create([
                'group_id' => $student->group->id,
                'reservation_id' => $student->reservation->id,
            ]);
            $message=" has new attempt {".$attempt->id."}";
            Logging::logStudent(auth()->user()->getStudent(), $message);
        }


        return view('exams.home', compact('fullName', 'student'));
    }

    public function showExam()
    {
        if (!$this->checkSessionData())
        return redirect()->action('ExamsController@showStudentHome');
        $grammarExam = session()->get('grammarExam');
        $fillQuestions = $grammarExam->getFillQuestions;
        $findQuestions = $grammarExam->getFindQuestions;
        $grammarTime = Config::find(2)->value;
        $message=" start solving grammar exam {".$grammarExam->id."}";
        Logging::logStudent(auth()->user()->getStudent(), $message);
        $readingExam = session()->get('readingExam');
        $vocabQuestions = $readingExam->vocabQuestions;
        $paragraphs = $readingExam->paragraphs;
        $readingTime = Config::find(3)->value;
        $message=" start solving reading exam {".$readingExam->id."}";
        Logging::logStudent(auth()->user()->getStudent(), $message);
        $listeningExam = session()->get('listeningExam');
//        dd($listeningExam);
        $shortConversations = $listeningExam->audios->where('audio_type_id', 1);
        $longConversations = $listeningExam->audios->where('audio_type_id', 2);
        $speeches = $listeningExam->audios->where('audio_type_id', 3);
        $listeningTime = Config::find(4)->value;
        $message=" start solving listening exam {".$listeningExam->id."}";
        Logging::logStudent(auth()->user()->getStudent(), $message);
        return view('exams.exam', compact('fillQuestions', 'findQuestions','vocabQuestions', 'paragraphs','shortConversations', 'longConversations', 'speeches', 'grammarTime','readingTime','listeningTime'));

    }

    public function storeResult(Request $request)
    {

        $student = session()->get('student');

        $answers = $request->get('answers');
//        $grammar_marks = Exam::getGrammarMarks($answers);

        $vocabAnswers = $request->get('vocabAnswers');
        $paragraphAnswers = $request->get('paragraphAnswers');

//        $reading_marks = Exam::getReadingMarks($vocabAnswers,$paragraphAnswers);

        $listeningAnswers = $request->get('listeningAnswers');
//        $listening_marks = Exam::getListeningMarks($listeningAnswers);
        //Logs
//        $message=" solved grammar exam and has {".$grammar_marks."}";
//        Logging::logStudent(auth()->user()->getStudent(), $message);
//        $message=" solved reading exam and has {".$reading_marks."}";
//        Logging::logStudent(auth()->user()->getStudent(), $message);
//        $message=" solved listening exam and has {".$listening_marks."}";
//        Logging::logStudent(auth()->user()->getStudent(), $message);
//
//        $student->sumAllMarks($grammar_marks,$reading_marks,$listening_marks);
        storeStudentResult::dispatch($student,$answers,$vocabAnswers,$paragraphAnswers,$listeningAnswers)
            ->delay(Carbon::now()->addMinutes(5));
        $this->logout();
        $message='You will know your grades soon';
        return view('success',compact('message'));
    }
//    public function showGrammarExam()
//    {
//        if (!$this->checkSessionData())
//            return redirect()->action('ExamsController@showStudentHome');
//        $student = session()->get('student');
//        if (session()->has('student-' . $student->id . '-grammar'))
//            return redirect()->action('ExamsController@showReadingExam');
//        elseif (session()->has('student-' . $student->id . '-reading'))
//            return redirect()->action('ExamsController@showListeningExam');
//
//        $grammarExam = session()->get('grammarExam');
//        $fillQuestions = $grammarExam->getFillQuestions;
//        $findQuestions = $grammarExam->getFindQuestions;
//        $time = Config::find(2)->value;
//        $route = route('grammar.exam.submit');
//        $message=" start solving grammar exam {".$grammarExam->id."}";
//        Logging::logStudent(auth()->user()->getStudent(), $message);
//        return view('exams.grammarExam', compact('fillQuestions', 'findQuestions', 'time', 'route'));
//    }
//
//    public function storeGrammarExamAttempt(Request $request)
//    {
//        $student = session()->get('student');
//        $answers = $request->get('answers');
//        $marks = Exam::getGrammarMarks($answers);
//       session(['student-' . $student->id . '-grammar'=> $marks]);
//        $expiresAt = Carbon::now()->addHours(8);
//       Cache::put('student-' . $student->id . '-grammar',$marks,$expiresAt);
//        $message=" solved grammar exam and has {".$marks."}";
//        Logging::logStudent(auth()->user()->getStudent(), $message);
//        return redirect()->action("ExamsController@showReadingExam");
//    }
//
//    public function showReadingExam()
//    {
//
//
//        if (!$this->checkSessionData())
//            return redirect()->action('ExamsController@showStudentHome');
//        $student = session()->get('student');
//        if (session()->has('student-' . $student->id . '-reading'))
//            return redirect()->action('ExamsController@showListeningExam');
//
//        $readingExam = session()->get('readingExam');
//        $vocabQuestions = $readingExam->vocabQuestions;
//        $paragraphs = $readingExam->paragraphs;
//        $time = Config::find(3)->value;
//        $route = route('reading.exam.submit');
//        $message=" start solving reading exam {".$readingExam->id."}";
//        Logging::logStudent(auth()->user()->getStudent(), $message);
//        return view('exams.readingExam', compact('vocabQuestions', 'paragraphs', 'time', 'route'));
//    }
//
//    public function storeReadingExamAttempt(Request $request)
//    {
//        $student = session()->get('student');
//        $vocabAnswers = $request->get('vocabAnswers');
//        $paragraphAnswers = $request->get('paragraphAnswers');
//
//        $marks = Exam::getReadingMarks($vocabAnswers,$paragraphAnswers);
//        session(['student-' . $student->id . '-reading'=> $marks]);
//        $expiresAt = Carbon::now()->addHours(8);
//        Cache::put('student-' . $student->id . '-reading',$marks,$expiresAt);
//        $message=" solved reading exam and has {".$marks."}";
//        Logging::logStudent(auth()->user()->getStudent(), $message);
//        return redirect()->action("ExamsController@showListeningExam");
//    }
//
//    public function showListeningExam()
//    {
//        if (!$this->checkSessionData())
//            return redirect()->action('ExamsController@showStudentHome');
//        $listeningExam = session()->get('listeningExam');
//        $shortConversations = $listeningExam->audios->where('audio_type_id', 1);
//        $longConversations = $listeningExam->audios->where('audio_type_id', 2);
//        $speeches = $listeningExam->audios->where('audio_type_id', 3);
//        $time = Config::find(4)->value;
//        $route = route('listening.exam.submit');
//        $message=" start solving listening exam {".$listeningExam->id."}";
//        Logging::logStudent(auth()->user()->getStudent(), $message);
//        return view('exams.listeningExam', compact('shortConversations', 'longConversations', 'speeches', 'time', 'route'));
//    }
//
//    public function storeListeningExamAttempt(Request $request)
//    {
//        dd($request->all());
//        $student = session()->get('student');
//        $listeningAnswers = $request->get('listeningAnswers');
//        $marks = Exam::getListeningMarks($listeningAnswers);
//        $message=" solved listening exam and has {".$marks."}";
//        Logging::logStudent(auth()->user()->getStudent(), $message);
//        $student->sumAllMarks(session()->get('student-' . $student->id . '-grammar'), session()->get('student-' . $student->id . '-reading'), $marks);
//        $this->logout();
//        return redirect(route('success'))->with('message', 'You will know your grades soon');
//    }

    public function logout()
    {
        $student = session()->get('student');
//        Cache::forget('student-' . $student->id . '-grammar');
//        Cache::forget('student-' . $student->id . '-reading');
        Cache::forget('student-is-online-' . $student->id);
//        session()->forget([ 'student-' . $student->id . '-grammar','student-' . $student->id . '-reading']);
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
