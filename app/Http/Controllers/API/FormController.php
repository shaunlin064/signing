<?php


    namespace App\Http\Controllers\API;

    use App\EmailSend;
    use App\FormApply;
    use App\FormApplyCheckpoint;
    use App\FormData;
    use App\FormDataSub;
    use App\FormFlow;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\SessionController;
    use App\SuperUser;
    use App\SystemMessage;
    use DB;
    use Illuminate\Http\Request;
    use phpDocumentor\Reflection\Types\Boolean;
    use Route;
    use Validator;

    /**
     * Class FormController
     * 表單流程管理 申請表處理
     * @package App\Http\Controllers\API
     */
    class FormController extends Controller {

        //
        /**
         * @var array
         * API回傳訊息格式
         * status : 成功或失敗狀態 0 失敗 1 成功
         * status_string : 狀態文字
         * message : API成功或失敗訊息說明
         * data : API執行成功夾帶資料
         */
        protected static $message = [ 'status' => 0, 'status_string' => '', 'message' => '', 'data' => [] ];
        public $canCheck = false;

        /**
         * @param Request $request
         * 簽核表單送出申請
         * 依照取得表單流程找出該關卡簽核人寫入資料庫
         * @input form_id :表單ID
         * @input apply_member_id : 送審人員ID
         * @input 表單其他欄位name
         * @return array
         */
        public function apply ( Request $request ) {

            $validator = Validator::make($request->all(),
                                         [ 'form_id' => 'required', 'apply_member_id' => 'required', ]);

            if ( $validator->fails() ) {
                $error = $validator->errors()->toArray();
                $error = reset($error);

                self::$message['status'] = 0;
                self::$message['status_string'] = '驗證錯誤';
                self::$message['message'] = $error[0];

                return self::$message;
            }

            DB::beginTransaction();
            try {

                //確認form_id有在定義中
                if ( !array_key_exists($request->get('form_id'), Config('form')) ) {
                    self::$message['status'] = 0;
                    self::$message['status_string'] = '驗證錯誤';
                    self::$message['message'] = '表單不存在，請洽管理員';

                    return self::$message;
                }


                //檢查是否已經設定表單簽核流程
                $FormFlow = FormFlow::where('form_id', $request->get('form_id'))->get();


                if ( !is_null($FormFlow) ) {

                    //寫入申請表單
                    $FormApply = FormApply::create([ 'form_id'         => $request->get('form_id'),
                                                     'apply_member_id' => $request->get('apply_member_id'),
                                                     'status'          => 1 ]);

                    //寫入填單資料
                    $form = Config('form.' . $request->get('form_id'));
                    foreach ( $form['column'] as $k => $v ) {

                        //寫入主資料
                        $MainData = $FormApply->data()->create([ 'form_id' => $request->get('form_id'), 'column' => $k,
                                                                 'value'   => ( $request->get($k) == '' || is_array($request->get($k)) ) ? null : $request->get($k) ]);

                        if ( isset($v['sub_column']) && is_array($request->get($k)) ) {
                            //有子欄位，寫入子資料
                            foreach ( $request->get($k) as $k1 => $v1 ) {
                                foreach ( $v['sub_column'] as $k2 => $v2 ) {
                                    $MainData->subData()->create([ 'key'   => $k1, 'column' => $k2,
                                                                   'value' => ( $request->get($k)[ $k1 ][ $k2 ] == '' ) ? null : $request->get($k)[ $k1 ][ $k2 ] ]);
                                }
                            }
                        }
                    }
                    //取user 資料
                    $member = SessionController::getSession('member');

                    //依照簽核順序寫入關卡資料
                    foreach ( $FormFlow as $k => $v ) {
                        $signed_member_id = $v->reviewer_id;
                        if ( $v->review_type == 2 ) {
                            //位階須先找出實際簽署者
                            if ( $v->reviewer_id == 1 ) {
                                $signed_member_id = $member[ $request->get('apply_member_id') ]['top_manage'];
                            } else if ( $v->reviewer_id == 2 ) {
                                $signed_member_id = $member[ $request->get('apply_member_id') ]['sec_manage'];
                            } else {
                                $signed_member_id = $member[ $request->get('apply_member_id') ]['executive'];
                                /* TODO::erp 後台主管設定 最部門主高主管定義邏輯有問題 如果最高主管為 15 json的話 自動替換成 top_manage*/
                                if($signed_member_id == 15){
                                    $signed_member_id = $member[ $request->get('apply_member_id') ]['top_manage'];
                                }
                            }
                        } else if ($v->review_type == 3) {
                            $signed_member_id = $request->get('apply_member_id');
                        }

                        //找到可代簽人員
                        $replace_signed_member_id = [];

                        foreach ( $v->replaceMember as $k1 => $v1 ) {
                            if ( $v1->review_type == 2 ) {
                                //位階須先找出實際簽署者
                                if ( $v->reviewer_id == 1 ) {
                                    $replace_id = $member[ $request->get('apply_member_id') ]['top_manage'];
                                } else if ( $v->reviewer_id == 2 ) {
                                    $replace_id = $member[ $request->get('apply_member_id') ]['sec_manage'];
                                } else {
                                    $replace_id = $member[ $request->get('apply_member_id') ]['executive'];
                                }
                                array_push($replace_signed_member_id, $replace_id);
                            }else{
                                array_push($replace_signed_member_id, $v1->replace_id);
                            }
                        }

                        /* TODO::未來需修正後台主管設定邏輯 top manage 為 null 或簽核關卡為自己 直接跳過不設關卡 1級主管 沒有top_manage*/
                        if($signed_member_id !== null){
                            if(  $signed_member_id !== $request->get('apply_member_id') || $v->role != 1 ){
                                $FormApply->checkPoint()->create([ 'review_order'     => $v->review_order, 'role' => $v->role,
                                                                   'signed_member_id' => $signed_member_id,
                                                                   'overwrite'        => $v->overwrite,
                                                                   'replace_members'  => json_encode($replace_signed_member_id),
                                                                   'status'           => 1 ]);
                            }
                        }



                        //寄出通知信件
/*                        $mail_data = [ 'name'       => $member[ $signed_member_id ]['name'],
                                       'form_id'    => $request->get('form_id'),
                                       'member'     => $member[ $request->get('apply_member_id') ]['name'],
                                       'created_at' => date('Y-m-d H:i:s') ];

                        EmailSend::create([ 'notify_type'    => '簽核通知',
                                            'receiver_email' => $member[ $signed_member_id ]['email'],
                                            'receiver_name'  => $member[ $signed_member_id ]['name'] . ' - ' . $member[ $signed_member_id ]['org_name_ch'],
                                            'template'       => 'Email.signing_notify', 'subject' => "傑思 愛德威 - 簽核系統通知",
                                            'content'        => json_encode($mail_data), 'status' => 0 ]);*/
                    }
                    //設定目前關卡狀態
                    $FormApply->now = $FormApply->checkPoint()->first()->id;
                    $FormApply->next = ( $FormApply->checkPoint()
                            ->skip(1)
                            ->first() == null ) ? null : $FormApply->checkPoint()->skip(1)->first()->id;
                    $FormApply->save();

                    //寫入通知訊息 通知第一位簽核者
                    SystemMessage::create([ 'member_id' => $FormFlow->first()['reviewer_id'], 'title' => '系統訊息',
                                            'content'   => '您有一則待簽核資料，請儘速處理',
                                            'url'       => Route('form-edit', [ "id" => $FormApply->id ]),
                                            'send_by'   => 0 ]);

                } else {
                    self::$message['status_string'] = '申請失敗';
                    self::$message['message'] = '未有簽核流程，申請表未開放使用';

                    return self::$message;
                }


                self::$message['status'] = 1;
                self::$message['status_string'] = '申請成功';
                self::$message['message'] = '';
                self::$message['data'] = $FormApply;
                DB::commit();

            } catch ( \Exception $ex ) {
                DB::rollback();
                self::$message['status_string'] = '申請失敗';
                self::$message['message'] = '資料庫錯誤!' . $ex->getMessage();
            }

            return self::$message;
        }

        /**
         * @param Request $request
         * 取得申請單內容與簽核狀況
         * 依照申請單ID取得內容與簽核狀況
         * @input id : 申請單ID
         * @input member_id : 登入人員ID
         * @return array['data'] : 申請單基本資料
         * @reutrn array['data']['column'] : 申請單填寫欄位資料
         * @reutrn array['data']['checkPoint'] : 申請單簽核關卡紀錄
         * @return array['data']['check_status']['can_check'] : 可以簽核或不行 0 不行(代表前面有人卡關) 1 可簽
         * @return array['data']['check_status']['is_replace'] : 是否為代簽 0 否 1 是
         * @return array['data']['check_status']['form_check_point_id'] : 簽核關卡ID
         */
        public function get ( Request $request ) {

            try {
                $member_id = $request->get('member_id');
                $FormApply = FormApply::findOrFail($request->get('id'));

                $result = $FormApply->toArray();
                //封裝欄位填寫資料
                $form = Config('form.' . $FormApply->form_id);
                $columnData = $FormApply->data;
                $column = $columnData->pluck('value', 'column');
                foreach ( $columnData as $k => $v ) {
                    if ( isset($form['column'][ $v->column ]['sub_column']) ) {
                        //取得子欄位資料
                        $subData = [];
                        $subDataTemp = FormDataSub::select('key')->where('form_data_id', $v->id)->groupBy('key')->get();
                        foreach ( $subDataTemp as $k1 => $v1 ) {

                            $subData[ $v1->key ] = FormDataSub::where('form_data_id', $v->id)
                                ->where('key', $v1->key)
                                ->pluck('value', 'column');

                        }
                        $column[ $v->column ] = $subData;
                    }
                }
                $result['column'] = $column;


                //確認可簽核狀態
                $in_checkpoint = 0;
                $assign_checkpoint_id = 0;
                $result['check_status']['can_check'] = 0;
                $result['check_status']['is_replace'] = 0;
                $result['check_status']['form_check_point_id'] = 0;

                //檢查有沒有在關卡中
                $check_point = $FormApply->checkPoint()->where('status', 1)->orderBy('review_order', 'ASC')->get();

                // 找尋使用者 最多可以簽核的關卡id
                /* ex: 連續三關都是同一個user 或者可以取代的簽核  將直接取最後可簽核id*/
                foreach($check_point as $key => $item){
                    $canCheck = $this->checkCanSigning($item,$member_id,false);
                    if($canCheck  == false){
                        break;
                    }
                    $replace_members = json_decode($item->replace_members, true);
                    if ( in_array($member_id, $replace_members) ) {
                        $result['check_status']['is_replace'] = 1;
                    }
                    $in_checkpoint = $item->review_order;
                    $assign_checkpoint_id = $item->id;
                }


//
//                foreach ( $check_point as $k => $v ) {
//                    $replace_members = json_decode($v->replace_members, true);
//                    if ( $v->signed_member_id == $member_id || in_array($member_id, $replace_members) ) {
//                        $in_checkpoint = $v->review_order;
//                        $assign_checkpoint_id = $v->id;
//                        if ( in_array($member_id, $replace_members) ) {
//                            $result['check_status']['is_replace'] = 1;
//                        }
//                        break;
//                    }
//                }
//
//                //檢查有沒有比我前面的人卡關
//                $overwriteCount = $FormApply->checkPoint()
//                    ->where('review_order', '<', $in_checkpoint)
//                    ->whereNull('signed_at')
//                    ->where('overwrite', 0)
//                    ->count();


                if ( $in_checkpoint != 0 ) {
                    $result['check_status']['can_check'] = 1;
                    $result['check_status']['form_check_point_id'] = $assign_checkpoint_id;
                }

                //封裝簽核列表
                $formflow = FormFlow::where('form_id',$FormApply->form_id)->get();

                $result['checkPoint'] = $FormApply->checkPoint->transform(function ( $item, $key ) use($formflow) {
                    $item['check_point_name'] = $formflow->where('review_order',$item->review_order)->max('name');
                    $item = collect($item)->forget([ 'updated_at', 'form_apply_id', 'overwrite', 'replace_members', ]);
                    $item['created_at'] = date('Y-m-d', strtotime($item['created_at']));
                    $item['role_str'] = $item['role'] == 1 ? '簽核' : '執行';

                    return $item;
                });

                self::$message['status'] = 1;
                self::$message['status_string'] = '取得成功';
                self::$message['message'] = '';
                self::$message['data'] = $result;

            } catch ( \Exception $ex ) {

                self::$message['status_string'] = '取得失敗';
                self::$message['message'] = '資料庫錯誤!' . $ex->getMessage();
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
        public function edit ( Request $request ) {

            DB::beginTransaction();
            try {
                //檢查申請表是否已經有人簽核
                $FormApplyCheckpoint = FormApplyCheckpoint::where('form_apply_id', $request->get('id'))
                    ->whereNotNull('signed_at')
                    ->first();

                if ( $FormApplyCheckpoint == null ) {
                    $FormApply = FormApply::findOrFail($request->get('id'));
                    if ( $FormApply->fail_at == null ) {

                        //移除原填寫欄位資料
                        foreach ( $FormApply->data as $k => $v ) {
                            FormDataSub::where('form_data_id', $v->id)->delete();
                        }
                        $FormApply->data()->delete();
                        //重新寫入填單資料
                        $form = Config('form.' . $FormApply->form_id);
                        foreach ( $form['column'] as $k => $v ) {

                            //寫入主資料
                            $MainData = $FormApply->data()->create([ 'form_id' => $FormApply->form_id, 'column' => $k,
                                                                     'value'   => ( $request->get($k) == '' || is_array($request->get($k)) ) ? null : $request->get($k) ]);

                            if ( isset($v['sub_column']) && is_array($request->get($k)) ) {
                                //有子欄位，寫入子資料
                                foreach ( $request->get($k) as $k1 => $v1 ) {
                                    foreach ( $v['sub_column'] as $k2 => $v2 ) {
                                        $MainData->subData()->create([ 'key'   => $k1, 'column' => $k2,
                                                                       'value' => ( $request->get($k)[ $k1 ][ $k2 ] == '' ) ? null : $request->get($k)[ $k1 ][ $k2 ] ]);
                                    }
                                }
                            }
                        }

                        $FormApply->push();
                    } else {
                        self::$message['status_string'] = '編輯失敗';
                        self::$message['message'] = '表單錯誤或資料已經作廢';

                        return self::$message;
                    }
                } else {
                    self::$message['status_string'] = '編輯失敗';
                    self::$message['message'] = '表單錯誤或已有簽核紀錄無法作廢';

                    return self::$message;
                }


                self::$message['status'] = 1;
                self::$message['status_string'] = '編輯成功';
                self::$message['message'] = '';
                self::$message['data'] = $FormApply;
                DB::commit();

            } catch ( \Exception $ex ) {
                DB::rollback();
                self::$message['status_string'] = '編輯失敗';
                self::$message['message'] = '資料庫錯誤!' . $ex->getMessage();
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
        public function fail ( Request $request ) {

            DB::beginTransaction();
            try {
                //檢查申請表是否已經有人簽核
                $FormApplyCheckpoint = FormApplyCheckpoint::where('form_apply_id', $request->get('id'))
                    ->whereNotNull('signed_at')
                    ->first();

                if ( $FormApplyCheckpoint == null ) {
                    $FormApply = FormApply::findOrFail($request->get('id'));
                    if ( $FormApply->fail_at == null ) {
                        $FormApply->fail_at = date('Y-m-d H:i:s');
                        $FormApply->save();
                    } else {
                        self::$message['status_string'] = '作廢失敗';
                        self::$message['message'] = '表單錯誤或資料已經作廢';

                        return self::$message;
                    }
                } else {
                    self::$message['status_string'] = '作廢失敗';
                    self::$message['message'] = '表單錯誤或已有簽核紀錄無法作廢';

                    return self::$message;
                }


                self::$message['status'] = 1;
                self::$message['status_string'] = '作廢成功';
                self::$message['message'] = '';
                self::$message['data'] = $FormApply;
                DB::commit();

            } catch ( \Exception $ex ) {
                DB::rollback();
                self::$message['status_string'] = '作廢失敗';
                self::$message['message'] = '資料庫錯誤!' . $ex->getMessage();
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
        public function check ( Request $request ) {

            DB::beginTransaction();
            try {
                $now = date('Y-m-d H:i:s');
                $checkPoint = FormApplyCheckpoint::find($request->get('id'));

                //檢查簽核狀態，確認是否可執行或者簽核
                $checkCanSigning = $this->checkCanSigning($checkPoint, $request->get('member_id'));
                if ( !$checkCanSigning ) {
                    return self::$message;
                }

                $this->signingBeforeMe($request, $checkPoint, $now);

                //沒有人卡關 人員在代簽名單中 人員為簽署者 則可簽
                $checkPoint->signed_at = $now;
                $checkPoint->signature = $request->get('signature');
                $checkPoint->remark = $request->get('remark') ?? '';
                /*是否為代簽 補上代簽者 id*/
                if ( json_decode($checkPoint->replace_members, true) ) {
                    $checkPoint->replace_signed_member_id = $request->get('member_id');
                }
                $checkPoint->status = $request->get('status');

                //變更申請表now next 以及簽核狀態
                if ( $request->get('status') != 0 ) {
                    $checkPoint->apply->status = 2;
                } else {
                    $checkPoint->apply->status = 0;
                }
                /*確認是否有下一關*/
                $FormApplyCheckpointNext = FormApplyCheckpoint::where('form_apply_id', $checkPoint->form_apply_id)
                    ->where('review_order', '>', $checkPoint->review_order)
                    ->where('status', 1)
                    ->whereNull('signed_at')
                    ->orderBy('review_order', 'ASC')
                    ->first();
                /*有下一關 更改前後狀態*/

                if ( $FormApplyCheckpointNext ) {
                    $FormApplyCheckpointNextNext = FormApplyCheckpoint::where('form_apply_id',
                                                                              $checkPoint->form_apply_id)
                        ->where('review_order', '>', $FormApplyCheckpointNext->review_order)
                        ->where('status', 1)
                        ->whereNull('signed_at')
                        ->orderBy('review_order', 'ASC')
                        ->first();

                    $checkPoint->apply->now = $FormApplyCheckpointNext->id;
                    $checkPoint->apply->next = ( $FormApplyCheckpointNextNext == null ) ? null : $FormApplyCheckpointNextNext->id;

                    //寫入通知訊息 通知下位簽核者
                    SystemMessage::create([ 'member_id' => $FormApplyCheckpointNext['signed_member_id'], 'title' => '系統訊息',
                                            'content'   => '您有一則待簽核資料，請儘速處理',
                                            'url'       => Route('form-edit', [ "id" => $checkPoint->apply->id ]),
                                            'send_by'   => 0 ]);
                } else {
                    //沒有下一關，代表簽核結束
                    $checkPoint->apply->now = null;
                    $checkPoint->apply->next = null;
                    if ( $request->get('status') != 0 ) {//審核結束並通過
                        $checkPoint->apply->status = 3;
                    }
    /*簽核完成 通知申請者*/
                    SystemMessage::create([ 'member_id' => $checkPoint->apply->apply_member_id, 'title' => '系統訊息',
                                            'content'   => '您申請的簽核已完成流程',
                                            'url'       => Route('form-edit', [ "id" => $checkPoint->apply->id ]),
                                            'send_by'   => 0 ]);
                }

                $checkPoint->push();

                self::$message['status'] = 1;
                self::$message['status_string'] = '簽核成功';
                self::$message['message'] = '';
                self::$message['data'] = $checkPoint;
                DB::commit();

            } catch ( \Exception $ex ) {
                DB::rollback();
                self::$message['status_string'] = '簽核失敗';
                self::$message['message'] = '資料庫錯誤!' . $ex->getMessage();
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
         * @return array['data'][0]['form_apply_id'] : 表單送審ID
         * @return array['data'][0]['form_id'] : 表單類型ID
         * @return array['data'][0]['form_type'] : 表單名稱
         * @return array['data'][0]['column'] : 填表資料
         * @return array['data'][0]['apply_member_id'] : 申請人ID
         * @return array['data'][0]['apply_at'] : 申請日期
         * @return array['data'][0]['status'] : 狀態 0:駁回 1:暫存中 2:簽核中 3:通過
         * @return array['data'][0]['status_string'] : 狀態轉換中文顯示
         * @return array['data'][0]['department'] : 申請人部門
         * @return array['data'][0]['member'] : 申請人姓名
         * @return array['data'][0]['apply_subject'] : 表單主旨
         * @return array['data'][0]['can_check'] : 可以簽核或不行 0 不行(代表前面有人卡關) 1 可簽
         * @return array['data'][0]['is_replace'] : 是否為代簽 0 否 1 是
         */
        public function checkList ( Request $request ) {

            $result = [];

            try {
                //找出所有未簽資料
                $checkList = FormApplyCheckpoint::where('status', 1)->whereNull('signed_at');

                if ( $request->get('role') != null ) {
                    $checkList->where('role', $request->get('role'));
                }
                $checkList = $checkList->get()->unique('form_apply_id');

                $member_id = $request->get('member_id');

                //取得session資料
                $member = SessionController::getSession('member');
                $department = SessionController::getSession('department');

                $status = Config('form_status.apply');


                foreach ( $checkList as $k => $v ) {
                    //判斷是主簽或代簽人才加入列表
                    $replace_members = json_decode($v->replace_members, true);
                    if ( $v->signed_member_id == $member_id || in_array($member_id, $replace_members) ) {

                        $department_id = ( isset($member[ $v->apply->apply_member_id ]) ) ? $member[ $v->apply->apply_member_id ]['department_id'] : null;
                        $dpartment = ( isset($department[ $department_id ]) ) ? $department[ $department_id ]['name'] : '';

                        $item = [ 'id'                      => $v->id, 'form_apply_id' => $v->form_apply_id,
                                  'form_id'                 => $v->apply->form_id,
                                  'form_type'               => Config('form')[ $v->apply->form_id ]['name'],
                                  'column'                  => $v->applyData()->pluck('value', 'column'),
                                  'apply_member_id'         => $v->apply->apply_member_id,
                                  'apply_at'                => $v->apply->created_at->format('Y-m-d'),
                                  'status'                  => $v->apply->status,
                                  'status_string'           => $status[ $v->apply->status ], 'department' => $dpartment,
                                  'member'                  => ( isset($member[ $v->apply->apply_member_id ]) ) ? $member[ $v->apply->apply_member_id ]['name'] : '',
                                  'apply_subject'           => $v->apply->data()
                                      ->where('column', 'apply_subject')
                                      ->pluck('value')
                                      ->get(0), 'can_check' => 0, 'is_replace' => 0 ];

                        //檢查有沒有比我前面的人卡關
                        $overwriteCount = FormApplyCheckpoint::where('review_order', '<', $v->review_order)
                            ->where('form_apply_id', $v->form_apply_id)
                            ->whereNull('signed_at')
                            ->where('overwrite', 0)
                            ->count();

                        if ( $overwriteCount == 0 ) {
                            $item['can_check'] = 1;
                        }

                        if ( in_array($member_id, $replace_members) ) {
                            $item['is_replace'] = 1;
                        }

                        array_push($result, $item);
                    }
                }
                self::$message['status'] = 1;
                self::$message['status_string'] = '取得成功';
                self::$message['message'] = '';
                self::$message['data'] = $result;

            } catch ( \Exception $ex ) {
                DB::rollback();
                self::$message['status_string'] = '取得失敗';
                self::$message['message'] = '資料庫錯誤!' . $ex->getMessage();
            }

            return self::$message;

        }

        /**
         * @param Request $request
         * 已送簽列表資料
         * 依照member_id找出該送簽者目前列表
         * @input member_id : 簽核者ID
         * @input page : 頁碼，如果沒有則全部列出
         * @return array['data'][0]['id'] : 表單ID
         * @return array['data'][0]['created_at'] : 申請時間(原始值)
         * @return array['data'][0]['updated_at'] : 修改時間(原始值)
         * @return array['data'][0]['form_id'] : 表單類型ID
         * @return array['data'][0]['apply_member_id'] : 申請人員ID
         * @return array['data'][0]['status'] : 狀態值
         * @return array['data'][0]['now'] : 目前關卡ID
         * @return array['data'][0]['next'] : 下一關卡ID
         * @return array['data'][0]['fail_at'] : 作廢時間
         * @return array['data'][0]['created_at_format'] : 申請時間(格式化值)
         * @return array['data'][0]['form_type'] : 表單類型名稱
         * @return array['data'][0]['status_string'] : 狀態文字值
         * @return array['data'][0]['department'] : 申請者部門名稱
         * @return array['data'][0]['member'] : 申請者姓名
         * @return array['data'][0]['apply_subject'] : 表單主旨
         */
        public function userList ( Request $request ) {

            try {
                $_GET['page'] = $request->get('page');
                $list = FormApply::where('apply_member_id', $request->get('member_id'))->orderBy('id', 'DESC');
                if ( $request->get('page') == null ) {
                    $list = $list->get();
                } else {
                    $list = $list->paginate();
                }

                //取得session資料
                $member = SessionController::getSession('member');
                $department = SessionController::getSession('department');

                $status = Config('form_status.apply');

                $list->map(function ( $item ) use ( $member, $department, $status ) {

                    $department_id = ( isset($member[ $item->apply_member_id ]) ) ? $member[ $item->apply_member_id ]['department_id'] : null;
                    $dpartment = ( isset($department[ $department_id ]) ) ? $department[ $department_id ]['name'] : '';

                    $item->created_at_format = $item->created_at->format('Y-m-d');
                    $item->form_type = Config('form')[ $item->form_id ]['name'];
                    $item->status_string = $status[ $item->status ];
                    $item->department = $dpartment;
                    $item->member = ( isset($member[ $item->apply_member_id ]) ) ? $member[ $item->apply_member_id ]['name'] : '';
                    $item->apply_subject = $item->data()->where('column', 'apply_subject')->pluck('value')->get(0);

                    return $item;
                });

                self::$message['status'] = 1;
                self::$message['status_string'] = '取得成功';
                self::$message['message'] = '';
                self::$message['data'] = $list;

            } catch ( \Exception $ex ) {
                DB::rollback();
                self::$message['status_string'] = '取得失敗';
                self::$message['message'] = '資料庫錯誤!' . $ex->getMessage();
            }

            return self::$message;

        }

        /**
         * @param Request $request
         * 取得所有已簽核或已執行列表
         * 依照role取得已簽核或者已執行資料，若member_id為super user 則取出所有申請資料，不判斷member_id
         * @input page : 頁碼，如果沒有則全部列出
         * @input role : 簽核者或執行者 1 簽核 2 執行 NULL 不區分
         * @inpit form_id : 指定表單類型ID，若無則不區分
         * @input member_id : 指定簽核人員ID，若無則apply_member_id必填
         * @input apply_member_id : 指定填單人員ID，與member_id則一
         * @return array['data'][0]['id'] : 表單ID
         * @return array['data'][0]['created_at'] : 申請時間(原始值)
         * @return array['data'][0]['updated_at'] : 修改時間(原始值)
         * @return array['data'][0]['form_id'] : 表單類型ID
         * @return array['data'][0]['apply_member_id'] : 申請人員ID
         * @return array['data'][0]['status'] : 狀態值
         * @return array['data'][0]['now'] : 目前關卡ID
         * @return array['data'][0]['next'] : 下一關卡ID
         * @return array['data'][0]['fail_at'] : 作廢時間
         * @return array['data'][0]['created_at_format'] : 申請時間(格式化值)
         * @return array['data'][0]['form_type'] : 表單類型名稱
         * @return array['data'][0]['status_string'] : 狀態文字值
         * @return array['data'][0]['department'] : 申請者部門名稱
         * @return array['data'][0]['member'] : 申請者姓名
         * @return array['data'][0]['apply_subject'] : 表單主旨
         */
        public function all ( Request $request ) {
            try {
                $_GET['page'] = $request->get('page');

                //判斷member_id是否為super user
                $is_super_user = false;
                if ( $request->get('member_id') != null ) {
                    $super_user_check = SuperUser::where('member_id', $request->get('member_id'))->count();
                    if ( $super_user_check != 0 ) {
                        $is_super_user = true;
                    }
                }

                //取得Apply List 有收到form_id,apply_member_id,member_id都要增加條件判斷，另外需確認member_id是否為super user
                $list = FormApply::whereNull('fail_at');
                if ( $request->get('form_id') != null ) {
                    $list->where('form_id', $request->get('form_id'));
                }
                if ( $request->get('apply_member_id') != null ) {
                    $list->where('apply_member_id', $request->get('apply_member_id'));
                }
                $list->whereHas('checkPoint', function ( $query ) use ( $request, $is_super_user ) {
                    $query->whereNotNull('signed_at');
                    if ( $request->get('role') != null ) {
                        $query->where('role', $request->get('role'));
                    }
                    $query->where(function ( $query1 ) use ( $request, $is_super_user ) {
                        if ( $request->get('member_id') != null && $is_super_user == false ) {
                            $query1->orWhere('signed_member_id', $request->get('member_id'));
                            $query1->orWhere('replace_signed_member_id', $request->get('member_id'));
                        }
                    });

                })->orderBy('id', 'DESC');
                if ( $request->get('page') == null ) {
                    $list = $list->get();
                } else {
                    $list = $list->paginate();
                }

                //取得session資料
                $member = SessionController::getSession('member');
                $department = SessionController::getSession('department');

                $status = Config('form_status.apply');

                $list->map(function ( $item ) use ( $member, $department, $status ) {

                    $department_id = ( isset($member[ $item->apply_member_id ]) ) ? $member[ $item->apply_member_id ]['department_id'] : null;
                    $dpartment = ( isset($department[ $department_id ]) ) ? $department[ $department_id ]['name'] : '';

                    $item->created_at_format = $item->created_at->format('Y-m-d');
                    $item->form_type = Config('form')[ $item->form_id ]['name'];
                    $item->status_string = $status[ $item->status ];
                    $item->department = $dpartment;
                    $item->member = ( isset($member[ $item->apply_member_id ]) ) ? $member[ $item->apply_member_id ]['name'] : '';
                    $item->apply_subject = $item->data()->where('column', 'apply_subject')->pluck('value')->get(0);

                    return $item;
                });

                self::$message['status'] = 1;
                self::$message['status_string'] = '取得成功';
                self::$message['message'] = '';
                self::$message['data'] = $list;

            } catch ( \Exception $ex ) {
                DB::rollback();
                self::$message['status_string'] = '取得失敗';
                self::$message['message'] = '資料庫錯誤!' . $ex->getMessage();
            }

            return self::$message;
        }

        /**
         * @param Request $request
         * 取得上方依賴列表
         * 依照apply_member_id & form_id 取出是form_id類型且為apply_member_id提出且未被使用過的資料
         * @inpit form_id : 指定表單類型ID，若無則不區分
         * @input apply_member_id : 指定填單人員ID
         * @return array['data'][0]['id'] : 表單ID
         * @return array['data'][0]['created_at'] : 申請時間(原始值)
         * @return array['data'][0]['updated_at'] : 修改時間(原始值)
         * @return array['data'][0]['form_id'] : 表單類型ID
         * @return array['data'][0]['apply_member_id'] : 申請人員ID
         * @return array['data'][0]['status'] : 狀態值
         * @return array['data'][0]['now'] : 目前關卡ID
         * @return array['data'][0]['next'] : 下一關卡ID
         * @return array['data'][0]['fail_at'] : 作廢時間
         * @return array['data'][0]['created_at_format'] : 申請時間(格式化值)
         * @return array['data'][0]['form_type'] : 表單類型名稱
         * @return array['data'][0]['status_string'] : 狀態文字值
         * @return array['data'][0]['department'] : 申請者部門名稱
         * @return array['data'][0]['member'] : 申請者姓名
         * @return array['data'][0]['apply_subject'] : 表單主旨
         */
        public function depend ( Request $request ) {

            try {
                //先找到form_grant_id已被用過的清單
                $used_form_apply_id = FormData::where('column', 'form_grant_id')->pluck('value');

                $list = FormApply::whereNull('fail_at')
                    ->where('form_id', $request->get('form_id'))
                    ->where('apply_member_id', $request->get('apply_member_id'))
                    ->whereNotIn('id', $used_form_apply_id)
                    ->whereNull('now')
                    ->whereNull('next')
                    ->get();

                //取得session資料
                $member = SessionController::getSession('member');
                $department = SessionController::getSession('department');

                $status = Config('form_status.apply');

                $list->map(function ( $item ) use ( $member, $department, $status ) {

                    $department_id = ( isset($member[ $item->apply_member_id ]) ) ? $member[ $item->apply_member_id ]['department_id'] : null;
                    $dpartment = ( isset($department[ $department_id ]) ) ? $department[ $department_id ]['name'] : '';

                    $item->created_at_format = $item->created_at->format('Y-m-d');
                    $item->form_type = Config('form')[ $item->form_id ]['name'];
                    $item->status_string = $status[ $item->status ];
                    $item->department = $dpartment;
                    $item->member = ( isset($member[ $item->apply_member_id ]) ) ? $member[ $item->apply_member_id ]['name'] : '';
                    $item->apply_subject = $item->data()->where('column', 'apply_subject')->pluck('value')->get(0);

                    return $item;
                });

                self::$message['status'] = 1;
                self::$message['status_string'] = '取得成功';
                self::$message['message'] = '';
                self::$message['data'] = $list;

            } catch ( \Exception $ex ) {
                DB::rollback();
                self::$message['status_string'] = '取得失敗';
                self::$message['message'] = '資料庫錯誤!' . $ex->getMessage();
            }

            return self::$message;
        }

        /**
         * @param $checkPoint
         * @param $signUserId
         * @return Boolean
         */
        private function checkCanSigning ( FormApplyCheckpoint $checkPoint, $signUserId, $rewriteMessage = true ) {
            if ( !$checkPoint->status == 1 && !$checkPoint->signed_at === null ) {
                //此關已簽
                if ( $rewriteMessage ) {
                    self::$message['status_string'] = '簽核失敗';
                    self::$message['message'] = '此關卡已簽核，請勿重複簽署';
                }

                return false;
            }
            //檢查是否為可代簽人
            $replace_members = json_decode($checkPoint->replace_members, true);
            /*非簽單本人*/
            if ( $checkPoint->signed_member_id != $signUserId ) {
                /*確認是否為代簽人*/
                if ( !in_array($signUserId, $replace_members) ) {
                    if ( $rewriteMessage ) {
                        self::$message['status_string'] = '簽核失敗';
                        self::$message['message'] = '您所在的關卡有卡關或您並非簽署者';
                    }
                    return false;
                }
            }

            /*確認前面是否有關卡還尚未簽核*/ /*如果不是第一關需要判斷是否前面關卡*/
            /*取出前面所有關卡*/
            if ( $checkPoint->review_order != 1 ) {
                $befoerCheckList = FormApplyCheckpoint::where('form_apply_id', $checkPoint->form_apply_id)
                    ->where('review_order', '<', $checkPoint->review_order)
                    ->get();
                /*判斷關卡是否已有駁回*/ /*已有人駁回 不需要再簽核了*/
                //  status    簽核狀態 0:駁回 1:待簽核 2:通過'
                if ( $befoerCheckList->where('status', 0)->count() > 0 ) {
                    if ( $rewriteMessage ) {
                        self::$message['status_string'] = '簽核失敗';
                        self::$message['message'] = '此表單已有人駁回';
                    }
                    return false;
                };
                /*執行者不能取代與代簽*/
                if ( $befoerCheckList->where('status', 1)->count() > 0 && $checkPoint->role == 2 ) {
                    if ( $rewriteMessage ) {
                        self::$message['status_string'] = '簽核失敗';
                        self::$message['message'] = '此表單前面尚有卡關執行者無法取代簽核';
                    }
                    return false;
                }
                //  取出 前面關卡未簽 checkpoint 確認是否有設定 卡關*/
                //  overwrite 是否可被上層簽核取代   0:不可 1:可'
                $overWriteData = $befoerCheckList->where('status', 1)->where('overwrite', 0);

                if ( $overWriteData->count() > 0 ) {
                    $overWriteName = $overWriteData->pluck('signed_member_id')->map(function ( $v, $k ) {
                        return getMember($v);
                    });
                    if ( $rewriteMessage ) {
                        self::$message['status_string'] = '簽核失敗';
                        self::$message['message'] = '此表單前面尚有卡關無法取代簽核' . $overWriteName->implode(',');
                    }
                    return false;
                }
            };

            return true;

        }

        /**
         * @param Request $request
         * @param $checkPoint
         * @param string $now
         */
        private function signingBeforeMe ( Request $request, $checkPoint ): void {
            $now = date('Y-m-d H:i:s');
            /*如果不是駁回可以代簽前面*/ //比我前面且不卡關的人全部代簽掉
            //                status 0:駁回 1:暫存中 2:簽核中 3:通過
            if ( $request->get('status') != 0 ) {
                $FormApplyCheckBefore = FormApplyCheckpoint::where('review_order', '<', $checkPoint->review_order)
                    ->where('form_apply_id', $checkPoint->form_apply_id)
                    ->whereNull('signed_at')
                    ->where('overwrite', 1)
                    ->get();
                $FormApplyCheckBefore->each(function ( $v ) use ( $now, $request ) {
                    $v->signed_at = $now;
                    $v->signature = $request->get('signature');
                    $v->status = $request->get('status');
                    if($request->get('member_id') != $v->signed_member_id){
                        $v->replace_signed_member_id = $request->get('member_id');
                    }

                    $v->save();
                });
            }
        }
    }
