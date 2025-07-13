<?php

require_once 'conexao.php';

function lerUsuarios() {
    global $pdo;

    try {
        $stmt = $pdo->query("SELECT id, nome, email, idade FROM usuarios ORDER BY id ASC");
        $usuarios = $stmt->fetchAll();
        return $usuarios;

    } catch (PDOException $e) {
        error_log("Erro ao ler usuários do banco de dados: " . $e->getMessage());
        return [];
    }
}

function buscarUsuarioPorEmail($email) {
    global $pdo;
    try {
        $sql = "SELECT id, nome, email, idade, senha_hash FROM usuarios WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC); 
        
        return $usuario;

    } catch (PDOException $e) {
        error_log("Erro ao buscar usuário por email: " . $e->getMessage());
        return false;
    }
}

function criarUsuario($dadosUsuario) {
    global $pdo;

    try {
        $sql = "INSERT INTO usuarios (nome, email, idade, senha_hash) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            $dadosUsuario['nome'],
            $dadosUsuario['email'],
            $dadosUsuario['idade'],
            $dadosUsuario['senha_hash']
        ]);
        
        return $pdo->lastInsertId();

    } catch (PDOException $e) {
        error_log("Erro ao criar usuário no banco de dados: " . $e->getMessage());
        return false;
    }
}

function deletarUsuario($id) {
    global $pdo;

    try {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        return $stmt->rowCount() > 0;

    } catch (PDOException $e) {
        error_log("Erro ao deletar usuário do banco de dados (ID: $id): " . $e->getMessage());
        return false;
    }
}

function buscarUsuarioPorId($id) {
    global $pdo;
    try {
        $sql = "SELECT id, nome, email, idade FROM usuarios WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC); 
        
        return $usuario; 

    } catch (PDOException $e) {
        error_log("Erro ao buscar usuário por ID: " . $e->getMessage());
        return false;
    }
}

function atualizarUsuario($id, $dadosUsuario) {
    global $pdo;

    try {
        $sql = "UPDATE usuarios SET nome = :nome, email = :email, idade = :idade";
        
        if (isset($dadosUsuario['senha_hash']) && !empty($dadosUsuario['senha_hash'])) {
            $sql .= ", senha_hash = :senha_hash";
        }
        
        $sql .= " WHERE id = :id"; 
        
        $stmt = $pdo->prepare($sql);
        
        $params = [
            ':nome' => $dadosUsuario['nome'],
            ':email' => $dadosUsuario['email'],
            ':idade' => $dadosUsuario['idade'],
            ':id' => $id
        ];

        if (isset($dadosUsuario['senha_hash']) && !empty($dadosUsuario['senha_hash'])) {
            $params[':senha_hash'] = $dadosUsuario['senha_hash'];
        }

        $stmt->execute($params);
        
        return $stmt->rowCount() > 0;

    } catch (PDOException $e) {
        error_log("Erro ao atualizar usuário no banco de dados (ID: $id): " . $e->getMessage());
        return false;
    }
}

?>