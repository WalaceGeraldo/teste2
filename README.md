# Sistema de Login com PostgreSQL

Este é um sistema simples de login com conexão real ao banco de dados PostgreSQL.

## Como Rodar

Para que o sistema funcione corretamente (o PHP precisa ser executado por um servidor, não abrir direto o arquivo):

1. Abra o terminal nesta pasta.
2. Execute o comando:
   ```bash
   php -S localhost:8000
   ```
3. Abra seu navegador em: [http://localhost:8000](http://localhost:8000)

## Configuração do Banco de Dados

1. Abra o arquivo `includes/db.php`.
2. Edite as variáveis `$host`, `$db_name`, `$username`, e `$password` com suas credenciais do PostgreSQL.

## Login de Demonstração

Se ainda não configurou o banco, use:
- **Usuário:** `admin`
- **Senha:** `admin`
