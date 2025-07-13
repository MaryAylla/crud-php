<?php session_start();
require_once 'funcoes.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
echo '<pre>';
echo 'DEBUG_LOGIN_PROC: Conteúdo de $_POST na entrada: ';
print_r($_POST);
echo '</pre>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    echo "DEBUG_LOGIN_PROC: Email digitado: '" . htmlspecialchars($email) . "'<br>";
    echo "DEBUG_LOGIN_PROC: Senha digitada (texto puro): '" . htmlspecialchars($senha) . "'<br>";

    if (empty($email) || empty($senha)) {
        $_SESSION['status'] = 'erro';
        $_SESSION['msg'] = 'Por favor, preencha todos os campos.';
        header('Location: login.php');
        exit();
    }

    $usuarioAutenticado = buscarUsuarioPorEmail($email);

    echo "DEBUG_LOGIN_PROC: Resultado de buscarUsuarioPorEmail(): ";
    if ($usuarioAutenticado) {
        echo "Usuário encontrado.<br>";
        echo "DEBUG_LOGIN_PROC: Hash da senha no BD para este email: '" . htmlspecialchars(isset($usuarioAutenticado['senha_hash']) ? $usuarioAutenticado['senha_hash'] : 'N/A') . "'<br>";
    } else {
        echo "Nenhum usuário encontrado com este email.<br>";
    }

    if ($usuarioAutenticado && isset($usuarioAutenticado['senha_hash']) && password_verify($senha, $usuarioAutenticado['senha_hash'])) {
        echo "DEBUG_LOGIN_PROC: password_verify() retornou TRUE. Senha CORRETA.<br>";

        $_SESSION['logado'] = true;
        $_SESSION['usuario_id'] = $usuarioAutenticado['id'];
        $_SESSION['usuario_nome'] = $usuarioAutenticado['nome'];
        $_SESSION['usuario_email'] = $usuarioAutenticado['email'];

        $_SESSION['status'] = 'sucesso';
        $_SESSION['msg'] = 'Login realizado com sucesso! Bem-vindo, ' . htmlspecialchars($usuarioAutenticado['nome']) . '.';

        header('Location: index.php');
        exit();
    } else {
        $_SESSION['status'] = 'erro';

        if (!$usuarioAutenticado) { 
            $_SESSION['msg'] = 'E-mail não cadastrado.';
        } else {
            $_SESSION['msg'] = 'Senha incorreta.';
        }

        header('Location: login.php');
        exit();
    }

} else {
    $_SESSION['status'] = 'erro';
    $_SESSION['msg'] = 'Método de requisição inválido.';
    header('Location: login.php');
    exit();
}
?>