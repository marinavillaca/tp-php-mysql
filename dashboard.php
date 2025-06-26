<?php
require 'config.php';
if (!isLoggedIn()) redirect('index.php');

// Processamento do CRUD
if (isset($_POST['nome'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $sql = $pdo->prepare("UPDATE tabela_clientes SET nome = ?, email = ? WHERE id = ?");
        $sql->execute([$nome, $email, $_POST['id']]);
        $mensagem = 'Atualizado com sucesso!';
    } else {
        $sql = $pdo->prepare("INSERT INTO tabela_clientes (nome, email) VALUES (?, ?)");
        $sql->execute([$nome, $email]);
        $mensagem = 'Cadastrado com sucesso!';
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->exec("DELETE FROM tabela_clientes WHERE id=$id");
    $mensagem = 'Deletado com sucesso!';
}

$editCliente = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $sql = $pdo->prepare("SELECT * FROM tabela_clientes WHERE id = ?");
    $sql->execute([$id]);
    $editCliente = $sql->fetch();
}

$clientes = $pdo->query("SELECT * FROM tabela_clientes")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['nome'] ?? $_SESSION['usuario'] ?? 'Visitante') . ' !!!! =)' ?></h1>
        <a href="logout.php" class="btn-logout">Sair</a>
    </header>

    <main class="container">
        <?php if (isset($mensagem)): ?>
            <div class="mensagem"><?= $mensagem ?></div>
        <?php endif; ?>

        <section class="card">
            <h2><?= $editCliente ? 'Editar Cliente' : 'Novo Cliente' ?></h2>
            <form method="post">
                <?php if ($editCliente): ?>
                    <input type="hidden" name="id" value="<?= $editCliente['id'] ?>">
                <?php endif; ?>
                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($editCliente ? $editCliente['nome'] : '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($editCliente ? $editCliente['email'] : '') ?>" required>
                </div>
                <button type="submit" class="btn-submit">
                    <?= $editCliente ? 'Atualizar' : 'Cadastrar' ?>
                </button>
                <?php if ($editCliente): ?>
                    <a href="dashboard.php" class="btn-cancel">Cancelar</a>
                <?php endif; ?>
            </form>
        </section>

        <section class="card">
            <h2>Clientes Cadastrados</h2>
            <?php foreach ($clientes as $cliente): ?>
                <div class="cliente-item">
                    <span><?= htmlspecialchars($cliente['nome']) ?> - <?= htmlspecialchars($cliente['email']) ?></span>
                    <div>
                        <a href="?edit=<?= $cliente['id'] ?>" class="btn-edit">Editar</a>
                        <a href="?delete=<?= $cliente['id'] ?>" class="btn-delete" 
                           onclick="return confirm('Tem certeza que quer deletar?')">Excluir</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
</body>
</html>