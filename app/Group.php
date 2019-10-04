<?php

namespace App;

use App\Grammar\GrammarExam;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded=[];

    public function students()
    {
       return $this->hasMany(Student::class);
    }

    public function exam()
    {
        return $this->hasOne(GrammarExam::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
