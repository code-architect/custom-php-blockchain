<?php
function hash256($s) {
    // Two rounds of SHA256
    return hash('sha256', hash('sha256', $s, true), true);
}