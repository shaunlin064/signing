<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SystemMessage;

use Storage;
use Cache;
use Carbon\Carbon;

/**
 * Class SystemController
 * @package App\Http\Controllers\API
 */
class SystemController extends Controller
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
     * @var string
     * 加解密key
     */
    public static $encrypt = "FAA2C53CA77AEF2F77C6E3C83C81B798";

    /**
     * @param Request $request
     * 執行帳號密碼登入或key登入
     * 可接收帳號密碼(md5後)透過遠端登入，或者由key直接解密進行遠端登入
     * @input key : 登入key
     * @input account : 登入帳號
     * @input password : md5後的登入密碼
     * @return array
     */
    public function login(Request $request){
        if($request->get('key') != null){
            //由key登入的狀況
            $result = explode('_', self::decrypt($request->get('key'), 'AES-256-CBC'));
            if(count($result) != 2){
                self::$message['status_string'] = '登入錯誤';
                self::$message['message'] = '登入連結有誤，請重新取得';

                return self::$message;
            }

            $message = self::remoteLogin($result[0], $result[1], self::$encrypt);

        }
        else{
            //由帳號密碼登入的狀況
            $message = self::remoteLogin($request->get('account'), $request->get('password'), self::$encrypt);
        }

        //將登入資訊儲存至快取
        $expiresAt = Carbon::now()->addMinutes(120);
        foreach($message['data'] as $k=>$v){
            Cache::put($k,$v,$expiresAt);
        }

        return $message;
    }

    /**
     * @param Request $request
     * 執行檔案上傳儲存
     * 依照指定路徑儲存檔案，並回傳詳細資料與檔案URL，支援多檔案上傳
     * @input file : 要上傳的檔案
     * @input dir : 儲存資料夾
     * @return array
     */
    public function upload(Request $request){
        try {
            $item = $request->file('file');
            $dir = $request->get('dir');
            if(is_array($item) && count($item) > 1){
                $url = [];
                $files = [];
                foreach($item as $k=>$v){
                    $path = $v->store($dir);
                    $size = Storage::size($path);
                    $info = pathinfo($path);
                    $tmp = [
                        'id' => $info['filename'],
                        'name' => $v->getClientOriginalName(),
                        'ext' => $info['extension'],
                        'dir' => $info['dirname'],
                        'file_size' => $size
                    ];

                    array_push($url,Storage::url($info['dirname'].'/'.$info['basename']));
                    array_push($files,$tmp);
                }
            }
            else{
                if(is_array($item)){
                    $item = $item[0];
                }
                $path = $item->store($dir);
                $size = Storage::size($path);
                $info = pathinfo($path);
                $tmp = [
                    'id' => $info['filename'],
                    'name' => $item->getClientOriginalName(),
                    'ext' => $info['extension'],
                    'dir' => $info['dirname'],
                    'file_size' => $size
                ];

                $url = Storage::url($info['dirname'].'/'.$info['basename']);
                $files = $tmp;
            }

            self::$message['status'] =1;
            self::$message['status_string'] = "上傳成功";
            self::$message['data']['url'] = $url;
            self::$message['data']['file'] = $files;
        }catch(\Exception $ex){
            self::$message['status_string'] = "上傳失敗";
            self::$message['message'] = $ex->getMessage();
        }

        return self::$message;
    }

    /**
     * @param Request $request
     * 取得系統訊息列表
     * 依照member_id 取得該使用者的通知訊息
     * @input member_id : 接收者ID
     * @input take : 取多少筆資料 null : 全部列出
     * @return array['data'] : SystemMessageArray
     */
    public function messageList(Request $request){
        try {
            $take = $request->get('take');
            $message = SystemMessage::where('member_id',$request->get('member_id'))
                ->orderBy('id','DESC');
            if($take != null&&  is_numeric($take)){
                $message->take($take);
            }
            $message = $message->get()->toArray();

            self::$message['status'] =1;
            self::$message['status_string'] = "取得成功";
            self::$message['data'] = $message;

        }catch(\Exception $ex){
            self::$message['status_string'] = "取得失敗";
            self::$message['message'] = $ex->getMessage();
        }

        return self::$message;
    }

    /**
     * @param Request $request
     * 取得系統訊息內容
     * 根據ID取得系統訊息內容，接收者必須為member_id
     * @input id : 訊息ID
     * @input member_id : 接收者ID
     * @return array['data'] : SystemMessage
     */
    public function messageGet(Request $request){
        try {

            $message = SystemMessage::where('member_id',$request->get('member_id'))
                ->where('id',$request->get('id'))
                ->first()->toArray();

            self::$message['status'] =1;
            self::$message['status_string'] = "取得成功";
            self::$message['data'] = $message;

        }catch(\Exception $ex){
            self::$message['status_string'] = "取得失敗";
            self::$message['message'] = $ex->getMessage();
        }

        return self::$message;
    }

    /**
     * @param Request $request
     * 設定訊息為已讀
     * 依照訊息id設定為已讀
     * @input id : 訊息ID
     * @input member_id : 接收者ID
     * @return array
     */
    public function messageSetRead(Request $request){

        try {

            $message = SystemMessage::where('member_id',$request->get('member_id'))
                ->where('id',$request->get('id'))
                ->first();

            if($message != null){
                $message->read_at = date('Y-m-d H:i:s');
                $message->save();

                self::$message['status'] =1;
                self::$message['status_string'] = "設定成功";
                self::$message['data'] = $message;
            }
            else{
                self::$message['status_string'] = "設定失敗";
                self::$message['data'] = '找不到此訊息';
            }



        }catch(\Exception $ex){
            self::$message['status_string'] = "設定失敗";
            self::$message['message'] = $ex->getMessage();
        }

        return self::$message;
    }

    /**
     * @param $username : 帳號
     * @param $password :md5後的密碼
     * @param $encrypt :加解密的key
     * 執行遠端登入
     * 先檢查是不是客戶以及預設manager帳號
     * 如果都不是則透過curl向遠端伺服器發出驗證申請
     * 驗證成功後再向遠端伺服器取得部門資料
     * @return array
     */
    protected static function remoteLogin($username, $password, $encrypt)
    {
        try {
            //檢查是否為預設Manager
            $defaultAdminStatus = self::checkDefaultAdmin($username, $password);
            if($defaultAdminStatus['status'] == 0){
                //後台管理員登入
                //API取得後台系統登入者資訊與人員相關資訊
                $post = 'username=' . $username . '&password=' . $password . '&apikey=' . $encrypt;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, env('API_LOGIN_URL'));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);
                curl_close($ch);

                $result = json_decode($result, true);

                if ($result['status'] == 1) { //登入成功

                    //取得人員部門資料
                    $post = 'token=' . urlencode($result['data']['token']);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, env('API_GETMEMBER_URL'));
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $resultMember = curl_exec($ch);
                    curl_close($ch);

                    $resultMember = json_decode($resultMember, true);

                    if ($resultMember['status'] == 1) {//取得成功
                        $user = $result['data']['user'];
                        $department = $resultMember['data']['department'];
                        $member = $resultMember['data']['member'];
                        //增加一個預設管理人員
                        $member[0] = [
                            "id" => 0,
                            "department_id" => 0,
                            "name" => "Admin",
                            "org_name" => "Admin",
                            "org_name_ch" => "管理員",
                            "email" => "it@js-adways.com.tw",
                            "account" => "Admin",
                            "code" => "",
                            "status" => 1
                        ];

                        //整理部門與人員資訊陣列
                        foreach ($department as $k => $v) {
                            $department[$k]['members'] = [];
                            foreach ($member as $k1 => $v1) {
                                if ($v1['department_id'] == $v['id']) {
                                    array_push($department[$k]['members'], $v1);
                                }
                            }
                        }

                        $dataResult = [
                            'login_user' => $user,
                            'member' => $member,
                            'department' => $department
                        ];

                        self::$message['status'] = 1;
                        self::$message['status_string'] = '登入成功';
                        self::$message['message'] = '歡迎 ' . $user['name'];
                        self::$message['data'] = $dataResult;

                    } else {//取得失敗

                        self::$message['status_string'] = '登入失敗';
                        self::$message['message'] = $resultMember['message'];

                    }
                } else {//登入失敗

                    self::$message['status_string'] = '登入失敗';
                    self::$message['message'] = $result['message'];

                }
            }
        }
        catch (\Exception $ex){
            self::$message['status_string'] = '登入失敗';
            self::$message['message'] = $ex->getMessage();
        }

        return self::$message;
    }

    /**
     * @param $username : 帳號
     * @param $password : md5密碼
     * 檢查帳號是否為預設manager帳號
     * 如果是則取得全站可用權限，並且向選端取得所有部門資料
     * 暫時不支援本地端部門資料取得
     * @return array
     */
    protected static function checkDefaultAdmin($username, $password){

        try{
            if(md5($username) == '1d0258c2440a8d19e716292b231e3190' && $password == 'ac886a5225dc159479c53eb978072dab'){
                $adminUser = [
                    "id" => 0,
                    "department_id" => 0,
                    "name" => "Admin",
                    "org_name" => "Admin",
                    "org_name_ch" => "管理員",
                    "email" => "it@js-adways.com.tw",
                    "account" => "Admin",
                    "code" => "",
                    "status" => 1,
                    'created_at' => date('Y-m-d')
                ];

                //取得人員部門資料
                $post = 'token=' . urlencode('\/g5CClHztT2PeHYkSHwMMDFhzPN1KGv4Aotmzt39YzE=');
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, env('API_GETMEMBER_URL'));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $resultMember = curl_exec($ch);
                curl_close($ch);

                $resultMember = json_decode($resultMember, true);
                if ($resultMember['status'] == 1) {//取得成功
                    $department = $resultMember['data']['department'];
                    $member = $resultMember['data']['member'];
                    //增加一個預設管理人員
                    $member[0] = [
                        "id" => 0,
                        "department_id" => 0,
                        "name" => "Admin",
                        "org_name" => "Admin",
                        "org_name_ch" => "管理員",
                        "email" => "it@js-adways.com.tw",
                        "account" => "Admin",
                        "code" => "",
                        "status" => 1
                    ];

                    //整理部門與人員資訊陣列
                    foreach ($department as $k => $v) {
                        $department[$k]['members'] = [];
                        foreach ($member as $k1 => $v1) {
                            if ($v1['department_id'] == $v['id']) {
                                array_push($department[$k]['members'], $v1);
                            }
                        }
                    }
                }

                $dataResult = [
                    'login_user' => $adminUser,
                    'member' => $member,
                    'department' => $department
                ];

                self::$message['status'] = 1;
                self::$message['status_string'] = '登入成功';
                self::$message['message'] = '歡迎 ' . $adminUser['name'];
                self::$message['data'] = $dataResult;
            }
        }
        catch (\Exception $ex){
            self::$message['status_string'] = '登入失敗';
        }

        return self::$message;

    }

    /**
     * @param string $data : 要解密的資料
     * @param string $method :解密碼的方式
     * 透過key解密
     * @return bool|string
     */
    protected function decrypt(string $data, string $method)
    {
        $data = base64_decode($data);
        $ivSize = openssl_cipher_iv_length($method);
        $iv = substr($data, 0, $ivSize);
        $data = openssl_decrypt(substr($data, $ivSize), $method, self::$encrypt, OPENSSL_RAW_DATA, $iv);

        return $data;
    }


}
