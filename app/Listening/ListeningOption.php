<?php

namespace App\Listening;

use Illuminate\Database\Eloquent\Model;

class ListeningOption extends Model
{
    protected $guarded=[];

    public function question()
    {
        return $this->belongsTo(ListeningQuestion::class);
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
