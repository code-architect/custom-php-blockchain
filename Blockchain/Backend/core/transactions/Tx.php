<?php

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

    public function serialize() {
        $result = intToLittleEndian($this->version, 4);
        $result .= count($this->txIns);

        // Add serialization logic here

        return $result;
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