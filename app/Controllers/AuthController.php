<?php
namespace App\Controllers;

use App\Models\User;
use App\Config\Database;

class AuthController {
    
    // Mostra tela de login
    public function showLogin() {
        require __DIR__ . '/../Views/login.php';
    }

    // Processa o login
    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        try {
            $db = new Database();
            $userModel = new User($db);
            $user = $userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php?action=dashboard");
                exit;
            } else {
                header("Location: index.php?error=" . urlencode("Usuário ou senha incorretos!"));
                exit;
            }

        } catch(\Exception $e) {
            header("Location: index.php?error=" . urlencode("Erro no sistema: " . $e->getMessage()));
            exit;
        }
    }

    // Mostra tela de cadastro
    public function showRegister() {
        require __DIR__ . '/../Views/register.php';
    }

    // Processa cadastro
    public function register() {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($username) || empty($password)) {
            header("Location: index.php?action=register&error=" . urlencode("Preencha todos os campos!"));
            exit;
        }

        if ($password !== $confirm_password) {
            header("Location: index.php?action=register&error=" . urlencode("As senhas não coincidem!"));
            exit;
        }

        try {
            $db = new Database();
            $userModel = new User($db);
            
            if ($userModel->create($username, $password)) {
                header("Location: index.php?action=register&success=1");
                exit;
            } else {
                header("Location: index.php?action=register&error=" . urlencode("Erro ao cadastrar."));
                exit;
            }

        } catch(\Exception $e) {
            header("Location: index.php?action=register&error=" . urlencode($e->getMessage()));
            exit;
        }
    }

    // Mostra dashboard (protegido)
    public function dashboard() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit;
        }
        
        $db = new Database();
        $status = $db->testConnection();
        
        require __DIR__ . '/../Views/dashboard.php';
    }

    // Logout
    public function logout() {
        session_destroy();
        header("Location: index.php");
        exit;
    }
}
?>
