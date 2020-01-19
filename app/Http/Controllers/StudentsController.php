<?php

namespace App\Http\Controllers;


use App\Reservation;
use App\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
    public function verifiedOptions()
    {
        return [
            1=>'Verified',
            0=>'Not Verified',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
//        $students= Student::paginate(15);
//        return view('students.index',compact('students'));
   $students=Student::all()->map(function($student){
      return[
         'id'=> $student->id,
          'Arabic Name'=>$student->arabic_name,
          'English Name'=>$student->user->name,
          'phone'=>$student->phone,
          'email'=>$student->user->email,
          'verified'=>$student->verified,
          'Studying Degree'=>$student->studying,
          'Required Score'=>$student->required_score,
          'Actions'=>'',
          'failed'=>$student->results->last()->success?true:false,
      ] ;
   });
   return response()->json($students);
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
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return view('students.show',compact('student'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return view('students.update',compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request, Student $student)
    {

        $checkEmail = true;
        $checkEnglishName = true;
        $checkArabicName = true;
        $checkRequiredScore = true;
        $checkStudyingDegree = true;
        $checkPhone = true;
        $checkGroupType = true;


        if (strlen($request->name) > 0)
            $checkEnglishName = $student->user->update([
                'name' => $request->name,
            ]);
        if (strlen($request->arabic_name) > 0)
            $checkArabicName = $student->update([
                'arabic_name' => $request->arabic_name,
            ]);

        if (strlen($request->email) > 0)
            $checkEmail = $student->user->update([
                'email' => $request->email,
            ]);
        if ($request->required_score > 0)
            $checkRequiredScore = $student->update([
                'required_score' => $request->required_score,
            ]);
        if ($request->studying > 0)
            $checkStudyingDegree = $student->update([
                'studying' => $request->studying,
            ]);
        if ($request->group_type > 0){
            $type=$request->group_type;
            $res=$student->reservation;
            $newGroup=$res->groups()->where('group_type_id',$type)->get()->last();
            if($newGroup->id!=$student->group->id)
            $checkGroupType = $student->update([
                'group_id' => $newGroup->id,
            ]);
            else
                $checkGroupType=false;
        }
        if (strlen($request->phone)>0){
            $checkPhone = $student->user->update([
                'password' => Hash::make($request->phone),
            ]);
            $student->update([
                'phone' => $request->phone,
            ]);
        }


        $check = $checkEmail && $checkEnglishName && $checkArabicName
                &&$checkRequiredScore&&$checkStudyingDegree&&$checkPhone
                &&$checkGroupType;
        return response()->json(['success' => $check]);

    }

    public function moveStudentToNewReservation(Request $request,Student $student)
    {
        if($request->has('res'))
        {
            $type=intval($request->get('type'));
            $oldGroup=$student->group;
            $oldReservation=$student->reservation;
            $res=intval($request->get('res'));
            $newReservation=Reservation::findOrFail($res);
            $newGroup=$newReservation->groups()->where('group_type_id',$type)->get()->last();
            if(
                $oldGroup->id!=$newGroup->id
                &&$oldReservation->id!=$newReservation->id
            ){
                $student->update([
                    'res_id'=>$newReservation->id,
                    'group_id'=>$newGroup->id,
                ]);
                return response()->json(['success'=>true]);
            }else{
                return response()->json(['success'=>false,'message'=>'choose another resrvation and group type']);
            }

        }

}
    public function verifyStudent(Student $student)
    {
        $student->update([
//                'required_score'=>intval($request['required_score']),
            'verified'=>1
        ]);
        return view('cpanel.studentspanel');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */

    public function destroy(Student $student)
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
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
            'phone'=>'required|string|unique:students',
            'personalimage'=>'sometimes|file|image|max:5120',
            'nidimage'=>'sometimes|file|image|max:5120',
            'certificateimage'=>'sometimes|file|image|max:5120',
            'messageimage'=>'sometimes|file|image|max:5120',
        ]);
    }


}
