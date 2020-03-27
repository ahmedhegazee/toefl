<?php

namespace App\Http\Controllers;

use App\AllowedIP;
use Illuminate\Http\Request;

class ComputersIPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $ips=AllowedIP::all();
        $count=$ips->count();
        $ips=$ips->paginate(20)->map(function($ip){
        return[
            'computer number'=>$ip->computer_number,
            'computer ip'=>$ip->ip,
            'actions'=>''
        ];
    });
        return response()->json(compact('ips','count'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AllowedIP  $allowedIP
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AllowedIP $allowedIP)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AllowedIP  $allowedIP
     * @return \Illuminate\Http\Response
     */
    public function destroy(AllowedIP $allowedIP)
    {
        //
    }
}
