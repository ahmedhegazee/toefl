<?php
namespace App;

use App\Grammar\GrammarExam;
use App\Grammar\GrammarOption;
use App\Jobs\EndExamJob;
use App\Listening\ListeningExam;
use App\Listening\ListeningOption;
use App\Providers\ExamIsEnded;
use App\Providers\ExecuteJobs;
use App\Reading\ParagraphQuestionOption;
use App\Reading\ReadingExam;
use App\Reading\VocabOption;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class Exam
{
    public static function checkExamIsRunning($exam)
    {
        return Cache::has('reservation-' . $exam->reservation->id . '-exam-is-running');
    }

    public static function isStopped(Group $group)
    {
        return Cache::has('exam-group-' . $group->id . '-is-stopped');
    }

    private static function makeCache($name)
    {
        $expiresAt = Carbon::now()->addHours(5);
        Cache::put($name, true, $expiresAt);
        $message = " make cache which its name is  " . $name . " for 8 hours";
        Logging::logAdmin(auth()->user(), $message);
    }

    public static function studentsCanEnterExam(Group $group)
    {
        Exam::makeCache('group-can-enter-exam-' . $group->id);
        Exam::makeCache('reservation-' . $group->reservation->id . '-exam-is-running');
    }

    public static function studentsCanStartExam(Group $group)
    {
        EndExamJob::dispatch($group, auth()->user())->delay(Carbon::now()->addHours(5));
        Exam::makeCache('group-can-start-exam-' . $group->id);
    }

    public static function isExamEntered(Group $group)
    {
        return Cache::has('group-can-enter-exam-' . $group->id);
    }

    public static function isExamStarted(Group $group)
    {
        return Cache::has('group-can-start-exam-' . $group->id);
    }

    public static function isExamWorking(Group $group)
    {
        return Exam::isExamStarted($group) && Exam::isExamEntered($group);
    }

    public static function closeExam(Group $group)
    {
        if (Exam::isExamStarted($group))
            Cache::forget('group-can-start-exam-' . $group->id);
        if (Exam::isExamEntered($group))
            Cache::forget('group-can-enter-exam-' . $group->id);
        if (Exam::checkExamIsRunning($group))
            Cache::forget('reservation-' . $group->reservation->id . '-exam-is-running');
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
//        event(new ExamIsEnded());
               EndExamJob::dispatch($group, auth()->user())->delay(Carbon::now()->addMicroseconds(500));

//            event(new ExamIsEnded($group,auth()->user()));

    }

    public static function getGrammarMarks($answers)
    {
        return collect($answers)->map(function ($answer) {
            return GrammarOption::find($answer)->correct;
        })->sum();
    }

    public static function getReadingMarks($vocab, $paragraphs)
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
