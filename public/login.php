<?php
// public/login.php
require '../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Buscar usuário no banco
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];  // Adiciona o tipo de usuário na sessão

        // Registrar log de acesso
        $stmt = $pdo->prepare("INSERT INTO logs_acesso (usuario_id, acao) VALUES (?, ?)");
        $stmt->execute([$usuario['id'], 'Login']);

        // Redirecionar para a página inicial
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['erro'] = "Email ou senha inválidos.";
    }
}
?>

<!-- Formulário de Login -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Login</title>
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <h2>Login</h2>
    <?php
    if(isset($_SESSION['erro'])) {
        echo "<p style='color:red'>".$_SESSION['erro']."</p>";
        unset($_SESSION['erro']);
        
    }
    ?>
    <form method="POST" action="">
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>
        <button type="submit">Entrar</button>
    </form>
    <?php include '../templates/footer.php'; ?>
</body>
</html>
