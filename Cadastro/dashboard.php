

<?php

// Incluindo a conexão
include("conexao.php");


$sql = "SELECT * FROM empresa";

$result = mysqli_query($conexao, $sql);
?>



<div class="tabela">
    <h2>Lista de Empresas</h2>
    <table>
      <tr>
        <th>nome</th>
        <th>cnpj</th>
        <th>email</th>
        <th>senha</th>
       
      
      </tr>
      <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          
          <td><?php echo $row['nome']; ?></td>
          <td><?php echo $row['cnpj']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php echo $row['senha']; ?></td>
      
        
        </tr>
      <?php } ?>
    </table>
  </div>