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
       return $this->hasOne(User::class,'id','uid');
    }

    public function getVerifiedAttribute($option)
    {
        return $this->verifiedOptions()[$option];
    }
    public function getStudyingAttribute($option)
    {
        return $this->studyingOptions()[$option];
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
    public function studyingOptions()
    {
        return [

            1=>'Ms.c(Master)',
            2=>'PhD(Doctor)',
            3=>'Board certified',
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

    public function implementScoreEquation($marks)
    {

        return ($marks*677)/140;
}

    public function checkIfSuccess($marks)
    {
        return $marks > $this->required_score;
}
    public function sumAllMarks( int $grammarMarks=0,int $readingMarks=0,int $listeningMarks=0)
    {
        $marks=$grammarMarks+$readingMarks+$listeningMarks;
        $marks=$this->implementScoreEquation($marks);
        $this->results()->create([
            'attempt_id'=>$this->attempts->last()->id,
            'mark'=>intval($marks),
            'success'=>$this->checkIfSuccess($marks),
        ]);
        $message=" solved toefl exam and has {".$marks."}";
        Logging::logStudent($this, $message);
    }

    public function editResult($marks)
    {
        $result =$this->attempts()->last()->result;
        $marks=$this->implementScoreEquation($marks);

        $result->update([
            'mark'=>intval($marks),
            'success'=>$this->checkIfSuccess($marks),
        ]);
    }
    public function isVerified()
    {
        return  $this->verified=='Verified';
    }

    public function CanEnterExam()
    {
        return  Cache::has('group-can-enter-exam-'.$this->group->id);

    }
    public function CanStartExam()
    {
        return  Cache::has('group-can-start-exam-'.$this->group->id);

    }
}
