<?php

namespace Illuminate\Foundation\Auth;

use App\GroupType;
use App\Providers\ClosedReservation;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $res=$this->getAvailableReservation();
        if($res!=null){
        $groups=$res->groups;
        return view('auth.register',compact('groups'));
        }
        else
            return redirect('/error')->with('error','Reservation is Not Available');

    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $res=$this->getAvailableReservation();
        if($res!=null){
            $this->validator($request->all())->validate();
            event(new Registered($user = $this->create($request->all(),$res)));
            $studentsCount = $res->students->count();
            $maxStudents = $res->max_students;
            $this->guard()->login($user);
            if($studentsCount==$maxStudents)
                event(new ClosedReservation($res));

            return $this->registered($request, $user)
                ?: redirect($this->redirectPath());

        }
        else
            return redirect(route('error'))->with('No available registration');

        // TODO:: solve many requsts in the same time
        /*
         *


//        if(isset($res)||$studentsCount!=$maxStudents){
//
//
//            $this->guard()->login($user);
//
//            return $this->registered($request, $user)
//                ?: redirect($this->redirectPath());
//        }
//        else
//        {
//            event(new ClosedReservation($res));
//        }
//         * */
//        if(isset($res)){
//            event(new Registered($user = $this->create($request->all())));
//
//
//        }
//        else
//            return redirect(route('error'))->with('No available registration');

    }
    public function getAvailableReservation()
    {
        $reservations= Reservation::where('start','<=',now()->toDateString())
            ->where('end','>=',now()->toDateString())
            ->where('done','!=',1)->get();
        $res= $reservations->first();

        return $res;

    }
    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }
}
