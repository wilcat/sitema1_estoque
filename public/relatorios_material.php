<?php
// public/relatorios_material.php
require '../config/database.php';
require '../templates/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];

    $stmt = $pdo->prepare("INSERT INTO relatorios_material (usuario_id, descricao) VALUES (?, ?)");
    if ($stmt->execute([$_SESSION['usuario_id'], $descricao])) {
        $_SESSION['mensagem'] = "Relatório de material criado com sucesso!";
        header("Location: relatorios_material.php");
        exit();
    } else {
        $erro = "Erro ao criar relatório.";
    }
}

// Buscar relatórios do usuário
$stmt = $pdo->prepare("SELECT * FROM relatorios_material WHERE usuario_id = ? ORDER BY data_relatorio DESC");
$stmt->execute([$_SESSION['usuario_id']]);
$relatorios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Relatórios de Material</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <h2>Relatórios de Material</h2>
    <?php
    if(isset($_SESSION['mensagem'])) {
        echo "<p style='color:green'>".$_SESSION['mensagem']."</p>";
        unset($_SESSION['mensagem']);
    }
    if(isset($erro)) echo "<p style='color:red'>$erro</p>";
    ?>
    <form method="POST" action="">
        <label>Descrição do Relatório:</label><br>
        <textarea name="descricao" rows="4" cols="50" required></textarea><br><br>
        <button type="submit">Criar Relatório</button>
    </form>
    <h3>Seus Relatórios</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Data</th>
        </tr>
        <?php foreach($relatorios as $relatorio): ?>
        <tr>
            <td><?= htmlspecialchars($relatorio['id']) ?></td>
            <td><?= htmlspecialchars($relatorio['descricao']) ?></td>
            <td><?= htmlspecialchars($relatorio['data_relatorio']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php include '../templates/footer.php'; ?>
</body>
</html>
