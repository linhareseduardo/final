<?php

class Database {
    private $host = '127.0.0.1';
    private $port = '5432';
    private $dbname = 'projeto';
    private $username = 'postgres';
    private $password = 'root';
    private $connection;

    public function connect() {
        try {
            $this->connection = new PDO("pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}", $this->username, $this->password);
            return $this->connection;
        } catch (PDOException $e) {
            die("Erro: " . $e->getMessage());
        }
    }
}

?>
