<?php

namespace App\Http\Controllers\ApiControllers;

use App\Exam;
use App\Grammar\GrammarExam;
use App\Group;
use App\Http\Controllers\Controller;
use App\Listening\ListeningExam;
use App\Reading\ReadingExam;
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
    public function isExamEntered(Group $group)
    {
        $check = Cache::has('group-can-enter-exam-' . $group->id);
        return response()->json(['success' => $check]);
    }

    public function isExamStarted(Group $group)
    {
        $check = Cache::has('group-can-start-exam-' . $group->id);
        return response()->json(['success' => $check]);

    }

    public function isExamWorking(Group $group)
    {
        $check = ['success' => (Cache::has('group-can-enter-exam-' . $group->id) && Cache::has('group-can-start-exam-' . $group->id))];
        return response()->json($check);
    }

    public function isGroupHasExams(Group $group)
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
        $check = $grammarExam && $readingExam && $listeningExam;
        return response()->json(['success' => $check]);
    }
}
