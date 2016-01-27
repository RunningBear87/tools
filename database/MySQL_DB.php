<?php
/**
 * Created by PhpStorm.
 * User: tylerdotson
 */

namespace db;


class MySQL_DB extends Database
{
    private $databaseConnection;
    private $selectedDatabase;

    public function __construct()
    {
        try
        {
            $DB_CONNECT = new DB_CONNECT();

            $this->databaseConnection = mysql_connect($DB_CONNECT->getHost(), $DB_CONNECT->getUsername(), $DB_CONNECT->getPassword()) or die("Unable to connect to MySQL");
            $this->selectedDatabase = mysql_select_db($DB_CONNECT->getDatabase(), $this->databaseConnection) or die("Could not select database");
        }
        catch(Exception $error)
        {
            echo 'Caught exception: ',  $error->getMessage(), "\n";
        }
    }

    public function query($query="")
    {
        try
        {
            $results         = array();
            $queryString     = trim($query);
            $explodedQuery   = explode(' ', $queryString);
            $queryFirstWord  = strtoupper(trim($explodedQuery[0]));

            $response = mysql_query($queryString, $this->databaseConnection);

            if($response)
            {
                if(is_resource($response))
                {
                    while($row = mysql_fetch_assoc($response))
                    {
                        $results[] = $row;
                    }
                }

                switch($queryFirstWord)
                {
                    case "DELETE":
                    case "UPDATE":
                        return mysql_affected_rows();
                        break;
                    case "INSERT":
                        return mysql_insert_id();
                        break;
                    default:
                        return $results;
                        break;
                }

            }
            else
            {
                return mysql_error();
            }
        }
        catch(Exception $error)
        {
            echo 'Caught exception: ',  $error->getMessage(), "\n";
        }
    }

    public function escapeString($string)
    {
        return mysql_real_escape_string($string, $this->databaseConnection);
    }

    public function __destruct()
    {
        mysql_close($this->databaseConnection);
    }

}