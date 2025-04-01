<?php
include ("conexao.php");

$nome=$_POST['nome'];
$nascimento=$_POST['nascimento'];
$email=$_POST['email'];
$serie=$_POST['serie'];

$sql="INSERT INTO alunos(nome,nascimento,email, serie)
VALUES ('$nome', '$nascimento' , '$email' ,'$serie')";

if (mysqli_query ($conexao,$sql)) {
   echo "Aluno cadastrado com sucesso!";
} else {
    echo "erro" . mysqli_connect_erro($conexao);
}
mysqli_close($conexao);
?>