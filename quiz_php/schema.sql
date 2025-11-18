
DROP DATABASE IF EXISTS quiz;
CREATE DATABASE quiz CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quiz;

CREATE TABLE usuario (
    id_usuario INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(60) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pergunta (
    id_pergunta INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    alternativa_a VARCHAR(255) NOT NULL,
    alternativa_b VARCHAR(255) NOT NULL,
    alternativa_c VARCHAR(255) NOT NULL,
    alternativa_d VARCHAR(255) NOT NULL,
    resposta_correta ENUM('A','B','C','D') NOT NULL,
    valor TINYINT UNSIGNED NOT NULL DEFAULT 1,
    ativa TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE resposta_usuario (
    id_resposta INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNSIGNED NOT NULL,
    id_pergunta INT UNSIGNED NOT NULL,
    resposta_escolhida ENUM('A','B','C','D') NOT NULL,
    correta TINYINT(1) NOT NULL,
    pontos SMALLINT NOT NULL,
    respondido_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_usuario_pergunta (id_usuario, id_pergunta),
    CONSTRAINT fk_resp_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE,
    CONSTRAINT fk_resp_pergunta FOREIGN KEY (id_pergunta) REFERENCES pergunta(id_pergunta) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO pergunta (titulo, alternativa_a, alternativa_b, alternativa_c, alternativa_d, resposta_correta, valor)
VALUES
('Qual é o resultado de 2 + 2?', '3', '4', '5', '6', 'B', 1),
('Quem escreveu Dom Casmurro?', 'Machado de Assis', 'José de Alencar', 'Clarice Lispector', 'Graciliano Ramos', 'A', 1),
('Qual linguagem roda no navegador?', 'PHP', 'Python', 'JavaScript', 'SQL', 'C', 1),
('Qual comando cria uma base no MySQL?', 'CREATE DATABASE', 'MAKE DATABASE', 'NEW DATABASE', 'INIT DATABASE', 'A', 1);


