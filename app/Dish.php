<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    //
    protected $fillable = [
        'name', 'price', 'cover','detail','fcategory_id','business_id'
    ];
}
