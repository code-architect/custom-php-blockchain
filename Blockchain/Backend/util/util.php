<?php
function hash256($s) {
    // Two rounds of SHA256
    return hash('sha256', hash('sha256', $s, true), true);
}

function hash160($data) {
    // Using RIPEMD160 with HMAC-SHA256
    $sha256Hash = hash('sha256', $data, true);
    return hash('ripemd160', $sha256Hash, true);
}

function intToLittleEndian($number, $length)
{
    // Use 'V' format for little-endian and unsigned long
    $value = pack('V', $number);
    return bin2hex($value);
}

function bytesNeeded($n)
{
    if ($n == 0) {
        return 1;
    }
    return intval(log($n, 256)) + 1;
}

function littleEndianToInt($b)
{
    // Reverse the byte array and convert it to an integer
    $reversedBytes = array_reverse(str_split($b));
    $littleEndian = implode('', $reversedBytes);
    return hexdec(bin2hex($littleEndian));
}

// Example usage
//$input = 'some data to hash';
//$hashed256 = hash256($input);
//$hashed160 = hash160($input);
//
//echo "Hashed 256: " . bin2hex($hashed256) . PHP_EOL;
//echo "Hashed 160: " . bin2hex($hashed160) . PHP_EOL;