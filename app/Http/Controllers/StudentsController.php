<?php

namespace App\Http\Controllers;


use App\Student;

use Illuminate\Http\Request;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students= Student::paginate(15);
        return view('students.index',compact('students'));
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        Validator::make($request->all(),[
            'required_score'=>'numbers|min:300'
        ]);

            $student->update([
                'required_score'=>intval($request['required_score']),
                'verified'=>1
            ]);
            return redirect(route('student.index'));
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
