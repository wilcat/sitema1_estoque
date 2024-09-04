<?php
// public/relatorios_estoque.php
require '../config/database.php';
require '../templates/auth.php';

// Buscar todos os produtos
$stmt = $pdo->query("SELECT * FROM produtos ORDER BY descricao ASC");
$produtos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Relatório de Estoque</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <h2>Relatório de Estoque</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Quantidade</th>
            <th>Data de Criação</th>
        </tr>
        <?php foreach($produtos as $produto): ?>
        <tr>
            <td><?= htmlspecialchars($produto['id']) ?></td>
            <td><?= htmlspecialchars($produto['descricao']) ?></td>
            <td><?= htmlspecialchars($produto['quantidade']) ?></td>
            <td><?= htmlspecialchars($produto['criado_em']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php include '../templates/footer.php'; ?>
</body>
</html>
