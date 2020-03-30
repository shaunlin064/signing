<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormApplyCheckpoint extends Model
{
    //
  protected $table = 'form_apply_checkpoint';

  protected $fillable = [
      'form_apply_id',
      'review_order',
      'role',
      'signed_member_id',
      'replace_signed_member_id',
      'status',
      'signed_at',
      'signature',
      'remark'
  ];

  /**
   * 申請資料，一對一
   */
  public function apply(){
      return $this->hasOne('\App\Form_apply','id','form_apply_id');
  }
}
