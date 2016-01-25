<?php
require_once('Database.php');
/**
 * Created by PhpStorm.
 * User: tylerdotson
 */
class MySQLI_DB extends Database
{
    private $connection;
    private $resource;

    public function __construct()
    {
        require_once('DB_CONNECT.php');
        $DB_CONNECT = new DB_CONNECT();

        $this->connection = new mysqli($DB_CONNECT->getHost(), $DB_CONNECT->getUsername(), $DB_CONNECT->getPassword(), $DB_CONNECT->getDatabase());
        if ($this->connection->connect_errno) {
            echo "Failed to connect to MySQLI: " . $this->connection->connect_error;
        }
    }

    public function query($query)
    {
        if($query !== "")
        {
            $this->resource = $this->connection->query($query);
            return $this->resource->fetch_assoc();
        }
        else
        {
            echo "This is not a query string.";
        }
    }

    public function __destruct()
    {
        if($this->connection->close()){
            echo "Database resource and connection destroyed.";
        }
    }
}