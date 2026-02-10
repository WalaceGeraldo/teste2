<?php
namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

class User {
    private $conn;
    private $table_name = "users";

    public function __construct(Database $db) {
        $this->conn = $db->connect();
    }

    public function findByUsername($username) {
        $query = "SELECT id, username, password_hash FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($username, $password) {
        // Verificar se usuário existe
        if($this->findByUsername($username)) {
           throw new \Exception("Usuário já existe.");
        }

        $query = "INSERT INTO " . $this->table_name . " (username, password_hash) VALUES (:username, :password)";
        
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password_hash);

        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    public function getAll() {
        $query = "SELECT id, username, created_at FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $username) {
        $query = "UPDATE " . $this->table_name . " SET username = :username WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':id', $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
