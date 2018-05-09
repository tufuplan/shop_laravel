<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'events_id', 'member_id'
    ];
}
