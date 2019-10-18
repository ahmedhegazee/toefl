<?php

namespace App\Listening;

use App\Group;
use App\GroupType;
use App\Reservation;
use Illuminate\Database\Eloquent\Model;

class ListeningExam extends Model
{
    protected $guarded=[];
    public function audios()
    {
        return $this->belongsToMany(Audio::class,'audio_listening_exam')
            ->withTimestamps();
    }
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function groupType()
    {
        return $this->belongsTo(GroupType::class);
    }
}
