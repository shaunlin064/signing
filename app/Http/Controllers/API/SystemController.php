<?php


    namespace App\Http\Controllers\API;

    use App\Http\Controllers\ApiController;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\SessionController;
    use App\SystemMessage;
    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
    use Route;

    /**
     * Class SystemController
     * @package App\Http\Controllers\API
     */
    class SystemController extends Controller {
        //
        /**
         * @var string
         * 加解密key
         */
        public static $encrypt = "FAA2C53CA77AEF2F77C6E3C83C81B798";
        /**
         * @var array
         * API回傳訊息格式
         * status : 成功或失敗狀態 0 失敗 1 成功
         * status_string : 狀態文字
         * message : API成功或失敗訊息說明
         * data : API執行成功夾帶資料
         */
        protected static $message
            = [
                'status'        => 0,
                'status_string' => '',
                'message'       => '',
                'data'          => []
            ];

        /**
         * @param $username : 帳號
         * @param $password :md5後的密碼
         * 執行遠端登入
         * 先檢查是不是客戶以及預設manager帳號
         * 如果都不是則透過curl向遠端伺服器發出驗證申請
         * 驗證成功後再向遠端伺服器取得部門資料
         * @return array
         */
        protected static function remoteLogin ( $username, $password ) {
            try {
                //後台管理員登入
                //API取得後台系統登入者資訊與人員相關資訊
	            $data = [
		            'username'=> $username,
		            'password'=> $password,
		            'apikey'=> self::$encrypt
	            ];
	
	            $result =  Http::asForm()->post(env('API_LOGIN_URL'),$data)->json();

                if ( $result['status'] !== 1 ) {//登入失敗
                    ( new SystemController )->loginFail($result);
                    return self::$message;
                }

                $user = $result['data']['user'];
                //取得人員部門資料
                $objUser      = new User();
                $resultMember = $objUser->getErpUser();

                if ( $resultMember['status'] !== 1 ) {//登入失敗
                    ( new SystemController )->loginFail($resultMember);
                    return self::$message;
                }

                self::$message['status']        = 1;
                self::$message['status_string'] = '登入成功';
                self::$message['message']       = '歡迎 ' . $user['name'];
                self::$message['data']          = [
                    'login_user'   => $user,
                    'department'   => $resultMember['data']['department'],
                    'member'       => $resultMember['data']['member'],
                    'member_alive' => $resultMember['data']['member_alive'],
                ];

            } catch ( \Exception $ex ) {
                self::$message['status_string'] = '登入失敗';
                self::$message['message']       = $ex->getMessage();
            }

            return self::$message;
        }
	
	    public function loginFail ( $result ) {
            self::$message['status_string'] = '登入失敗';
            self::$message['message']       = $result['message'];
        }

        /**
         * @param Request $request
         * 執行帳號密碼登入或key登入
         * 可接收帳號密碼(md5後)透過遠端登入，或者由key直接解密進行遠端登入
         * @input key : 登入key
         * @input account : 登入帳號
         * @input password : md5後的登入密碼
         * @return array
         */
        public function login ( Request $request ) {
            $account  = '';
            $password = '';
            if ( $request->get('key') != null ) {
                //由key登入的狀況
                $result = explode('_', self::decrypt($request->get('key'), 'AES-256-CBC'));
                if ( count($result) != 2 ) {
                    self::$message['status_string'] = '登入錯誤';
                    self::$message['message']       = '登入連結有誤，請重新取得';

                    return self::$message;
                }
                $account  = $result[0];
                $password = $result[1];
            } else {
                //由帳號密碼登入的狀況
                $account  = $request->get('account');
                $password = $request->get('password');
            }
	        if(env('APP_DEMO')){
		        $credentials = [
		        	'name' => $request->account,
			        'password' => $request->password,
		        ];
		       
		        if (Auth::attempt($credentials)) {
			        Auth::user()->setApiToken($token = Str::random(60));
			        Auth::loginUsingId(auth()->user()->id);
			        $disturbDataService = new \App\Service\DisturbDataService();
			        $message = $disturbDataService->getFakeSession();
		        }else{
			        $message = [
				        "status"        => 2,
				        "status_string" => "登入失敗",
				        "message"       => "帳號密碼錯誤",
				        "data"          => [
				        ]
			        ];
		        }
	        }else{
		        $message = self::remoteLogin($account, $password);
		        $userObj = User::where('name',$account)->first();
		        Auth::loginUsingId($userObj->id);
		        Auth::user()->setApiToken($token = Str::random(60));
	        }
            //將登入資訊儲存至session
            if ( $message['status'] == 1 ) {
	            $message['data']['login_user']['api_token'] = Auth::user()->getApiToken();
                SessionController::store($message['data']);
            }
            
            return $message;
        }

        public function logout ( Request $request ) {
            //操作session
            $api_request = Request::create('session/release', 'POST');
            $api_request = $api_request->replace($request->input());
            $response    = Route::dispatch($api_request)->getOriginalContent();
        }

        /**
         * @param Request $request
         * 執行檔案上傳儲存
         * 依照指定路徑儲存檔案，並回傳詳細資料與檔案URL，支援多檔案上傳
         * @input file : 要上傳的檔案
         * @input dir : 儲存資料夾
         * @return array
         */
        public function upload ( Request $request ) {
            try {
                $item = $request->file('file');
                $dir  = $request->get('dir');
                if ( is_array($item) && count($item) > 1 ) {
                    $url   = [];
                    $files = [];
                    foreach ( $item as $k => $v ) {
                        $path = $v->store($dir);
                        $size = Storage::size($path);
                        $info = pathinfo($path);
                        $tmp  = [
                            'id'        => $info['filename'],
                            'name'      => $v->getClientOriginalName(),
                            'ext'       => $info['extension'],
                            'dir'       => $info['dirname'],
                            'file_size' => $size
                        ];

                        array_push($url, Storage::url($info['dirname'] . '/' . $info['basename']));
                        array_push($files, $tmp);
                    }
                } else {
                    if ( is_array($item) ) {
                        $item = $item[0];
                    }
                    $path = $item->store($dir);
                    $size = Storage::size($path);
                    $info = pathinfo($path);
                    $tmp  = [
                        'id'        => $info['filename'],
                        'name'      => $item->getClientOriginalName(),
                        'ext'       => $info['extension'],
                        'dir'       => $info['dirname'],
                        'file_size' => $size
                    ];

                    $url   = Storage::url($info['dirname'] . '/' . $info['basename']);
                    $files = $tmp;
                }

                self::$message['status']        = 1;
                self::$message['status_string'] = "上傳成功";
                self::$message['data']['url']   = $url;
                self::$message['data']['file']  = $files;
            } catch ( \Exception $ex ) {
                self::$message['status_string'] = "上傳失敗";
                self::$message['message']       = $ex->getMessage();
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
        public function messageList ( Request $request ) {
            try {
                $take    = $request->get('take');
                $message = SystemMessage::where('member_id', $request->get('member_id'))->orderBy('id', 'DESC');
                if ( $take != null && is_numeric($take) ) {
                    $message->take($take);
                }
                $message = $message->get()->toArray();

                self::$message['status']        = 1;
                self::$message['status_string'] = "取得成功";
                self::$message['data']          = $message;

            } catch ( \Exception $ex ) {
                self::$message['status_string'] = "取得失敗";
                self::$message['message']       = $ex->getMessage();
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
        public function messageGet ( Request $request ) {
            try {
                $message = SystemMessage::where('member_id', $request->get('member_id'))->where(
                        'id', $request->get('id')
                    )->first()->toArray();

                self::$message['status']        = 1;
                self::$message['status_string'] = "取得成功";
                self::$message['data']          = $message;

            } catch ( \Exception $ex ) {
                self::$message['status_string'] = "取得失敗";
                self::$message['message']       = $ex->getMessage();
            }

            return self::$message;
        }

        /**
         * @param Request $request
         * 設定訊息為已讀
         * 依照訊息id設定為已讀
         * @input id : 訊息ID Array
         * @input member_id : 接收者ID
         * @return array
         */
        public function messageSetRead ( Request $request ) {

            try {
                $message = SystemMessage::where('member_id', $request->get('member_id'))->whereIn(
                        'id', $request->get('id')
                    );

                if ( $message->exists() ) {
                    $message = SystemMessage::query()->whereIn('id', $request->get('id'))->update(
                        [ 'read_at' => date('Y-m-d H:i:s') ]
                    );

                    self::$message['status']        = 1;
                    self::$message['status_string'] = "設定成功";
                    self::$message['data']          = $message;
                } else {
                    self::$message['status_string'] = "設定失敗";
                    self::$message['data']          = '找不到此訊息';
                }


            } catch ( \Exception $ex ) {
                self::$message['status_string'] = "設定失敗";
                self::$message['message']       = $ex->getMessage();
            }

            return self::$message;
        }

        /**
         * @param Request $request
         * 設定user 所有訊息為已讀
         * @input member_id : 接收者ID
         * @return array
         */
        public function messageSetReadAll ( Request $request ) {

            try {
                $message = SystemMessage::where('member_id', $request->get('member_id'))->whereNull('read_at');

                if ( $message->exists() ) {
                    $id = $message->get()->pluck('id');

                    SystemMessage::query()->whereIn('id', $id)->update([ 'read_at' => date('Y-m-d H:i:s') ]);

                    $message = SystemMessage::where('member_id', $request->get('member_id'))
                                            ->orderBy('id', 'DESC')
                                            ->take(10)
                                            ->get()
                                            ->toArray();

                    self::$message['status']        = 1;
                    self::$message['status_string'] = "設定成功";
                    self::$message['data']          = $message;
                } else {
                    self::$message['status_string'] = "設定失敗";
                    self::$message['data']          = '找不到此訊息';
                }


            } catch ( \Exception $ex ) {
                self::$message['status_string'] = "設定失敗";
                self::$message['message']       = $ex->getMessage();
            }

            return self::$message;
        }

        /**
         * @param string $data : 要解密的資料
         * @param string $method :解密碼的方式
         * 透過key解密
         * @return bool|string
         */
        protected function decrypt ( string $data, string $method ) {
            $data   = base64_decode($data);
            $ivSize = openssl_cipher_iv_length($method);
            $iv     = substr($data, 0, $ivSize);
            $data   = openssl_decrypt(substr($data, $ivSize), $method, self::$encrypt, OPENSSL_RAW_DATA, $iv);

            return $data;
        }

    }
