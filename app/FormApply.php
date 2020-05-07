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
        return $this->hasMany('\App\FormApplyCheckpoint','form_apply_id','id')->orderBy('review_order','ASC');
    }

    /**
     * 申請填寫資料，一對多
     */
    public function data(){
        return $this->hasMany('\App\FormData','form_apply_id','id');
    }

    /**
     * @return mixed
     */
    public function formDataWrap () {
        $form       = Config('form.' . $this->form_id);

        $columnData = $this->data;
        $column     = $columnData->pluck('value', 'column');
        foreach ( $columnData as $k => $v ) {
            if ( isset($form['column'][ $v->column ]['sub_column']) ) {
                //取得子欄位資料
                $subData     = [];
                $subDataTemp = FormDataSub::select('key')->where('form_data_id', $v->id)->groupBy('key')->get();
                foreach ( $subDataTemp as $k1 => $v1 ) {

                    $subData[ $v1->key ] = FormDataSub::where('form_data_id', $v->id)->where('key', $v1->key)->pluck(
                            'value', 'column'
                        );

                }
                $column[ $v->column ] = $subData;
            }
        }
        return $column;
    }
}
