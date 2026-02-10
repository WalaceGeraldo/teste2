<?php
use App\Models\User;

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit();
}

// O controller já passa a variável $users
$users = $users ?? [];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | PostgreSQL App</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .container { max-width: 900px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .logout-btn { background: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; }
        .grid { display: grid; gap: 1rem; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; background: rgba(0,0,0,0.2); border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1); }
        th { background: rgba(255,255,255,0.05); }
        tr:hover { background: rgba(255,255,255,0.02); }

        .btn-sm { padding: 4px 8px; font-size: 0.8rem; margin-right: 5px; cursor: pointer; border: none; border-radius: 4px; }
        .btn-edit { background: #f59e0b; color: white; }
        .btn-delete { background: #ef4444; color: white; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 100; align-items: center; justify-content: center; }
        .modal-content { background: #1e1b4b; padding: 2rem; border-radius: 1rem; width: 300px; border: 1px solid #312e81; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Painel de Controle</h2>
        <div>
            <span style="margin-right: 15px;">Olá, <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="index.php?action=logout" class="logout-btn">Sair</a>
        </div>
    </div>

    <!-- Feedback Message -->
    <?php if(isset($_GET['success'])): ?>
        <div class="status-success status-message" style="display: block; margin-bottom: 1rem;"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>
    <?php if(isset($_GET['error'])): ?>
        <div class="status-error status-message" style="display: block; margin-bottom: 1rem;"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <div class="card">
        <h3>Lista de Usuários (CRUD)</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                    <td>
                        <button class="btn-sm btn-edit" onclick="openEditModal(<?= $user['id'] ?>, '<?= htmlspecialchars($user['username']) ?>')">Editar</button>
                        
                        <?php if($user['id'] != $_SESSION['user_id']): ?>
                            <a href="index.php?action=delete&id=<?= $user['id'] ?>" class="btn-sm btn-delete" onclick="return confirm('Tem certeza?');">Excluir</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Edição -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3>Editar Usuário</h3>
        <form action="index.php?action=update" method="POST">
            <input type="hidden" id="edit-id" name="id">
            <div class="form-group">
                <label>Novo Nome</label>
                <input type="text" id="edit-username" name="username" required>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 1rem;">
                <button type="submit" class="btn">Salvar</button>
                <button type="button" class="btn" onclick="closeEditModal()" style="background: #475569;">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, username) {
        document.getElementById('editModal').style.display = 'flex';
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-username').value = username;
    }
    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>

</body>
</html>
