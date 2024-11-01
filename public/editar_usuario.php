<?php
include '../config/database.php';
include '../templates/auth.php';

// Verifica se o usuário é admin
if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Busca as informações do usuário
$id = $_GET['id'];
$query = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se o usuário existe
if (!$usuario) {
    header('Location: usuarios.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<?php include '../templates/header.php'; ?>

<div class="container">
    <h2>Editar Usuário</h2>

    <form action="usuarios.php" method="POST">
        <input type="hidden" name="user_id" value="<?= $usuario['id']; ?>">
        <label for="username">Nome de Usuário:</label>
        <input type="text" id="username" name="username" value="<?= $usuario['username']; ?>" required>

        <label for="role">Privilégio:</label>
        <select id="role" name="role" required>
            <option value="user" <?= $usuario['role'] == 'user' ? 'selected' : ''; ?>>Usuário</option>
            <option value="admin" <?= $usuario['role'] == 'admin' ? 'selected' : ''; ?>>Administrador</option>
        </select>

        <input type="submit" name="edit_user" value="Salvar Alterações">
    </form>
</div>

<?php include '../templates/footer.php'; ?>

</body>
</html>
