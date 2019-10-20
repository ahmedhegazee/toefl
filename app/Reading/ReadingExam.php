<?php

namespace App\Reading;

use App\GroupType;
use App\Reservation;
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
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function groupType()
    {
        return $this->belongsTo(GroupType::class);
    }
}
