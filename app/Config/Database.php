<?php
namespace App\Config;

use PDO;
use PDOException;
use Exception;

class Database {
    // ⚠️ ATENÇÃO: Configure suas credenciais aqui
    private $host = 'localhost';
    private $db_name = 'postgres'; // Nome do banco de dados padrão
    private $username = 'postgres';
    private $password = '20121994'; // Senha padrão comum, altere se necessário
    private $port = '5432';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            // Configurar PDO para lançar exceções em caso de erro
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $e) {
            // Em produção, não exiba o erro diretamente para o usuário
            // error_log("Connection error: " . $e->getMessage());
            throw new Exception("Erro de conexão com o banco de dados: " . $e->getMessage());
        }

        return $this->conn;
    }

    public function testConnection() {
        try {
            $this->connect();
            return [
                'status' => 'success',
                'message' => 'Conexão com PostgreSQL estabelecida com sucesso!',
                'timestamp' => date('Y-m-d H:i:s')
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }
}
?>
