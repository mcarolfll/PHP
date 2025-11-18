<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'conexao.php';

$rankingSql = "SELECT u.nome, u.email, COALESCE(SUM(r.pontos),0) AS pontos, COUNT(r.id_resposta) AS questoes
               FROM usuario u
               LEFT JOIN resposta_usuario r ON r.id_usuario = u.id_usuario
               GROUP BY u.id_usuario
               ORDER BY pontos DESC, questoes DESC, u.nome ASC";
$resultado = mysqli_query($conexao, $rankingSql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking - Quiz</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container" style="width:min(700px,95vw);">
        <header style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h2>Ranking geral</h2>
            <div>
                <a class="btn" href="quiz.php" style="margin-right:10px;">Voltar ao quiz</a>
                <a class="btn" href="resultado.php">Meu resultado</a>
            </div>
        </header>

        <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Usuário</th>
                        <th>Pontos</th>
                        <th>Questões respondidas</th>
                    </tr>
                </thead>
                <tbody>
                <?php $posicao = 1; ?>
                <?php while ($linha = mysqli_fetch_assoc($resultado)): ?>
                    <tr<?php echo $linha['nome'] === $_SESSION['usuario_nome'] ? ' style="background:#f0f4ff;"' : ''; ?>>
                        <td><?php echo $posicao++; ?></td>
                        <td><?php echo htmlspecialchars($linha['nome']); ?></td>
                        <td><?php echo $linha['pontos']; ?></td>
                        <td><?php echo $linha['questoes']; ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum participante ainda.</p>
        <?php endif; ?>
    </div>
</body>
</html>

