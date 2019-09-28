<?php

namespace App\Http\Controllers;

use App\Resarvation;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class ReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Resarvation::all();
        return view('reservation.index',compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reservation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(! $this->validateInterval()){
            Resarvation::create($this->validateData());
            return redirect()->to(route('res.index'));
        }
    else
        return redirect()->back()->with('error','Choose Correct Dates');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Resarvation  $resarvation
     * @return \Illuminate\Http\Response
     */
    public function show(Resarvation $re)
    {
        return redirect()->to(route('res.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resarvation  $resarvation
     * @return \Illuminate\Http\Response
     */
    public function edit(Resarvation $re)
    {

        return view('reservation.update',compact('re'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resarvation  $resarvation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resarvation $re)
    {
        $re->update($this->validateData());
        return redirect()->to(route('res.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resarvation  $resarvation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resarvation $re)
    {
        $re->delete();
        return redirect()->to(route('res.index'));
    }

    public function validateInterval()
    {
        $fdate = request('start');
        $tdate = request('end');
        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
        $interval = $datetime1->diff($datetime2);
        return $interval->invert;
}

    public function validateData()
    {


        return request()->validate([
        'start'=>'required|date',
        'end'=>'required|date|different:start',
    ]);
    }
}
