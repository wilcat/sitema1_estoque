<?php
// public/relatorios_estoque.php
require '../config/database.php';
require '../templates/auth.php';
//require '../vendor/autoload.php'; // se estiver usando Composer

// Buscar todos os produtos
$stmt = $pdo->query("SELECT * FROM produtos ORDER BY descricao ASC");
$produtos = $stmt->fetchAll();

// Incluindo a biblioteca FPDF
require('../vendor/setasign/fpdf/fpdf.php'); // Se não estiver usando Composer

// Cria um novo PDF
$pdf = new FPDF();
$pdf->AddPage();

// Definindo o título
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Relatório de Estoque', 0, 1, 'C');

// Adicionando uma linha em branco
$pdf->Ln(10);

// Definindo os cabeçalhos da tabela
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, 'ID', 1);
$pdf->Cell(80, 10, 'Descrição', 1);
$pdf->Cell(40, 10, 'Quantidade', 1);
$pdf->Ln();

// Exibindo os dados da tabela
$pdf->SetFont('Arial', '', 12);
foreach ($produtos as $produto) {
    $pdf->Cell(20, 10, $produto['id'], 1);
    $pdf->Cell(80, 10, $produto['descricao'], 1);
    $pdf->Cell(40, 10, $produto['quantidade'], 1);
    $pdf->Ln();
}

// Saída do PDF
$pdf->Output('D', 'relatorio_estoque.pdf'); // Para forçar o download do PDF
