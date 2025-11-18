<?php
include("conexao.php");


$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

mysqli_set_charset($conexao, "utf8mb4");


$createSql = "
    CREATE TABLE IF NOT EXISTS usuario (
        id_usuario INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        nome VARCHAR(60) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if (!mysqli_query($conexao, $createSql)) {
    die('Erro ao garantir tabela usuario: ' . mysqli_error($conexao));
}

$senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

$checkSql = "SELECT 1 FROM usuario WHERE email = ? LIMIT 1";
$checkStmt = mysqli_prepare($conexao, $checkSql);

if (!$checkStmt) {
    die("Erro ao preparar verificação: " . mysqli_error($conexao));
}

mysqli_stmt_bind_param($checkStmt, "s", $email);
mysqli_stmt_execute($checkStmt);
mysqli_stmt_store_result($checkStmt);

if (mysqli_stmt_num_rows($checkStmt) > 0) {
    mysqli_stmt_close($checkStmt);
    die("Erro: E-mail já cadastrado.");
}

mysqli_stmt_close($checkStmt);

$sql = "INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conexao, $sql);

if ($stmt) {
  
    mysqli_stmt_bind_param($stmt, "sss", $nome, $email, $senha_hashed);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: cadastro_sucesso.php');
        exit();
    }

    echo "Erro ao inserir registro: " . mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);

} else {
    echo "Erro na preparação da consulta: " . mysqli_error($conexao);
}

mysqli_close($conexao);
?>