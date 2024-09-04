<?php
// public/deletar_produto.php
require '../config/database.php';
require '../includes/auth.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obter descrição do produto para log
    $stmt = $pdo->prepare("SELECT descricao FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch();

    if($produto) {
        // Deletar produto
        $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
        if($stmt->execute([$id])) {
            // Registrar log de deleção de produto
            $stmt_log = $pdo->prepare("INSERT INTO logs_acesso (usuario_id, acao) VALUES (?, ?)");
            $stmt_log->execute([$_SESSION['usuario_id'], "Deletou produto: ".$produto['descricao']]);

            header("Location: produtos.php");
            exit();
        } else {
            $_SESSION['erro'] = "Erro ao deletar produto.";
        }
    }
}
header("Location: produtos.php");
exit();
?>
