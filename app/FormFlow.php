<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormFlow extends Model
{
    //
  protected $table = 'form_flow';

  protected $fillable = [
    'form_id',
    'review_order',
    'review_type',
    'reviewer_id',
    'overwrite',
    'replace',
    'role'
  ];
}
