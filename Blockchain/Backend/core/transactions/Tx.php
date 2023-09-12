<?php
require_once 'Blockchain/Backend/util/util.php';
class Tx
{
    public $locktime;
    public $txOuts;
    public $txIns;
    public $version;

    public function __construct($version, $txIns, $txOuts, $locktime) {
        $this->version = $version;
        $this->txIns = $txIns;
        $this->txOuts = $txOuts;
        $this->locktime = $locktime;
    }

    /**
     * @throws Exception
     */
    public function serialize() {
        // Initialize an empty result string
        $result = "";

        // Serialize the version as a little-endian 4-byte integer
        $result .= intToLittleEndian($this->version, 4);

        // Serialize the number of transaction inputs as a variable-length integer
        $result .= encode_varint(count($this->tx_ins));

        // Serialize each transaction input
        foreach ($this->tx_ins as $tx_in) {
            $result .= $tx_in->serialize();
        }

        // Serialize the number of transaction outputs as a variable-length integer
        $result .= encode_varint(count($this->tx_outs));

        // Serialize each transaction output
        foreach ($this->tx_outs as $tx_out) {
            $result .= $tx_out->serialize();
        }

        // Serialize the locktime as a little-endian 4-byte integer
        $result .= intToLittleEndian($this->locktime, 4);

        // Return the serialized result
        return $result;
    }

    public function id() {
        // Human-readable Tx id
        return $this->hash()->hex();
    }

    /**
     * @throws Exception
     */
    public function hash() {
        // Binary Hash of serialization
        return strrev(hash256($this->serialize()));
    }

    public function isCoinbase() {
        if (count($this->txIns) !== 1) {
            return false;
        }

        $firstInput = $this->txIns[0];
        if ($firstInput->prevTx !== hex2bin(ZERO_HASH)) {
            return false;
        }

        if ($firstInput->prevIndex !== 0xFFFFFFFF) {
            return false;
        }

        return true;
    }

    public function toDict() {
        // Convert Transaction Input to dict
        foreach ($this->txIns as $txIndex => $txIn) {
            if ($this->isCoinbase()) {
                $txIn->scriptSig->cmds[0] = littleEndianToInt($txIn->scriptSig->cmds[0]);
            }

            $txIn->prevTx = bin2hex($txIn->prevTx);

            foreach ($txIn->scriptSig->cmds as $index => $cmd) {
                if (is_string($cmd)) {
                    $txIn->scriptSig->cmds[$index] = bin2hex($cmd);
                }
            }

            $txIn->scriptSig = (array) $txIn->scriptSig;
            $this->txIns[$txIndex] = (array) $txIn;
        }

        // Convert Transaction Output to dict
        foreach ($this->txOuts as $index => $txOut) {
            $txOut->scriptPubkey->cmds[2] = bin2hex($txOut->scriptPubkey->cmds[2]);
            $txOut->scriptPubkey = (array) $txOut->scriptPubkey;
            $this->txOuts[$index] = (array) $txOut;
        }

        return (array) $this;
    }
}