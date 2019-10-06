<?php

namespace App\Grammar;

use App\Group;
use Illuminate\Database\Eloquent\Model;

class GrammarExam extends Model
{
    protected $guarded=[];

    public function questions()
    {
        return $this->belongsToMany(GrammarQuestion::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function getFillQuestions()
    {
        return $this->questions()->where('grammar_question_type_id',1);
    }
    public function getFindQuestions()
    {
        return $this->questions()->where('grammar_question_type_id',2);
    }
}
