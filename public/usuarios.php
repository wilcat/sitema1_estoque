<?php
// public/usuarios.php
require '../config/database.php';
require '../templates/auth.php';

$isAdmin = $_SESSION['tipo_usuario'] === 'admin';

// Buscar todos os usuários
$stmt = $pdo->query("SELECT id, nome, email, criado_em FROM usuarios");
$usuarios = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Gerenciar Usuários</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <h2>Usuários</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Criado em</th>
            <?php if ($isAdmin): ?>
                <th>Ações</th> <!-- Exibe a coluna "Ações" apenas para administradores -->
                <a href="register.php">Adicionar Usuário</a>
            <?php endif; ?>
        </tr>
        
        <?php foreach($usuarios as $usuario): ?>
        <tr>
            <td><?= htmlspecialchars($usuario['id']) ?></td>
            <td><?= htmlspecialchars($usuario['nome']) ?></td>
            <td><?= htmlspecialchars($usuario['email']) ?></td>
            <td><?= htmlspecialchars($usuario['criado_em']) ?></td>
            <td>
            <?php if ($isAdmin): ?>
                <td>
                    <?php if($usuario['id'] != $_SESSION['usuario_id']): ?>
                    <a href="deletar_usuario.php?id=<?= $usuario['id'] ?>" onclick="return confirm('Tem certeza que deseja deletar este usuário?');">Deletar</a>
                <?php else: ?>
                
                <?php endif; ?>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php include '../templates/footer.php'; ?>
</body>
</html>
