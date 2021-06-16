<?php
//Imprime erros com o banco
//mysqli_set_charset($con,"utf8");
require_once("../../wp-load.php");
global $wpdb;
$anobase = $_GET['anobase'];
$sql = 'SELECT *
FROM sc_orcamento
WHERE ano_base = "'.$anobase.'" AND projeto IS NOT NULL
ORDER BY projeto ASC';

$res = $wpdb->get_results($sql);
		
		//echo "<pre>";
		//var_dump($sql);
		//echo "</pre>";
for($i = 0; $i < count($res); $i++){
	$k[] = array(
		'id'	=> $res[$i]->id,
		'projeto' => $res[$i]->projeto."/".$res[$i]->ficha." - ".$res[$i]->descricao,
	);
}
echo( json_encode( $k ) );
?>