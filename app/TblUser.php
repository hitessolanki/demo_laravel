<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblUser extends Model
{
    //

    protected $fillable = [
        'username',
        'email',
        'mobile_number',
        'password'
    ];
   
}
