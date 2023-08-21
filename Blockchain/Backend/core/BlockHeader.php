<?php
require_once 'Blockchain/Backend/util/util.php';

class BlockHeader {
    public function __construct($version, $prevBlockHash, $merkleRoot, $timestamp, $bits) {
        $this->bits = $bits;
        $this->timestamp = $timestamp;
        $this->merkleRoot = $merkleRoot;
        $this->prevBlockHash = $prevBlockHash;
        $this->version = $version;
        $this->nonce = 0;
        $this->blockHash = '';
    }


    public function mine() {
        while (substr($this->blockHash, 0, 4) !== '0000') {
            $inputString = $this->version . $this->prevBlockHash . $this->merkleRoot . $this->timestamp . $this->bits . $this->nonce;
            $inputString = hash256($inputString);
            $this->blockHash = bin2hex($inputString);   // convert to hexadecimal
            $this->nonce++;
            echo "Mining started {$this->nonce}\r";
        }
        echo PHP_EOL; // Add a newline after mining is complete
    }
}