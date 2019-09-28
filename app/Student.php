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
            1=>'Verified',
            0=>'Not Verified',
        ];
    }
}
