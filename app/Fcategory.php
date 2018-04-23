<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fcategory extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'name', 'cover', 'detail','is_selected','business_id'
    ];
}
