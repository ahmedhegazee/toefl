<?php

namespace App;

use App\Grammar\GrammarAnswer;
use App\Grammar\GrammarResult;
use App\Reading\ParagraphAnswer;
use App\Reading\ReadingResult;
use App\Reading\VocabAnswer;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded=[];

    public function user()
    {
       return User::find($this->uid);
    }

    public function getVerifiedAttribute($option)
    {
        return $this->verifiedOptions()[$option];
    }

    public function verifiedOptions()
    {
        return [

            0=>'Not Verified',
            1=>'Verified',
        ];
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class,'res_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function grammarAnswers()
    {
        return $this->hasMany(GrammarAnswer::class);
    }
    public function vocabAnswers()
    {
        return $this->hasMany(VocabAnswer::class);
    }
    public function paragraphAnswers()
    {
        return $this->hasMany(ParagraphAnswer::class);
    }

    public function grammarResults()
    {
        return $this->hasMany(GrammarResult::class);
    }
    public function readingResults()
    {
        return $this->hasMany(ReadingResult::class);
    }
}
