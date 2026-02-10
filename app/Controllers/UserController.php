<?php
namespace App\Controllers;

use App\Config\Database;
use App\Models\User;

class UserController {
    
    // CRUD: Read (Listar) e Exibir Dashboard
    public function dashboard() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $db = new Database();
        $userModel = new User($db);
        $users = $userModel->getAll();

        // O view espera que exista uma variável $users
        require __DIR__ . '/../Views/dashboard.php';
    }

    // CRUD: Update (Atualizar)
    public function update() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $id = $_POST['id'] ?? null;
        $username = $_POST['username'] ?? null;

        if ($id && $username) {
            $db = new Database();
            $userModel = new User($db);
            
            if ($userModel->update($id, $username)) {
                // Atualiza sessão se for o próprio usuário
                if ($id == $_SESSION['user_id']) {
                    $_SESSION['username'] = $username;
                }
                header("Location: index.php?action=dashboard&success=Updated");
            } else {
                header("Location: index.php?action=dashboard&error=UpdateFailed");
            }
        } else {
            header("Location: index.php?action=dashboard&error=MissingData");
        }
    }

    // CRUD: Delete (Deletar)
    public function delete() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $id = $_GET['id'] ?? null;

        if ($id) {
            // Não permitir deletar o próprio usuário logado
            if ($id == $_SESSION['user_id']) {
                header("Location: index.php?action=dashboard&error=CannotSelfDelete");
                exit;
            }

            $db = new Database();
            $userModel = new User($db);
            
            if ($userModel->delete($id)) {
                header("Location: index.php?action=dashboard&success=Deleted");
            } else {
                header("Location: index.php?action=dashboard&error=DeleteFailed");
            }
        } else {
            header("Location: index.php?action=dashboard&error=MissingId");
        }
    }
}
?>
