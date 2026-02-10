<?php
session_start();

require_once __DIR__ . '/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\UserController;

// Router Simples
$action = $_GET['action'] ?? 'login';

$authController = new AuthController();
$userController = new UserController();

switch ($action) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            // Se já estiver logado, vai pro dashboard
            if (isset($_SESSION['user_id'])) {
                header("Location: index.php?action=dashboard");
                exit;
            }
            $authController->showLogin();
        }
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->register();
        } else {
            $authController->showRegister();
        }
        break;

    case 'dashboard':
        // Usa o UserController pois o Dashboard agora lista os usuários (CRUD Read)
        $userController->dashboard();
        break;

    case 'logout':
        $authController->logout();
        break;
    
    // Novas rotas de CRUD
    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->update();
        }
        break;

    case 'delete':
        $userController->delete();
        break;

    default:
        http_response_code(404);
        echo "Página não encontrada.";
        break;
}
?>
