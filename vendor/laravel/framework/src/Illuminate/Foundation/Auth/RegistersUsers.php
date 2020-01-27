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
        $reservations= Reservation::where('done','!=',1)->get();
        $res= $reservations->first();
        if($res->students->count()==$res->max_students)
        {
            event(new ClosedReservation($res));
            return redirect('/error')->with('error','Reservation is Not Available');
        }
        else{
            $groups=GroupType::all();
            return view('auth.register',compact('groups'));
        }

    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $reservations= Reservation::where('done','!=',1)->get();
        $res= $reservations->first();
        if($res->students->count()==$res->max_students)
        {
            event(new ClosedReservation($res));
            return redirect('/error')->with('error','Reservation is Not Available');
        }
            $this->validator($request->all())->validate();
            event(new Registered($user = $this->create($request->all(),$res)));
            $message='Successfully registered. Go to the center admission to pay the cost of the exam.';
            return view('success',compact('message'));
//            $this->guard()->login($user);
//
//            return $this->registered($request, $user)
//                ?: redirect($this->redirectPath());


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
