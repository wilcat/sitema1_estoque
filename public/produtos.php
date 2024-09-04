<?php
// public/produtos.php
require '../config/database.php';
require '../templates/auth.php';

// Buscar todos os produtos
$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Gerenciar Produtos</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <h2>Produtos</h2>
    <a href="adicionar_produto.php">Adicionar Produto</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>
        <?php foreach($produtos as $produto): ?>
        <tr>
            <td><?= htmlspecialchars($produto['id']) ?></td>
            <td><?= htmlspecialchars($produto['descricao']) ?></td>
            <td><?= htmlspecialchars($produto['quantidade']) ?></td>
            <td>
                <a href="editar_produto.php?id=<?= $produto['id'] ?>">Editar</a> |
                <a href="deletar_produto.php?id=<?= $produto['id'] ?>" onclick="return confirm('Tem certeza que deseja deletar este produto?');">Deletar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php include '../templates/footer.php'; ?>
</body>
</html>
