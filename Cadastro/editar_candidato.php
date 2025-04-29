<?php
include("conexao.php");

$id = $_GET['id'];
$sql = "SELECT * FROM candidato WHERE id_cand = $id";
$result = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_assoc($result);
?>

<h2>Editar Usuário</h2>
<form action="atualizar2.php" method="POST">
<!-- O hidden vai esconder o ID do usuário para que não 
 seja atualizado pelo usuário na troca de atualização -->
  <input type="hidden" name="id" value="<?php echo $dados['id_cand']; ?>">
  E-mail: <input type="text" name="email" value="<?php echo $dados['email']; ?>"><br>
  Senha: <input type="text" name="senha" value="<?php echo $dados['senha']; ?>"><br>
  <button type="submit">Atualizar</button>
</form>