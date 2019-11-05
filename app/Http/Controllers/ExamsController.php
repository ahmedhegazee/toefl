<?php

namespace App\Http\Controllers;

use App\Config;
use App\Grammar\GrammarExam;
use App\Grammar\GrammarOption;
use App\Grammar\GrammarQuestion;
use App\Reading\ParagraphQuestionOption;
use App\Reading\ReadingExam;
use App\Reading\VocabOption;

use Illuminate\Http\Request;

class ExamsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check_student');

    }

    public function showStudentHome()
    {
        $student=auth()->user()->getStudent();

        session([
            'student'=>$student,
            'groupType'=>$student->group->type->id,
            'reservation'=>$student->reservation->id
        ]);
        $fullName =auth()->user()->name;
        return view('exams.home',compact('fullName','student'));
    }

    public function showGrammarExam()
    {
        $reservation =session()->get('reservation');
        $groupType =session()->get('groupType');

        $grammareExam= GrammarExam::where('reservation_id',$reservation)
                                    ->where('group_type_id',$groupType)->get()->first();
        $fillQuestions=$grammareExam->getFillQuestions;
        $findQuestions=$grammareExam->getFindQuestions;
        $time=Config::find(2)->value;

//        return view('exams.grammarExam',compact('time','questions'));
        return view('exams.grammarExam',compact('fillQuestions','findQuestions','time'));
    }
    public function storeGrammarExamAttempt(Request $request)
    {
        $student =session()->get('student');

        $questions = $request->get('qid');
       $answers= $request->get('answers');
        $marks=0;
        foreach ($questions as $question){
            $questionId = intval($question);
            $q = GrammarQuestion::find($questionId);
            if(isset($answers[$questionId])){
                $optionId=intval($answers[$questionId]);
                $option=GrammarOption::find($optionId);
                $student->grammarAnswers()->create([
                    'grammar_question_id'=>$q->id,
                    'grammar_option_id'=>$option->id
                ]);
                if($option->correct)
                    $marks++;
            }else{
                $student->grammarAnswers()->create([
                    'grammar_question_id'=>$q->id,
                    'grammar_option_id'=>null
                ]);
            }

        }
        $student->grammarResults()->create([
            'marks'=>$marks
        ]);
        return redirect()->action("ExamsController@showReadingExam");
    }
public function showReadingExam()
    {
        $reservation =session()->get('reservation');
        $groupType =session()->get('groupType');

        $readingeExam= ReadingExam::where('reservation_id',$reservation)
                                    ->where('group_type_id',$groupType)->get()->first();
        $vocabQuestions=$readingeExam->vocabQuestions;
        $paragraphs=$readingeExam->paragraphs;

        $time=Config::find(3)->value;
//        return view('exams.grammarExam',compact('time','questions'));
        return view('exams.readingExam',compact('vocabQuestions','paragraphs','time'));
    }
    public function storeReadingExamAttempt(Request $request)
    {
        $student =session()->get('student');
        $vocabQuestions = $request->get('vocabQuestions');
        $vocabAnswers= $request->get('vocabAnswers');
        $paragraphs = $request->get('paragraphs');
        $paragraphQuestions = $request->get('paragraphQuestions');
        $paragraphAnswers= $request->get('paragraphAnswers');
        $marks=0;
        foreach ($vocabQuestions as $question){
            $questionId = intval($question);
//            $q = VocabQuestion::find($questionId);
            if(isset($vocabAnswers[$questionId])){
                $optionId=intval($vocabAnswers[$questionId]);
                $option=VocabOption::find($optionId);
                $student->vocabAnswers()->create([
                    'vocab_question_id'=>$questionId,
                    'vocab_option_id'=>$option->id
                ]);
                if($option->correct)
                    $marks++;
            }else{
                $student->vocabAnswers()->create([
                    'vocab_question_id'=>$questionId,
                    'vocab_option_id'=>null
                ]);
            }

        }
        //to reach every paragraph
        foreach ($paragraphs as $paragraph){
          $questions=  $paragraphQuestions[intval($paragraph)]['questions'];
          // to reach every question in every paragraph
            foreach ($questions as $question){
                if(isset($paragraphAnswers[intval($paragraph)]['questions'])){
                    $selectedQuestions=$paragraphAnswers[intval($paragraph)]['questions'];
                    if(isset($selectedQuestions[intval($question)])){
                        $question=intval($question);
                        $selectedQuestion =$selectedQuestions[$question];
                        $optionId=intval($selectedQuestion);
                        $option=ParagraphQuestionOption::find($optionId);
                        $student->paragraphAnswers()->create([
                            'paragraph_id'=>intval($paragraph),
                            'paragraph_question_id'=>$question,
                            'paragraph_question_option_id'=>$option->id
                        ]);
                        if($option->correct)
                            $marks++;
                    }
                }
               else{
                    $student->paragraphAnswers()->create([
                        'paragraph_id'=>intval($paragraph),
                        'paragraph_question_id'=>intval($question),
                        'paragraph_question_option_id'=>null
                    ]);
                }
            }
        }
        $student->readingResults()->create([
            'marks'=>$marks
        ]);
        return "You have in reading exam ".$marks;
    }

}
