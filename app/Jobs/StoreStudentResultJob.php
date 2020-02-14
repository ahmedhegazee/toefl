<?php

namespace App\Jobs;

use App\Exam;
use App\Logging;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class StoreStudentResultJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $student;
    public $grammarAnswers;
    public $listeningAnswers;
    public $paragraphAnswers;
    public $vocabAnswers;
    public $newResult;

    /**
     * Create a new job instance.
     *
     * @param $student
     * @param $grammarAnswers
     * @param $vocabAnswers
     * @param $paragraphAnswers
     * @param $listeningAnswers
     * @param $newResult
     */
    public function __construct($student, $grammarAnswers, $vocabAnswers, $paragraphAnswers, $listeningAnswers, $newResult)
    {
        $this->student=$student;
        $this->grammarAnswers=$grammarAnswers;
        $this->vocabAnswers=$vocabAnswers;
        $this->paragraphAnswers=$paragraphAnswers;
        $this->listeningAnswers=$listeningAnswers;
        $this->newResult=$newResult;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sleep(30);

        $grammar_marks = Exam::getGrammarMarks($this->grammarAnswers);

        $reading_marks = Exam::getReadingMarks($this->vocabAnswers,$this->paragraphAnswers);

        $listening_marks = Exam::getListeningMarks($this->listeningAnswers);
        //Logs
        $message=" solved grammar exam and has {".$grammar_marks."}";
        Logging::logStudent($this->student, $message);
        $message=" solved reading exam and has {".$reading_marks."}";
        Logging::logStudent($this->student, $message);
        $message=" solved listening exam and has {".$listening_marks."}";
        Logging::logStudent($this->student, $message);
        if($this->newResult)
        $this->student->sumAllMarks($grammar_marks,$reading_marks,$listening_marks);
        else
        {
            $marks=$grammar_marks+$reading_marks+$listening_marks;
            $this->student->editResult($marks);
        }
    }
}
