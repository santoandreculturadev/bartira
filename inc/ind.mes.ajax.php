<?php
//Imprime erros com o banco
//mysqli_set_charset($con,"utf8");
require_once("../../wp-load.php");
require_once("function.php");
global $wpdb;
$cod = $_GET['idEvento'];
$mes = geraMesOcorrencia($_GET['idEvento']);
for($i = 0; $i < count($mes); $i++){
	$k[] = array(	
		'dia'	=> "01/".$mes[$i],
		'mes'			=> $mes[$i],
	);
}
echo( json_encode( $k ) );
?>