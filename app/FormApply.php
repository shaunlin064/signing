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

    /**
     * 簽核關卡資料，一對多
     */
    public function checkPoint(){
        return $this->hasOne('\App\Form_applyCheckpoint','form_apply_id','id');
    }
}
