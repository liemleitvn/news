<?php
/**
 * Created by PhpStorm.
 * User: liemleitvn
 * Date: 09/10/2018
 * Time: 22:13
 */

namespace App\Helpers;


class ApiHelper
{
    private $apiEndPoint;
    private $apiVersion;

    public function __construct()
    {
        $this->apiEndPoint = config('api.end_point');
        $this->apiVersion = "";
    }

    /**
     * Combine URL with endpoint, path and params
     * @author Liem Le
     * @param $path
     * @param array $params
     * @return \Illuminate\Config\Repository|mixed|string
     */
    private function _makeUrl($path, $params = []) {
        $url = $this->apiEndPoint;

        if (!empty($this->apiVersion)) {
            $url .= "/{$this->apiVersion}";
        }

        $url .= "/{$path}";

        if (!empty($params)) {

//            //create querystring from params as: keyword=1&id=2
//            $queryString = http_build_query($params);
//            $url .= "?$queryString";

            foreach ($params as $param) {
                $url .= "/$param";
            }
        }

        return $url;
    }

    private function _getHeader() {
        $token = session('token');
        return [
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        ];
    }

    public function getJson($path, $params = []) {
        // http://blog.local/api/v1/posts?keyword=test&cat_id=1
        // ENDPOINT/VERSION/PATH?PARAMS

        $ch = curl_init();
        $url = $this->_makeUrl($path, $params);

        $headers = $this->_getHeader();
//        $headers[''] = 'abc';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $result = curl_exec($ch);

        curl_close($ch);

        $result = json_decode($result, true);

        return $result;
    }

    public function postJson($path, $data) {
        $url = $this->_makeUrl($path);
        $headers = $this->_getHeader();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);

        curl_close($ch);

        dd($result);

    }

    public function updateJson($path, $data, $params) {
        $url = $this->_makeUrl($path, $params);
        $headers = $this->_getHeader();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);

        curl_close($ch);

        dd($result);
    }

    public function deleteJson($path, $params) {
        $url = $this->_makeUrl($path, $params);
        $headers = $this->_getHeader();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        $result = curl_exec($ch);

        return $result;
    }
}
