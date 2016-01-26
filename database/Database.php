<?php
namespace db;
/**
 * Created by PhpStorm.
 * User: tylerdotson
 */
abstract class Database
{
    abstract public function __construct();
    abstract public function query($query);
    abstract public function __destruct();
}