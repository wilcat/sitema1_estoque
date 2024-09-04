<?php
// public/logout.php
session_start();
if(isset($_SESSION['usuario_id'])) {
    // Registrar log de logout
    require '../config/database.php';
    $stmt = $pdo->prepare("INSERT INTO logs_acesso (usuario_id, acao) VALUES (?, ?)");
    $stmt->execute([$_SESSION['usuario_id'], 'Logout']);
}

session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
