<?php

namespace App\Listening;

use Illuminate\Database\Eloquent\Model;

class ListeningQuestion extends Model
{
    protected $guarded=[];



    public function options()
    {
        return $this->hasMany(ListeningOption::class);
    }


    public function audio()
    {
        return $this->belongsTo(Audio::class);

    }
}
