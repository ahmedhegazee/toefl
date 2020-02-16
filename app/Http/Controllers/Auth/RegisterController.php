<?php

namespace App\Http\Controllers\Auth;

use App\Config;
use App\Group;
use App\Providers\ClosedReservation;
use App\Reservation;
use App\Student;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('available');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules =[
            'name' => 'required|string|max:255',
            'arabic_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'phone'=>'required|string|unique:students|min:11|max:11',
            'personalimage'=>'required|image|max:5120',
            'nidimage'=>'required|image|max:5120',
            'certificateimage'=>'required|image|max:5120',
            'messageimage'=>'required|image|max:5120',
            'required_score'=>'numeric|min:300|max:700'
        ];
        $messages=[
            'personalimage.required'=>'personal image field is required',
            'nidimage.required'=>'national id image field is required',
            'certificateimage.required'=>'certificate image field is required',
            'messageimage.required'=>'message image field is required',
            'name.required'=>'full name field is required',
            'arabic_name.required'=>'arabic full name field is required',
            'personalimage.image'=>'you have to upload image to personal image field ',
            'nidimage.image'=>'you have to upload image to national id image field ',
            'certificateimage.image'=>'you have to upload image to certificate image field ',
            'messageimage.image'=>'you have to upload image to message image field ',
            'phone.unique'=>'this phone number is token',
            'email.unique'=>'this email is token',
        ];

//        dd($data['name']);
        return Validator::make($data,$rules,$messages );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @param Reservation $res
     * @return \App\User
     */
    protected function create(array $data,Reservation $res)
    {
        if ($res->students->count()==$res->max_students-1)
        {
            $user= $this->createUser($data);
            $this->createStudent($user,$data,$res);
            event(new ClosedReservation($res));
            return $user;
        }
        else{
            $user= $this->createUser($data);
            $this->createStudent($user,$data,$res);
            return $user;
        }



    }

    public function createUser($data)
    {
//        dd($data);
      $user=  User::create([
            'name' => $data['name'],
            'email'=>$data['email'],
//            'password' => Hash::make('password'),
            'password' => Hash::make($data['phone']),
        ]);

        $user->roles()->attach(2);
        return $user;
    }
    public function createStudent($user,$data,Reservation $res)
    {
        $group=$res->groups()->where('group_type_id',intval($data['type']))->first();
       $student= Student::create([
            'uid'=> $user->id,
            'phone'=>$data['phone'],
            'arabic_name'=>$data['arabic_name'],
            'personalimage'=>$data['personalimage']->store('personalimages','public'),
            'nidimage'=>$data['nidimage']->store('nidimages','public'),
           'gender'=>intval($data['gender']),
            ]);
      $document= $student->documents()->create([
           'certificate_document'=>$data['certificateimage']->store('certificateimages','public'),
           'message_document'=>$data['messageimage']->store('messageimages','public'),
       ]);
      $student->reservation()->attach([
              $res->id=>[
                  'studying'=>intval($data['studying']),
                  'required_score'=>intval($data['required_score']),
                  'student_documents_id'=>$document->id,
              ]
      ]
          );
       $group->students()->attach($student->id);
}
//    public function getAvailableReservation()
//    {
//        $reservations= Reservation::where('start','<=',now()->toDateString())
//            ->where('end','>=',now()->toDateString())
//            ->where('done','!=',1)->get();
//        $res= $reservations->first();
//
//        return $res;
//
//    }

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
//    }

}
