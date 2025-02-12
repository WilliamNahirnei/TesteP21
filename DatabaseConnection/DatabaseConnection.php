<?php
namespace DatabaseConnection;

use PDO;
use PDOException;

class DatabaseConnection {
    private string $host;
    private string $port;
    private string $db_name;
    private string $username;
    private string $password;
    public ?PDO $pdo;

    public function getConnection() {
        $this->pdo = null;

        try {
            $this->loadConnectionData();
            $this->pdo = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->pdo;
    }

    private function loadConnectionData()
    {
        $this->host = DatabaseConfig::getInstance()->getConfig(DatabaseConfig::HOST);
        $this->port = DatabaseConfig::getInstance()->getConfig(DatabaseConfig::PORT);
        $this->db_name = DatabaseConfig::getInstance()->getConfig(DatabaseConfig::DB_NAME);
        $this->username = DatabaseConfig::getInstance()->getConfig(DatabaseConfig::USER);
        $this->password = DatabaseConfig::getInstance()->getConfig(DatabaseConfig::PASSWORD);
    }
}
?>