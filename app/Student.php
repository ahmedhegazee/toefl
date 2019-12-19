<?php

namespace App;

use App\Grammar\GrammarAnswer;
use App\Grammar\GrammarResult;
use App\Listening\ListeningAnswer;
use App\Listening\ListeningResult;
use App\Reading\ParagraphAnswer;
use App\Reading\ReadingResult;
use App\Reading\VocabAnswer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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
    public function isOnline()
    {
        return Cache::has('student-is-online-' . $this->id)?'active':'not active';
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


    public function results()
    {
        return $this->hasMany(Result::class);
        }
    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function sumAllMarks( int $grammarMarks,int $readingMarks,int $listeningMarks)
    {
        $marks=$grammarMarks+$readingMarks+$listeningMarks;
        $this->results()->create([
            'attempt_id'=>$this->attempts->last()->id,
            'mark'=>$marks,
            'success'=>$marks > $this->required_score,
        ]);
    }
}
