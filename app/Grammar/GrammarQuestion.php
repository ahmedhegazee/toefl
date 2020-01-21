<?php

namespace App\Grammar;

use Illuminate\Database\Eloquent\Model;

class GrammarQuestion extends Model
{
    protected $guarded = [];

    public function options()
    {
        return $this->hasMany(GrammarOption::class,'question_id');
}

    public function getTypeOption($options)
    {
        return $this->typeOptions()[$options];
}

    public function type()
    {
       return $this->belongsTo(GrammarQuestionType::class,'grammar_question_type_id');
}
    public function typeOptions()
    {
        return [
            0=>'Fill in the space',
            1=>'Find the mistake',
        ];
}

    public function exam()
    {
        return $this->belongsToMany(GrammarExam::class)->withTimestamps();
}

    public function scopeFillQuestions($query)
    {
        return $query->where('grammar_question_type_id',1)->get();
}
public function scopeFindQuestions($query)
    {
        return $query->where('grammar_question_type_id',2)->get();
}


}
