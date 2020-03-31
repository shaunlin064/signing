<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
    //
    protected $table = 'form_data';

    protected $fillable = [
        'form_id',
        'form_apply_id',
        'column',
        'value'
    ];

    /**
     * 申請資料，一對一
     */
    public function apply(){
        return $this->hasOne('\App\FormApply','id','form_apply_id');
    }
}
