<?php
require '../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Inserir usuário no banco
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    if ($stmt->execute([$nome, $email, $senha])) {
        $_SESSION['mensagem'] = "Usuário registrado com sucesso!";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['erro'] = "Erro ao registrar usuário.";
    }
}
?>

<!-- Formulário de Registro -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Registrar Usuário</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <h2>Registrar Usuário</h2>
    <?php
    if(isset($_SESSION['erro'])) {
        echo "<p style='color:red'>".$_SESSION['erro']."</p>";
        unset($_SESSION['erro']);
    }
    ?>
    <form method="POST" action="">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br>
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>
        <button type="submit">Registrar</button>
    </form>
    <?php include '../templates/footer.php'; ?>
</body>
</html>
