<?php
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_candidato = (int) $_POST['id_candidato'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];

    $sql = "UPDATE candidato SET nome='$nome', email='$email', telefone='$telefone', senha='$senha' WHERE id_candidato=$id_candidato";

    if (mysqli_query($conexao, $sql)) {
        header("Location: dashboard2.php");
        exit;
    } else {
        echo "Erro ao atualizar: " . mysqli_error($conexao);
    }
} else {
    echo "Requisição inválida.";
}
?>
