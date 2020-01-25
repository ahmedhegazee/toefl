<?php
namespace App;
 use App\Grammar\GrammarExam;
use App\Grammar\GrammarOption;
use App\Listening\ListeningExam;
use App\Listening\ListeningOption;
use App\Reading\ParagraphQuestionOption;
use App\Reading\ReadingExam;
use App\Reading\VocabOption;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class Exam{
    public static function checkExamIsRunning($exam)
    {
        return Cache::has('reservation-'.$exam->reservation->id.'-exam-is-running');
    }

    public static function isStopped(Group $group)
    {
       return Cache::has('exam-group-' . $group->id.'-is-stopped');
    }
    private static function makeCache($name){
        $expiresAt = Carbon::now()->addHours(8);
        Cache::put($name, true, $expiresAt);
        $message = " make cache which its name is  " . $name . " for 8 hours";
        Logging::logAdmin(auth()->user(), $message);
    }
    public static function studentsCanEnterExam(Group $group)
    {
        Exam::makeCache('group-can-enter-exam-' . $group->id);
        Exam::makeCache('reservation-'.$group->reservation->id.'-exam-is-running');
    }

    public static function studentsCanStartExam(Group $group)
    {
        Exam::makeCache('group-can-start-exam-' . $group->id);
    }

    public static function isExamEntered(Group $group)
    {
        return Cache::has('group-can-enter-exam-' . $group->id);
    }
    public static function isExamStarted(Group $group)
    {
        return  Cache::has('group-can-start-exam-' . $group->id);
    }

    public static function isExamWorking(Group $group)
    {
        return Exam::isExamStarted($group)&&Exam::isExamEntered($group);
    }

    public static function closeExam(Group $group)
    {
        if(Exam::isExamStarted($group))
        Cache::forget('group-can-start-exam-' . $group->id);
        if(Exam::isExamEntered($group))
        Cache::forget('group-can-enter-exam-' . $group->id);
        if(Exam::checkExamIsRunning($group))
        Cache::forget('reservation-'.$group->reservation->id.'-exam-is-running');
    }
    public static function isGroupHasExams(Group $group)
    {
//        dd($group);
        $reservation = $group->reservation->id;
//        $groupType = $group->type->id;
//        $grammarExam = GrammarExam::where('reservation_id', $reservation)
//                ->where('group_type_id', $groupType)->get()->count() > 0;
//        $readingExam = ReadingExam::where('reservation_id', $reservation)
//                ->where('group_type_id', $groupType)->get()->count() > 0;
//        $listeningExam = ListeningExam::where('reservation_id', $reservation)
//                ->where('group_type_id', $groupType)->get()->count() > 0;
        $grammarExam = GrammarExam::where('reservation_id', $reservation)
                ->get()->count() > 0;
        $readingExam = ReadingExam::where('reservation_id', $reservation)
                ->get()->count() > 0;
        $listeningExam = ListeningExam::where('reservation_id', $reservation)
                ->get()->count() > 0;
        return $grammarExam && $readingExam && $listeningExam;
    }
    public static function endExam(Group $group)
    {

        if (
            Cache::has('group-can-enter-exam-' . $group->id)
            && Cache::has('group-can-start-exam-' . $group->id)
        ) {
            $message = " end exam  for group with id is" . $group->id ;
            Logging::logAdmin(auth()->user(), $message);
            $group->students()->each(function ($student) {
                $attempt = Attempt::where('student_id', $student->id)
                    ->where('reservation_id', $student->reservation->id)
                    ->where('group_id', $student->group->id)->get();
                $grammar = 0;
                $reading = 0;
                //if the student didn't came to take the exam
                if ($attempt->count() == 0) {
                    $student->attempts()->create([
                        'reservation_id' => $student->reservation->id,
                        'group_id' => $student->group->id,
                    ]);
                    //-1 means the student didn't attend.
                    $grammar = -1;
                }
                //if the student came but he didn't finish in the time
                if (is_null($attempt->first->result)) {

                    if (Cache::has('student-' . $student->id . '-grammar')) {
                        $grammar = Cache::get('student-' . $student->id . '-grammar');
                        Cache::forget('student-' . $student->id . '-grammar');
                    } elseif (Cache::has('student-' . $student->id . '-reading')) {
                        $reading = Cache::get('student-' . $student->id . '-reading');
                        Cache::forget('student-' . $student->id . '-reading');
                    }


                    $student->sumAllMarks($grammar, $reading, 0);

                }

            });
        }
        $expiresAt = Carbon::now()->addMinutes(5);
        Cache::put('exam-group-' . $group->id.'-is-stopped', true, $expiresAt);
        Cache::forget('group-can-start-exam-' . $group->id);
        Cache::forget('group-can-enter-exam-' . $group->id);
        Cache::forget('reservation-'.$group->reservation->id.'-exam-is-running');

    }

    public static function getGrammarMarks($answers)
    {
        return collect($answers)->map(function ($answer) {
            return GrammarOption::find($answer)->correct;
        })->sum();
    }

    public static function getReadingMarks($vocab,$paragraphs)
    {
        $vocabMarks = collect($vocab)->map(function ($answer) {
            return VocabOption::find($answer)->correct;
        })->sum();
        $paragraphMarks = collect($paragraphs)->map(function ($answer) {
            return ParagraphQuestionOption::find($answer)->correct;
        })->sum();
        return $vocabMarks + $paragraphMarks;
    }

    public static function getListeningMarks($answers)
    {
        return collect($answers)->map(function ($answer) {
            return ListeningOption::find($answer)->correct;
        })->sum();
    }


}
?>
