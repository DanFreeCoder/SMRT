<?php

class clsConnection
{

    private $host = 'localhost';
    protected $dbname = 'srmtdb';
    private $username = 'root';
    private $password = '';

    protected $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        } catch (PDOException $exception) {
            echo 'Connection Error: ' . $exception->getMessage();
        }
        return $this->conn;
    }

    public function disconnect()
    {
        $this->conn = null;
        return $this->conn;
    }
}
