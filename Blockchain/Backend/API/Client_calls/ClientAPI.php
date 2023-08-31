<?php
require_once 'Blockchain/Backend/API/Client_calls/BaseCurl.php';
class ClientAPI extends BaseCurl
{
    public static $clientAddress = 'http://localhost:5000/generate_keys';

    public static function postRequestAPI($curlObject)
    {
        curl_setopt($curlObject, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curlObject);

        if (curl_errno($curlObject)) {
            return ["error"=>true, "errorType" => "Curl Error", "data" => curl_error($curlObject)];
        } else {
            return ["data" => $response];
        }
    }

    public static function errorHandleResponse($data): bool
    {
        return array_key_exists('error', $data);
    }


}