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

    /**
     * 代簽列表，一對多
     */
    public function replace(){
        return $this->hasMany('\App\FormFlowReplace','form_flow_id','id');
    }
}
