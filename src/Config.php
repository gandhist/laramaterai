<?php

namespace Gandhist\Ematerai;

/**
 * E Materai configurations
 */
class Config{

    /**
     * true for production
     * false for sanbox mode
     */
    public static $isProduction = false;

    /**
     * Your client ID
     */
    public static $clientId;

    /**
     * Your client secret
     */
    public static $clientSecret;

    /**
     * Your auth code
     */
    public static $authCode;

    const PRODUCTION_BASE_URL = "https://api.mekari.com/v2/esign/v1";
    const SANDBOX_BASE_URL = "https://sandbox-api.mekari.com/v2/esign/v1";
    const PRODUCTION_SSO_BASE_URL = "https://account.mekari.com";
    const SANDBOX_SSO_BASE_URL = "https://sandbox-account.mekari.com";

    /**
     * get base url, depends on $isProduction
     */
    public static function getBaseUrl(){
        return Config::$isProduction ?
        Config::PRODUCTION_BASE_URL : Config::SANDBOX_BASE_URL;
    }

    /**
     * get SSO url, depends on $isProduction
     */
    public static function getSSOBaseUrl(){
        return Config::$isProduction ?
        Config::PRODUCTION_SSO_BASE_URL : Config::SANDBOX_SSO_BASE_URL;
    }

}