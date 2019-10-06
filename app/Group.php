<?php

namespace App;

use App\Grammar\GrammarExam;
use App\Reading\ReadingExam;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded=[];

    public function students()
    {
       return $this->hasMany(Student::class);
    }

    public function grammarExam()
    {
        return $this->hasOne(GrammarExam::class);
    }
    public function readingExam()
    {
        return $this->hasOne(ReadingExam::class);
    }
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
