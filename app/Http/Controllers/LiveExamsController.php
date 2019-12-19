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

class LiveExamsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function showGrammarExam(GrammarExam $exam)
    {
        $fillQuestions = $exam->getFillQuestions;
        $findQuestions = $exam->getFindQuestions;
        $time = Config::find(2)->value;
        $route=route('grammar.live.exam.submit');
        return view('exams.grammarExam', compact('fillQuestions', 'findQuestions', 'time','route'));
    }

    public function storeGrammarExamAttempt(Request $request)
    {
        $answers = $request->get('answers');
        $marks= collect($answers)->map(function($answer) {
            return GrammarOption::find($answer)->correct;
        })->sum();
       return "you have ".$marks . ' in this exam';
    }

    public function showReadingExam(ReadingExam $exam)
    {
        $vocabQuestions = $exam->vocabQuestions;
        $paragraphs = $exam->paragraphs;
        $time = Config::find(3)->value;
        $route=route('reading.live.exam.submit');
        return view('exams.readingExam', compact('vocabQuestions', 'paragraphs', 'time','route'));
    }

    public function storeReadingExamAttempt(Request $request)
    {
        $vocabAnswers = $request->get('vocabAnswers');
        $paragraphAnswers = $request->get('paragraphAnswers');
        $vocabMarks=collect($vocabAnswers)->map(function($answer){
            return VocabOption::find($answer)->correct();
        })->sum();
        $paragraphMarks=collect($paragraphAnswers)->map(function($answer){
            return ParagraphQuestionOption::find($answer)->correct();
        })->sum();
        $marks = $vocabMarks+$paragraphMarks;
        return "you have ".$marks . ' in this exam';
    }

    public function showListeningExam(ListeningExam $exam)
    {
        $shortConversations = $exam->audios->where('audio_type_id', 1);
        $longConversations = $exam->audios->where('audio_type_id', 2);
        $speeches = $exam->audios->where('audio_type_id', 3);
        $time = Config::find(4)->value;
        $route=route('listening.live.exam.submit');
        return view('exams.listeningExam', compact('shortConversations', 'longConversations', 'speeches', 'time','route'));
    }

    public function storeListeningExamAttempt(Request $request)
    {
        $listeningAnswers = $request->get('listeningAnswers');
        $marks = collect($listeningAnswers)->map(function ($answer){
            return ListeningOption::find($answer)->correct;
        })->sum();
        return "you have ".$marks . ' in this exam';
    }
}
