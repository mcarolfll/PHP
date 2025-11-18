<?php
$servidor = "localhost";
$usuario = "root";       // Alterar para um usuário dedicado em produção
$senha = "123456"; // Alterar esta senha!
$dbname = "quiz";

$conexao = mysqli_connect($servidor, $usuario, $senha, $dbname);

if (!$conexao) {
    die("Houve um erro: " . mysqli_connect_error());
}
?>