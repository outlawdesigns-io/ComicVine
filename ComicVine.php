<?php

require_once __DIR__ . '/ApiKey.php';

class ComicVine{

    const APIBASE = 'https://comicvine.gamespot.com/api/';
    const QUERYSEP = '?';
    const RATELIMIT = 450;

    public function __construct(){}

    protected function _apiCall($url){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_USERAGENT,'MYTESTUSERAGENTTHATISUREHOPEISUNIQUE');
        $output = curl_exec($ch);
        curl_close($ch);
        return simplexml_load_string($output,null,LIBXML_NOCDATA);
    }
    public static function search($query){
        $data = array(
            "api_key"=>APIKEY,
            "query"=>$query
        );
        $url = self::APIBASE . 'search/?' . http_build_query($data);
        $obj = new self();
        return $obj->_apiCall($url);
    }
    public static function followURI($url){
        $data = array("api_key"=>APIKEY);
        $url .= self::QUERYSEP .  http_build_query($data);
        $obj = new self();
        return $obj->_apiCall($url);
    }
}
