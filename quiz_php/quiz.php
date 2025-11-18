<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'conexao.php';

$usuarioId = $_SESSION['usuario_id'];
$usuarioNome = $_SESSION['usuario_nome'];

// Recupera perguntas ativas
$perguntasSql = "SELECT id_pergunta, titulo, alternativa_a, alternativa_b, alternativa_c, alternativa_d
                 FROM pergunta
                 WHERE ativa = 1
                 ORDER BY id_pergunta ASC";
$perguntasResult = mysqli_query($conexao, $perguntasSql);

// Respostas já enviadas pelo usuário
$respostaSql = "SELECT id_pergunta, resposta_escolhida, correta, pontos
                FROM resposta_usuario
                WHERE id_usuario = ?";
$stmtResp = mysqli_prepare($conexao, $respostaSql);
mysqli_stmt_bind_param($stmtResp, 'i', $usuarioId);
mysqli_stmt_execute($stmtResp);
$respostasUsuario = [];
mysqli_stmt_bind_result($stmtResp, $idPerg, $respEscolhida, $correta, $pontos);
while (mysqli_stmt_fetch($stmtResp)) {
    $respostasUsuario[$idPerg] = [
        'resposta' => $respEscolhida,
        'correta' => (bool)$correta,
        'pontos' => $pontos
    ];
}
mysqli_stmt_close($stmtResp);

$pontuacaoSql = "SELECT COALESCE(SUM(pontos), 0) AS total_pontos, COUNT(*) AS respondidas
                 FROM resposta_usuario
                 WHERE id_usuario = ?";
$stmtPont = mysqli_prepare($conexao, $pontuacaoSql);
mysqli_stmt_bind_param($stmtPont, 'i', $usuarioId);
mysqli_stmt_execute($stmtPont);
mysqli_stmt_bind_result($stmtPont, $totalPontos, $respondidas);
mysqli_stmt_fetch($stmtPont);
mysqli_stmt_close($stmtPont);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container" style="width: min(760px, 95vw);">
        <header style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <div>
                <strong>Olá, <?php echo htmlspecialchars($usuarioNome); ?>!</strong><br>
                Pontuação atual: <?php echo $totalPontos; ?> pts · Questões respondidas: <?php echo $respondidas; ?>
            </div>
            <div>
                <a class="btn" href="ranking.php" style="margin-right:10px;">Ranking</a>
                <a class="btn" href="logout.php">Sair</a>
            </div>
        </header>

        <?php if ($perguntasResult && mysqli_num_rows($perguntasResult) > 0): ?>
            <form action="processa_quiz.php" method="POST">
                <?php while ($pergunta = mysqli_fetch_assoc($perguntasResult)): ?>
                    <?php
                        $respondida = $respostasUsuario[$pergunta['id_pergunta']] ?? null;
                        $marcada = $respondida['resposta'] ?? '';
                        $correta = $respondida['correta'] ?? null;
                    ?>
                    <div class="quiz-card">
                        <h2><?php echo $pergunta['id_pergunta'] . '. ' . htmlspecialchars($pergunta['titulo']); ?></h2>
                        <div class="options">
                            <?php foreach (['A','B','C','D'] as $opcao): 
                                $campo = 'alternativa_' . strtolower($opcao);
                                $checked = $marcada === $opcao ? 'checked' : '';
                            ?>
                                <label>
                                    <input type="radio"
                                           name="resposta[<?php echo $pergunta['id_pergunta']; ?>]"
                                           value="<?php echo $opcao; ?>"
                                           <?php echo $checked; ?>
                                           required>
                                    (<?php echo $opcao; ?>) <?php echo htmlspecialchars($pergunta[$campo]); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <?php if ($correta === true): ?>
                            <small style="color:green;">Você acertou esta questão! (+<?php echo $respondida['pontos']; ?>)</small>
                        <?php elseif ($correta === false): ?>
                            <small style="color:#c0392b;">Você errou esta questão. Tente novamente.</small>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>

                <button class="btn" type="submit">Enviar respostas</button>
            </form>
        <?php else: ?>
            <p>Não há perguntas ativas no momento.</p>
        <?php endif; ?>
    </div>
</body>
</html>

