<?php
require_once 'Blockchain/Backend/core/Block.php'; // Assuming the block.php file path
require_once 'Blockchain/Backend/core/BlockHeader.php'; // Assuming the blockheader.php file path
require_once 'Blockchain/Backend/util/util.php'; // Assuming the util.php file path

$ZERO_HASH = str_repeat('0', 64);
$VERSION = 1;

class Blockchain {
    private $chain = [];

    public function __construct() {
        $this->GenesisBlock();
    }

    private function GenesisBlock() {
        $BlockHeight = 0;
        $prevBlockHash = $GLOBALS['ZERO_HASH'];
        $this->addBlock($BlockHeight, $prevBlockHash);
    }

    public function addBlock($BlockHeight, $prevBlockHash) {
        $timestamp = time();
        $Transaction = "Code Architect sent {$BlockHeight} Bitcoins to Indranil";
        $merkleRoot = bin2hex(hash256($Transaction));
        $bits = 'ffff001f';
        $blockheader = new BlockHeader($GLOBALS['VERSION'], $prevBlockHash, $merkleRoot, $timestamp, $bits);
        $blockheader->mine();
        $block = new Block($BlockHeight, 1, (array)$blockheader, 1, $Transaction);
        $this->chain[] = (array)$block;
        print_r(json_encode($this->chain, JSON_PRETTY_PRINT));
    }

    public function main() {
        while (true) {
            $lastBlock = array_reverse($this->chain);
            $BlockHeight = $lastBlock[0]['Height'] + 1;
            $prevBlockHash = $lastBlock[0]['BlockHeader']['blockHash'];
            $this->addBlock($BlockHeight, $prevBlockHash);
        }
    }
}


$blockchain = new Blockchain();
$blockchain->main();

