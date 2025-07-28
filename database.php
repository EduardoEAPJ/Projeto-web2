<?php
class Database {
    private $connection;
    private function connect() {
        $this->connection = new PDO('mysql:host=localhost;port=3306;dbname=acai_do_mamute;charset=utf8', 'root', '', [PDO::ATTR_PERSISTENT => true]);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    private function disconnect() {
        $this->connection = null;
    }
    public function select($sql, $parameters = null) {
        if (!preg_match('/^SELECT/i', $sql)) die('*** Não é SELECT ***');
        $this->connect();
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($parameters);
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            $result = false;
        }
        $this->disconnect();
        return $result;
    }
    public function insert($sql, $parameters = null) {
        if (!preg_match('/^INSERT/i', $sql)) die('*** Não é INSERT ***');
        $this->connect();
        try {
            $stmt = $this->connection->prepare($sql);
            $result = $stmt->execute($parameters);
        } catch (Exception $e) {
            $result = false;
        }
        $this->disconnect();
        return $result;
    }
    public function update($sql, $parameters = null) {
        if (!preg_match('/^UPDATE/i', $sql)) die('*** Não é UPDATE ***');
        $this->connect();
        try {
            $stmt = $this->connection->prepare($sql);
            $result = $stmt->execute($parameters);
        } catch (Exception $e) {
            $result = false;
        }
        $this->disconnect();
        return $result;
    }
    public function delete($sql, $parameters = null) {
        if (!preg_match('/^DELETE/i', $sql)) die('*** Não é DELETE ***');
        $this->connect();
        try {
            $stmt = $this->connection->prepare($sql);
            $result = $stmt->execute($parameters);
        } catch (Exception $e) {
            $result = false;
        }
        $this->disconnect();
        return $result;
    }
}
