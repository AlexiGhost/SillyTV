<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:16
 */

class Encryptor
{
    private $_encoding_prefix;
    private $_encoding_suffix;

    public function __construct($enc_pre="Silly", $enc_suf="TV") {
        $this->_encoding_prefix = $enc_pre;
        $this->_encoding_suffix = $enc_suf;
    }

    public function encrypt($origin) {
        $prefix = sha1($this->_encoding_prefix);
        $suffix = sha1($this->_encoding_suffix);
        return md5($prefix.$origin.$suffix);
    }

    public function checkPassword($password, $true_password) {
        return ($this->encrypt($password) === $true_password);
    }
}