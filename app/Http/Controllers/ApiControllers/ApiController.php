<?php

namespace App\Http\Controllers\ApiControllers;

use App\Attempt;
use App\Config;
use App\Exam;
use App\Group;
use App\GroupType;
use App\Http\Controllers\Controller;
use App\Logging;
use App\Reservation;
use App\Student;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ApiController extends Controller
{
    public function checkStudentAttempt(Student $student)
    {
        $count = Attempt::where('student_id', $student->id)
            ->where('reservation_id', $student->reservation->id)
            ->where('group_id', $student->group->id)->get()->count();
        if ($count > 0) {

            if (
//                Cache::has('student-' . $student->id . '-grammar') ||
//                Cache::has('student-' . $student->id . '-reading') ||
            !is_null($student->attempts->last()->result)
            ) {
                $message = "can't delete this attempt {" . $student->attempts->last()->id . "}.The student has solved the exam whose id " . $student->id . " and name is " . $student->user->name;
                Logging::logAdmin(auth()->user(), $message);
                return response()->make("you can't delete this attempt.The student has solved the exam");

            } else {
                $message = " delete this attempt {" . $student->attempts->last()->id . "} of this student whose id " . $student->id . " and name is " . $student->user->name;
                Logging::logAdmin(auth()->user(), $message);
                $student->attempts->last()->delete();

                return response()->make("Successful deleting");
            }
        } else {
            $message = "can't delete this attempt.The student doesn't have attempt in this reservation whose id " . $student->id . " and name is " . $student->user->name;
            Logging::logAdmin(auth()->user(), $message);
            return response()->make("the student doesn't have attempt in this reservation");

        }
    }

    public function printPDF(Request $request, Reservation $reservation)
    {
        $students = $reservation->students()->with('results')->get()
            ->filter(function ($student) {
                if ($student->results()->count() > 0)
                    if ($student->results->last()->success == 1)
                        return true;
                    else
                        return false;
            });
        $centerManager = Config::find(5)->value;
        $FacultyDean = Config::find(6)->value;
        $vicePresident = Config::find(7)->value;
        $certificateNumbering = Config::find(8);
        $count = intval($certificateNumbering->value);
        $certificateNumbering->update([
            'value' => $count + $students->count()
        ]);
        $startDate = Carbon::parse($request->start)->format('d-m-yy');
        $endDate = Carbon::parse($request->end)->format('d-m-yy');
        $message = "print certificates of reservation id " . $reservation->id . " which has start data is " . $reservation->start;
        Logging::logAdmin(auth()->user(), $message);
        return view('certificate', compact('students', 'count', 'centerManager', 'FacultyDean', 'vicePresident', 'startDate', 'endDate'));
//        return $pdf->download('certificates ' . $reservation->start . '.pdf');

    }

    public function getStudentsForCertificates(Reservation $reservation)
    {
        $students = $reservation->students()->get()
            ->map(function ($student) {
                if (!is_null($student->results->last()))
                    if ($student->results->last()->success == 1)
                        return [
                            "ID" => $student->id,
                            "English Name" => $student->user->name,
                            "Arabic Name" => $student->arabic_name,
                            "Email" => $student->user->email,
                            "Phone Number" => $student->phone,
                            "Score" => $student->results->last()->mark,
                        ];
            })->filter(function ($student) {
                return !is_null($student);
            })->values()->all();
        return response()->json($students);
    }


    public function getStudents(Group $group)
    {
        $students = $group->students()->get()
            ->map(function ($student) {
                return [
                    "ID" => $student->id,
                    "English Name" => $student->user->name,
                    "Arabic Name" => $student->arabic_name,
                    "Email" => $student->user->email,
                    "Phone Number" => $student->phone,
                    "Verified" => $student->verified,
                    "Active" => $student->isOnline(),
                    "Actions" => ""
                ];
            })->values()->all();
        return response()->json([
            'students' => $students,
            'entered' => Exam::isExamEntered($group),
            'started' => Exam::isExamStarted($group),
            'has_exams' => Exam::isGroupHasExams($group),
        ]);
    }

    public function getFailedStudents(Reservation $reservation)
    {


        $students = $reservation->students()->get()
            ->filter(function ($student) {
                if (!is_null($student->results->last()))
                    if (
                        !$student->results->last()->success
//                        && $student->results->last()->mark > 0
                    ) {
//                        dump($student);
                        return $student;
                    }
            })
            ->map(function ($student) {

                return [
                    "ID" => $student->id,
                    "english_name" => $student->user->name,
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
//        return response()->json(Reservation::where('is_examined', 1)->get(['id', 'start'])->toArray());
        return response()->json(Reservation::examined(1)->get(['id', 'start'])->toArray());
    }
    public function getReservationsForExams()
    {
//        return response()->json(Reservation::where('is_examined', 0)->get(['id', 'start'])->toArray());
        return response()->json(Reservation::examined(0)->closed(1)->get(['id', 'start'])->toArray());
    }

    public function getGroups(Reservation $res)
    {
        return response()->json($res->groups()->get(['id', 'name'])->toArray());
    }

    public function updateStudentMarks(Request $request)
    {
        $student = Student::findOrFail($request->id);
        $check = false;
        $currentScore = $student->results->last()->mark;
        $requiredScore = $student->required_score;
        $score = $request->score;
        $message = "";
        if ($score < 500 && $score > $currentScore && $score >= $requiredScore) {
            $message = "update student mark whose name is " . $student->user->name . " and id is " . $student->id . " from " . $student->results->last()->mark . " to " . $score;
            $check = $student->results->last()->update(
                [
                    'mark' => $request->score,
                    'success' => 1
                ]
            );

        } else {
            $check = false;
            $message = "failed in updating student mark whose name is " . $student->user->name . " and id is " . $student->id . " from " . $student->results->last()->mark . " to " . $score;

        }
        Logging::logProfessor(auth()->user(), $message);


        return response()->json(['success' => $check]);
    }

    public function checkEmailIsUnique(Request $request)
    {
        if (strlen($request->email) == 0)
            $check = null;
        else
            $check = User::where('email', $request->email)->count() == 0;
        return response()->json(['check' => $check]);
    }

    public function checkPhoneIsUnique(Request $request)
    {
        $check = Student::where('phone', $request->phone)->count() == 0;
        return response()->json(['check' => $check]);
    }


    public function getAvailableReservations()
    {
        $reservations = Reservation::closed(0)->get();
//        $reservations = Reservation::where('start', '<=', now()->toDateString())->closed(0)->get();

//            ->where('end', '>=', now()->toDateString())


        $reservations = $reservations->map(function ($reservation) {
            return [
                'text' => $reservation->start . ' ' . $reservation->done,
                'value' => $reservation->id,
            ];
        })->values()->all();
        $types = GroupType::all()->map(function ($type) {
            return [
                'text' => $type->type,
                'value' => $type->id,
            ];
        });
        $studyingDegrees = [
            [
                'text' => 'Ms.c (Master)',
                'value' => 1,
            ],
            [
                'text' => 'PhD (Doctor)',
                'value' => 2,
            ],
            [
                'text' => 'Board certified',
                'value' => 3,
            ],
        ];
        $data = [
            'reservations' => $reservations,
            'groupTypes' => $types,
            'studyingDegrees' => $studyingDegrees,
        ];
        return response()->json($data);
    }

    public function editStudentResult(Request $request, Student $student)
    {
//        dd($request->data);

        $data = json_decode($request->data);
        $data = collect($data);
        $marks = 0;
        $grammarAnswers = collect($data->get('grammar'));
        $marks += Exam::getGrammarMarks($grammarAnswers);

        $listeningAnswers = collect($data->get('listening'));
        $marks += Exam::getListeningMarks($listeningAnswers);

        $vocabAnswers = collect($data->get('vocab'));
        $paragraphAnswers = collect($data->get('paragraph'));
        $marks += Exam::getReadingMarks($vocabAnswers, $paragraphAnswers);
        $student->editResult( $marks);

//        else{
//            if($checkGrammar){
//                $grammarAnswers=collect($data->get('grammar'));
//                $marks=Exam::getGrammarMarks($grammarAnswers);
//                $student->editResult($attempt,$marks);
//            }if($checkListening){
//                $listeningAnswers=collect($data->get('listening'));
//                $marks=Exam::getListeningMarks($listeningAnswers);
//                $student->editResult($attempt,$marks);
//            }if($checkVocab&&$checkParagraph){
//                $vocabAnswers=collect($data->get('vocab'));
//                $paragraphAnswers=collect($data->get('paragraph'));
//                $marks=Exam::getReadingMarks($vocabAnswers,$paragraphAnswers);
//                $student->editResult($attempt,$marks);
//            }
//        }
//        dd($data->vocab);
//        dd($data->grammar);
    }
}
