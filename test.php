<?php

require_once 'vendor/autoload.php';

use kornrunner\Secp256k1;
use kornrunner\Serializer\HexSignatureSerializer;

class Account
{
    public function createKeys()
    {
        $secp256k1 = new Secp256k1();

        // Generate a private key (random 256-bit integer)
        $privateKey = random_bytes(32);

        // Generate the corresponding public key
        $publicKey = $secp256k1->publicKeyCreate($privateKey);

        // Serialize the public key to its compressed format
        $compressedPublicKey = $secp256k1->publicKeySerialize($publicKey);

        // Hash the compressed public key using RIPEMD160
        $hash160 = hash('ripemd160', hex2bin($compressedPublicKey));

        // Add a prefix for the mainnet (0x00)
        $mainnetPrefix = '00';
        $address = $mainnetPrefix . $hash160;

        // Double SHA-256 hash of the address, take the first 4 bytes as checksum
        $checksum = substr(hash('sha256', hash('sha256', hex2bin($address), true)), 0, 8);

        // Append the checksum to the address
        $addressWithChecksum = $address . $checksum;

        // Base58 encoding
        $base58Alphabet = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
        $count = 0;
        for ($i = 0; $i < strlen($addressWithChecksum); $i++) {
            if ($addressWithChecksum[$i] === '0') {
                $count++;
            } else {
                break;
            }
        }
        $num = gmp_init($addressWithChecksum, 16);
        $base58Address = str_repeat('1', $count) . gmp_strval($num, 58, false);

        return [
            'privateKey' => bin2hex($privateKey),
            'publicAddress' => $base58Address,
        ];
    }
}

$account = new Account();
$keys = $account->createKeys();

echo "Private Key: " . $keys['privateKey'] . PHP_EOL;
echo "Public Address: " . $keys['publicAddress'] . PHP_EOL;
