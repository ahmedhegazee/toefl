<?php

namespace App\Http\Controllers;

use App\Config;
use App\Grammar\GrammarQuestion;
use App\Group;
use App\GroupType;
use App\Reservation;
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
        $reservations = Reservation::all();
        return view('reservation.index', compact('reservations'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$this->isAvailableOpenedReservation()) {
            $res = Reservation::create($this->validateData());
            $this->generateGroups($res);
            return redirect()->to(route('res.index'));
        } else
            return redirect()->back()->with('error', 'You can\'t create another reservation.There is another one is opened');
    }

    /**
     * Display the specified resource.
     *
     * @param Reservation $re
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $re)
    {
        $groups = $re->groups;
        return view('reservation.show', compact('groups', 're'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Reservation $resarvation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $re)
    {

        return view('reservation.update', compact('re'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Reservation $resarvation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $re)
    {
//        dd($request['max_students']);

            if ($re->done ==0) {
                $re->update($this->validateData());
                return redirect()->to(route('res.index'));
            }
            else
                return redirect()->back()->with('error', 'You can\'t change number of students after the reservation is closed');
           }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Reservation $resarvation
     * @return \Illuminate\Http\Response
     */
//    public function destroy(Reservation $re)
//    {
//        $re->delete();
//        return redirect()->to(route('res.index'));
//    }
    /**
     * @param Reservation $re
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateGroups(Reservation $re)
    {
//        //get the maximum number of students in this reservation
//        $max=$re->max_students;
//        //get the value of computers count in labs
//        $computers = Config::first()->value;
//        //divide the max number on the computers number to get the groups number
//        $groupsNumber = ceil($max/$computers);
//        //for this reservation create number of groups
//
//        for($i=0;$i<$groupsNumber;$i++){
//            $group= $re->groups()->create([
//                'name'=>'Group '.($i+1),
//                'group_type_id'=>1,
//            ]);
//               }
        $groups = GroupType::all()->count();
        for ($i = 0; $i < $groups; $i++) {
            $group = $re->groups()->create([
                'name' => 'Group ' . ($i + 1),
                'group_type_id' => $i + 1,
            ]);
        }
        return redirect()->to(route('res.index'));

    }

    public function isAvailableOpenedReservation()
    {
        return Reservation::where('done', 0)->count() > 0;
    }



    public function validateData()
    {

        return request()->validate([
            'start' => 'required|date',
            'max_students' => 'required|numeric|min:2',
        ]);
    }
}
