<?php

namespace App\Http\Controllers\ApiControllers;

use App\Config;
use App\Http\Controllers\Controller;
use App\Logging;
use Illuminate\Http\Request;

class ConfigsController extends Controller
{
    public function index()
    {
        $exam = Config::all()
            ->filter(function($config){
                if($config->id==2||$config->id==3||$config->id==4||$config->id==1)
                    return $config;
            })
            ->map(function ($config) {
            return [
                'id' => $config->id,
                'name' => $config->name,
                'value' => $config->value,
                'actions' => ''
            ];
        })->values()->all();
        $certificate = Config::all()
            ->filter(function($config){
                if($config->id==5||$config->id==6||$config->id==7||$config->id==8)
                    return $config;
            })
            ->map(function ($config) {
            return [
                'id' => $config->id,
                'name' => $config->name,
                'value' => $config->value,
                'actions' => ''
            ];
        })->values()->all();
        return response()->json(['exam'=>$exam,'certificate'=>$certificate]);
    }

    public function update(Request $request,Config $config)
    {
        $message="change config with id ".$config->id." old value is ".$config->value." new value ".$request->value;
        Logging::logAdmin(auth()->user(), $message);
        $check = $config->update([
            'value' => $request->value,
        ]);
        return response()->json(['success' => $check]);
    }
}
