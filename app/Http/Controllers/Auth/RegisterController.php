<?php

namespace App\Http\Controllers\Auth;

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
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'phone'=>['required', 'string' ],
            'personalimage'=>['required','image','max:5120'],
            'nidimage'=>['required','image','max:5120'],
            'certificateimage'=>['required','image','max:5120'],
            'messageimage'=>['required','image','max:5120'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

       $user= $this->createUser($data);

        $this->createStudent($user,$data);

     //dd($st);
       return $user;
    }

    public function createUser($data)
    {
      $user=  User::create([
            'name' => $data['name'],
            'email'=>$data['email'],
            'password' => Hash::make('password'),
            'role_id'=>2
        ]);
        return $user;
    }
    public function createStudent($user,$data)
    {
        Student::create([
            'uid'=> $user->id,
            'phone'=>$data['phone'],
            'personalimage'=>$data['personalimage']->store('personalimages','public'),
            'nidimage'=>$data['nidimage']->store('nidimages','public'),
            'certificateimage'=>$data['certificateimage']->store('certificateimages','public'),
            'messageimage'=>$data['messageimage']->store('messageimages','public'),
        ]);
}

}
