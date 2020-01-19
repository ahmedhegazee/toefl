<?php

namespace App\Http\Controllers;

use App\Attempt;
use App\Config;
use App\Grammar\GrammarExam;
use App\Group;
use App\GroupType;
use App\Listening\ListeningExam;
use App\Reading\ReadingExam;
use App\Reservation;
use App\Role;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
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
        if (
            Cache::has('group-can-enter-exam-' . $group->id)
            && Cache::has('group-can-start-exam-' . $group->id)
        ) {

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
                    ) {
//                        dump($student);
                        return $student;
                    }
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
        $users = $users->filter(function ($user) {
            if (!$user->roles->contains(2))
                return $user;
        })->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $this->getRoles($user->roles->toArray()),
                'selectedRoles' => $user->roles->pluck('id')->toArray(),
                'Actions' => '',
            ];
        })->values();
        $roles = Role::all()
            ->map(function ($role) {

                if ($role->id == 1 || $role->id == 2)
                    return [
                        'value' => $role->id,
                        'text' => $role->title,
                        'disabled' => true,
                    ];
                else
                    return [
                        'value' => $role->id,
                        'text' => $role->title
                    ];
            })->values();
        $data = [
            'users' => $users,
            'roles' => $roles
        ];
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

    public function getConfigs()
    {
        $configs = Config::all()->map(function ($config) {
            return [
                'id' => $config->id,
                'name' => $config->name,
                'value' => $config->value,
                'actions' => ''
            ];
        });
        return response()->json($configs);
    }

    public function updateConfig(Request $request)
    {
        $config = Config::findOrFail($request->id);
//        dd($request);
        $check = $config->update([
            'value' => $request->value,
        ]);
        return response()->json(['success' => $check]);
    }

    public function updateUser(Request $request, User $user)
    {
//        dd($request);
        $checkEmail = true;
        $checkName = true;
        $checkPassword = true;


        if (strlen($request->name) > 0)
            $checkName = $user->update([
                'name' => $request->name,
            ]);
        if (strlen($request->email) > 0)
            $checkEmail = $user->update([
                'email' => $request->email,
            ]);
        if (strlen($request->password) > 0)
            $checkPassword = $user->update([
                'password' => Hash::make($request->password),
            ]);
        $check = $checkEmail && $checkName && $checkPassword;
        return response()->json(['success' => $check]);
    }

    public function updateUserRoles(Request $request, User $user)
    {
//        dd($request);
        $user->roles()->sync($request->roles);
        return response()->json(['success' => true]);
    }

    public function addNewUser(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
        ]);
        $user->roles()->attach(1);
        $data = [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $this->getRoles($user->roles->toArray()),
                'selectedRoles' => $user->roles->pluck('id')->toArray(),
                'Actions' => '',
            ],
            'success' => true
        ];
        return response()->json($data);
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

    public function destroyUser(User $user)
    {
        $user->roles()->sync([]);
        $user->delete();

    }

    public function getAvailableReservations()
    {
        $reservations = Reservation::where('start', '<=', now()->toDateString())
            ->where('end', '>=', now()->toDateString())
            ->where('done', '!=', 1)->get();
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
                'value'=>1,
            ],
            [
                'text' => 'PhD (Doctor)',
                'value'=>2,
            ],
            [
                'text' => 'Board certified',
                'value'=>3,
            ],
        ];
        $data = [
            'reservations' => $reservations,
            'groupTypes' => $types,
            'studyingDegrees' => $studyingDegrees,
        ];
        return response()->json($data);
    }
}
