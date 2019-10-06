<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded=[];

    public function user()
    {
       return User::find($this->uid);
    }

    public function getVerifiedAttribute($option)
    {
        return $this->verifiedOptions()[$option];
    }

    public function verifiedOptions()
    {
        return [

            0=>'Not Verified',
            1=>'Verified',
        ];
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
