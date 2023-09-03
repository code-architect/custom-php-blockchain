<?php
require_once 'Blockchain/Backend/API/Client_calls/ClientAPI.php';

//$ch = curl_init(ClientAPI::$clientAddress);
//$response = ClientAPI::curlSkeleton($ch, "POST", $data_string);

// URL of the Flask API
 // Update with your actual API URL


$ch = curl_init(ClientAPI::$clientAddress);
$response = ClientAPI::postRequestAPI($ch);

$jsonData = $response['data'];
$data = json_decode($jsonData, true, 512, JSON_BIGINT_AS_STRING);
print_r($data['privateKey']);