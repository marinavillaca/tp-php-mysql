<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM tabela_clientes WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $user = $stmt->fetch();
        
        if ($user) {
            // Verifica se a senha está hasheada ou em texto puro
            if (password_verify($senha, $user['senha'])) {
                // Senha hasheada correta
                $_SESSION['id'] = $user['id'];
                $_SESSION['usuario'] = $user['usuario'];
                $_SESSION['nome'] = $user['nome']; 

                redirect('dashboard.php');
            } elseif ($user['senha'] === $senha) {

                $_SESSION['id'] = $user['id'];
                $_SESSION['usuario'] = $user['usuario'];
                redirect('dashboard.php');
            } else {
                redirect('index.php?error=Usuário ou senha incorretos');
            }
        } else {
            redirect('index.php?error=Usuário ou senha incorretos');
        }
    } catch (PDOException $e) {
        redirect('index.php?error=Erro no servidor');
    }
}
redirect('index.php');
?>