<?php
// public/relatorios.php
require '../config/database.php';
require '../templates/auth.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Relatórios</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <h2>Relatórios</h2>
    <ul>
        <li><a href="relatorios_acesso.php">Relatório de Acessos</a></li>
        <li><a href="relatorios_estoque.php">Relatório de Estoque</a></li>
        <li><a href="relatorios_material.php">Relatórios de Material</a></li>
        <li><a href="relatorio_ordens.php">Relatórios de Ordem de Serviços</a></li>
    </ul>
    <?php include '../templates/footer.php'; ?>
</body>
</html>
