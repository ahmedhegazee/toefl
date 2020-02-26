<?php

namespace App\Http\Controllers;


use App\Attempt;
use App\Logging;
use App\Providers\ClosedReservation;
use App\Reservation;
use App\Student;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StudentsController extends Controller
{
    public function verifiedOptions()
    {
        return [
            1 => 'Verified',
            0 => 'Not Verified',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
//        $students= Student::paginate(15);
//        return view('students.index',compact('students'));
        $students = [];
        $count = 0;
//        dd($request->all());
        if ($request->has('filter') || ($request->has('filter') && $request->has('page'))) {

            $reservations = Reservation::where('start', '>=', $request->get('filter'))->get()->pluck('id');
            $studentsQuery=   DB::table('student_reservation')->whereIn('reservation_id',$reservations)->latest();
//            $studentsQuery = Student::whereIn('res_id', $reservations)->orderBy('created_at', 'desc');
//            $studentsQuery = Student::all()->orderBy('created_at', 'desc');
            $ids=$studentsQuery->pluck('student_id')->toArray();
            $count = $studentsQuery->get()->count();
            $students = Student::getStudents(Student::whereIn('id',$ids)->paginate(50));
//            dd($students);

            $students = $students->all();
        } elseif ($request->has('phone')) {
            $studentsQuery = Student::where('phone', $request->get('phone'))->orderBy('created_at', 'desc');
            $students = Student::getStudents($studentsQuery->paginate(50));
            $count = Student::getStudents($studentsQuery->get())->count();
        } else {
            $students = Student::getStudents(Student::latest()->paginate(50));
            $count = Student::all()->count();
        }

        return response()->json(['students' => $students, 'count' => $count]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create()
//    {
//        $reservations =$this->getAvailableReservations();
//       $options=$this->verifiedOptions();
//        return view('students.create',compact('reservations','options'));
//    }


    /**
     * Display the specified resource.
     *
     * @param \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Student $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return view('students.update', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Student $student
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request, Student $student)
    {
        $data = [];
        $user_data = [];
        $checkUpdate = true;
        $checkUserUpdate = true;
//        $checkGroupType = true;

        if (strlen($request->name) > 0) {
            $message = " update student account with id is " . $student->id . " and old name is" . $student->user->name . " new name is " . $request->name;
            Logging::logAdmin(auth()->user(), $message);
            $user_data['name'] = $request->name;
//            $checkEnglishName = $student->user->update([
//                'name' => $request->name,
//            ]);
        }

        if (strlen($request->arabic_name) > 0) {
            $message = " update student account with id is " . $student->id . " and old name is" . $student->arabic_name . " new name is " . $request->arabic_name;
            Logging::logAdmin(auth()->user(), $message);
            $data['arabic_name'] = $request->arabic_name;
//            $checkArabicName = $student->update([
//                'arabic_name' => $request->arabic_name,
//            ]);
        }


        if (strlen($request->email) > 0) {
            $message = " update student account with id is " . $student->id . " and old email is" . $student->user->email . " new email is " . $request->email;

            Logging::logAdmin(auth()->user(), $message);
            $user_data['email'] = $request->email;
//            $checkEmail = $student->user->update([
//                'email' => $request->email,
//            ]);
        }

        if ($request->required_score > 0) {
            $message = " update student account with id is " . $student->id . " and old required score is" . $student->reservation->last()->required_score . " new required score is " . $request->required_score;
            Logging::logAdmin(auth()->user(), $message);
            $student->reservation()->updateExistingPivot($student->reservation->last()->id, ['required_score' => $request->required_score]);
//            $data['required_score'] =$request->required_score ;

//            $checkRequiredScore = $student->update([
//                'required_score' => $request->required_score,
//            ]);
        }
        $studyingOption = [

            1 => 'Ms.c(Master)',
            2 => 'PhD(Doctor)',
            3 => 'Board certified',
        ];
        if ($request->studying > 0) {
            $message = " update student account with id is " . $student->id . " and old studying degree is" . $student->reservation->last()->studying . " new studying degree is "
                . $studyingOption[$request->studying];
            Logging::logAdmin(auth()->user(), $message);
            $student->reservation()->updateExistingPivot($student->reservation->last()->id, ['studying' => $request->studying]);

//            $data['studying'] = $request->studying;

//            $checkStudyingDegree = $student->update([
//                'studying' => $request->studying,
//            ]);
        }

//        if ($request->group_type > 0) {
//            $type = $request->group_type;
//            $res = $student->reservation;
//            $newGroup = $res->groups()->where('group_type_id', $type)->get()->last();
//            if ($newGroup->id != $student->group->id)
//            {
//                $message = " update student account with id is " . $student->id . " and old group is" . $student->group_id . " new group is " . $newGroup->id;
//                Logging::logAdmin(auth()->user(), $message);
//                $data['group_id']=$newGroup->id;
//
////                $checkGroupType = $student->update([
////                    'group_id' => $newGroup->id,
////                ]);
//            }
//            else{
//
//                $checkGroupType = false;
//            }
//
//        }
        if (strlen($request->phone) > 0) {
            $user_data['password'] = Hash::make($request->phone);
            $data['phone'] = $request->phone;

//            $checkPhone = $student->user->update([
//                'password' => Hash::make($request->phone),
//            ]);
            $message = "update student account with id is " . $student->id . " and phone is" . $student->phone . " phone is " . $request->phone;
            Logging::logAdmin(auth()->user(), $message);

//            $student->update([
//                'phone' => $request->phone,
//            ]);
        }
        if (!empty($data)) {
            $checkUpdate = $student->update($data);
        }
        if (!empty($user_data)) {
            $checkUserUpdate = $student->user->update($user_data);
        }

//        $check =  $checkGroupType&&$checkUpdate&&$checkUserUpdate;
        $check = $checkUpdate && $checkUserUpdate;

        return response()->json(['success' => $check]);

    }

    public function moveStudentToNewReservation(Request $request, Student $student)
    {
        if ($request->has('res')) {
            $type = intval($request->get('type'));
            $oldGroup = $student->group->last();
            $oldReservation = $student->reservation->last();
            $res = intval($request->get('res'));
            $newReservation = Reservation::findOrFail($res);
            $newGroup = $newReservation->groups()->where('group_type_id', $type)->get()->last();
            if (
                $oldGroup->id != $newGroup->id
                && $oldReservation->id != $newReservation->id
            ) {

//                dd($request->get('failed'));
                if($request->get('failed')=='true'){
                    $studying = $request->get('studying');
                    $required_score = $request->get('required_score');
                    $certificate=$this->getImageLink($request->file('certificate'), 'certificateimages');
                   $message= $this->getImageLink($request->file('message'), 'messageimages');
                    $document=$student->documents()->create([
                        'certificate_document'=>$certificate,
                        'message_document'=>$message
                    ]);
                    $document=$document->id;
                }

                else
                {
                    $studying=$student->reservation->last()->pivot->studying;
                    $required_score=$student->reservation->last()->pivot->required_score;
                    $document=$student->documents->last()->id;
                }
                $newReservation->students()->attach([
                    $student->id=>[
                        'studying'=>$studying,
                        'required_score'=>$required_score,
                        'student_documents_id'=>$document,
                        'verified'=>0
                    ]
                ]);
                $newGroup->students()->attach($student->id);
//                $student->update([
//                    'res_id' => $newReservation->id,
//                    'group_id' => $newGroup->id,
//                ]);
                if ($newReservation->students->count() == $newReservation->max_students ) {
                    event(new ClosedReservation($newReservation));
                }
                $message = " move student with id {" . $student->id . "} from reservation with id {" . $oldReservation . "} to reservation with id {" . $newReservation . "}";
                Logging::logAdmin(auth()->user(), $message);
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'choose another resrvation and group type']);
            }

        }

    }

    public function verifyStudent(Student $student)
    {
        $message = " verify student with id {" . $student->id . "} ";
        Logging::logAdmin(auth()->user(), $message);
        $student->reservation()->updateExistingPivot($student->reservation->last()->id, ['verified' => 1]);
//        $student->update([
////                'required_score'=>intval($request['required_score']),
//            'verified' => 1
//        ]);
        return redirect()->to(route('cpanel.students-panel'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param \App\Student $student
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateImages(Request $request, Student $student)
    {
        $data = [];
        $documents_data = [];
        if ($request->files->has('personalImage')) {
            $this->deleteImage($student->personalimage);
            $data['personalimage'] = $this->getImageLink($request->file('personalImage'), 'personalimages');
        }
        if ($request->files->has('nidImage')) {

            $this->deleteImage($student->nidimage);

            $data['nidimage'] = $this->getImageLink($request->file('nidImage'), 'nidimages');
        }
        if ($request->files->has('certificateImage')) {
            $this->deleteImage($student->documents->last()->certificate_document);
            $documents_data['certificate_document'] = $this->getImageLink($request->file('certificateImage'), 'certificateimages');
        }
        if ($request->files->has('messageImage')) {
            $this->deleteImage($student->documents->last()->message_document);
            $documents_data['message_document'] = $this->getImageLink($request->file('messageImage'), 'messageimages');
        }
        $check = false;
        $documents_check = false;
        if (!empty($data)) {
            $check = $student->update($data);
        }
        if (!empty($documents_data)) {
            $documents_check = $student->documents->last()->update($documents_data);
        }
        if ($check||$documents_check)
            return response()->json(['success' => true]);
        else
            return response()->json(['success' => false, 'message' => "Cannot changing student's images.Please call support"]);


    }

    public function deleteImage($image)
    {
        $imageDirectory = public_path('storage/' . $image);
        if (file_exists($imageDirectory))
            unlink($imageDirectory);
    }

    public function getImageLink(UploadedFile $image, $imgKind)
    {
        $encryptedName = sha1(now()->toTimeString());
        $dir = public_path('/storage/' . $imgKind);
        $imageName = $encryptedName . '.' . $image->getClientOriginalExtension();
        $image->move($dir, $imageName);
        sleep(1);
        return $imgKind . '/' . $imageName;
    }

    public function destroy(Student $student)
    {
        //
    }

    public function getCertificates(Student $student)
    {
        $certificates = $student->certificates->map(function ($certificate) use ($student) {
            return [
                'text' => $certificate->no . " - " . $certificate->reservation->start . " - " . $student->getStudyingAttribute($certificate->studying_degree),
                'value' => $certificate->no,
            ];
        })->values()->all();
        return response()->json($certificates);
    }

    public function getStudentReservations(Student $student)
    {
      $reservations=  $student->reservation->map(function ($reservation) use ($student) {
          $attempt=Attempt::where('reservation_id', $reservation->id)->where('student_id', $student->id)->get()->first();
//          dd(is_null($attempt));
          $result='';
          if(is_null($attempt))
          {
              $result='not examined yet';
          }elseif (is_null($attempt->result)){
              $result="doesn't have result";
          }
          else{
                $result=$attempt->result->mark;
          }
            return[
                'text'=>$reservation->start.' - '.$result.' - '.$student->getStudyingAttribute($reservation->pivot->studying)
            ];
        })->all();
        return response()->json($reservations);
    }
//    public function validator(array $data)
//    {
//        return Validator::make($data, [
//            'name' => 'required|string|max:255',
//            'email' => 'required|string|email|unique:users',
//            'phone'=>'required|string|unique:students',
//            'personalimage'=>'required|image|max:5120',
//            'nidimage'=>'required|image|max:5120',
//            'certificateimage'=>'required|image|max:5120',
//            'messageimage'=>'required|image|max:5120',
//            'reservation'=>'required|numeric',
//        ]);}
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
//    public function store(Request $request)
//    {
//        //dd($request->all());
//        $vali=$this->validator($request->all())->validate();
////        $vali=$this->validator($request->all());
//
//        $user= $this->createUser($request);
//        $this->createStudent($user,$request);
//
//        return redirect(route('student.index'));
//    }
//    public function createUser($data)
//    {
//        $user=  User::create([
//            'name' => $data['name'],
//            'email'=>$data['email'],
////            'password' => Hash::make('password'),
//            'password' => Hash::make($data['phone']),
//            'role_id'=>2
//        ]);
//        return $user;
//    }
//    public function createStudent($user,$data)
//    {
//
//        $res = $this->getAvailableReservation();
//        $groupID=$this->getAvailableGroup($res);
//       $st= Student::create([
//            'uid'=> $user->id,
//            'phone'=>$data['phone'],
//            'personalimage'=>'',
//            'nidimage'=>"",
//            'certificateimage'=>"",
//            'messageimage'=>"",
//            'res_id'=>$res->id,
//            'group_id'=>$groupID
//
//        ]);
//        $this->storeImages($st);
//    }
//
//    public function getAvailableReservation()
//{
//    $reservations= Reservation::where('start','<=',now()->toDateString())
//        ->where('done','!=',1)->get();
//    $res= $reservations->first();
//
//    return $res;
//
//}
//public function getAvailableReservations()
//{
//    $reservations= Reservation::where('start','<=',now()->toDateString())
//        ->where('done','!=',1)->get();
//
//    return $reservations;
//
//}
//
//    public function getAvailableGroup(Reservation $res)
//    {
//        $computers = Config::first()->value;
//        $groupID=0;
//        $groups=$res->groups;
//
//        foreach ($groups as $group){
//            if($group->students->count()<$computers){
//                $groupID=$group->id;
//                break;
//            }
//        }
//        return $groupID;
//}
//
//    public function storeImages(Student $student)
//    {
//        if(\request()->has('personalimage')){
//
//            $student->update([
//                'personalimage'=>\request()->personalimage->store('personalimages','public')
//            ]);
//        }
//        if(\request()->has('nidimage')){
//
//            $student->update([
//                'nidimage'=>\request()->nidimage->store('nidimages','public')
//            ]);
//        }
//        if(\request()->has('certificateimage')){
//
//            $student->update([
//                'certificateimage'=>\request()->personalimage->store('certificateimages','public')
//            ]);
//        }
//        if(\request()->has('messageimage')){
//
//            $student->update([
//                'messageimage'=>\request()->nidimage->store('messageimages','public')
//            ]);
//        }
//}


    public function validateData()
    {
        return \request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'phone' => 'required|string|unique:students',
            'personalimage' => 'sometimes|file|image|max:5120',
            'nidimage' => 'sometimes|file|image|max:5120',
            'certificateimage' => 'sometimes|file|image|max:5120',
            'messageimage' => 'sometimes|file|image|max:5120',
        ]);
    }


}
