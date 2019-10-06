<?php

namespace App\Reading;

use App\Group;
use Illuminate\Database\Eloquent\Model;

class ReadingExam extends Model
{
    protected $guarded=[];
    public function vocabQuestions()
    {
        return $this->belongsToMany(VocabQuestion::class);

    }

    public function paragraphs()
    {
        return $this->belongsToMany(Paragraph::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
