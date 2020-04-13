<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuperUser extends Model
{
    //
    protected $table = 'super_user';

    protected $fillable = [
        'member_id',
        'name'
    ];
}
