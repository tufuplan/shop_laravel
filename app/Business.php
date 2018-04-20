<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    //
    protected $fillable = [
        'account', 'password', 'logo','category_id'
    ];

}
