<?php
require_once 'Blockchain/Backend/API/Client_calls/BaseCurl.php';
class PluginHelperAPI extends BaseCurl
{
    public static $clientAddress = 'http://localhost:5000/';

    public static function postRequestAPI($url, $postData)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo "cURL Error: " . curl_error($ch);
            die();
        }
        return $response;
    }

}