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
        $reservations=$this->getReservations(Reservation::all());
        $reservations=json_encode($reservations);
        return view('reservation.index', compact('reservations'));
    }

    public function getReservations($reservations)
    {
         return $reservations->map(function ($res) {
            return [
                'id' => $res->id,
                'start' => $res->start,
                'Students Count' => $res->students->count(),
                'Max Students Count' => $res->max_students,
                'open/close'=>$res->done,
                'actions'=>'',
            ];
        });

    }
//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        return view('reservation.create');
//    }

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
            $reservations=$this->getAllReservations(Reservation::all());
            $reservations=json_encode($reservations);
            return response()->json(['success'=>true,'res'=>$reservations]);
        } else
            return response()->json(['success'=>false,'message'=>'You can\'t create another reservation.There is another one is opened']);
    }

    /**
     * Display the specified resource.
     *
     * @param Reservation $re
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $re)
    {
        $groups = $this->getGroups($re->groups);
        $groups=json_encode($groups);
        return view('reservation.show', compact('groups', 're'));
    }

    public function getGroups($groups)
    {
        return $groups->map(function($group){
            return[
              'id'=>$group->id,
              'name'=>$group->name,
              'Group Type'=>$group->type->type,
              'Students Count'=>$group->students->count(),
              'actions'=>''
            ];
        });
}
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param \App\Reservation $resarvation
//     * @return \Illuminate\Http\Response
//     */
//    public function edit(Reservation $re)
//    {
//
//        return view('reservation.update', compact('re'));
//    }

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

        if ($re->done == 0) {
           $check= $re->update($this->validateData());
            return response()->json(['success'=>$check]);
        } else
            return response()->json(['success'=>false,'message'=>'You can\'t change number of students after the reservation is closed']);
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
