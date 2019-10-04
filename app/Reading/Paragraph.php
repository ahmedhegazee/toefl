<?php

namespace App\Reading;

use Illuminate\Database\Eloquent\Model;

class Paragraph extends Model
{
    protected $guarded=[];

    public function questions()
    {
        return $this->hasMany(ReadingQuestion::class);
    }
}
