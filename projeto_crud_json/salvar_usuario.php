<?php session_start();
require_once 'funcoes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim(isset($_POST['nome']) ? $_POST['nome'] : '');
    $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $idade = (int) (isset($_POST['idade']) ? $_POST['idade'] : 0);
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    if (empty($nome) || empty($email) || empty($senha) || $idade <= 0 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = 'erro';
        $_SESSION['msg'] = 'Por favor, preencha todos os campos corretamente (nome, email válido, idade > 0 e senha).';
        header('Location: index.php');
        exit();
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $usuariosExistentes = lerUsuarios(); 
    foreach ($usuariosExistentes as $usuario) {
        if (isset($usuario['email']) && $usuario['email'] === $email) {
            $_SESSION['status'] = 'erro';
            $_SESSION['msg'] = 'O e-mail "' . htmlspecialchars($email) . '" já está cadastrado.';
            header('Location: index.php');
            exit();
        }
    }

    $novoUsuarioDados = [
        'nome' => $nome,
        'email' => $email,
        'idade' => $idade,
        'senha_hash' => $senha_hash
    ];

    $novoId = criarUsuario($novoUsuarioDados);

    if ($novoId !== false) { 
        $_SESSION['status'] = 'sucesso';
        $_SESSION['msg'] = 'Usuário "' . htmlspecialchars($nome) . '" cadastrado com sucesso! ID: ' . $novoId;
    } else {
        $_SESSION['status'] = 'erro';
        $_SESSION['msg'] = 'Erro ao cadastrar usuário. Tente novamente.';
    }

    header('Location: index.php');
    exit();

} else {
    $_SESSION['status'] = 'erro';
    $_SESSION['msg'] = 'Método de requisição inválido.';
    header('Location: index.php');
    exit();
}