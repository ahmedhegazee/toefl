<?php

namespace App\Http\Controllers;

use App\Config;
use App\Reservation;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentsController extends Controller
{
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
    public function create()
    {
        return view('students.create');
    }



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
        //
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user= $this->createUser($this->validateUserData());
        $this->createStudent($user,$this->validateStudentData());

        return view('students.index');
    }
    public function createUser($data)
    {
        $user=  User::create([
            'name' => $data['name'],
            'email'=>$data['email'],
//            'password' => Hash::make('password'),
            'password' => Hash::make($data['phone']),
            'role_id'=>2
        ]);
        return $user;
    }
    public function createStudent($user,$data)
    {
        $res = $this->getAvailableReservation();
        $groupID=$this->getAvailableGroup($res);
        Student::create([
            'uid'=> $user->id,
            'phone'=>$data['phone'],
            'personalimage'=>$data['personalimage']->store('personalimages','public'),
            'nidimage'=>$data['nidimage']->store('nidimages','public'),
            'certificateimage'=>$data['certificateimage']->store('certificateimages','public'),
            'messageimage'=>$data['messageimage']->store('messageimages','public'),
            'res_id'=>$res->id,
            'group_id'=>$groupID

        ]);
    }

    public function getAvailableReservation()
    {
        $reservations= Reservation::where('start','<=',now()->toDateString())
            ->where('end','>=',now()->toDateString())
            ->where('done','!=',1)->get();
        $res= $reservations->first()->id;

        return $res;

}

    public function getAvailableGroup(Reservation $res)
    {
        $computers = Config::first()->value;
        $groupID=0;
        $groups=$res->groups;

        foreach ($groups as $group){
            if($group->students->count()<$computers){
                $groupID=$group->id;
                break;
            }
        }
        return $groupID;
}

    public function storePersonalImage()
    {

}
    public function validateUserData()
    {
        return \request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'phone'=>'required|string|unique:students',
        ]);
    }

    public function validateStudentData()
    {
        return \request()->validate([
            'phone'=>'required|string|unique:students',
            'personalimage'=>'required|file|image|max:5120',
            'nidimage'=>'required|file|image|max:5120',
            'certificateimage'=>'required|file|image|max:5120',
            'messageimage'=>'required|file|image|max:5120',
        ]);
    }
}
