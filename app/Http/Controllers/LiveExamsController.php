<?php

namespace App\Http\Controllers;

use App\Config;
use App\Grammar\GrammarExam;
use App\Grammar\GrammarOption;
use App\Grammar\GrammarQuestion;
use App\Listening\ListeningExam;
use App\Listening\ListeningOption;
use App\Logging;
use App\Reading\ParagraphQuestionOption;
use App\Reading\ReadingExam;
use App\Reading\VocabOption;
use Illuminate\Http\Request;

class LiveExamsController extends Controller
{


    public function showGrammarExam(GrammarExam $exam)
    {
        $fillQuestions = $exam->getFillQuestions;
        $findQuestions = $exam->getFindQuestions;
        $time = Config::find(2)->value;
        $message=" display grammar exam live {".$exam->id."} ";
        Logging::logProfessor(auth()->user(),$message);
        $route=route('grammar.live.exam.submit');
        return view('exams.grammarExam', compact('fillQuestions', 'findQuestions', 'time','route'));
    }

    public function storeGrammarExamAttempt(Request $request)
    {
        $answers = $request->get('answers');
        $marks= collect($answers)->map(function($answer) {
            return GrammarOption::find($answer)->correct;
        })->sum();
        $message=" have ".$marks . ' in this grammar exam ';
        Logging::logProfessor(auth()->user(),$message);
       return "you have ".$marks . ' in this exam';
    }

    public function showReadingExam(ReadingExam $exam)
    {
        $vocabQuestions = $exam->vocabQuestions;
        $paragraphs = $exam->paragraphs;
        $time = Config::find(3)->value;
        $message=" display reading exam live {".$exam->id."} ";
        Logging::logProfessor(auth()->user(),$message);
        $route=route('reading.live.exam.submit');
        return view('exams.readingExam', compact('vocabQuestions', 'paragraphs', 'time','route'));
    }

    public function storeReadingExamAttempt(Request $request)
    {
        $vocabAnswers = $request->get('vocabAnswers');
        $paragraphAnswers = $request->get('paragraphAnswers');
        $vocabMarks=collect($vocabAnswers)->map(function($answer){
            return VocabOption::find($answer)->correct;
        })->sum();
        $paragraphMarks=collect($paragraphAnswers)->map(function($answer){
            return ParagraphQuestionOption::find($answer)->correct;
        })->sum();
        $marks = $vocabMarks+$paragraphMarks;
        $message=" have ".$marks . ' in this reading exam ';
        Logging::logProfessor(auth()->user(),$message);
        return "you have ".$marks . ' in this exam';
    }

    public function showListeningExam(ListeningExam $exam)
    {
        $shortConversations = $exam->audios->where('audio_type_id', 1);
        $longConversations = $exam->audios->where('audio_type_id', 2);
        $speeches = $exam->audios->where('audio_type_id', 3);
        $time = Config::find(4)->value;
        $message=" display listening exam live {".$exam->id."} ";
        Logging::logProfessor(auth()->user(),$message);
        $route=route('listening.live.exam.submit');
        return view('exams.listeningExam', compact('shortConversations', 'longConversations', 'speeches', 'time','route'));
    }

    public function storeListeningExamAttempt(Request $request)
    {
        $listeningAnswers = $request->get('listeningAnswers');
        $marks = collect($listeningAnswers)->map(function ($answer){
            return ListeningOption::find($answer)->correct;
        })->sum();
        $message=" have ".$marks . ' in this listening exam ';
        Logging::logProfessor(auth()->user(),$message);
        return "you have ".$marks . ' in this exam';
    }
}
