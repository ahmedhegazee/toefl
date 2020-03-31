<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AllowedIP extends Model
{
    protected $guarded=[];
    protected $table="allowed_ips";
}
