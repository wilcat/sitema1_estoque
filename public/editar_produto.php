<?php
// public/editar_produto.php
require '../config/database.php';
require '../templates/auth.php';

if(!isset($_GET['id'])) {
    header("Location: produtos.php");
    exit();
}

$id = $_GET['id'];

// Buscar produto
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch();

if(!$produto) {
    header("Location: produtos.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];

    $stmt = $pdo->prepare("UPDATE produtos SET descricao = ?, quantidade = ? WHERE id = ?");
    if ($stmt->execute([$descricao, $quantidade, $id])) {
        // Registrar log de edição de produto
        $stmt_log = $pdo->prepare("INSERT INTO logs_acesso (usuario_id, acao) VALUES (?, ?)");
        $stmt_log->execute([$_SESSION['usuario_id'], "Editou produto: $descricao"]);

        header("Location: produtos.php");
        exit();
    } else {
        $erro = "Erro ao atualizar produto.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Editar Produto</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <h2>Editar Produto</h2>
    <?php if(isset($erro)) echo "<p style='color:red'>$erro</p>"; ?>
    <form method="POST" action="">
        <label>Descrição:</label><br>
        <input type="text" name="descricao" value="<?= htmlspecialchars($produto['descricao']) ?>" required><br>
        <label>Quantidade:</label><br>
        <input type="number" name="quantidade" value="<?= htmlspecialchars($produto['quantidade']) ?>" required><br><br>
        <label>Estoque Minimo:</label><br>
        <input type="number" name="estoque_minimo" value="<?= htmlspecialchars($produto['estoque_minimo']) ?>" required><br><br>
        <button type="submit">Atualizar</button>
    </form>
    <?php include '../templates/footer.php'; ?>
</body>
</html>
