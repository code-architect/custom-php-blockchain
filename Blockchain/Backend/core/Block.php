<?php
class Block {
    /**
     * Block is a storage container that stores transactions
     */
    public function __construct($Height, $blockSize, $blockHeader, $TxCount, $Txs) {
        $this->Height = $Height;
        $this->Blocksize = $blockSize;
        $this->BlockHeader = $blockHeader;
        $this->TxCount = $TxCount;
        $this->Txs = $Txs;
    }
}

