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
        'overwrite',
        'replace_members',
        'status',
        'signed_at',
        'signature',
        'remark'
    ];

    /**
     * 申請資料，一對一
     */
    public function apply(){
        return $this->hasOne('\App\FormApply','id','form_apply_id');
    }

    /**
     * 填表資料，一對一
     */
    public function applyData(){
        return $this->hasMany('\App\FormData','form_apply_id','form_apply_id');
    }
}
