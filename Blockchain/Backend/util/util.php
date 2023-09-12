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

function intToLittleEndian($n, $length) {
    // Convert an integer to a little-endian byte string of a specified length
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $byte = $n & 0xFF; // Get the least significant byte
        $result .= chr($byte); // Convert to a character and append to the result
        $n >>= 8; // Shift the integer right by 8 bits
    }
    return $result;
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


function encode_varint($i) {
    if ($i < 0xFD) {
        return chr($i);
    } elseif ($i < 0x10000) {
        return "\xFD" . intToLittleEndian($i, 2);
    } elseif ($i < 0x100000000) {
        return "\xFE" . intToLittleEndian($i, 4);
    } elseif ($i < 0x10000000000000000) {
        return "\xFF" . intToLittleEndian($i, 8);
    } else {
        throw new Exception("integer too large: $i");
    }
}

//try {
//    $encoded = encode_varint(500);
//} catch (Exception $e) {
//}
//echo bin2hex($encoded);

// Example usage
//$input = 'some data to hash';
//$hashed256 = hash256($input);
//$hashed160 = hash160($input);
//
//echo "Hashed 256: " . bin2hex($hashed256) . PHP_EOL;
//echo "Hashed 160: " . bin2hex($hashed160) . PHP_EOL;