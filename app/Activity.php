<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    protected $fillable =[
        'name','content','business_id','status','start_time','end_time'
    ];
}
