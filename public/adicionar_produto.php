<?php
// public/adicionar_produto.php
require '../config/database.php';
require '../templates/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];

    $stmt = $pdo->prepare("INSERT INTO produtos (descricao, quantidade) VALUES (?, ?)");
    if ($stmt->execute([$descricao, $quantidade])) {
        // Registrar log de adição de produto
        $stmt_log = $pdo->prepare("INSERT INTO logs_acesso (usuario_id, acao) VALUES (?, ?)");
        $stmt_log->execute([$_SESSION['usuario_id'], "Adicionou produto: $descricao"]);

        header("Location: produtos.php");
        exit();
    } else {
        $erro = "Erro ao adicionar produto.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Adicionar Produto</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <h2>Adicionar Produto</h2>
    <?php if(isset($erro)) echo "<p style='color:red'>$erro</p>"; ?>
    <form method="POST" action="">
        <label>Descrição:</label><br>
        <input type="text" name="descricao" required><br>
        <label>Quantidade:</label><br>
        <input type="number" name="quantidade" required><br><br>
        <button type="submit">Adicionar</button>
    </form>
    <?php include '../templates/footer.php'; ?>
</body>
</html>
