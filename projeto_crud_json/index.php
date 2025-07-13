<?php session_start();

require_once 'conexao.php';

require_once 'funcoes.php';


$mensagem = '';
$tipoMensagem = '';

if (isset($_SESSION['status'])) {
    if ($_SESSION['status'] === 'sucesso') {
        $mensagem = isset($_SESSION['msg']) ? $_SESSION['msg'] : 'Operação realizada com sucesso!';
        $tipoMensagem = 'sucesso';
    } elseif (isset($_SESSION['status']) && $_SESSION['status'] === 'erro') {
        $mensagem = isset($_SESSION['msg']) ? $_SESSION['msg'] : 'Ocorreu um erro na operação.';
        $tipoMensagem = 'erro';
    }
    unset($_SESSION['status']);
    unset($_SESSION['msg']);
}

$usuarios = lerUsuarios();

if (!is_array($usuarios)) {
    $usuarios = [];
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Usuários</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Gerenciamento de Usuários</h1>

        <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
            <p style="text-align: center;">Bem-vindo(a), **<?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>**! <a href="logout.php">Sair</a></p>
        <?php endif; ?>

        <?php if (!empty($mensagem)):  ?>
            <div class="mensagem-<?php echo $tipoMensagem; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <h2>Adicionar Novo Usuário</h2>
        <form action="salvar_usuario.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required autocomplete="name">

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required autocomplete="email">

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" min="1" required autocomplete="off">

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required autocomplete="new-password">

            <button type="submit" class="submit-btn">Adicionar Usuário</button>
        </form>
    </div>

    <div class="container">
        <h2>Lista de Usuários</h2>
        <?php if (empty($usuarios)): ?>
            <p>Nenhum usuário cadastrado ainda.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Idade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['idade']); ?></td>
                            <td>
                               <a href="editar_usuario.php?id=<?php echo htmlspecialchars($usuario['id']); ?>" class="button edit">Editar</a>
                               <a href="deletar_usuario.php?id=<?php echo htmlspecialchars($usuario['id']); ?>" class="button delete" onclick="return confirm('Tem certeza que deseja deletar este usuário?');">Deletar</a>
                            </td>
                       </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>