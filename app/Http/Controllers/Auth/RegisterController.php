<?php

namespace App\Http\Controllers\Auth;

use App\Config;
use App\Group;
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
            'phone'=>'required|string|unique:students',
            'personalimage'=>'required|image|max:5120',
            'nidimage'=>'required|image|max:5120',
            'certificateimage'=>'required|image|max:5120',
            'messageimage'=>'required|image|max:5120',
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
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data,Reservation $res)
    {

       $user= $this->createUser($data);

        $this->createStudent($user,$data,$res);

       return $user;
    }

    public function createUser($data)
    {
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

//ll
        Student::create([
            'uid'=> $user->id,
            'phone'=>$data['phone'],
            'arabic_name'=>$data['arabic_name'],
            'personalimage'=>$data['personalimage']->store('personalimages','public'),
            'nidimage'=>$data['nidimage']->store('nidimages','public'),
            'certificateimage'=>$data['certificateimage']->store('certificateimages','public'),
            'messageimage'=>$data['messageimage']->store('messageimages','public'),
            'res_id'=>$res->id,
            'group_id'=>intval($data['type']),
            'gender'=>intval($data['gender']),
            'studying'=>intval($data['studying']),
        ]);
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
