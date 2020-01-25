<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $guarded=[];

    public function attempt()
    {
        return $this->hasOne(Attempt::class);
    }
}
