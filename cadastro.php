<?php
include ("conexao.php");

$nome=$_POST['nome'];
$sobrenome=$_POST['sobrenome'];
$email=$_POST['email'];
$senha=$_POST['senha'];

$sql="INSERT INTO cadastro(nome,sobrenome,email, senha)
VALUES ('$nome', '$sobrenome' , '$email' ,'$senha')";

if (mysqli_query ($conexao,$sql)) {
   echo "usuario cadastro com sucesso";
} else {
    echo "erro" . mysqli_connect_erro($conexao);
}
mysqli_close($conexao);
?>
