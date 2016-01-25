<?php
/**
 * Created by PhpStorm.
 * User: tylerdotson
 */

class DB_CONNECT
{
    private $HOST = "";
    private $USERNAME = "";
    private $PASSWORD = "";
    private $DATABASE = "";

    public function getHost(){
        return $this->HOST;
    }

    public function getUsername(){
        return $this->USERNAME;
    }

    public function getPassword(){
        return $this->PASSWORD;
    }

    public function getDatabase(){
        return $this->DATABASE;
    }
}