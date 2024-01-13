<?php

class Database
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $charset;
    private $pdo;

    public function __construct($host, $username, $password, $database, $charset)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->charset = $charset;

        $this->connect();
    }

    private function connect()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->database . ';charset=' . $this->charset;

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Er is een fout opgetreden: ' . $e->getMessage());
        }
    }

    public function query($sql, $params = [])
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);

        return $statement;
    }

    public function select($sql, $params = [])
    {
        $statement = $this->query($sql, $params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($sql, $params = [])
    {
        $this->query($sql, $params);
        return $this->pdo->lastInsertId();
    }

    public function update($sql, $params = [])
    {
        $this->query($sql, $params);
    }

    public function delete($sql, $params = [])
    {
        $this->query($sql, $params);
    }
}
