<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormApply extends Model
{
    //
  protected $table = 'form_apply';

  protected $fillable = [
    'form_id',
    'apply_member_id',
    'status',
    'now',
    'next',
    'fail_at'
  ];
}
