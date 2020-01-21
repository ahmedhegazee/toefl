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

    public static function getAudios($audios)
    {
        return $audios->map(function ($audio){
            return [
              'id'=>$audio->id,
              'title'=>$audio->title,
              'type'=>$audio->type->type,
              'questions'=>$audio->questions->count(),
                'actions'=>'',
            ];
        });
    }
    public static function getAudiosForChoose($audios)
    {
        return $audios->map(function ($audio){
            return [
                'check'=>'',
                'id'=>$audio->id,
                'title'=>$audio->title,
                'type'=>$audio->type->type,
                'questions'=>$audio->questions->count(),
                'actions'=>'',
            ];
        });
    }
}
