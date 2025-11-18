<?php
session_start();
require_once 'conexao.php';

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($email === '' || $senha === '') {
    $_SESSION['erro_login'] = 'Informe e-mail e senha.';
    header('Location: login.php');
    exit();
}

$sql = "SELECT id_usuario, nome, senha FROM usuario WHERE email = ? LIMIT 1";
$stmt = mysqli_prepare($conexao, $sql);

if (!$stmt) {
    $_SESSION['erro_login'] = 'Erro interno. Tente novamente.';
    header('Location: login.php');
    exit();
}

mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id_usuario, $nome, $hash);

if (mysqli_stmt_fetch($stmt) && password_verify($senha, $hash)) {
    $_SESSION['usuario_id'] = $id_usuario;
    $_SESSION['usuario_nome'] = $nome;
    header('Location: quiz.php');
} else {
    $_SESSION['erro_login'] = 'Credenciais inválidas.';
    header('Location: login.php');
}

mysqli_stmt_close($stmt);
mysqli_close($conexao);
exit();

