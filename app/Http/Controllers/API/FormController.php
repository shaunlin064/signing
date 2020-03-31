<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\FormApply;
use App\FormFlow;
use DB;

class FormController extends Controller
{
    //
    protected static $message= [
        'status' => 0,
        'status_string' => '',
        'message' => '',
        'data' => []
    ];

    public function flowList(Request $request){

        try {
            $_GET['page'] = $request->get('page');
            $pagination = ($request->get('page') != NULL) ? $request->get('page') : 15;
            $FormFlow = FormFlow::paginate($pagination);


            self::$message['status'] = 1;
            self::$message['status_string'] = '取得成功';
            self::$message['message'] = '';
            self::$message['data'] = $FormFlow;

        }catch (\Exception $ex){

            self::$message['status_string'] = '取得失敗';
            self::$message['message'] = '資料庫錯誤!'.$ex->getMessage();
        }

        return self::$message;
    }

    public function flowGet(Request $request){

        try {
            $FormFlow = FormFlow::findOrFail($request->get('id'));

            self::$message['status'] = 1;
            self::$message['status_string'] = '取得成功';
            self::$message['message'] = '';
            self::$message['data'] = $FormFlow;

        }catch (\Exception $ex){

            self::$message['status_string'] = '取得失敗';
            self::$message['message'] = '資料庫錯誤!'.$ex->getMessage();
        }

        return self::$message;
    }

    public function flowAdd(Request $request){

        DB::beginTransaction();
        try {
            //先檢查是不是已經有流程
            $FlowCheck = FormFlow::where('form_id',$request->get('form_id'))
                ->count();
            if($FlowCheck == 0){
                //寫入簽核關卡資料
                $FormFlow = FormFlow::create([
                    'form_id' => $request->get('form_id'),
                    'review_order' => $request->get('review_order'),
                    'review_type' =>$request->get('review_type'),
                    'reviewer_id' =>$request->get('reviewer_id'),
                    'overwrite' =>$request->get('overwrite'),
                    'replace' =>$request->get('replace'),
                    'role' =>$request->get('role'),
                ]);

                //寫入多筆關卡可代簽資料
                if($request->get('replace_type') != null) {
                    foreach ($request->get('replace_type') as $k => $v) {
                        $FormFlow->replace()->create([
                            'review_type' => $v,
                            'reviewer_id' => $request->get('reviewer_id')[$k]
                        ]);
                    }
                }

                self::$message['status'] = 1;
                self::$message['status_string'] = '新增成功';
                self::$message['message'] = '';
                self::$message['data'] = $FormFlow;
                DB::commit();
            }
            else{
                self::$message['status_string'] = '新增失敗';
                self::$message['message'] = '已有表單流程請勿重複設定';

                return self::$message;
            }

        }catch (\Exception $ex){
            DB::rollback();
            self::$message['status_string'] = '新增失敗';
            self::$message['message'] = '資料庫錯誤!'.$ex->getMessage();
        }

        return self::$message;
    }

    public function flowEdit(Request $request){

        DB::beginTransaction();
        try {
            //先檢查是不是已經有流程
            $FormFlow = FormFlow::findOrFail($request->get('id'));

            if($FormFlow != NULL){
                //編輯簽核關卡資料
                $FormFlow->form_id = $request->get('form_id');
                $FormFlow->review_order = $request->get('review_order');
                $FormFlow->review_type = $request->get('review_type');
                $FormFlow->reviewer_id = $request->get('reviewer_id');
                $FormFlow->overwrite = $request->get('overwrite');
                $FormFlow->replace = $request->get('replace');
                $FormFlow->role = $request->get('role');

                $FormFlow->replace()->delete();

                if($request->get('replace_type') != null) {
                    //寫入新多筆關卡可代簽資料
                    foreach ($request->get('replace_type') as $k => $v) {
                        $FormFlow->replace()->create([
                            'review_type' => $v,
                            'reviewer_id' => $request->get('reviewer_id')[$k]
                        ]);
                    }
                }

                $FormFlow->push();

                self::$message['status'] = 1;
                self::$message['status_string'] = '編輯成功';
                self::$message['message'] = '';
                self::$message['data'] = $FormFlow;
                DB::commit();
            }
            else{
                self::$message['status_string'] = '編輯失敗';
                self::$message['message'] = '找不到資料';

                return self::$message;
            }

        }catch (\Exception $ex){
            DB::rollback();
            self::$message['status_string'] = '編輯失敗';
            self::$message['message'] = '資料庫錯誤!'.$ex->getMessage();
        }

        return self::$message;
    }

    public function flowDelete(Request $request){

        DB::beginTransaction();
        try {
            //先檢查是不是已經有流程
            $FormFlow = FormFlow::findOrFail($request->get('id'));

            if($FormFlow != NULL){
                //移除簽核關卡資料
                $FormFlow->delete();

                $FormFlow->replace()->delete();

                self::$message['status'] = 1;
                self::$message['status_string'] = '刪除成功';
                self::$message['message'] = '';
                self::$message['data'] = [];
                DB::commit();
            }
            else{
                self::$message['status_string'] = '刪除失敗';
                self::$message['message'] = '找不到資料';

                return self::$message;
            }

        }catch (\Exception $ex){
            DB::rollback();
            self::$message['status_string'] = '刪除失敗';
            self::$message['message'] = '資料庫錯誤!'.$ex->getMessage();
        }

        return self::$message;
    }

    public function apply(Request $request){

        DB::beginTransaction();
        try {

            //檢查是否已經設定表單簽核流程
            $FormFlow = FormFlow::where('form_id',$request->get('form_id'))
                ->first();

            if(!is_null($FormFlow)){

                //寫入申請表單
                $FormApply = FormApply::create([
                    'form_id' => $request->get('form_id'),
                    'apply_member_id' => $request->get('apply_member_id'),
                    'status' => 1
                ]);

                //依照簽核順序寫入關卡資料
                foreach($FormFlow as $k=>$v){
                    $signed_member_id = $v->reviewer_id;
                    if($v->review_type == 2){
                        // TODO 位階須先找出實際簽署者
                    }

                    $FormApply->checkPoint()->create([
                        'review_order' => $v->review_order,
                        'role' => $v->role,
                        'signed_member_id' => $signed_member_id,
                        'status' => 1
                    ]);
                }

                //寫入填單資料
                $form = Config::from($request->get('form_id'));
                foreach($form['column'] as $k=>$v){

                    $FormApply->data()->create([
                        'form_id' => $request->get('form_id'),
                        'column' => $k,
                        'value' => $v['name']
                    ]);

                }


            }else{
                self::$message['status_string'] = '申請失敗';
                self::$message['message'] = '未有簽核流程，申請表未開放使用';

                return self::$message;
            }


            self::$message['status'] = 1;
            self::$message['status_string'] = '申請成功';
            self::$message['message'] = '';
            self::$message['data'] = $FormApply;
            DB::commit();

        }catch (\Exception $ex){
            DB::rollback();
            self::$message['status_string'] = '申請失敗';
            self::$message['message'] = '資料庫錯誤!'.$ex->getMessage();
        }

        return self::$message;
    }
}
