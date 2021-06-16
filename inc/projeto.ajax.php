<?php
//Imprime erros com o banco
//mysqli_set_charset($con,"utf8");
require_once("../../wp-load.php");
global $wpdb;
$cod = $_GET['programa'];
$cidades = array();
$programa = '"programa":"'.$cod.'"';
$sql = 'SELECT *
FROM sc_tipo
WHERE abreviatura = "projeto"
AND publicado = "1"
AND ano_base = 2019
AND descricao LIKE "%'.addslashes($programa).'%" 
ORDER BY tipo ASC';

$res = $wpdb->get_results($sql);
		//echo "<pre>";
		//var_dump($res);
		//echo "</pre>";
for($i = 0; $i < count($res); $i++){
	$k[] = array(
		'id'	=> $res[$i]->id_tipo,
		'projeto' => (($res[$i]->tipo)),
	);
}
echo( json_encode( $k ) );
?>