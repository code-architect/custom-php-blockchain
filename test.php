<?php
require_once 'Blockchain/Backend/core/database/BaseDB.php';

$blockchainDB = new BlockchainDB();
$lastBlock = $blockchainDB->lastBlock();
if ($lastBlock) {
    print_r($lastBlock);
} else {
    echo "Blockchain is empty.\n";
}
echo "\n";
print_r(__DIR__);
echo "\n";
print_r(__FILE__);