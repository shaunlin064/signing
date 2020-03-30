<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormFlowReplace extends Model
{
    //
  protected $table = 'form_flow_replace';

  protected $fillable = [
      'form_flow_id',
      'review_type',
      'reviewer_id'
  ];

  /**
   * 表單流程資料，一對一
   */
  public function flow(){
      return $this->hasOne('\App\Form_flow','id','form_flow_id');
  }
}
