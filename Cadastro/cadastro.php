<?php
include ("conexao.php");

$nome = $_POST['nome'];
$cnpj= $_POST['cnpj'];
$email = $_POST['email'];
$senha = $_POST['senha'];


$sql = " INSERT INTO empresa (nome,cnpj,email,senha)
values ('$nome','$cnpj','$email','$senha')";
if (mysqli_query ($conexao,$sql)) {
    header('Location: empresa.html');
 } else {
     echo "erro" . mysqli_connect_erro($conexao);
 }

mysqli_close($conexao);
?>