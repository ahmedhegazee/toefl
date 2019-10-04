<?php

namespace App\Grammar;

use Illuminate\Database\Eloquent\Model;

class GrammarQuestionType extends Model
{
protected $guarded=[];

    public function questions()
    {
        return $this->hasMany(GrammarQuestion::class);
}
}
