<?php

namespace App\Providers;

use App\Config;
use App\Providers\ClosedReservation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class GenerateGroups
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ClosedReservation $event
     * @return void
     */
    public function handle(ClosedReservation $event)
    {

        $reservation = $event->reservation;
        $groups = $reservation->groups;
//        dd($groups);
        $counter=1;
        $groups->each(function ($group) use ($counter, $reservation) {
            $studentsCount = $group->students->count();
            $computers = Config::first()->value;
            if ($studentsCount > 0) {
                //divide the max number on the computers number to get the groups number
                $groupsNumber = ceil($studentsCount / $computers);
                for ($i = 0; $i < $groupsNumber; $i++) {
                    $createdGroup = $reservation->groups()->create([
                        'name' => 'Group ' . ($counter).'( '.$group->type->type.' )',
                        'group_type_id' => $group->type->id
                    ]);
                    $counter++;
                    $index = $i * $computers;
                    $students = $group->students->slice($index, $computers);
                    DB::table('students')->whereIn('id',$students->pluck('id')->toArray())
                        ->update(['group_id' => $createdGroup->id]);
//                    $students->each(function ($student) use ($createdGroup) {
//                        $student->update(['group_id' => $createdGroup->id]);
//                    });
//                    DB::table('students')->whereIn('id',$students);

                }


            }

            $check=$group->delete();
        });


    }

}
