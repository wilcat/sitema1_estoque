<?php
// public/deletar_usuario.php
require '../config/database.php';
require '../templates/auth.php';

$isAdmin = $_SESSION['tipo_usuario'] === 'admin';

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Não permitir que o usuário deletar a si mesmo
    if($id == $_SESSION['usuario_id']) {
        $_SESSION['erro'] = "Você não pode deletar a si mesmo.";
        header("Location: usuarios.php");
        exit();
    }

    // Obter nome do usuário para log
    $stmt = $pdo->prepare("SELECT nome FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch();

    if($usuario) {
        // Deletar usuário
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        if($stmt->execute([$id])) {
            // Registrar log de deleção de usuário
            $stmt_log = $pdo->prepare("INSERT INTO logs_acesso (usuario_id, acao) VALUES (?, ?)");
            $stmt_log->execute([$_SESSION['usuario_id'], "Você deletou o usuário: ".$usuario['nome']]);
            $_SESSION['sucesso'] = "Usuário deletado com sucesso.";
            
            header("Location: usuarios.php");
            exit();
        } else {
            $_SESSION['erro'] = "Erro ao deletar usuário.";
        }
    }
}
header("Location: usuarios.php");
exit();
?>
