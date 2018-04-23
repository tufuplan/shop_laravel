<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Business extends Authenticatable
{
    //
    protected $fillable = [
        'account', 'password', 'logo','category_id'
    ];

}
