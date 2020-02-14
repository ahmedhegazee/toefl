<?php

namespace App\Http\Middleware\StudentMiddlewares;

use App\Attempt;
use App\Exam;
use App\Jobs\StoreStudentResultJob;
use App\Student;
use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class checkStudent
{
    public function isVerified(Student $student)
    {
        return  $student->isVerified();
    }
    public function CanEnterExam(Student $student)
    {
        return  $student->CanEnterExam();

//            auth()->user()->getStudent()->enterexam==1;
    }
    public function CanStartExam(Student $student)
    {
        return  $student->CanStartExam();

//            auth()->user()->getStudent()->enterexam==1;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//dd('hello');
        $student =auth()->user()->getStudent();
//        dd(Exam::isStopped($student->group));
        if(!$this->isVerified($student)){
            auth()->logout();
            return redirect(route('error'))->with('error','You Are Not Verified');
        }

        else if(Exam::isStopped($student->group)){
//            dd($request->path());
        if($request->method()=='POST'){
            $answers = $request->get('answers');
//            $grammar_marks = Exam::getGrammarMarks($answers);

            $vocabAnswers = $request->get('vocabAnswers');
            $paragraphAnswers = $request->get('paragraphAnswers');
//            $reading_marks = Exam::getReadingMarks($vocabAnswers,$paragraphAnswers);

            $listeningAnswers = $request->get('listeningAnswers');
            StoreStudentResultJob::dispatch($student,$answers,$vocabAnswers,$paragraphAnswers,$listeningAnswers,false)
                ->delay(Carbon::now()->addMinutes(1));

//            $listening_marks = Exam::getListeningMarks($listeningAnswers);
//            $marks=$grammar_marks+$reading_marks+$listening_marks;
//            $student->editResult($marks);

        }else if($request->path()=='active'){
            return $next($request);
        }
            Cache::forget('student-is-online-' . $student->id);
        auth()->logout();
        return redirect()->route('error')->with('error','Time is out. Don\'t worry all your answers are saved' );
    } else if( !$this->canEnterExam($student)){
            auth()->logout();
            return redirect(route('error'))->with('error','You Are Not Allowed to Enter Exam');
        }

        else
        return $next($request);
    }
}
