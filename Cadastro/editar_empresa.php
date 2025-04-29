<?php
include("conexao.php");

$id = $_GET['id'];
$sql = "SELECT * FROM empresa WHERE id_emp = $id";
$result = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_assoc($result);
?>

<h2>Editar Usuário</h2>
<form action="atualizar.php" method="POST">
<!-- O hidden vai esconder o ID do usuário para que não 
 seja atualizado pelo usuário na troca de atualização -->
  <input type="hidden" name="id" value="<?php echo $dados['id_emp']; ?>">
  E-mail: <input type="text" name="email" value="<?php echo $dados['email']; ?>"><br>
  Senha: <input type="text" name="senha" value="<?php echo $dados['senha']; ?>"><br>
  <button type="submit">Atualizar</button>
</form>