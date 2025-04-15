<?php
include ("conexao.php");

$nome = $_POST['nome'];
$email= $_POST['email'];
$telefone = $_POST['telefone'];
$senha = $_POST['senha'];


$sql = " INSERT INTO candidato (nome,email,telefone,senha)
values ('$nome','$email','$telefone','$senha')";
if (mysqli_query ($conexao,$sql)) {
    header('Location: candidato.html');
 } else {
     echo "erro" . mysqli_connect_erro($conexao);
 }

mysqli_close($conexao);
?>