<?php
abstract class BaseCurl
{
    public static function curlSkeletonIfDataSend($curlObj, $OpType, $data)
    {
        curl_setopt($curlObj, CURLOPT_CUSTOMREQUEST, $OpType);
        curl_setopt($curlObj, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
                // Set an authorization header if needed
                // 'Authorization: Bearer YourAccessToken',
        );
        $response = curl_exec($curlObj);
        // Get the HTTP response code
        $httpCode = curl_getinfo($curlObj, CURLINFO_HTTP_CODE);

        // Check for cURL errors and handle response code
        if (curl_errno($curlObj))
        {
            return ["error"=>true, "errorType" => "Curl Error", "data"=>curl_error($curlObj)];
        }
        elseif ($httpCode >= 400)
        {
            return ["error" => true, "errorType" => "HTTP Error", "data" => $httpCode];
        } else
        {
            return ["data" => $response];
        }
    }

    public static function closeCurl($curlObj)
    {
        curl_close($curlObj);
    }
}