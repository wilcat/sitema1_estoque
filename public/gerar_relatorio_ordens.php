<?php
require '../vendor/autoload.php';
include '../config/database.php';

// Consulta para obter todas as ordens e produtos associados
$query = "SELECT os.id, os.descricao, os.data_criacao, p.descricao AS produto, op.quantidade
          FROM ordens_servico os
          LEFT JOIN ordem_produtos op ON os.id = op.ordem_id
          LEFT JOIN produtos p ON op.produto_id = p.id
          ORDER BY os.id, p.descricao";
$stmt = $pdo->query($query);
$ordens = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Criação do PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Relatorio de Ordens de Servico', 0, 1, 'C');
$pdf->Ln(10);

$currentOrderId = null;

foreach ($ordens as $ordem) {
    // Cabeçalho de uma nova ordem de serviço
    if ($ordem['id'] !== $currentOrderId) {
        $currentOrderId = $ordem['id'];
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, "Ordem #{$ordem['id']} - {$ordem['descricao']} ({$ordem['data_criacao']})", 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(5);
        $pdf->Cell(100, 10, 'Produto', 1);
        $pdf->Cell(30, 10, 'Quantidade', 1);
        $pdf->Ln();
    }

    // Detalhes do produto na ordem
    if ($ordem['produto']) {
        $pdf->Cell(100, 10, $ordem['produto'], 1);
        $pdf->Cell(30, 10, $ordem['quantidade'], 1);
        $pdf->Ln();
    }
}

$pdf->Output();

