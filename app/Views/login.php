<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PostgreSQL App</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Bem-vindo</h2>
    
    <!-- Connection Status Indicator -->
    <div id="connectionStatus" class="status-message" style="display: none;">
        Verificando conexão...
    </div>

    <!-- Login Form directs to controller via index.php -->
    <form action="index.php?action=login" method="POST">
        <div class="form-group">
            <label for="username">Usuário</label>
            <input type="text" id="username" name="username" placeholder="Digite seu usuário" required>
        </div>

        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
        </div>

        <button type="submit" class="btn">Entrar</button>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="status-error status-message" style="display: block; margin-top: 1rem;">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
    </form>
    
    <div class="links">
        <a href="#">Esqueceu a senha?</a>
        <br><br>
        <a href="index.php?action=register" style="color: var(--primary-light);">Criar uma conta</a>
    </div>
</div>

<script>
    // Verificar conexão com o banco ao carregar a página
    window.addEventListener('load', async () => {
        const statusDiv = document.getElementById('connectionStatus');
        
        try {
            const response = await fetch('api/check_connection.php');
            const data = await response.json();
            
            if (response.ok) {
                console.log('Database connected:', data.message);
            } else {
                statusDiv.style.display = 'block';
                statusDiv.className = 'status-message status-error';
                statusDiv.innerText = 'Erro de Conexão: ' + data.message;
            }
        } catch (error) {
            statusDiv.style.display = 'block';
            statusDiv.className = 'status-message status-error';
            statusDiv.innerText = 'Falha ao conectar na API de verificação';
        }
    });

    // Modal helpers
    function openEditModal(id, username) {
        const modal = document.querySelector('.modal');
        const inputId = document.getElementById('edit-id');
        const inputUser = document.getElementById('edit-username');
        if(modal && inputId && inputUser) {
           modal.style.display = 'flex';
           inputId.value = id;
           inputUser.value = username;
        }
    }

    function closeEditModal() {
        const modal = document.querySelector('.modal');
        if(modal) modal.style.display = 'none';
    }
</script>

</body>
</html>
