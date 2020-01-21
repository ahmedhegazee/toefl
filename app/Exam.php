<?php
namespace App;
 use App\Grammar\GrammarExam;
use App\Listening\ListeningExam;
use App\Reading\ReadingExam;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class Exam{
    private static function makeCache($name){
        $expiresAt = Carbon::now()->addHours(4);
        Cache::put($name, true, $expiresAt);
        $message = " make cache which its name is  " . $name . " for 4 hours";
        Logging::logAdmin(auth()->user(), $message);
    }
    public static function studentsCanEnterExam(Group $group)
    {
        Exam::makeCache('group-can-enter-exam-' . $group->id);
    }

    public static function studentsCanStartExam(Group $group)
    {
        Exam::makeCache('group-can-start-exam-' . $group->id);
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
                if ($attempt->count() == 0) {
                    $student->attempts()->create([
                        'reservation_id' => $student->reservation->id,
                        'group_id' => $student->group->id,
                    ]);
                    //-1 means the student didn't attend.
                    $grammar = -1;
                }
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
        Cache::forget('group-can-start-exam-' . $group->id);
        Cache::forget('group-can-enter-exam-' . $group->id);


    }


}
?>
