<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemMessage extends Model
{
    //
    protected $table = 'system_message';

    protected $fillable = [
        'member_id',
        'title',
        'content',
        'url',
        'send_by',
        'read_at'
    ];
}
