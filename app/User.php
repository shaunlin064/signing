<?php

namespace App;

use App\Http\Controllers\ApiController;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Http;

class User extends Authenticatable
{
    use Notifiable;

    public $users;
    public $department;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','erp_user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getErpUser ()
    {
	    $returnData = Http::asForm()->post(env('API_GET_MEMBER_URL'),[ 'token' => env('API_TOKEN') ])->json();
        $this->department = $returnData['data']['department'];

        foreach($returnData['data']['member'] as $key => $item){
            if(isset($this->department[$item['department_id']])){
                /*user 直接增加部門名稱*/
                $returnData['data']['member'][$key]['department_name'] = $this->department[$item['department_id']]['name'];
                /*department 增加同部門人員*/
                $this->department[$item['department_id']]['members'][] = $item;
            }else{
                $returnData['data']['member'][$key]['department_name'] = '';
            }
        }
        $this->users = $returnData['data']['member'];
        $returnData['data']['member_alive'] = collect($returnData['data']['member'])->where('user_resign_date','0000-00-00')->toarray();
        $returnData['data']['department'] = $this->department;
        return $returnData;
    }
	
	public function getApiToken()
	{
		// 不使用 remember token，回傳空字串
		return $this->api_token;
	}
	
	public function setApiToken($value = null)
	{
		$this->api_token = $value;
		$this->update();
	}
	
	public function getApiTokenName()
	{
		return 'api_token';
	}
}
