<?php 

//Carrega WP como FW
require_once("../wp-load.php");
$user = wp_get_current_user();
if(!is_user_logged_in()): // Impede acesso de pessoas não autorizadas
/*** REMEMBER THE PAGE TO RETURN TO ONCE LOGGED IN ***/
$_SESSION["return_to"] = $_SERVER['REQUEST_URI'];
/*** REDIRECT TO LOGIN PAGE ***/
header("location: /");
endif;
//Carrega os arquivos de funções
require "inc/function.php";

// Carrega o MPDF
include("inc/pdf/mpdf70/src/Mpdf.php");
if(isset($_GET['id'])){
	$evento = evento($_GET['id']);
	$event = recuperaDados("sc_evento",$_GET['id'],"idEvento");
}


$html = "
<div class='folha'>
<h1>Ficha do Evento - Quadro Resumo</h1>
<table class='tabela' border='1'>
<tr>
<td colspan='3'><p class='campo'>Evento:</p><p class='dado'>".$evento['titulo']."<p></td>
</tr>
<tr>
<td><p class='campo'>Local:</p><p class='dado'>".$evento['local']."<p></td>
<td><p class='campo'>Horário:</p><p class='dado'>".$evento['periodo']['horario']."<p></td>
<td><p class='campo'>Data:</p><p class='dado'>".$evento['periodo']['legivel']."<p></td>
</tr>
<tr>
<td colspan='3'><p class='campo'>Responsável SC:</p><p class='dado'>".$evento['responsavel']."<p></td>
</tr>
</table>
<h2 align='center'>Contratação de Cachê</h2>
<table class='tabela' border='1'>
<tr height='100'>
<td ><p class='campo' >Expectativa de Público:</p><p class='dado center'>".$event['previsto']."<p></td>
<td><p class='campo'>Público Efetivo:</p></td>
</tr>
<tr>
<td colspan='2'><p class='campo'>Vistoria no local, data e presentes:</p></td>
</tr>
<tr>
<td colspan='2'><p class='campo'>Condições Meteorológicas:</p></td>
</tr>
<tr>
<td colspan='2'><p class='campo'>Observações:</p></td>
</tr>
<tr>
<td colspan='2'>&nbsp;</td>
</tr>
<tr>
<td colspan='2'>&nbsp;</td>
</tr>
<tr>
<td colspan='2'>&nbsp;</td>
</tr>
<tr>
<td colspan='2'>&nbsp;</td>
</tr>
<tr>
<td colspan='2'>&nbsp;</td>
</tr>
<tr>
<td colspan='2'>&nbsp;</td>
</tr>
<tr>
<td colspan='2'>&nbsp;</td>
</tr>
<tr>
<td colspan='2'>&nbsp;</td>
</tr>
<tr>
<td colspan='2'>&nbsp;</td>
</tr>
</table>

</div>

";

$mpdf=new mPDF(); 
$mpdf->SetDisplayMode('fullpage');
$css = file_get_contents("inc/pdf/css/estilo.css");
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html);
$mpdf->Output();

exit;


?>