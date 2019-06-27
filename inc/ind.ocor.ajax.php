<?php
//Imprime erros com o banco
//mysqli_set_charset($con,"utf8");
require_once("../../wp-load.php");
require_once("function.php");
global $wpdb;
$cod = $_GET['idEvento'];
$sql = 'SELECT *
		FROM sc_ocorrencia
		WHERE idEvento = "'.$cod.'" 
		AND publicado = "1"';

		$res = $wpdb->get_results($sql);
		//echo "<pre>";
		//var_dump($res);
		//echo "</pre>";
		//echo $sql;
for($i = 0; $i < count($res); $i++){
	$data = ocorrencia($res[$i]->idOcorrencia);
	$k[] = array(	
		'idOcorrencia'	=> $res[$i]->idOcorrencia,
		'data'			=> $data['local'],
	);
}
echo( json_encode( $k ) );
?>