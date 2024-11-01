<?php
include '../config/database.php';
include '../templates/auth.php';
require '../vendor/autoload.php';

$pdf = new FPDF();

// Listar produtos disponíveis
$query = "SELECT * FROM produtos";
$stmt = $pdo->query($query);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $produtos_selecionados = $_POST['produtos'];
    $quantidades = $_POST['quantidade'];

    // Inserir nova ordem de serviço
    $query = "INSERT INTO ordens_servico (descricao) VALUES (:descricao)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->execute();
    $ordem_id = $pdo->lastInsertId();

    // Associar produtos à ordem
    foreach ($produtos_selecionados as $index => $produto_id) {
        $quantidade = $quantidades[$index];
        $query = "INSERT INTO ordem_produtos (ordem_id, produto_id, quantidade) VALUES (:ordem_id, :produto_id, :quantidade)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':ordem_id', $ordem_id);
        $stmt->bindParam(':produto_id', $produto_id);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->execute();
    }

    // Redireciona para a geração do PDF
    header("Location: gerar_pdf.php?id=$ordem_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Ordem de Serviço</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<?php include '../templates/header.php'; ?>

<div class="container">
    <h2>Nova Ordem de Serviço</h2>

    <form action="ordem_servico.php" method="POST">
        <label for="descricao">Descrição do Serviço:</label>
        <textarea id="descricao" name="descricao" required></textarea>

        <h3>Produtos</h3>
        <?php foreach ($produtos as $produto): ?>
            <div>
                <label>
                    <input type="checkbox" name="produtos[]" value="<?= $produto['id'] ?>"> 
                    <?= $produto['descricao'] ?>
                </label>
                <input type="number" name="quantidade[]" placeholder="Quantidade" min="1">
            </div>
        <?php endforeach; ?>

        <input type="submit" value="Criar Ordem de Serviço">
    </form>
</div>

<?php include '../templates/footer.php'; ?>
</body>
</html>
