<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $guarded=[];

    public function student()
    {
        return $this->hasOne(Student::class);
    }
    public function reservation()
    {
        return $this->hasOne(Reservation::class);
    }
    public function attempt()
    {
        return $this->hasOne(Attempt::class);
    }
    public function result()
    {
        return $this->hasOne(Result::class);
    }
}
