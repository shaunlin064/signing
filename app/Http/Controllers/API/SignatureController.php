<?php
	/**
	 * Created by PhpStorm.
	 * User: shaun
	 * Date: 2020/5/29
	 * Time: 10:08
	 */

	namespace App\Http\Controllers\API;


    use Illuminate\Http\Request;
    use App\Signature;
    use Illuminate\Support\Facades\DB;

    class SignatureController {

        protected static $message
            = [
                'status'        => 0,
                'status_string' => '',
                'message'       => '',
                'data'          => []
            ];

        public function getUserSignatures ( Request $request ) {
//
            self::$message['status']        = 1;
            self::$message['status_string'] = '查詢成功';
            self::$message['message']       = '';
            self::$message['data']          = Signature::where('erp_user_id',$request->erp_user_id)->get();

            return self::$message;
	    }

        public function delete ( Request $request ) {

            DB::beginTransaction();
            try{
                self::$message['status']        = 1;
                self::$message['status_string'] = '刪除成功';
                self::$message['message']       = '';

                if($this->checkCanDelete($request->id)){
                    /*hard delete*/
                    $result =  Signature::findOrFail($request->id)->forceDelete();
                }else{
                    /*soft delete*/
                    $result = Signature::findOrFail($request->id)->delete();
                }
                self::$message['data']          = Signature::withTrashed()->where('id',$request->id)->first();
                DB::commit();
            }catch ( \Exception $ex ) {

                DB::rollback();
                self::$message['status_string'] = '刪除失敗';
                self::$message['message']       = '資料庫錯誤!' . $ex->getMessage();
            }
            return self::$message;
        }

        public function checkCanDelete ( $id ) {
            /*確認該簽名檔是否有使用過 沒有才能刪除*/
            return Signature::find($id)->formApplyCheckPoint->count() > 0 ? false : true;
	    }

        public function add ( Request $request ) {

            DB::beginTransaction();
            try {
                self::$message['status']        = 1;
                self::$message['status_string'] = '新增成功';
                self::$message['message']       = '';
                self::$message['data']          = Signature::create($request->all());
                DB::commit();
            }catch ( \Exception $ex ) {

                DB::rollback();
                self::$message['status_string'] = '新增失敗';
                self::$message['message']       = '資料庫錯誤!' . $ex->getMessage();
            }
            return self::$message;
	    }


        public function resetFavorite ( Request $request ) {

            DB::beginTransaction();
            try {
                Signature::where('id','!=',$request->id)->update(['favorite'=>0]);
                Signature::where('id',$request->id)->update(['favorite'=>1]);
                self::$message['status']        = 1;
                self::$message['status_string'] = '新增成功';
                self::$message['message']       = '';
                self::$message['data']          =  Signature::where('id',$request->id)->first();
                DB::commit();
            }catch ( \Exception $ex ) {

                DB::rollback();
                self::$message['status_string'] = '新增失敗';
                self::$message['message']       = '資料庫錯誤!' . $ex->getMessage();
            }

            return self::$message;
        }
	}
