<?php

class TxOut
{
    public $amount;
    public $scriptPubkey;

    public function __construct($amount, $scriptPubkey) {
        $this->amount = $amount;
        $this->scriptPubkey = $scriptPubkey;
    }
}