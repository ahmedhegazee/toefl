<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
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

    public function result()
    {
      return  $this->hasOne(Result::class);
    }
}
