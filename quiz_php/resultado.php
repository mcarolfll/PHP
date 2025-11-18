<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'conexao.php';

$usuarioId = $_SESSION['usuario_id'];
$usuarioNome = $_SESSION['usuario_nome'];

$historicoSql = "SELECT p.titulo, ru.resposta_escolhida, p.resposta_correta, ru.correta, ru.pontos, ru.respondido_em
                 FROM resposta_usuario ru
                 INNER JOIN pergunta p ON p.id_pergunta = ru.id_pergunta
                 WHERE ru.id_usuario = ?
                 ORDER BY ru.respondido_em DESC";
$stmt = mysqli_prepare($conexao, $historicoSql);
mysqli_stmt_bind_param($stmt, 'i', $usuarioId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result(
    $stmt,
    $titulo,
    $respostaEscolhida,
    $gabarito,
    $correta,
    $pontos,
    $respondidoEm
);
$historico = [];
while (mysqli_stmt_fetch($stmt)) {
    $historico[] = [
        'titulo' => $titulo,
        'resposta' => $respostaEscolhida,
        'gabarito' => $gabarito,
        'correta' => (bool)$correta,
        'pontos' => $pontos,
        'respondido_em' => $respondidoEm
    ];
}
mysqli_stmt_close($stmt);

$pontuacaoSql = "SELECT COALESCE(SUM(pontos),0) AS total FROM resposta_usuario WHERE id_usuario = ?";
$stmtPont = mysqli_prepare($conexao, $pontuacaoSql);
mysqli_stmt_bind_param($stmtPont, 'i', $usuarioId);
mysqli_stmt_execute($stmtPont);
mysqli_stmt_bind_result($stmtPont, $totalPontos);
mysqli_stmt_fetch($stmtPont);
mysqli_stmt_close($stmtPont);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - Quiz</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container" style="width:min(820px,95vw);">
        <header style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <div>
                <h2>Resumo de <?php echo htmlspecialchars($usuarioNome); ?></h2>
                <p>Total de pontos: <?php echo $totalPontos; ?></p>
            </div>
            <div>
                <a class="btn" href="quiz.php" style="margin-right:10px;">Voltar ao quiz</a>
                <a class="btn" href="ranking.php">Ranking</a>
            </div>
        </header>

        <?php if (!empty($historico)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Pergunta</th>
                        <th>Resposta enviada</th>
                        <th>Gabarito</th>
                        <th>Status</th>
                        <th>Pontos</th>
                        <th>Respondido em</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($historico as $linha): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($linha['titulo']); ?></td>
                        <td><?php echo $linha['resposta']; ?></td>
                        <td><?php echo $linha['gabarito']; ?></td>
                        <td><?php echo $linha['correta'] ? 'Correta' : 'Incorreta'; ?></td>
                        <td><?php echo $linha['pontos']; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($linha['respondido_em'])); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Responda ao quiz para ver seus resultados.</p>
        <?php endif; ?>
    </div>
</body>
</html>

