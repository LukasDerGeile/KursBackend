<?php

namespace ext;

class DB {
    private $host = 'your_database_host';
    private $dbname = 'your_database_name';
    private $username = 'your_database_username';
    private $password = 'your_database_password';
    private $charset = 'utf8';
    private $dsn;
    private $options;
    private $connection;

    public function __construct() {
        $this->dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
        $this->options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }

    public function connect(): \PDO {
        try {
            $this->connection = new \PDO($this->dsn, $this->username, $this->password, $this->options);
            return $this->connection;
        } catch (\PDOException $e) {
            throw new \Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function close(): void {
        $this->connection = null;
    }
}
