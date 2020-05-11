<?php
	/**
	 * Created by PhpStorm.
	 * User: shaun
	 * Date: 2020-05-11
	 * Time: 16:59
	 */

	namespace App\Http\Controllers;

    use Illuminate\Support\Str;
    use Illuminate\Http\Request;

	class ApiController extends Controller
	{

		public function curlPost ($Jsondata,$url,$contentType='json')
		{

			$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POST, true);
			if($contentType == 'form'){
				curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
			}elseif($contentType == 'json'){
				curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
			}
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $Jsondata);
			$output = curl_exec($ch);
            $curl_errno = curl_errno($ch);
            $curl_error = curl_error($ch);

            if ($curl_errno > 0) {
               dd("cURL Error ($curl_errno): $curl_error");
            }
			$output = json_decode($output, true);

            curl_close($ch);

			return $output;
		}

        /**
         * Update the authenticated user's API token.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array
         */
        public function update(Request $request)
        {
            $token = Str::random(60);

            $request->user()->forceFill([
                'api_token' => hash('sha256', $token),
            ])->save();

            return ['token' => $token];
        }


	}
