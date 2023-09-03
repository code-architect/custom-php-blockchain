<?php
class Script
{
    public $cmds;

    public function __construct($cmds = null)
    {
        if ($cmds === null) {
            $this->cmds = [];
        } else {
            $this->cmds = $cmds;
        }
    }

    public static function p2pkhScript($h160)
    {
        // Takes a hash160 and returns the p2 public key hash ScriptPubKey
        $script = new Script([0x76, 0xA9, $h160, 0x88, 0xAC]);
        return $script;
    }
}