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

    public function serialize()
    {
        $result = strrev($this->prev_tx);
        $result .= intToLittleEndian($this->prev_index, 4);
        $result .= $this->script_sig->serialize();
        $result .= intToLittleEndian($this->sequence, 4);
        return $result;
    }
}