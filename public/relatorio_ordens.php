<?php
include '../config/database.php';
include '../templates/auth.php';
require '../vendor/autoload.php'; // se estiver usando Composer

// Consulta para obter todas as ordens de serviço
$query = "SELECT id, descricao, data_criacao FROM ordens_servico ORDER BY data_criacao DESC";
$stmt = $pdo->query($query);
$ordens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Ordens de Serviço</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<?php include '../templates/header.php'; ?>

<div class="container">
    <h2>Relatório de Ordens de Serviço</h2>

    <?php if ($ordens): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Data de Criação</th>
            </tr>
            <?php foreach ($ordens as $ordem): ?>
                <tr>
                    <td><?= $ordem['id'] ?></td>
                    <td><?= $ordem['descricao'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($ordem['data_criacao'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <form action="gerar_relatorio_ordens.php" method="post">
            <button type="submit">Gerar Relatório em PDF</button>
        </form>
    <?php else: ?>
        <p>Nenhuma ordem de serviço encontrada.</p>
    <?php endif; ?>
</div>

<?php include '../templates/footer.php'; ?>
</body>
</html>
