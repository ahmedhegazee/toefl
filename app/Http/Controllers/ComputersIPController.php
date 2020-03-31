<?php

namespace App\Http\Controllers;

use App\AllowedIP;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComputersIPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {

        $ips=AllowedIP::all();
        $count=$ips->count();
        $page=$request->has('page')?intval($request->get('page')):1;
        $perPage=30;
        $index= ($page-1)*$perPage;
//        $pages=intval(ceil($ips->count()/$perPage));
        $ips=$ips->map(function($ip){
            return[
                'id'=>$ip->id,
                'computer_number'=>$ip->computer_number,
                'computer_ip'=>$ip->ip,
                'actions'=>''
            ];
        })->slice($index,$perPage);
        if($ips->count()==0)
            return response()->json(['error'=>'please write correct page number']);

        return response()->json(compact('ips','count'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $validator = $this->validator($request->all());
            if($validator->fails())
                return response()->json(['errors'=>$validator->errors()]);
            AllowedIP::create($request->all());
            return response()->json(['success'=>true]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param AllowedIP $ip
     * @return JsonResponse
     */
    public function update(Request $request, AllowedIP $ip)
    {
        $validator = $this->validator($request->all());
        if($validator->fails())
            return response()->json(['errors'=>$validator->errors()]);
        $ip->update($request->all());
        return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AllowedIP  $allowedIP
     * @return \Illuminate\Http\Response
     */
    public function destroy(AllowedIP $ip)
    {
        $ip->delete();
    }

    public function validator($data)
    {
        $rules =[
            'computer_number'=>'sometimes|numeric|unique:allowed_ips',
            'ip'=>'required|ip|unique:allowed_ips',
        ];
        return Validator::make($data,$rules);
    }
}
