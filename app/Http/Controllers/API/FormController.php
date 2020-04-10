<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\FormApply;
use App\FormFlow;
use App\FormApplyCheckpoint;
use App\SystemMessage;
use App\EmailSend;
//use Cache;
use DB;
use Route;

/**
 * Class FormController
 * 表單流程管理 申請表處理
 * @package App\Http\Controllers\API
 */
class FormController extends Controller
{
    //
    /**
     * @var array
     * API回傳訊息格式
     * status : 成功或失敗狀態 0 失敗 1 成功
     * status_string : 狀態文字
     * message : API成功或失敗訊息說明
     * data : API執行成功夾帶資料
     */
    protected static $message= [
        'status' => 0,
        'status_string' => '',
        'message' => '',
        'data' => []
    ];

    /**
     * @param Request $request
     * 簽核表單送出申請
     * 依照取得表單流程找出該關卡簽核人寫入資料庫
     * @input form_id :表單ID
     * @input apply_member_id : 送審人員ID
     * @input 表單其他欄位name
     * @return array
     */
    public function apply(Request $request){

        DB::beginTransaction();
        try {
            //取得快取資料
            //$login_user = Cache::get('login_user');
            //$member = Cache::get('member');
            //$department = Cache::get('department');

            $request->replace(['key'=>'login_user']);
            $api_request = Request::create('session/get', 'POST');
            $api_request = $api_request->replace($request->input());
            $response = Route::dispatch($api_request)->getOriginalContent();

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
                        //位階須先找出實際簽署者
                        /*if($v->reviewer_id == 1){
                            $signed_member_id = $member[$request->get('apply_member_id')]['top_manage'];
                        }else if($v->reviewer_id == 2){
                            $signed_member_id = $member[$request->get('apply_member_id')]['sec_manage'];
                        }else{
                            $signed_member_id = $member[$request->get('apply_member_id')]['executive'];
                        }*/
                    }

                    //找到可代簽人員
                    $replace_signed_member_id = [];
                    foreach($v->replaceMember as $k1=>$v1){
                        if($v1->review_type == 2){
                            //位階須先找出實際簽署者
                            /*if($v->reviewer_id == 1){
                                $replace_id = $member[$request->get('apply_member_id')]['top_manage'];
                            }else if($v->reviewer_id == 2){
                                $replace_id = $member[$request->get('apply_member_id')]['sec_manage'];
                            }else{
                                $replace_id = $member[$request->get('apply_member_id')]['executive'];
                            }
                            array_push($replace_signed_member_id,$replace_id);*/
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

                    //寫入通知訊息
                    SystemMessage::create([
                        'member_id' => $signed_member_id,
                        'title' => '系統訊息',
                        'content' => '您有一則待簽核資料，請儘速處理',
                        'url' => '#',
                        'send_by' => 0
                    ]);

                    //寄出通知信件
                    /*$mail_data = [
                        'name' => $member[$signed_member_id]['name'],
                        'form_id' => $request->get('form_id'),
                        'member' => $login_user['name'],
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    EmailSend::create([
                        'notify_type' => '簽核通知',
                        'receiver_email' => $member[$signed_member_id]['email'],
                        'receiver_name' => $member[$signed_member_id]['name'] .' - '. $member[$signed_member_id]['org_name_ch'],
                        'template' => 'Email.signing_notify',
                        'subject' => "傑思 愛德威 - 簽核系統通知",
                        'content' => json_encode($mail_data),
                        'status' => 0
                    ]);*/
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

    /**
     * @param Request $request
     * 取得申請單內容與簽核狀況
     * 依照申請單ID取得內容與簽核狀況
     * @input id : 申請單ID
     * @return array['data'] : 申請單基本資料
     * @reutrn array['data']['column'] : 申請單填寫欄位資料
     * @reutrn array['data']['checkPoint'] : 申請單簽核關卡紀錄
     */
    public function get(Request $request){

        try {
            $FormApply = FormApply::findOrFail($request->get('id'));

            $result = $FormApply->toArray();
            //封裝欄位填寫資料
            $result['column'] = $FormApply->data->pluck('value','column');
            //封裝簽核列表
            $result['checkPoint'] = $FormApply->checkPoint->transform(function($item,$key){

                $item = collect($item)->forget([
                    'updated_at',
                    'form_apply_id',
                    'overwrite',
                    'replace_members',
                ]);
                $item['created_at'] = date('Y-m-d',strtotime($item['created_at']));

                return $item;
            });


            self::$message['status'] = 1;
            self::$message['status_string'] = '取得成功';
            self::$message['message'] = '';
            self::$message['data'] = $result;

        }catch (\Exception $ex){

            self::$message['status_string'] = '取得失敗';
            self::$message['message'] = '資料庫錯誤!'.$ex->getMessage();
        }

        return self::$message;
    }

    /**
     * @param Request $request
     * 表單申請編輯
     * 依照id判斷該表單是否已經有人簽核，若無人簽核可編輯
     * @input id : 表單申請ID
     * @return array
     */
    public function edit(Request $request){

        DB::beginTransaction();
        try {
            //檢查申請表是否已經有人簽核
            $FormApplyCheckpoint = FormApplyCheckpoint::where('form_apply_id',$request->get('id'))
                ->whereNotNull('signed_at')
                ->first();

            if($FormApplyCheckpoint == NULL){
                $FormApply = FormApply::findOrFail($request->get('id'));
                if($FormApply->fail_at == NULL){

                    //移除原填寫欄位資料
                    $FormApply->data()->delete();
                    //重新寫入填單資料
                    $form = Config('form.'.$FormApply->form_id);
                    foreach($form['column'] as $k=>$v){

                        $FormApply->data()->create([
                            'form_id' => $request->get('form_id'),
                            'column' => $k,
                            'value' => $request->get($k)
                        ]);
                    }

                    $FormApply->push();
                }
                else{
                    self::$message['status_string'] = '編輯失敗';
                    self::$message['message'] = '表單錯誤或資料已經作廢';

                    return self::$message;
                }
            }
            else{
                self::$message['status_string'] = '編輯失敗';
                self::$message['message'] = '表單錯誤或已有簽核紀錄無法作廢';

                return self::$message;
            }


            self::$message['status'] = 1;
            self::$message['status_string'] = '編輯成功';
            self::$message['message'] = '';
            self::$message['data'] = $FormApply;
            DB::commit();

        }catch (\Exception $ex){
            DB::rollback();
            self::$message['status_string'] = '編輯失敗';
            self::$message['message'] = '資料庫錯誤!'.$ex->getMessage();
        }

        return self::$message;
    }

    /**
     * @param Request $request
     * 表單申請作廢
     * 依照id判斷該表單是否已經有人簽核，若無人簽核可作廢
     * @input id : 表單申請ID
     * @return array
     */
    public function fail(Request $request){

        DB::beginTransaction();
        try {
            //檢查申請表是否已經有人簽核
            $FormApplyCheckpoint = FormApplyCheckpoint::where('form_apply_id',$request->get('id'))
                ->whereNotNull('signed_at')
                ->first();

            if($FormApplyCheckpoint == NULL){
                $FormApply = FormApply::findOrFail($request->get('id'));
                if($FormApply->fail_at == NULL){
                    $FormApply->fail_at = date('Y-m-d H:i:s');
                    $FormApply->save();
                }
                else{
                    self::$message['status_string'] = '作廢失敗';
                    self::$message['message'] = '表單錯誤或資料已經作廢';

                    return self::$message;
                }
            }
            else{
                self::$message['status_string'] = '作廢失敗';
                self::$message['message'] = '表單錯誤或已有簽核紀錄無法作廢';

                return self::$message;
            }


            self::$message['status'] = 1;
            self::$message['status_string'] = '作廢成功';
            self::$message['message'] = '';
            self::$message['data'] = $FormApply;
            DB::commit();

        }catch (\Exception $ex){
            DB::rollback();
            self::$message['status_string'] = '作廢失敗';
            self::$message['message'] = '資料庫錯誤!'.$ex->getMessage();
        }

        return self::$message;
    }

    /**
     * @param Request $request
     * 表單簽核
     * 檢查簽核關卡後寫入簽核資料，並更新表單目前狀態
     * @input id : 簽核ID
     * @input member_id : 簽核人員ID
     * @input signature : 簽名檔
     * @input remark : 備註
     * @input status : 簽核狀態 0:駁回 2:通過
     * @return array
     */
    public function check(Request $request){

        DB::beginTransaction();
        try {

            $now = date('Y-m-d H:i:s');
            //檢查簽核狀態，確定關卡還沒簽
            $checkPoint = FormApplyCheckpoint::where('status',1)
                ->whereNull('signed_at')
                ->where('id',$request->get('id'))
                ->first();

            if($checkPoint != NULL){

                //檢查有沒有比我前面的人卡關
                $overwriteCount = FormApplyCheckpoint::where('review_order','<',$checkPoint->review_order)
                    ->where('form_apply_id',$checkPoint->form_apply_id)
                    ->whereNull('signed_at')
                    ->where('overwrite',1)
                    ->count();

                //檢查是否為可為代簽人
                $replace_members = json_decode($checkPoint->replace_members,true);

                if($overwriteCount == 0 && (in_array($request->get('member_id'),$replace_members) || $checkPoint->signed_member_id == $request->get('member_id'))){
                    //沒有人卡關 人員在代簽名單中 人員為簽署者 則可簽

                    $checkPoint->signed_at = $now;
                    $checkPoint->signature = $request->get('signature');
                    $checkPoint->remark = $request->get('remark');

                    if(in_array($request->get('member_id'),$replace_members)){
                        $checkPoint->replace_signed_member_id = $request->get('member_id');
                    }

                    $checkPoint->status = $request->get('status');

                    //比我前面且不卡關的人全部代簽掉
                    $FormApplyCheckBefore = FormApplyCheckpoint::where('review_order','<',$checkPoint->review_order)
                        ->where('form_apply_id',$checkPoint->form_apply_id)
                        ->whereNull('signed_at')
                        ->where('overwrite',0)
                        ->get();
                    foreach($FormApplyCheckBefore as $k=>$v){
                        $v->signed_at = $now;
                        $v->signature = $request->get('signature');
                        $v->status = $request->get('status');
                        $v->replace_signed_member_id = $request->get('member_id');
                        $v->save();
                    }

                    //變更申請表now next 以及簽核狀態
                    if($request->get('status') != 0){
                        $checkPoint->apply->status = 2;
                    }
                    else{
                        $checkPoint->apply->status = 0;
                    }
                    $FormApplyCheckpointNext = FormApplyCheckpoint::where('form_apply_id',$checkPoint->form_apply_id)
                        ->where('review_order','>',$checkPoint->review_order)
                        ->where('status',1)
                        ->whereNull('signed_at')
                        ->orderBy('review_order','ASC')
                        ->first();

                    if($FormApplyCheckpointNext == NULL){
                        //沒有下一關，代表簽核結束
                        $checkPoint->apply->now = NULL;
                        $checkPoint->apply->next = NULL;
                        if($request->get('status') != 0){//審核結束並通過
                            $checkPoint->apply->status = 3;
                        }
                    }
                    else{
                        $FormApplyCheckpointNextNext = FormApplyCheckpoint::where('form_apply_id',$checkPoint->form_apply_id)
                            ->where('review_order','>',$FormApplyCheckpointNext->review_order)
                            ->where('status',1)
                            ->whereNull('signed_at')
                            ->orderBy('review_order','ASC')
                            ->first();

                        $checkPoint->apply->now = $FormApplyCheckpointNext->id;
                        $checkPoint->apply->next = ($FormApplyCheckpointNextNext == NULL) ? NULL : $FormApplyCheckpointNextNext->id;
                    }

                    $checkPoint->push();

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

    /**
     * @param Request $request
     * 待簽核列表資料
     * 依照member_id找出該簽核者在關卡中可簽或可代簽的資料
     * @input member_id : 簽核者ID
     * @input role : 簽核者或執行者 1 簽核 2 執行 NULL 不區分
     * @return array['data'][0]['id'] : 關卡ID
     * @return array['data'][0]['form_id'] : 表單ID
     * @return array['data'][0]['column'] : 填表資料
     * @return array['data'][0]['apply_member_id'] : 申請人ID
     * @return array['data'][0]['apply_at'] : 申請日期
     * @return array['data'][0]['status'] : 狀態 0:駁回 1:暫存中 2:簽核中 3:通過
     * @return array['data'][0]['can_check'] : 可以簽核或不行 0 不行(代表前面有人卡關) 1 可簽
     * @return array['data'][0]['is_replace'] : 是否為代簽 0 否 1 是
     */
    public function checkList(Request $request){

        $result = [];
        try {
            //找出所有未簽資料
            $checkList = FormApplyCheckpoint::where('status', 1)
                ->whereNull('signed_at');
            if($request->get('role') != NULL){
                $checkList->where('role', $request->get('role'));
            }
            $checkList = $checkList->get();

            foreach ($checkList as $k => $v) {
                //判斷是主簽或代簽人才加入列表
                $replace_members = json_decode($v->replace_members, true);
                if ($v->signed_member_id == $request->get('member_id') || in_array($request->get('member_id'), $replace_members)) {
                    $item = [
                        'id' => $v->id,
                        'form_id' => $v->apply->form_id,
                        'column' => $v->applyData,
                        'apply_member_id' => $v->apply->apply_member_id,
                        'apply_at' => $v->apply->created_at->format('Y-m-d'),
                        'status' => $v->apply->status,
                        'can_check' => 0,
                        'is_replace' => 0
                    ];

                    //檢查有沒有比我前面的人卡關
                    $overwriteCount = FormApplyCheckpoint::where('review_order', '<', $v->review_order)
                        ->where('form_apply_id', $v->form_apply_id)
                        ->whereNull('signed_at')
                        ->where('overwrite', 1)
                        ->count();
                    if ($overwriteCount == 0) {
                        $item['can_check'] = 1;
                    }

                    if (in_array($request->get('member_id'), $replace_members)) {
                        $item['is_replace'] = 1;
                    }

                    array_push($result, $item);
                }
            }

            self::$message['status'] = 1;
            self::$message['status_string'] = '取得成功';
            self::$message['message'] = '';
            self::$message['data'] = $result;

        }catch (\Exception $ex){
            DB::rollback();
            self::$message['status_string'] = '取得失敗';
            self::$message['message'] = '資料庫錯誤!'.$ex->getMessage();
        }

        return self::$message;

    }
}
