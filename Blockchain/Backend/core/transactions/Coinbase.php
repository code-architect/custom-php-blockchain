<?php
require_once 'Blockchain/Backend/core/transactions/TxIn.php';
require_once 'Blockchain/Backend/core/transactions/TxOut.php';
require_once 'Blockchain/Backend/core/transactions/Tx.php';
require_once 'Blockchain/Backend/core/Script.php';
require_once 'Blockchain/Backend/util/util.php';
require_once 'Blockchain/Backend/API/Client_calls/PluginHelperAPI.php';

const ZERO_HASH = "0000000000000000000000000000000000000000000000000000000000000000";
const REWARD = 50;
const PRIVATE_KEY = "56114968769095885066321288702375272595970830268400415922098497799492460020984";
const MINER_ADDRESS = "1K3if2mFojLAWVtdD1eeYYKNVCwghpBvgb";

class Coinbase {
    public function __construct($blockHeight) {
        $this->blockHeightIntLittleEndian = intToLittleEndian($blockHeight, bytesNeeded($blockHeight));
    }

    public function coinbaseTransaction() {
        $prevTx = hex2bin(ZERO_HASH);
        $prevIndex = 0xFFFFFFFF;

        $txIns = [];
        $txIns[] = new TxIn($prevTx, $prevIndex);
        $txIns[0]->scriptSig->cmds[] = $this->blockHeightIntLittleEndian;

        $txOuts = [];
        $targetAmount = REWARD * 100000000;
        $hexValue = $this->decodeBase58API(MINER_ADDRESS);
        $targetH160 = $hexValue;
        $targetScript = Script::p2pkhScript($targetH160);
        $txOuts[] = new TxOut($targetAmount, $targetScript);

        return new Tx(1, $txIns, $txOuts, 0);
    }

    public function decodeBase58API($value)
    {
        $address = PluginHelperAPI::$clientAddress;
        $url = $address."get_decode_base58";
        $ch = curl_init($url);
        $data = json_encode(array(
            "value" => $value
        ));
        $val = PluginHelperAPI::curlSkeletonIfDataSend($ch, "POST", $data);
        $data = json_decode($val['data'], true);
        return $data['byte_data'];
    }

}

//$address = PluginHelperAPI::$clientAddress;
//$url = $address."get_decode_base58";
//$ch = curl_init($url);
//$data = json_encode(array(
//    "value" => "1K3if2mFojLAWVtdD1eeYYKNVCwghpBvgb"
//));
//$val = PluginHelperAPI::curlSkeletonIfDataSend($ch, "POST", $data);
//$data = json_decode($val['data'], true);
//echo "\n\n";
//print_r($data['byte_data']);
//function decodeBase58API($value)
//{
//    $address = PluginHelperAPI::$clientAddress;
//    $url = $address . "get_decode_base58";
//    $ch = curl_init($url);
//    $data = json_encode(array(
//        "value" => $value
//    ));
//    $val = PluginHelperAPI::curlSkeletonIfDataSend($ch, "POST", $data);
//    $data = json_decode($val['data'], true);
//    return $data['byte_data'];
//}
//
//$data = decodeBase58API("1K3if2mFojLAWVtdD1eeYYKNVCwghpBvgb");
//echo "\n\n";
//print_r($data);
//echo "\n\n";
//
//
//$binaryData = hex2bin($data);
//print_r($binaryData);
//echo "\n\n";
//
//// Perform operations on the binary data (if needed)
//
//// Convert the binary data back to a hexadecimal string
//$resultHexadecimal = bin2hex($binaryData);
//
//// Output the result
//echo $resultHexadecimal;

////$hexString = $data;
////$byteString = 'b"' . implode('\x', str_split($hexString, 2)) . '"';
//$byteString = hex2bin($data);
//$formattedBinary = 'b"';
//foreach (str_split($byteString) as $byte) {
//    $formattedBinary .= '\x' . bin2hex($byte);
//}
//$formattedBinary .= '",';
//
//echo $formattedBinary;
//echo "\n\n";
//
//$hexString = '';
//$matches = [];
//if (preg_match('/b"(.+)",/', $formattedBinary, $matches)) {
//    $hexBytes = explode('\x', $matches[1]);
//    foreach ($hexBytes as $hexByte) {
//        $hexString .= chr(hexdec($hexByte));
//    }
//    $hexString = bin2hex($hexString);
//    echo $hexString;
//} else {
//    echo "Invalid format.";
//}
//echo "\n\n";
//
//$hexString = '';
//$matches = [];
//
//if (preg_match('/b"(.+)",/', $formattedBinary, $matches)) {
//    $hexBytes = explode('\x', $matches[1]);
//    foreach ($hexBytes as $hexByte) {
//        $hexString .= bin2hex(hex2bin($hexByte));
//    }
//    echo $hexString;
//} else {
//    echo "Invalid format.";
//}