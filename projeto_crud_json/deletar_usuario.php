<?php session_start();
require_once 'funcoes.php';


error_reporting(E_ALL);
ini_set('display_errors', 1);

echo '<pre>';
echo 'DEBUG: Conteúdo de $_SESSION na entrada do deletar_usuario.php: ';
print_r($_SESSION);
echo '</pre>';

echo 'DEBUG: $_SESSION[\'logado\'] é: ' . (isset($_SESSION['logado']) ? ($_SESSION['logado'] ? 'true' : 'false') : 'NÃO DEFINIDO') . '<br>';
echo 'DEBUG: Tipo de $_SESSION[\'logado\']: ' . (isset($_SESSION['logado']) ? gettype($_SESSION['logado']) : 'N/A') . '<br>';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    $_SESSION['status'] = 'erro';
    $_SESSION['msg'] = 'Você precisa fazer login para acessar esta página.';
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $idParaDeletar = (int) $_GET['id'];

    $nomeUsuarioDeletado = 'usuário desconhecido';
    $usuariosExistentes = lerUsuarios();
    foreach ($usuariosExistentes as $user) {
        if (isset($user['id']) && $user['id'] == $idParaDeletar) {
            $nomeUsuarioDeletado = htmlspecialchars(isset($user['nome']) ? $user['nome'] : 'usuário desconhecido');
            break;
        }
    }

    if (deletarUsuario($idParaDeletar)) {
        $_SESSION['status'] = 'sucesso';
        $_SESSION['msg'] = 'Usuário "' . $nomeUsuarioDeletado . '" (ID: ' . $idParaDeletar . ') deletado com sucesso!';
    } else {
        $_SESSION['status'] = 'erro';
        $_SESSION['msg'] = 'Erro ao deletar usuário (ID: ' . $idParaDeletar . '). Pode ser que ele não exista ou ocorreu um erro no banco de dados.';
    }

    header('Location: index.php');
    exit();

} else {
    $_SESSION['status'] = 'erro';
    $_SESSION['msg'] = 'ID de usuário não fornecido para exclusão.';
    header('Location: index.php');
    exit();
}
?>