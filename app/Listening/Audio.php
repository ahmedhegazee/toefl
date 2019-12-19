<?php

namespace App\Listening;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    protected $guarded=[];
    protected $table="audio";
    public function questions()
    {
        return $this->hasMany(ListeningQuestion::class,'audio_id');
    }
    public function exam()
    {
        return $this->belongsToMany(ListeningExam::class,'audio_listening_exam')
            ->withTimestamps();

    }

    public function type()
    {
        return $this->belongsTo(AudioType::class,'audio_type_id');
    }
    public function scopeShortConversation($query){
        return $query->where('audio_type_id',1);
    }
    public function scopeLongConversation($query){
        return $query->where('audio_type_id',2);
    }
    public function scopeSpeech($query){
        return $query->where('audio_type_id',3);
    }
}
