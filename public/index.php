<?php
// public/index.php
require '../config/database.php';
require_once '../templates/auth.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Página Inicial</title>
</head>
<body>
    <?php include '../templates/header.php' ?>
    <h2>Bem-vindo, <?= htmlspecialchars($_SESSION['nome']) ?>!</h2>
    <p>Use o menu acima para navegar pelo sistema.</p>
    <?php include '../templates/footer.php' ?>
</body>
</html>
