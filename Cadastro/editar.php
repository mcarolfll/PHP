<?php
include("conexao.php");

if (!isset($_GET['id_candidato'])) {
    echo "ID do candidato não fornecido.";
    exit;
}

$id_candidato = (int) $_GET['id_candidato'];
$sql = "SELECT * FROM candidato WHERE id_candidato = $id_candidato";
$result = mysqli_query($conexao, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Candidato não encontrado.";
    exit;
}

$dados = mysqli_fetch_assoc($result);
?>

<h2>Editar Usuário</h2>
<form action="atualizar.php" method="POST">
    <input type="hidden" name="id_candidato" value="<?php echo $dados['id_candidato']; ?>">
    Nome: <input type="text" name="nome" value="<?php echo $dados['nome']; ?>"><br>
    E-mail: <input type="text" name="email" value="<?php echo $dados['email']; ?>"><br>
    Telefone: <input type="text" name="telefone" value="<?php echo $dados['telefone']; ?>"><br>
    Senha: <input type="text" name="senha" value="<?php echo $dados['senha']; ?>"><br>
    <button type="submit">Atualizar</button>
</form>
