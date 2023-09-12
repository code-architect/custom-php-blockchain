<?php
require_once 'Blockchain/Backend/util/util.php';
class TxOut
{
    public $amount;
    public $scriptPubkey;

    public function __construct($amount, $scriptPubkey) {
        $this->amount = $amount;
        $this->scriptPubkey = $scriptPubkey;
    }

    public function serialize()
    {
        $result = intToLittleEndian($this->amount, 8);
        $result .= $this->script_pubkey->serialize();
        return $result;
    }
}