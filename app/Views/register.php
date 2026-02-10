<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | PostgreSQL App</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Criar Conta</h2>
    
    <form action="index.php?action=register" method="POST">
        <div class="form-group">
            <label for="username">Usuário</label>
            <input type="text" id="username" name="username" placeholder="Escolha um nome de usuário" required>
        </div>

        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" id="password" name="password" placeholder="Escolha uma senha" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirmar Senha</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Repita a senha" required>
        </div>

        <button type="submit" class="btn">Cadastrar</button>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="status-error status-message" style="display: block; margin-top: 1rem;">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['success'])): ?>
            <div class="status-success status-message" style="display: block; margin-top: 1rem;">
                Cadastro realizado com sucesso! <a href="index.php?action=login">Faça login.</a>
            </div>
        <?php endif; ?>
    </form>
    
    <div class="links">
        <a href="index.php?action=login">Já tem uma conta? Faça login</a>
    </div>
</div>

</body>
</html>
