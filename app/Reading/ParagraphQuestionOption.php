<?php

namespace App\Reading;

use Illuminate\Database\Eloquent\Model;

class ParagraphQuestionOption extends Model
{
    protected $guarded=[];

    public function question()
    {
        return $this->belongsTo(ParagraphQuestion::class);
    }
    public function getCorrectOption($option)
    {
        return $this->correctOptions()[$option];
    }

    public function correctOptions()
    {
        return [
            1=>'First Option',
            2=>'Second Option',
            3=>'Third Option',
            4=>'Fourth Option',
        ];
    }
}
