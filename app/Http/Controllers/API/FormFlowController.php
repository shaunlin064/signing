<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\FormFlow;
use DB;

class FormFlowController extends Controller
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
     * 表單流程設定列表
     * 依照page頁碼取額每頁數量或每頁15個列表，回傳data包含pagination資料
     * @input page: 頁碼
     * @input item: 每頁數量
     * @return array
     */
    public function list(Request $request){

        try {
            $_GET['page'] = $request->get('page');
            $pagination = ($request->get('item') != NULL) ? $request->get('item') : 15;
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

    /**
     * @param Request $request
     * 取得表單流程設定內容
     * 依照id取得該flow關卡詳細資料
     * @input id: 流程設定紀錄ID(form_flow id)
     * @return array
     */
    public function get(Request $request){

        try {
            $FormFlow = FormFlow::findOrFail($request->get('id'))->toArray();

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

    /**
     * @param Request $request
     * 表單流程設定新增
     * 依照資料欄位傳入並寫入資料庫
     * @input form_id: 表單ID
     * @input review_order: 簽核順序
     * @input review_type: 簽核類型 1:指定人 2:指定位階
     * @input reviewer_id: 指定簽核人ID or 簽核位階 1:一階主管 2:二階主管 3:三階主管
     * @input overwrite: 是否可被上層簽核取代 0:不可 1:可
     * @input replace: 是否有代簽 0:不可 1:可
     * @input role: 角色 1:簽核 2:執行
     * @return array
     */
    public function add(Request $request){

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

    /**
     * @param Request $request
     * 表單流程設定編輯
     * 依照資料欄位傳入併更新資料庫
     * @input id: 編輯流程設定ID(form_flow id)
     * @input form_id: 表單ID
     * @input review_order: 簽核順序
     * @input review_type: 簽核類型 1:指定人 2:指定位階
     * @input reviewer_id: 指定簽核人ID or 簽核位階 1:一階主管 2:二階主管 3:三階主管
     * @input overwrite: 是否可被上層簽核取代 0:不可 1:可
     * @input replace: 是否有代簽 0:不可 1:可
     * @input role: 角色 1:簽核 2:執行
     * @return array
     */
    public function edit(Request $request){

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

    /**
     * @param Request $request
     * 表單流程設定刪除
     * 依照id確認資料是否存在，存在則移除該筆資料，並且一並移除設定好的代簽資料
     * @input id: 編輯流程設定ID(form_flow id)
     * @return array
     */
    public function delete(Request $request){

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
}
