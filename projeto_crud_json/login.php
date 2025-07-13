<?php session_start();

$mensagem = '';
$tipoMensagem = '';

if (isset($_SESSION['status'])) {
    if ($_SESSION['status'] === 'sucesso') {
        $mensagem = isset($_SESSION['msg']) ? $_SESSION['msg'] : 'Operação realizada com sucesso!';
        $tipoMensagem = 'sucesso';
    } elseif (isset($_SESSION['status']) && $_SESSION['status'] === 'erro') {
        $mensagem = isset($_SESSION['msg']) ? $_SESSION['msg'] : 'Ocorreu um erro.';
        $tipoMensagem = 'erro';
    }
    unset($_SESSION['status']);
    unset($_SESSION['msg']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
<body>
    <div class="container">
        <h1>Login</h1>

        <?php if (!empty($mensagem)): ?>
            <div class="mensagem-<?php echo $tipoMensagem; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <form action="processar_login.php" method="POST">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required autocomplete="email">

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required autocomplete="current-password">

            <button type="submit" class="submit-btn">Entrar</button>
        </form>
        <p style="margin-top: 20px;">Não tem uma conta? <a href="index.php">Crie uma aqui</a></p>
    </div>
</body>
</html>