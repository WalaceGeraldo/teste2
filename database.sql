-- Criação da tabela de usuários
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserir usuário padrão (senha: admin)
-- O hash abaixo é para a senha "admin"
INSERT INTO users (username, password_hash) 
VALUES ('admin', '$2y$10$8WkQJ.q.p.r/u.h.s.w.e.O.1.2.3.4.5.6.7.8.9.0')
ON CONFLICT (username) DO NOTHING;
