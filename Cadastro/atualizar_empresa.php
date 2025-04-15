<?php
include("conexao.php");

$id_empresa = $_POST['id_empresa'];
$email= $_POST['email'];
$senha = $_POST['senha'];

$sql = "UPDATE empresa SET email='$email', senha='$senha' WHERE id_empresa=$id_empresa";

if (mysqli_query($conexao, $sql)) {
    header("Location: dashboard.php");
} else {
    echo "Erro ao atualizar: " . mysqli_error($conexao);
}
?>