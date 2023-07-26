<?php

namespace Gandhist\Ematerai;

use Illuminate\Support\Facades\Cache;

class RemoteApi extends Authorization
{

    /**
     * function get method
     * @param string $url = end point 
     * @param array $data_hash
     * @return string
     */
    public function get($url, $data_hash){
        return $this->remoteCall($url, $data_hash, 'GET');
    }

    /**
     * function post method
     * @param string $url = end point 
     * @param array $data_hash
     * @return string
     */
    public function post($url, $data_hash){
        return $this->remoteCall($url, $data_hash, 'POST');
    }

    /**
     * function to call api
     * @param string $url
     * @param array $data_hash
     * @param string $method
     * @return string
     */
    public function remoteCall(string $url, array $data_hash, string $method){
        $token = Cache::get('materai_access_token');
        $ch = curl_init();
        $curl_options = array(
            CURLOPT_URL => Config::getBaseUrl().$url,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer ' . $token
            ),
            CURLOPT_RETURNTRANSFER => 1
        );
        if ($method != 'GET') {

            if ($data_hash) {
                $body = json_encode($data_hash);
                $curl_options[CURLOPT_POSTFIELDS] = $body;
            } else {
                $curl_options[CURLOPT_POSTFIELDS] = '';
            }

            if ($method == 'POST') {
                $curl_options[CURLOPT_POST] = 1;
            } elseif ($method == 'PATCH') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            }
        }
        curl_setopt_array($ch, $curl_options);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        return $result;
    }


}