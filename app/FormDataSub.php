<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormDataSub extends Model
{
    //
    protected $table = 'form_data_sub';

    protected $fillable = [
        'form_data_id',
        'key',
        'column',
        'value'
    ];

    /**
     * 申請資料，一對一
     */
    public function MainData(){
        return $this->hasOne('\App\FormData','id','form_data_id');
    }
}
