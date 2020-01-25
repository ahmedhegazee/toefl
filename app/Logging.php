<?php
namespace App;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Logging{
    public static function logAdmin(User $user,$message)
    {
        $time =Carbon::now()->toDateTimeString();
        $data="This admin ".$user->name." ".$message." at ".$time;
        Log::channel('adminSteps')->info($data);

    }
    public static function logProfessor(User $user,$message)
    {
        $time =Carbon::now()->toDateTimeString();
        $data="This professor ".$user->name." ".$message." at ".$time;
        Log::channel('profSteps')->info($data);
    }
    public static function logStudent(Student $student,$message)
    {
        $time =Carbon::now()->toDateTimeString();
        $data="This student ".$student->user->name." ".$message." at ".$time;
        Log::channel('studentsSteps')->info($data);
    }
}
?>
