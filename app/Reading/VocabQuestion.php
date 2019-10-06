<?php

namespace App\Reading;

use Illuminate\Database\Eloquent\Model;

class VocabQuestion extends Model
{
    protected $guarded=[];



    public function options()
    {
        return $this->hasMany(VocabOption::class);
    }


    public function exam()
    {
        return $this->belongsToMany(ReadingExam::class);

    }
}
