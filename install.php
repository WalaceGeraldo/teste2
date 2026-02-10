<?php
// Instalação do Banco de Dados
require_once __DIR__ . '/autoload.php';
use App\Config\Database;

try {
    $database = new Database();
    $conn = $database->connect();
    
    echo "Conectado ao PostgreSQL com sucesso!<br>";
    
    // Ler o arquivo SQL
    $sql = file_get_contents(__DIR__ . '/database.sql');
    
    // Executar o SQL
    $conn->exec($sql);
    
    // Inserir usuário Admin caso o SQL não tenha (senha: admin)
    // Usando PHP password_hash para garantir compatibilidade
    $adminUser = 'admin';
    $adminPass = password_hash('admin', PASSWORD_DEFAULT);
    
    // Verificar se já existe
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->execute([':username' => $adminUser]);
    
    if (!$stmt->fetch()) {
        $stmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (:username, :password)");
        $stmt->execute([
            ':username' => $adminUser,
            ':password' => $adminPass
        ]);
        echo "Usuário 'admin' criado com sucesso!<br>";
    } else {
        echo "Usuário 'admin' já existe.<br>";
    }

    echo "Tabela 'users' verificada/criada com sucesso.<br>";
    echo "<a href='index.php'>Ir para Login</a>";

} catch(PDOException $e) {
    echo "Erro na instalação: " . $e->getMessage();
    die();
}
?>
