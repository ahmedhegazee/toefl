<?php

namespace App\Reading;

use Illuminate\Database\Eloquent\Model;

class ReadingQuestion extends Model
{
    protected $guarded=[];

    public function paragraph()
    {
        return $this->belongsTo(Paragraph::class);
    }

    public function options()
    {
        return $this->hasMany(ReadingOption::class);
    }
}
