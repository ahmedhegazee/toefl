<?php

namespace App\Http\Controllers\ApiControllers;

use App\Attempt;
use App\Certificate;
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
use function foo\func;


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

    public function printPDF(Request $request, Group $group)
    {

        $startDate = Carbon::parse($request->start)->format('d-m-yy');
        $endDate = Carbon::parse($request->end)->format('d-m-yy');
        $certificateNumbering = Config::find(8);
        $centerManager = Config::find(5)->value;
        $FacultyDean = Config::find(6)->value;
        $vicePresident = Config::find(7)->value;
        $count = intval($certificateNumbering->value);
        $students = $group->students()->with('results')->get()
            ->filter(function ($student) use ($group) {
                if ($student->results()->count() > 0) {
                    $attempt = Attempt::where('reservation_id', $group->reservation->id)->where('student_id', $student->id)->get()->first();
                    return $attempt->result->success == 1;
                }

            });
        foreach ($students as $student) {
            if ($student->certificates->where('reservation_id', $group->reservation->id)->count() == 0) {
                $attempt = Attempt::where('reservation_id', $group->reservation->id)->where('student_id', $student->id)->get()->first();
                $student->certificates()->create([
                        'reservation_id' => $group->reservation->id,
                        'result_id' => $attempt->result->id,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'studying_degree' => $group->reservation->students->where('id', $student->id)->first()->pivot->studying,
                        'no' => $count++
                    ]
                );
            }
        }
        $certificates= $students->map(function($student) use ($group) {
            return $student->certificates->where('reservation_id', $group->reservation->id)->first();
        });
        $certificateNumbering->update([
            'value' => $count
        ]);
        $message = "print certificates of reservation id " .$group->reservation->id . " which has start data is " . $group->reservation->start;
        Logging::logAdmin(auth()->user(), $message);
        return view('certificate', compact('certificates', 'count', 'centerManager', 'FacultyDean', 'vicePresident', 'startDate', 'endDate'));
//        return $pdf->download('certificates ' . $reservation->start . ' . pdf');

    }

    public function printStudentCertificate(Student $student, Certificate $certificate)
    {

        $centerManager = Config::find(5)->value;
        $FacultyDean = Config::find(6)->value;
        $vicePresident = Config::find(7)->value;

        $message = "print certificate of student id " . $student->id . " which no is " . $certificate->no;
        Logging::logAdmin(auth()->user(), $message);
        return view('students.certificate', compact('centerManager', 'FacultyDean', 'vicePresident', 'certificate', 'student'));
//        return $pdf->download('certificates ' . $reservation->start . ' . pdf');

    }

    public function getStudentsForCertificates(Group $group)
    {
        $students = $group->students()->get()
            ->filter(function($student) use ($group){
                $attempt = Attempt::where('reservation_id', $group->reservation->id)->where('student_id', $student->id)->get()->first();

                if (!is_null($attempt->result))
                   return $attempt->result->success == 1;
            })
            ->map(function ($student)  use ($group){
                $attempt = Attempt::where('reservation_id', $group->reservation->id)->where('student_id', $student->id)->get()->first();
                        return [
                            "ID" => $student->id,
                            "English Name" => $student->user->name,
                            "Arabic Name" => $student->arabic_name,
                            "Email" => $student->user->email,
                            "Phone Number" => $student->phone,
                            "Score" => $attempt->result->mark,
                        ];
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
                    "Verified" => $student->getVerifiedAttribute($student->reservation->last()->pivot->verified),
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

    public function getFailedStudents(Group $group)
    {


        $students = $group->students()->get()
            ->filter(function ($student) use ($group) {
                $attempt = Attempt::where('reservation_id', $group->reservation->id)->where('student_id', $student->id)->get()->first();

                if (!is_null($attempt->result))
                    return  !$attempt->result->success;
            })
            ->map(function ($student) {

                return [
                    "ID" => $student->id,
                    "english_name" => $student->user->name,
                    "arabic_name" => $student->arabic_name,
                    "Degree" => $student->getStudyingAttribute($student->reservation->last()->pivot->studying),
                    "score" => $student->results->last()->mark,
                    "required_score" => $student->reservation->last()->pivot->required_score,
                    "Actions" => ""
                ];
            })->values()->all();
        return response()->json($students);
    }

    public function getClosedReservations()
    {

        $reservations = Reservation::closed(1)->get()->filter(function ($reservation) {
            return $reservation->groups->where("is_examined", 1)->count() > 0;
        })->map(function ($reservation) {
            return [
                'id' => $reservation->id,
                'start' => $reservation->start
            ];
        })->toArray();
        return response()->json($reservations);
    }

    public function getExaminedGroups(Reservation $res)
    {
        return response()->json($res->groups()->where('is_examined', 1)->get(['id', 'name'])->toArray());
    }

    public function getExaminedStudents(Group $group)
    {
        $students = Student::getExaminedStudents($group->students);
        $count = $students->count();
        $students = $students->all();
        return response()->json(['students' => $students, 'count' => $count]);
    }

    public function retakeExamAgain(Request $request)
    {
        $reservation = Reservation::find($request->get('reservation'));
        $group = Group::find($request->get('group'));
        $students = Student::whereIn('id', $request->get('students'))->get()->filter(function ($student) use ($reservation, $group) {
            $attempt = Attempt::where('student_id', $student->id)
                ->where('reservation_id', $reservation->id)
                ->where('group_id', $group->id)->get()->first();
            return $student->results->last()->success == 0 && $attempt->result->id == $student->results->last()->id;
        });
//        dd($students);
        $ids = $students->each(function ($student) {
            $student->attempts->last()->result->delete();
            $student->attempts->last()->delete();
        })->pluck('id')->all();
        if (sizeof($ids)) {
            $reservation->update(['is_examined' => 0]);
            $group->update(['is_examined' => 0]);
        }
        return response()->json($ids);
    }

//    public function getReservations()
//    {
////        return response()->json(Reservation::where('is_examined', 1)->get(['id', 'start'])->toArray());
//        return response()->json(Reservation::closed(1)->get(['id', 'start'])->toArray());
//    }

    public function getReservationsForExams()
    {
//        return response()->json(Reservation::where('is_examined', 0)->get(['id', 'start'])->toArray());
        return response()->json(Reservation::examined(0)->closed(1)->get(['id', 'start'])->toArray());
    }

    public function getGroups(Reservation $res)
    {
        return response()->json($res->groups()->where('is_examined', 0)->get(['id', 'name'])->toArray());
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
//        $reservations = Reservation::where('start', ' <= ', now()->toDateString())->closed(0)->get();

//            ->where('end', ' >= ', now()->toDateString())


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
                'text' => 'Ms . c(Master)',
                'value' => 1,
            ],
            [
                'text' => 'PhD(Doctor)',
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
        if ($data->has('grammar')) {
            $grammarAnswers = collect($data->get('grammar'));
            $marks += Exam::getGrammarMarks($grammarAnswers);
        }

        if ($data->has('listening')) {
            $listeningAnswers = collect($data->get('listening'));
            $marks += Exam::getListeningMarks($listeningAnswers);
        }

        if($data->has('vocab')&&$data->has('paragraph')){
            $vocabAnswers = collect($data->get('vocab'));
            $paragraphAnswers = collect($data->get('paragraph'));
            $marks += Exam::getReadingMarks($vocabAnswers, $paragraphAnswers);
        }
        $student->editResult($marks);

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
