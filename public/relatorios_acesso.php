<?php
// public/relatorios_acesso.php
require '../config/database.php';
require '../templates/auth.php';

// Buscar logs de acesso
$stmt = $pdo->query("SELECT logs_acesso.id, usuarios.nome, logs_acesso.acao, logs_acesso.data_acesso
                     FROM logs_acesso
                     JOIN usuarios ON logs_acesso.usuario_id = usuarios.id
                     ORDER BY logs_acesso.data_acesso DESC");
$logs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Relatório de Acessos</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <h2>Relatório de Acessos</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Ação</th>
            <th>Data</th>
        </tr>
        <?php foreach($logs as $log): ?>
        <tr>
            <td><?= htmlspecialchars($log['id']) ?></td>
            <td><?= htmlspecialchars($log['nome']) ?></td>
            <td><?= htmlspecialchars($log['acao']) ?></td>
            <td><?= htmlspecialchars($log['data_acesso']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php include '../templates/footer.php'; ?>
</body>
</html>
