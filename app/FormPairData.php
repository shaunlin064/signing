<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormPairData extends Model
{
    //
    protected $guarded = [];
    protected $table = 'form_pair_datas';
    protected $attributes = [
        'status' => 0,
        'use_to_form_apply_id' => null
    ];
    public function apply(){
        return $this->belongsTo('\App\FormApply','form_apply_id','id');
    }

}
