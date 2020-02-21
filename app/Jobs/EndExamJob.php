<?php

namespace App\Jobs;

use App\Attempt;
use App\Logging;
use App\Providers\ExamIsEnded;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class EndExamJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $group;
    public $user;

    /**
     * Create a new job instance.
     * @param $group
     * @param $user
     */
    public function __construct($group, $user)
    {
        $this->group = $group;
        $this->user = $user;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (
            Cache::has('group-can-enter-exam-' . $this->group->id)
            && Cache::has('group-can-start-exam-' . $this->group->id)
            && $this->group->is_examined != 1) {
            $message = " end exam  for group with id is " . $this->group->id;
            Logging::logAdmin($this->user, $message);
            $this->group->students()->each(function ($student) {
                $attempt = $student->attempts()->where('reservation_id', $student->reservation->last()->id)
                    ->where('group_id', $student->group->last()->id)->get();
                $grammar = 0;
                $reading = 0;
                //if the student didn't came to take the exam
                if ($attempt->count() == 0) {
                    $student->attempts()->create([
                        'reservation_id' => $student->reservation->last()->id,
                        'group_id' => $student->group->last()->id,
                    ]);

                }
                //if the student came but he didn't finish in the time
                if (is_null($attempt->first()->result)) {

//                    if (Cache::has('student-' . $student->id . '-grammar')) {
//                        $grammar = Cache::get('student-' . $student->id . '-grammar');
//                        Cache::forget('student-' . $student->id . '-grammar');
//                    } elseif (Cache::has('student-' . $student->id . '-reading')) {
//                        $reading = Cache::get('student-' . $student->id . '-reading');
//                        Cache::forget('student-' . $student->id . '-reading');
//                    }
                    $student->sumAllMarks($grammar, $reading, 0);

                }

            });

            $expiresAt = Carbon::now()->addHours(5);
            Cache::put('exam-group-' . $this->group->id . '-is-stopped', true, $expiresAt);
            Cache::forget('group-can-start-exam-' . $this->group->id);
            Cache::forget('group-can-enter-exam-' . $this->group->id);
            Cache::forget('reservation-' . $this->group->reservation->id . '-exam-is-running');

            $this->group->update(['is_examined' => 1]);
            if ($this->group->reservation->isAllGroupsExamined()) {
                $this->group->reservation->update(['is_examined' => 1]);
            }
        }
    }
}
