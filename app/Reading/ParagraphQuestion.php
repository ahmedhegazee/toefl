<?php

namespace App\Reading;

use Illuminate\Database\Eloquent\Model;

class ParagraphQuestion extends Model
{
    protected $guarded=[];



    public function options()
    {
        return $this->hasMany(ParagraphQuestionOption::class);
    }
}
