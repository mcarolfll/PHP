<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'conexao.php';

$usuarioId = $_SESSION['usuario_id'];
$respostas = $_POST['resposta'] ?? [];

if (empty($respostas)) {
    header('Location: quiz.php');
    exit();
}

// Recupera gabarito
$ids = array_map('intval', array_keys($respostas));
$idList = implode(',', $ids);

$sql = "SELECT id_pergunta, resposta_correta, valor
        FROM pergunta WHERE id_pergunta IN ($idList)";
$stmt = mysqli_query($conexao, $sql);

$gabaritoMap = [];
while ($row = mysqli_fetch_assoc($stmt)) {
    $gabaritoMap[$row['id_pergunta']] = [
        'resposta' => $row['resposta_correta'],
        'valor' => (int)$row['valor']
    ];
}
mysqli_free_result($stmt);

$insertSql = "INSERT INTO resposta_usuario (id_usuario, id_pergunta, resposta_escolhida, correta, pontos)
              VALUES (?, ?, ?, ?, ?)
              ON DUPLICATE KEY UPDATE resposta_escolhida = VALUES(resposta_escolhida),
                                      correta = VALUES(correta),
                                      pontos = VALUES(pontos),
                                      respondido_em = CURRENT_TIMESTAMP";
$stmtInsert = mysqli_prepare($conexao, $insertSql);

$perguntaAtual = 0;
$alternativaEscolhida = '';
$acertouAtual = 0;
$pontosAtual = 0;
mysqli_stmt_bind_param(
    $stmtInsert,
    'iisii',
    $usuarioId,
    $perguntaAtual,
    $alternativaEscolhida,
    $acertouAtual,
    $pontosAtual
);

foreach ($respostas as $perguntaId => $alternativa) {
    if (!isset($gabaritoMap[$perguntaId])) {
        continue;
    }

    $perguntaAtual = (int)$perguntaId;
    $alternativaEscolhida = strtoupper($alternativa);
    $acertouAtual = (int)($alternativaEscolhida === $gabaritoMap[$perguntaId]['resposta']);
    $pontosAtual = $acertouAtual ? $gabaritoMap[$perguntaId]['valor'] : 0;

    mysqli_stmt_execute($stmtInsert);
}

mysqli_stmt_close($stmtInsert);
mysqli_close($conexao);

header('Location: resultado.php');
exit();

