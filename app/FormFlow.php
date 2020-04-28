<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormFlow extends Model
{
    //
    use SoftDeletes;
    protected $table = 'form_flow';

    protected $fillable = [
        'name',
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
    public function replaceMember(){
        return $this->hasMany('\App\FormFlowReplace','form_flow_id','id');
    }
}
