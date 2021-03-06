<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormFlowReplace extends Model
{
    //
    protected $table = 'form_flow_replace';

    protected $fillable = [
        'form_flow_id',
        'replace_type',
        'replace_id'
    ];

    /**
     * 表單流程資料，一對一
     */
    public function flow(){
        return $this->hasOne('\App\FormFlow','id','form_flow_id');
    }
}
