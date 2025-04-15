<?php
include("conexao.php");

$id_empresa = $_GET['id_empresa'];
$sql = "SELECT * FROM empresa WHERE id_empresa = $id_empresa";
$result = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_assoc($result);
?>

<h2>Editar Usuário</h2>
<form action="atualizar_empresa.php" method="POST">
<!-- O hidden vai esconder o ID do usuário para que não
 seja atualizado pelo usuário na troca de atualização -->
  <input type="hidden" name="id" value="<?php echo $dados['id_empresa']; ?>">
  E-mail: <input type="text" name="email" value="<?php echo $dados['email']; ?>"><br>
  Senha: <input type="text" name="senha" value="<?php echo $dados['senha']; ?>"><br>
  <button type="submit">Atualizar</button>
</form>