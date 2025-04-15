

<?php

// Incluindo a conexão
include("conexao.php");


$sql = "SELECT * FROM candidato";

$result = mysqli_query($conexao, $sql);
?>

<a href="candidato.html"><button>voltar</button></a>


<div class="tabela">
    <h2>Lista de Candidatos</h2>
    <table>
      <tr>
        <th>id</th>
        <th>nome</th>
        <th>email</th>
        <th>telefone</th>
        <th>senha</th>
       
      
      </tr>
      <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
        <td><?php echo $row['id_cand']; ?></td>
          <td><?php echo $row['nome']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php echo $row['telefone']; ?></td>
          <td><?php echo $row['senha']; ?></td>
          <td>
    <a href="editar_candidato.php?id=<?php echo $row['id_cand']; ?>">Editar</a>
  </td>
        
        </tr>
      <?php } ?>
    </table>
  </div>