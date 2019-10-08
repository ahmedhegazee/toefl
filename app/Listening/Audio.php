<?php

namespace App\Listening;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    protected $guarded=[];

    public function questions()
    {
        return $this->hasMany(ListeningQuestion::class);
    }
    public function exam()
    {
        return $this->belongsToMany(ListeningExam::class);

    }

    public function type()
    {
        return $this->belongsTo(AudioType::class,'audio_type_id');
    }
}
