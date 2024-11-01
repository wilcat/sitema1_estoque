<?php
// public/produtos.php
require '../config/database.php';
require '../templates/auth.php';

$isAdmin = $_SESSION['tipo_usuario'] === 'admin';

// Buscar todos os produtos
$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll();

$query = "SELECT nome, quantidade, estoque_minimo FROM produtos WHERE quantidade <= estoque_minimo";
$stmt = $pdo->query($query);
$produtos_criticos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($produtos_criticos) {
        foreach ($produtos_criticos as $produto) {
            echo "Atenção: O produto {$produto['nome']} está abaixo do estoque mínimo!";
        }
}
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
    <table>
    <thead>
        <tr>
            <th>Nome do Produto</th>
            <th>Quantidade</th>
            <th>Descrição</th>
            <?php if ($isAdmin): ?>
                <th>Ações</th> <!-- Exibe a coluna "Ações" apenas para administradores -->
                <a href="adicionar_produto.php">Adicionar Produto</a>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?= htmlspecialchars($produto['nome']) ?></td>
                <td><?= htmlspecialchars($produto['quantidade']) ?></td>
                <td><?= htmlspecialchars($produto['descricao']) ?></td>
                <?php if ($isAdmin): ?>
                    <td>
                        <!-- Apenas administradores podem ver os botões de edição e exclusão -->
                        <a href="editar_produto.php?id=<?= $produto['id'] ?>">Editar</a>
                        <a href="excluir_produto.php?id=<?= $produto['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    <?php include '../templates/footer.php'; ?>
</body>
</html>
