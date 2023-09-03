<?php
require_once 'Blockchain/Backend/core/Script.php';

class TxIn
{
    public $prevTx;
    public $prevIndex;
    public $scriptSig;
    public $sequence;

    public function __construct($prevTx, $prevIndex, $scriptSig = null, $sequence = 0xFFFFFFFF) {
        $this->prevTx = $prevTx;
        $this->prevIndex = $prevIndex;
        $this->scriptSig = $scriptSig ?? new Script();
        $this->sequence = $sequence;
    }
}