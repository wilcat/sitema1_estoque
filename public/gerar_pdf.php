<?php
require '../vendor/autoload.php';
include '../config/database.php';

// Parâmetro da ordem de serviço
$ordem_id = $_GET['id'];

// Obtém os dados da ordem de serviço
$query = "SELECT * FROM ordens_servico WHERE id = :ordem_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':ordem_id', $ordem_id);
$stmt->execute();
$ordem = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtém os produtos associados à ordem de serviço
$query = "SELECT p.descricao, op.quantidade FROM ordem_produtos op
          JOIN produtos p ON op.produto_id = p.id
          WHERE op.ordem_id = :ordem_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':ordem_id', $ordem_id);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Criação do PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);

// Cabeçalho do PDF
$pdf->Cell(0, 10, 'Relatorio de Ordem de Servico', 0, 1, 'C');
$pdf->Ln(10);

// Descrição da ordem de serviço
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 10, 'Descricao: ' . $ordem['descricao'], 0, 1);
$pdf->Ln(5);

// Listagem de produtos
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(100, 10, 'Produto', 1);
$pdf->Cell(30, 10, 'Quantidade', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 11);
foreach ($produtos as $produto) {
    $pdf->Cell(100, 10, $produto['descricao'], 1);
    $pdf->Cell(30, 10, $produto['quantidade'], 1);
    $pdf->Ln();
}

// Saída do PDF sem headers HTML
$pdf->Output();

// Redirecionamento para a página de relatório de ordens após a geração do PDF
header("Location: relatorio_ordens.php");
exit();