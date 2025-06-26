<?php
require 'config.php';

if (isLoggedIn()) {
    redirect('dashboard.php');
}

$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $usuario = $_POST['usuario'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    // Validações
    if (empty($nome) || empty($usuario) || empty($email) || empty($senha)) {
        $erro = "Todos os campos são obrigatórios!";
    } elseif ($senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem!";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres!";
    } else {
        try {
            // Verifica se usuário já existe
            $stmt = $pdo->prepare("SELECT id FROM tabela_clientes WHERE usuario = ? OR email = ?");
            $stmt->execute([$usuario, $email]);
            
            if ($stmt->fetch()) {
                $erro = "Usuário ou email já cadastrado!";
            } else {
                // Hash da senha
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                
                // Insere novo usuário
                $stmt = $pdo->prepare("INSERT INTO tabela_clientes (nome, usuario, email, senha, ativo) VALUES (?, ?, ?, ?, 1)");
                $stmt->execute([$nome, $usuario, $email, $senha_hash]);
                
                // Login automático após cadastro
                $_SESSION['id'] = $pdo->lastInsertId();
                $_SESSION['usuario'] = $usuario;
                
                redirect('dashboard.php');
            }
        } catch (PDOException $e) {
            $erro = "Erro ao cadastrar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h1>Cadastro de Usuário</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>
        
        <?php if ($erro): ?>
            <div class="error"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label>Nome Completo:</label>
                <input type="text" name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Nome de Usuário:</label>
                <input type="text" name="usuario" value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Senha:</label>
                <input type="password" name="senha" required>
            </div>
            <div class="form-group">
                <label>Confirmar Senha:</label>
                <input type="password" name="confirmar_senha" required>
            </div>
            <button type="submit" class="btn-submit">Cadastrar</button>
        </form>
        
        <p>Já tem uma conta? <a href="index.php">Faça login</a></p>
    </div>
</body>
</html>