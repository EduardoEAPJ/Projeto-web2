<?php

class Database {
    private $host = 'localhost';
    private $dbname = 'acai_do_mamute';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function select($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }
}
