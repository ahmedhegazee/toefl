<?php

namespace App\Http\Controllers;

use App\Attempt;
use App\Grammar\GrammarExam;
use App\Group;
use App\Listening\ListeningExam;
use App\Reading\ReadingExam;
use App\Reservation;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class ApiController extends Controller
{
    public function checkStudentAttempt(Student $student)
    {
        $count = Attempt::where('student_id', $student->id)
            ->where('reservation_id', $student->reservation->id)
            ->where('group_id', $student->group->id)->get()->count();
        if ($count > 0) {

            if (
                session()->has('student-' . $student->id . '-grammar') ||
                session()->has('student-' . $student->id . '-reading') ||
                !is_null($student->attempts->last()->result)
            )
                return response()->make("you can't delete this attempt.The student has solved the exam");
            else {
                $student->attempts->last()->delete();

                return response()->make("Successful deleting");
            }
        } else
            return response()->make("the student doesn't have attempt in this reservation");
    }

    public function printPDF(Reservation $reservation)
    {
        $students = $reservation->students()->with('results')->get()
            ->filter(function ($student) {
                if ($student->results()->count() > 0)
                    if ($student->results->last()->success == 1)
                        return true;
                    else
                        return false;
            });
        $html = View::make('certificate', compact('students'));
        $pdf = App::make('dompdf.wrapper');
//   $pdf= $pdf->setOptions(['isHtml5ParserEnabled' => true]);
        $pdf->setPaper('letter', 'landscape');
        $pdf->loadHTML($html)->stream();
//    return view('certificate', compact('students'));
//    $pdf = PDF::loadView('certificate', $students);
        return $pdf->download('certificates ' . $reservation->start . '.pdf');

    }

    public function getStudentsForCertificates(Reservation $reservation)
    {
        $students = $reservation->students()->get()
            ->map(function ($student) {
                if (!is_null($student->results->last()))
                    if ($student->results->last()->success == 1)
                        return [
                            "ID" => $student->id,
                            "English Name" => $student->user()->name,
                            "Arabic Name" => $student->arabic_name,
                            "Email" => $student->user()->email,
                            "Phone Number" => $student->phone,
                            "Score" => $student->results->last()->mark,
                        ];
            })->filter(function ($student) {
                return !is_null($student);
            })->values()->all();
        return response()->json($students);
    }

    public function studentsCanEnterExam(Group $group)
    {
        $expiresAt = Carbon::now()->addHours(4);
        Cache::put('group-can-enter-exam-' . $group->id, true, $expiresAt);
    }

    public function studentsCanStartExam(Group $group)
    {
        $expiresAt = Carbon::now()->addHours(4);
        Cache::put('group-can-start-exam-' . $group->id, true, $expiresAt);
    }

    public function endExam(Group $group)
    {
        if (Cache::has('group-can-enter-exam-' . $group->id)) {
            $group->students()->each(function ($student) {
                $attempt = Attempt::where('student_id', $student->id)
                    ->where('reservation_id', $student->reservation->id)
                    ->where('group_id', $student->group->id)->get();
//                if ($attempt->count() == 0) {
//                    $student->attempts()->create([
//                        'reservation_id'=>$student->reservation->id,
//                        'group_id'=>$student->group->id,
//                    ]);
//                }
                if ($attempt->count() != 0)
                    if (is_null($attempt->first->result)) {
                        $grammar = 0;
                        $reading = 0;
                        if (session()->has('student-' . $student->id . '-grammar'))
                            $grammar = session()->get('student-' . $student->id . '-grammar');
                        elseif (session()->has('student-' . $student->id . '-reading'))
                            $reading = session()->get('student-' . $student->id . '-reading');

                        $student->sumAllMarks($grammar, $reading, 0);
                    }

            });
        }
        Cache::forget('group-can-start-exam-' . $group->id);
        Cache::forget('group-can-enter-exam-' . $group->id);

    }

    public function getStudents(Group $group)
    {
        $students = $group->students()->get()
            ->map(function ($student) {
                return [
                    "ID" => $student->id,
                    "English Name" => $student->user()->name,
                    "Arabic Name" => $student->arabic_name,
                    "Email" => $student->user()->email,
                    "Phone Number" => $student->phone,
                    "Verified" => $student->verified,
                    "Active" => $student->isOnline(),
                    "Actions" => ""
                ];
            })->values()->all();
        return response()->json($students);
    }

    public function getFailedStudents(Reservation $reservation)
    {
        $students = $reservation->students()->get()
            ->filter(function ($student) {
                if (!is_null($student->results->last()))
                    if (
                        !$student->results->last()->success
                        && $student->results->last()->mark != 0
                    )
                        return $student;
            })
            ->map(function ($student) {

                return [
                    "ID" => $student->id,
                    "english_name" => $student->user()->name,
                    "arabic_name" => $student->arabic_name,
                    "Degree" => $student->studying,
                    "score" => $student->results->last()->mark,
                    "required_score" => $student->required_score,
                    "Actions" => ""
                ];
            })->values()->all();

        return response()->json($students);
    }

    public function getReservations()
    {
        return response()->json(Reservation::get(['id', 'start'])->toArray());
    }

    public function getGroups(Reservation $res)
    {
        return response()->json($res->groups()->get(['id', 'name'])->toArray());
    }

    public function isExamEntered(Group $group)
    {
        return response()->json(Cache::has('group-can-enter-exam-' . $group->id));

    }

    public function isExamStarted(Group $group)
    {
        return response()->json(Cache::has('group-can-start-exam-' . $group->id));

    }

    public function isExamWorking(Group $group)
    {
        return response()->json((Cache::has('group-can-enter-exam-' . $group->id) && Cache::has('group-can-start-exam-' . $group->id)));
    }

    public function isGroupHasExams(Group $group)
    {
        $reservation = $group->reservation->id;
        $groupType = $group->type->id;
        $grammarExam = GrammarExam::where('reservation_id', $reservation)
                ->where('group_type_id', $groupType)->get()->count() > 0;
        $readingExam = ReadingExam::where('reservation_id', $reservation)
                ->where('group_type_id', $groupType)->get()->count() > 0;
        $listeningExam = ListeningExam::where('reservation_id', $reservation)
                ->where('group_type_id', $groupType)->get()->count() > 0;
        return $grammarExam && $readingExam && $listeningExam;
    }

    public function getRoles($roles)
    {
        $data = '';
        foreach ($roles as $role)
            $data .= $role['title'] . " , ";
        return $data;
    }

    public function getAllUsers()
    {
        $users = User::all();
        $data = $users->filter(function ($user) {
            if (!$user->roles->contains(2))
                return $user;
        })->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $this->getRoles($user->roles->toArray()),
                'Actions' => '',
            ];
        })->all();
        return response()->json($data);

    }

    public function updateStudentMarks(Request $request)
    {
        $student = Student::findOrFail($request->id);
        $check = false;
        $currentScore = $student->results->last()->mark;
        $requiredScore = $student->required_score;
        $score = $request->score;
        if ($score < 500 && $score > $currentScore && $score >= $requiredScore) {
            $check = $student->results->last()->update(
                [
                    'mark' => $request->score,
                    'success' => 1
                ]
            );

        } else {
            $check = false;
        }


        return response()->json(['success' => $check]);
    }
}
