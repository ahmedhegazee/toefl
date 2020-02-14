<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $guarded=[];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
    public function attempt()
    {
        return $this->belongsTo(Attempt::class);
    }
    public function result()
    {
        return $this->belongsTo(Result::class);
    }

    public function getKeyName()
    {
        return "no";
    }
}
