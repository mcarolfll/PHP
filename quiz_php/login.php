<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header('Location: quiz.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Quiz</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="login_processa.php" method="POST">
        <div class="container">
            <div class="heading">Acesse sua conta</div>

            <?php if (!empty($_SESSION['erro_login'])): ?>
                <div class="alert"><?php echo $_SESSION['erro_login']; unset($_SESSION['erro_login']); ?></div>
            <?php endif; ?>

            <div class="input-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autocomplete="off">
            </div>

            <div class="input-field">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required autocomplete="off">
            </div>

            <button class="btn" type="submit">Entrar</button>

            <div class="message">
                Ainda não tem cadastro? <a href="index.html">Crie sua conta</a>
            </div>
        </div>
    </form>
</body>
</html>

