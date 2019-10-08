<?php

namespace App\Listening;

use App\Group;
use Illuminate\Database\Eloquent\Model;

class ListeningExam extends Model
{
    protected $guarded=[];
    public function audios()
    {
        return $this->belongsToMany(Audio::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
