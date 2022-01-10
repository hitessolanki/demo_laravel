<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblCategory extends Model
{
    //
    protected $fillable = [
        'category_name',
        'user_id'
    ];

     
}
