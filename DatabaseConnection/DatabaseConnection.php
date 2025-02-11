<?php
namespace DatabaseConnection;

use PDO;
use PDOException;

class DatabaseConnection {
    private $host = 'localhost';
    private $port = '3306'; // Adicione a porta aqui
    private $db_name = 'MagicStore';
    private $username = 'root';
    private $password = 'root';
    public $pdo;

    public function getConnection() {
        $this->pdo = null;

        try {
            $this->pdo = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->pdo;
    }
}
?>