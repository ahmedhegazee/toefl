<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded=[];

    public function students()
    {
        return $this->hasMany(Student::class,'res_id');
    }

    public function getDoneAttribute($option)
    {
        return $this->doneOptions()[$option];
    }

    public function doneOptions()
    {
        return [
            0=>'Open',
            1=>'Closed',
            ];
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }


}
