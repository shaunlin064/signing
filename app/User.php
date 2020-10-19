<?php

namespace App;

use App\Http\Controllers\ApiController;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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
        'password', 'remember_token',
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
        $apiObj = new ApiController();

        $data = 'token=';
        $data .= urlencode(env('API_TOKEN'));
        $url = env('API_GET_MEMBER_URL');

        $returnData = $apiObj->curlPost($data,$url,'form');

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
}
