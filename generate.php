<?php

function dump($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'fpdf/fpdf.php';
require_once 'DB.php';

$oDB = new DB;
$aRegistros = $oDB->table('tb_produtos_olx')->select();

$oPdf = new FPDF('P', 'pt', 'A4');

$oPdf->AddPage();

$oPdf->SetFont('Arial', 'b', 18);
$oPdf->MultiCell(0, 50, 'Relatório de Produtos', 0, 'C');
$oPdf->Ln(20);

foreach($aRegistros as $aRegistro) {
    // header
    $oPdf->SetFont('Arial', 'B', 14);
    $oPdf->MultiCell(0, 40, "Produto #{$aRegistro['codigo']}");

    // linha
    $oPdf->SetFont('Arial', 'B', 12);
    $oPdf->SetFillColor(235, 235, 235);
    $oPdf->Cell(0, 30, "Descrição", '', 1, 'L', true);

    $oPdf->SetFont('Arial', '', 12);
    $oPdf->SetTextColor(0, 0, 0);

    $sDescricao = (strlen($aRegistro['descricao']) > 80) 
        ? substr($aRegistro['descricao'], 0, 80).'..'
        : $aRegistro['descricao'];

    $oPdf->MultiCell(0, 30, "{$sDescricao}", '');

    // linha
    $oPdf->SetFont('Arial', 'B', 12);
    $oPdf->SetFillColor(235, 235, 235);
    $oPdf->Cell(0, 30, "Endereço", '', 1, 'L', true);

    $oPdf->SetFont('Arial', '', 12);
    $oPdf->SetTextColor(0, 0, 0);

    $sEndereco = (strlen($aRegistro['endereco']) > 80) 
        ? substr($aRegistro['endereco'], 0, 80).'..'
        : $aRegistro['endereco'];

    $oPdf->MultiCell(0, 30, "{$sEndereco}", '');

    // linha
    $oPdf->SetFont('Arial', 'B', 12);
    $oPdf->SetFillColor(235, 235, 235);
    $oPdf->Cell(120, 30, "Situação", '', 0, 'L', true);
    $oPdf->Cell(307, 30, "Criado em", '', 0, 'L', true);
    $oPdf->Cell(100, 30, "Preço", '', 0, 'R', true);
    $oPdf->Cell(10, 30, "", '', 1, 'R', true);

    $oPdf->SetFont('Arial', '', 12);
    $oPdf->SetTextColor(0, 0, 0);
    $oPdf->Cell(120, 30, "{$aRegistro['estado_produto']}", '', 0, 'L');
    $oPdf->Cell(307, 30, "{$aRegistro['criado_em']}", '', 0, 'L');
    $oPdf->Cell(100, 30, "{$aRegistro['preco']}", '', 0, 'R');
    $oPdf->Cell(10, 30, "", '', 1, 'R');

    // espaco
    $oPdf->Ln(30);
    $oPdf->MultiCell(0, 0, "", 'B');
}

$oPdf->Output('I');