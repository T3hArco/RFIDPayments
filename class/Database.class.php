<?php
/**
 * Created by IntelliJ IDEA.
 * User: arnaudcoel
 * Date: 28/09/15
 * Time: 12:06
 */

namespace pos;


class Database
{
    private $hostname, $username, $password, $database, $db;

    public function __construct($hostname, $username, $password, $database)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $this->connect();
    }

    private function connect()
    {
        try {
            $this->db = new \PDO('mysql:host=' . $this->hostname . ';dbname=' . $this->database, $this->username, $this->password);
        } catch (\PDOException $e) {
            print "Database error. See error log.";
            die();
        }
    }

    public function close()
    {
        $this->db = null;
    }

    public function getDbObject()
    {
        return $this->db;
    }
}