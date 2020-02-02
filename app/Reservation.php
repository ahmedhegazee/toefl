<?php

namespace App;

use App\Grammar\GrammarExam;
use App\Listening\ListeningExam;
use App\Reading\ReadingExam;
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

    public function grammarExam()
    {
        return $this->hasOne(GrammarExam::class);
}    public function readingExam()
    {
        return $this->hasOne(ReadingExam::class);
}    public function listeningExam()
    {
        return $this->hasOne(ListeningExam::class);
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
