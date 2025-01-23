<?php
//Imprime erros com o banco
//mysqli_set_charset($con,"utf8");
require_once("../../wp-load.php");

if(isset($_GET['ano_base'])){
	$ano_base = $_GET['ano_base'];
}else{
	$ano_base = date('Y');
}



global $wpdb;
//var_dump(get_currentuserinfo());
$cod = $_GET['programa'];
$cidades = array();
$programa = '"programa":"'.$cod.'"';


if($ano_base == 'all'){
$sql = 'SELECT *
FROM sc_tipo
WHERE abreviatura = "projeto"
AND publicado = "1"
AND descricao LIKE "%'.addslashes($programa).'%" 
ORDER BY tipo ASC';
}else{
$sql = 'SELECT *
FROM sc_tipo
WHERE abreviatura = "projeto"
AND publicado = "1"
AND ano_base = "'.$ano_base.'" 
AND descricao LIKE "%'.addslashes($programa).'%" 
ORDER BY tipo ASC';
	
}

$res = $wpdb->get_results($sql);
		echo "<pre>";
		var_dump($sql);
		echo "</pre>";
for($i = 0; $i < count($res); $i++){
	$k[] = array(
		'id'	=> $res[$i]->id_tipo,
		'projeto' => (($res[$i]->tipo)),
		'ano_base' => (($res[$i]->ano_base)),
	);
}
echo( json_encode( $k ) );



?>