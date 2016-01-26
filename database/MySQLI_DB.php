<?php
namespace db;
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
        $DB_CONNECT = new DB_CONNECT();
        $this->connection = new \mysqli($DB_CONNECT->getHost(), $DB_CONNECT->getUsername(), $DB_CONNECT->getPassword(), $DB_CONNECT->getName());

        if ($this->connection->connect_errno) {
            echo "Failed to connect to MySQLI: " . $this->connection->connect_error;
        }
    }

    public function query($query)
    {
        $results = [];
        if($query !== "")
        {
            $this->resource = $this->connection->query($query);
            while($row = $this->resource->fetch_assoc())
            {
                $results[] = $row;
            }

            return $results;
        }
        else
        {
            return null;
        }
    }

    public function escapeString($string){
        return mysqli_real_escape_string($this->connection, $string);
    }

    public function getLastInsertedID()
    {
        return $this->resource->insert_id;
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}