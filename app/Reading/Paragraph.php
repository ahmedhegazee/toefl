<?php

namespace App\Reading;

use Illuminate\Database\Eloquent\Model;

class Paragraph extends Model
{
    protected $guarded=[];

    public function questions()
    {
        return $this->hasMany(ParagraphQuestion::class);
    }
    public function exam()
    {
        return $this->belongsToMany(ReadingExam::class);

    }
}
