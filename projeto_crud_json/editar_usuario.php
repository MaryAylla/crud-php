<?php

session_start();
require_once 'funcoes.php';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    $_SESSION['status'] = 'erro';
    $_SESSION['msg'] = 'Você precisa fazer login para acessar esta página.';
    header('Location: login.php');
    exit();
}


$usuarioParaEditar = null;
$idUsuario = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $idUsuario = (int) $_GET['id'];
    $usuarioParaEditar = buscarUsuarioPorId($idUsuario);

    if (!$usuarioParaEditar) {
        $_SESSION['status'] = 'erro';
        $_SESSION['msg'] = 'Usuário não encontrado para edição.';
        header('Location: index.php');
        exit();
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $idUsuario = (int) $_POST['id'];
    $nome = trim(isset($_POST['nome']) ? $_POST['nome'] : '');
    $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $idade = (int) (isset($_POST['idade']) ? $_POST['idade'] : 0);
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    if (empty($nome) || empty($email) || $idade <= 0 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = 'erro';
        $_SESSION['msg'] = 'Por favor, preencha nome, email válido e idade (maior que 0) corretamente.';
        header('Location: editar_usuario.php?id=' . $idUsuario);
        exit();
    }

    $dadosParaAtualizar = [
        'nome' => $nome,
        'email' => $email,
        'idade' => $idade
    ];

    if (!empty($senha)) {
        $dadosParaAtualizar['senha_hash'] = password_hash($senha, PASSWORD_DEFAULT);
    }

    if (atualizarUsuario($idUsuario, $dadosParaAtualizar)) {
        $_SESSION['status'] = 'sucesso';
        $_SESSION['msg'] = 'Usuário "' . htmlspecialchars($nome) . '" atualizado com sucesso!';
    } else {
        $_SESSION['status'] = 'erro';
        $_SESSION['msg'] = 'Nenhuma alteração foi feita ou ocorreu um erro ao atualizar o usuário.';
    }

    header('Location: index.php');
    exit();

} else {
    $_SESSION['status'] = 'erro';
    $_SESSION['msg'] = 'Requisição inválida para edição de usuário.';
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Editar Usuário</h1>

        <?php if (isset($_SESSION['status']) && isset($_SESSION['msg'])): ?>
            <div class="message <?php echo $_SESSION['status']; ?>">
                <?php
                echo $_SESSION['msg'];
                unset($_SESSION['status']);
                unset($_SESSION['msg']);
                ?>
            </div>
        <?php endif; ?>

        <?php if ($usuarioParaEditar): ?>
            <form action="editar_usuario.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuarioParaEditar['id']); ?>">

                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuarioParaEditar['nome']); ?>"
                    required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email"
                    value="<?php echo htmlspecialchars($usuarioParaEditar['email']); ?>" required>

                <label for="idade">Idade:</label>
                <input type="number" id="idade" name="idade"
                    value="<?php echo htmlspecialchars($usuarioParaEditar['idade']); ?>" required min="1">

                <label for="senha">Nova Senha (deixe em branco para não alterar):</label>
                <input type="password" id="senha" name="senha">
                <small>Preencha apenas se quiser alterar a senha.</small>

                <button type="submit">Atualizar Usuário</button>
            </form>
        <?php else: ?>
            <p>Nenhum usuário selecionado para edição.</p>
        <?php endif; ?>

        <p><a href="index.php">Voltar para a lista de usuários</a></p>
        <p><a href="logout.php">Sair</a></p>
    </div>
</body>

</html>