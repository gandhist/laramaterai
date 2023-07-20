<?php 

namespace Gandhist\Ematerai;
use Exception;
use Illuminate\Support\Facades\Cache;


class Authorization {

    /**
     * checking if refresh token is null
     * will call function getAuthToken, to get and store token in cache
     * if refresh token is set and if token is null then call function refresh token
     */
    public function __construct()
    {
        $refresh_token = Cache::get('materai_refresh_token');
        if($refresh_token == null){
            $this->getAuthToken();
        }
        else {
            $token = Cache::get('materai_access_token');
            if($token == null){
                $this->refreshToken();
            }
        }
    }

    /**
     * Request to get auth token
     * clear cache access token and refresh token first
     * store access token with expire time 3600 and store refresh token as well
     * @throw Exception
     */
    public function getAuthToken(){

        // validation client id not defined
        if(!Config::$clientId){
            throw new Exception(
                'The clientId/clientSecret is null, You need to set the clientId from Config. Please double-check Config and clientId key.'
            );
        }
        // validation if client secret is null
        if(!Config::$clientSecret){
            throw new Exception(
                'The clientId/clientSecret is null, You need to set the clientSecret from Config. Please double-check Config and clientSecret key.'
            );
        }
        // clear cache 
        Cache::forget('materai_access_token');
        Cache::forget('materai_refresh_token');

        $ch = curl_init();
        $body = json_encode([
            'client_id' => Config::$clientId,
            'client_secret' => Config::$clientSecret,
            'grant_type' => 'authorization_code',
            'code' => Config::$authCode,
        ]);
        $curl_options = array(
            CURLOPT_URL => Config::getSSOBaseUrl() . "/auth/oauth2/token",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
            ),
            CURLOPT_RETURNTRANSFER => 1
        );
        $curl_options[CURLOPT_POST] = 1;
        $curl_options[CURLOPT_POSTFIELDS] = $body;
        curl_setopt_array($ch, $curl_options);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        if($result){
            $result = json_decode($result, true);
            Cache::put('materai_access_token', $result['access_token'], $result['expires_in']);
            Cache::put('materai_refresh_token',  $result['refresh_token']);
            Cache::put('materai_expires_in',  $result['expires_in']);
            return $result['access_token'];
        } else {
            throw new \Exception('CURL Error: ' . curl_error($ch), curl_errno($ch));
        }
    }

    /**
     * Request to refresh token
     * if success to get response cache will forget keys materai_access_token and materai_refresh_token
     * and set new value to these key
     * return new access token
     */
    public function refreshToken(){
        $ch = curl_init();
        $body = json_encode([
            'client_id' => Config::$clientId,
            'client_secret' => Config::$clientSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => Cache::get('materai_refresh_token'),
        ]);
        $curl_options = array(
            CURLOPT_URL => Config::getSSOBaseUrl() . "/auth/oauth2/token",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
            ),
            CURLOPT_RETURNTRANSFER => 1
        );
        $curl_options[CURLOPT_POST] = 1;
        $curl_options[CURLOPT_POSTFIELDS] = $body;
        curl_setopt_array($ch, $curl_options);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        if($result){
            Cache::forget('materai_access_token');
            Cache::forget('materai_refresh_token');
            $result = json_decode($result, true);
            Cache::put('materai_access_token', $result['access_token'], $result['expires_in']);
            Cache::put('materai_refresh_token',  $result['refresh_token']);
            Cache::put('materai_expires_in',  $result['expires_in']);
            return $result['access_token'];
        } else {
            throw new \Exception('CURL Error: ' . curl_error($ch), curl_errno($ch));
        }
    }
    
}