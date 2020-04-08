<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailSend extends Model
{
    //
    protected $table = 'email_send';

    protected $fillable = [
        'notify_type',
        'receiver_email',
        'receiver_name',
        'template',
        'subject',
        'content',
        'status'
    ];
}
