<?php
namespace Lib;

class TokenGenerator{
    protected $token;
    public function __construct(){
        $this->token = md5(uniqid(rand(), true));
    }

    function getToken(){
        return $this->token;
    }
}