<?php
namespace db;
/**
 * Created by PhpStorm.
 * User: tylerdotson
 */
class MySQLI_DB extends Database
{
    private $connection;

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
        $results = array();
        $queryString     = trim($query);
        $explodedQuery   = explode(' ', $queryString);
        $queryFirstWord  = strtoupper(trim($explodedQuery[0]));
        $resource = $this->connection->query($query);

        if (!$resource) {
            throw new Exception("Database Error [{$this->connection->errno}] {$this->connection->error}");
        }

        if($this->connection->errno === 0)
        {
            switch($queryFirstWord)
            {
                case "DELETE":
                case "UPDATE":
                    return $this->connection->affected_rows;
                    break;
                case "INSERT":
                    return $this->connection->insert_id;
                    break;
                default:
                    while($row = $resource->fetch_assoc())
                    {
                        $results[] = $row;
                    }
                    return $results;
                    break;
            }
        }
        else
        {
            return $this->connection->error;
        }
    }

    public function escapeString($string){
        return mysqli_real_escape_string($this->connection, $string);
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}