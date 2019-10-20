<?php

namespace App;

use App\Grammar\GrammarExam;
use App\Listening\ListeningExam;
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
    } public function listeningExam()
    {
        return $this->hasOne(ListeningExam::class);
    }
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function type()
    {
        return $this->belongsTo(GroupType::class,'group_type_id');
    }
}
