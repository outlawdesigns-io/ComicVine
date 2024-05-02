<?php

class ComicVine{

    const APIBASE = 'https://comicvine.gamespot.com/api/';
    const QUERYSEP = '?';
    const RATELIMIT = 450;
    const API_ENV_VAR = 'COMIC_VINE_API_KEY';
    const USER_AGENT_STR = 'MYTESTUSERAGENTTHATISUREHOPEISUNIQUE';

    public function __construct(){
        $this->_loadApiKey();
    }

    protected static function _loadApiKey(){
        if(!$apiKey = getenv(self::API_ENV_VAR)){
          throw new Exception('Unable to access environment variable: ' . self::API_ENV_VAR);
        }
        return $apiKey;
    }

    protected function _apiCall($url){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_USERAGENT,self::USER_AGENT_STR);
        $output = curl_exec($ch);
        curl_close($ch);
        return simplexml_load_string($output,null,LIBXML_NOCDATA);
    }
    public static function search($query){
        $data = array(
            "api_key"=>self::_loadApiKey(),
            "query"=>$query
        );
        $url = self::APIBASE . 'search/?' . http_build_query($data);
        $obj = new self();
        return $obj->_apiCall($url);
    }
    public static function followURI($url){
        $data = array("api_key"=>self::_loadApiKey());
        $url .= self::QUERYSEP .  http_build_query($data);
        $obj = new self();
        return $obj->_apiCall($url);
    }
}
