<?php

namespace App\Listening;

use Illuminate\Database\Eloquent\Model;

class AudioType extends Model
{
    protected $guarded=[];

    public function audios()
    {
        return $this->hasMany(Audio::class);
    }
}
