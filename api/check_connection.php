<?php
// API para verificar a conexão com o banco de dados
header('Content-Type: application/json');

require_once __DIR__ . '/../autoload.php';

use App\Config\Database;

try {
    $database = new Database();
    $result = $database->testConnection();
    
    // Retornar código de status HTTP apropriado
    if ($result['status'] === 'success') {
        http_response_code(200);
    } else {
        http_response_code(500); // Internal Server Error
    }
    
    echo json_encode($result);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro interno do servidor: ' . $e->getMessage(),
        'timestamp' => date('Y-m-d H:i:s')
    ]);
}
?>
