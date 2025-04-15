

<?php

// Incluindo a conexão
include("conexao.php");


$sql = "SELECT * FROM empresa";

$result = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<a href="empresa.html"><button>voltar</button></a>


  <div class="container">
    <h2>Lista de Usuários</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Senha</th>
      </tr>
      <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $row['id_emp']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php echo $row['senha']; ?></td>
        </tr>
        <td>
    <a href="editar_empresa.php?id=<?php echo $row['id_emp']; ?>">Editar</a>
  </td>
      <?php } ?>
     
    </table>
    <td>
    
  </td>
  </div>

    </table>
  </div>
</body>
</html>