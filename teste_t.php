<?php
/*
* Criando e exportando planilhas do Excel
* /
*/

// Definimos o nome do arquivo que será exportado
$arquivo = 'planilha.xls';

// Criamos uma tabela HTML com o formato da planilha
$html = '';
$html .= '<table>';
$html .= '<tr>';
$html .= '<td colspan="3">Relatorio Edital Lei Aldir Blanc </tr>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td><b>Culturaz</b></td>';
$html .= '<td><b>Inscricao</b></td>';
$html .= '<td><b>Proponente</b></td>';
$html .= '<td><b>Titulo</b></td>';
$html .= '<td><b>Nota</b></td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>L1C1</td>';
$html .= '<td>L1C2</td>';
$html .= '<td>L1C3</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>L2C1</td>';
$html .= '<td>L2C2</td>';
$html .= '<td>L2C3</td>';
$html .= '</tr>';
$html .= '</table>';

// Configurações header para forçar o download
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
header ("Content-Description: PHP Generated Data" );

// Envia o conteúdo do arquivo
echo $html;
exit;
