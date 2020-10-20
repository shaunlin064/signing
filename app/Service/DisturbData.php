<?php
	/**
	 * Created by PhpStorm.
	 * User: shaun
	 * Date: 2020/10/15
	 * Time: 14:39
	 */
	
	namespace App\Service;
	
	use App\FinancialList;
	use App\User;
	use Carbon\Carbon;
	use Faker\Factory;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Facades\Storage;
	
	class DisturbDataService{
		
		public function user (  ) {
			// epr user name email
			$users = \App\User::all();
			$faker = Factory::create();
			$users->each(function($user) use($faker){
				$name = $faker->firstName;
				$email = $faker->email;
				while(\App\User::where('name' , $name)->orWhere('email' , $email)->exists()){
					$name = $faker->firstName;
					$email = $faker->email;
				}
				if($user->id == 129){
					$name = 'Admin';
				}
				$user->update([
					'name' => $name,
					'email' => $email,
					'password' => Hash::make('demo')
				]);
			});
		}
		
		public function getFakeSession (  ) {
			$user = auth()->user();
			$userAll = User::all();
			$sessionData = json_decode(Storage::get('fakeSession.text'),true);
			
			
			$sessionData['data']['member'] = collect($sessionData['data']['member'])->map(function($item,$erpuserId) use($userAll){
				$user = $userAll->where('erp_user_id',$erpuserId)->first();
				if(empty($user)){
					$faker = Factory::create();
					$user = User::create([
						'name' => $faker->name,
						'email' => $faker->email,
						'password' => Hash::make('demo'),
						'erp_user_id' => $erpuserId
					]);
				}
				$item["name"] = $user->name;
				$item["org_name"] = $user->name;
				$item["org_name_ch"] = $user->name;
				$item["email"] = $user->email;
				$item["account"] = $user->name;
				$item["code"] = "";
				return $item;
			})->toArray();
			$sessionDataMember = collect($sessionData['data']['member'])->map(function($item){
				if($item['department_id'] == 27){
					$item['department_name'] = '總經理室';
				}
				return $item;
			});
			
			$sessionData['data']['department'] = collect($sessionData['data']['department'])->map(function($items,$depId) use($sessionDataMember){
				
				switch($depId){
					case '27':
						$items['name'] = '總經理室';
						break;
				}
				if(!isset($items['members'])){
					$items['members'] = [];
					return $items;
				}
				foreach($items['members'] as $key => &$item){
					$item = $sessionDataMember[$item['id']];
				}
				return $items;
			})->toArray();
			
			foreach( $sessionData['data']['member_alive'] as $erpUserId => &$item) {
				$item = $sessionDataMember[$erpUserId];
			}
			
			$sessionData['message'] = '歡迎 '.$user->name;
			$sessionData['data']['login_user']['name'] = $user->name;
			$sessionData['data']['login_user']['email'] = $user->email;
			$sessionData['data']['login_user']['id'] = $user->erp_user_id;
			$sessionData['data']['login_user']['department_id'] = $sessionDataMember[$user->erp_user_id]['department_id'];
			$sessionData['data']['login_user']['department'] = $sessionDataMember[$user->erp_user_id]['department_name'];
			Storage::put('fakeSession.text',json_encode($sessionData));
			return 	$sessionData;
		}
	}