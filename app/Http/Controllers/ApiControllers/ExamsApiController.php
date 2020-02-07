<?php

namespace App\Http\Controllers\ApiControllers;

use App\Exam;
use App\Grammar\GrammarExam;
use App\Group;
use App\Http\Controllers\Controller;
use App\Listening\ListeningExam;
use App\Reading\ReadingExam;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ExamsApiController extends Controller
{
    public function studentsCanEnterExam(Group $group)
    {
        Exam::studentsCanEnterExam($group);

    }

    public function studentsCanStartExam(Group $group)
    {
        Exam::studentsCanStartExam($group);
    }

    public function endExam(Group $group)
    {
        Exam::endExam($group);

    }
    public function closeExam(Group $group)
    {
        Exam::closeExam($group);

    }
    public function isExamEntered(Group $group)
    {
        $check = Exam::isExamEntered($group);
        return response()->json(['success' => $check]);
    }

    public function isExamStarted(Group $group)
    {
        $check = Exam::isExamStarted($group);
        return response()->json(['success' => $check]);

    }

    public function isExamWorking(Group $group)
    {
        $check = ['success' => Exam::isExamWorking($group)];
        return response()->json($check);
    }

    public function isGroupHasExams(Group $group)
    {
        return response()->json(['success' => Exam::isGroupHasExams($group)]);
    }

    public function isGroupExamined(Group $group)
    {
        return response()->json(['success' => $group->is_examined]);
    }
    public function isReservationExamined(Reservation $res)
    {
        return response()->json(['success' => $res->is_examined]);
    }
}
