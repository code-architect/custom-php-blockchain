<?php
class BaseDB {
    private string $basepath = 'D:\\xampp\\htdocs\\sand_box\\get_job\\custom-php-blockchain\\Blockchain\\data\\';
    private string $filepath;

    public function __construct($filename) {
        $this->filepath = $this->basepath . DIRECTORY_SEPARATOR . $filename;
    }

    public function read() {
        if (!file_exists($this->filepath)) {
            echo "File named {$this->filepath} does not exist." . PHP_EOL;
            return false;
        }

        $raw = file_get_contents($this->filepath);

        if (strlen($raw) > 0) {
            $data = json_decode($raw, true);
        } else {
            $data = [];
        }

        return $data;
    }

    public function write($item) {
        $data = $this->read();
        if ($data) {
            $data[] = $item;
        } else {
            $data = [$item];
        }

        file_put_contents($this->filepath, json_encode($data, JSON_PRETTY_PRINT));
    }
}

class BlockchainDB extends BaseDB {
    public function __construct() {
        parent::__construct('blockchain');
    }

    public function lastBlock() {
        $data = $this->read();

        if ($data) {
            return end($data);
        }
    }
}