<?php

namespace App\Http\Middleware\StudentMiddlewares;

use App\Exam;
use App\Student;
use Closure;
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
            $path=$request->path();
            if($path=='exam/grammar'){
                $marks=Exam::getGrammarMarks($request->get('answers'));
                $attempt=$student->attempts->last()->id;
                $student->editResult($attempt,$marks);
            }
            else if($path=='exam/reading'){
                $marks=Exam::getReadingMarks($request->get('vocabAnswers'),$request->get('paragraphAnswers'));
                $attempt=$student->attempts->last()->id;
                $student->editResult($attempt,$marks);
            }
            else if($path=='exam/listening'){
                $marks=Exam::getListeningMarks($request->get('listeningAnswers'));
                $attempt=$student->attempts->last()->id;
                $student->editResult($attempt,$marks);
            }
        }
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
