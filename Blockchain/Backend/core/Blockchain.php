<?php
require_once 'Blockchain/Backend/core/Block.php'; // Assuming the block.php file path
require_once 'Blockchain/Backend/core/BlockHeader.php'; // Assuming the blockheader.php file path
require_once 'Blockchain/Backend/core/database/BaseDB.php'; // Assuming the blockheader.php file path
require_once 'Blockchain/Backend/util/util.php'; // Assuming the util.php file path
require_once 'Blockchain/Backend/core/transactions/Coinbase.php';

$ZERO_HASH = str_repeat('0', 64);
$VERSION = 1;

class Blockchain {
    private $chain = [];

    public function __construct() {
        $this->GenesisBlock();
    }

    public function writeOnDisk($block) {
        $blockchainDB = new BlockchainDB();
        $blockchainDB->write($block);
    }

    public function fetchLastBlock() {
        $blockchainDB = new BlockchainDB();
        return $blockchainDB->lastBlock();
    }

    private function GenesisBlock() {
        $BlockHeight = 0;
        $prevBlockHash = $GLOBALS['ZERO_HASH'];
        $this->addBlock($BlockHeight, $prevBlockHash);
    }

    public function addBlock($BlockHeight, $prevBlockHash) {
        $timestamp = time();
        $coinbaseInstance = new Coinbase($BlockHeight);
        $coinbaseTx = $coinbaseInstance->coinbaseTransaction();
        $merkleRoot = ' ';
        $bits = 'ffff001f';
        $blockheader = new BlockHeader($GLOBALS['VERSION'], $prevBlockHash, $merkleRoot, $timestamp, $bits);
        $blockheader->mine();
        $block = new Block($BlockHeight, 1, (array)$blockheader, 1, $coinbaseTx);
//        print_r((array)$block);
//        die();
        $this->writeOnDisk((array)$block);
    }

    public function main() {
        while (true) {
            $lastBlock = $this->fetchLastBlock();
            $BlockHeight = $lastBlock['Height'] + 1;
            $prevBlockHash = $lastBlock['BlockHeader']['blockHash'];
            $this->addBlock($BlockHeight, $prevBlockHash);
        }
    }
}


$blockchain = new Blockchain();
$blockchain->main();

