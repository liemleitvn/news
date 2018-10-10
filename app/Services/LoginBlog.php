<?php
/**
 * Created by PhpStorm.
 * User: liemleitvn
 * Date: 09/10/2018
 * Time: 14:47
 */

namespace App\Services;

class LoginBlog
{
    public function __construct()
    {

    }

    public function login ($request) {
        $email = $request->get('email');
        $password = $request->get('password');

        $data = array(
            "email"=>$email,
            "password"=>$password,
        );

        $curl = curl_init();
        $url = 'blog.local/api/auth/login';

        curl_setopt($curl, CURLOPT_URL, $url );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($result, true);

        if(isset($result['token'])) {

            //set token session to use api.
            session()->put('token',$result['token']);
        }

        return $result;
    }
}
