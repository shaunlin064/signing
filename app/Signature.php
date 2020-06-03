<?php
	/**
	 * Created by PhpStorm.
	 * User: shaun
	 * Date: 2020/6/1
	 * Time: 13:57
	 */


	namespace App;

	use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Signature extends Model {

        use SoftDeletes;
        protected $guarded = ['id'];
        protected $table = 'signatures';
        protected $attributes = [
            'favorite' => false,
        ];


        /*
     * 簽核 一對多
     * */
        public function formApplyCheckPoint (  ) {
            return $this->hasMany('\App\FormApplyCheckPoint','signatures_id','id');
        }

	}
