<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\FormApply;
use App\FormFlow;
use App\FormApplyCheckpoint;
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
                ->where('review_order',$request->get('review_order'))
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
                ->get();

            if(!is_null($FormFlow)){

                //寫入申請表單
                $FormApply = FormApply::create([
                    'form_id' => $request->get('form_id'),
                    'apply_member_id' => $request->get('apply_member_id'),
                    'status' => 1
                ]);

                //寫入填單資料
                $form = Config('form.'.$request->get('form_id'));
                foreach($form['column'] as $k=>$v){

                    $FormApply->data()->create([
                        'form_id' => $request->get('form_id'),
                        'column' => $k,
                        'value' => $request->get($k)
                    ]);
                }

                //依照簽核順序寫入關卡資料
                foreach($FormFlow as $k=>$v){
                    $signed_member_id = $v->reviewer_id;
                    if($v->review_type == 2){
                        // TODO 位階須先找出實際簽署者
                    }

                    //找到可代簽人員
                    $replace_signed_member_id = [];
                    foreach($v->replaceMember as $k1=>$v1){
                        if($v1->review_type == 2){
                            // TODO 位階須先找出實際簽署者
                        }
                        else{
                            array_push($replace_signed_member_id,$v1->reviewer_id);
                        }
                    }


                    $FormApply->checkPoint()->create([
                        'review_order' => $v->review_order,
                        'role' => $v->role,
                        'signed_member_id' => $signed_member_id,
                        'overwrite' => $v->overwrite,
                        'replace_members' => json_encode($replace_signed_member_id),
                        'status' => 1
                    ]);
                }

                //設定目前關卡狀態
                $FormApply->now = $FormApply->checkPoint()->first()->id;
                $FormApply->next = ($FormApply->checkPoint()->skip(1)->first() == NULL) ? NULL : $FormApply->checkPoint()->skip(1)->first()->id;
                $FormApply->save();


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

    public function applyCheck(Request $request){

        DB::beginTransaction();
        try {

            //檢查簽核狀態，確定關卡還沒簽
            $checkPoint = FormApplyCheckpoint::where('status',1)
                ->whereNull('signed_at')
                ->where('id',$request->get('id'))
                ->first();

            if($checkPoint != NULL){

                //檢查overwrite
                $overwriteCount = FormApplyCheckpoint::where('id','<',$request->get('id'))
                    ->whereNull('signed_at')
                    ->where('overwrite',0)
                    ->count();

                //檢查是否為可為代簽人
                $replace_members = json_decode($checkPoint->replace_members,true);

                if($overwriteCount == 0 && (in_array($request->get('member_id'),$replace_members) || $checkPoint->signed_member_id == $request->get('member_id'))){
                    //沒有人卡關 人員在代簽名單中 人員為簽署者 則可簽

                    $checkPoint->signed_at = date('Y-m-d H:i:s');
                    $checkPoint->signature = $request->get('signature');
                    $checkPoint->remark = $request->get('remark');

                    if(in_array($request->get('member_id'),$replace_members)){
                        $checkPoint->replace_signed_member_id = $request->get('member_id');
                    }

                    $checkPoint->status = $request->get('status');

                    $checkPoint->save();

                }else{
                    //條件錯誤 不可簽
                    self::$message['status_string'] = '簽核失敗';
                    self::$message['message'] = '您所在的關卡有卡關或您並非簽署者';

                    return self::$message;
                }

            }
            else{
                //此關已簽
                self::$message['status_string'] = '簽核失敗';
                self::$message['message'] = '此關卡已簽核，請勿重複簽署';

                return self::$message;
            }


            self::$message['status'] = 1;
            self::$message['status_string'] = '簽核成功';
            self::$message['message'] = '';
            self::$message['data'] = $checkPoint;
            DB::commit();

        }catch (\Exception $ex){
            DB::rollback();
            self::$message['status_string'] = '簽核失敗';
            self::$message['message'] = '資料庫錯誤!'.$ex->getMessage();
        }

        return self::$message;
    }
}
