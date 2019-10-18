<?php

namespace App\Grammar;

use App\Group;
use App\GroupType;
use App\Reservation;
use Illuminate\Database\Eloquent\Model;

class GrammarExam extends Model
{
    protected $guarded=[];

    public function questions()
    {
        return $this->belongsToMany(GrammarQuestion::class)->withTimestamps();
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function groupType()
    {
        return $this->belongsTo(GroupType::class);
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
