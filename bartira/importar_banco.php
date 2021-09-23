<?php 
function bancoMysqli()
{
	$servidor = 'localhost';
	$usuario = 'root';
	$senha = '';
	$banco = 'wordpress';
	$con = mysqli_connect($servidor,$usuario,$senha,$banco); 
	mysqli_set_charset($con,"utf8");
	return $con;
}

echo "Importando Bancos...";

$con = bancoMysqli();
$sql = "SELECT * FROM igsis_banco";
$query = mysqli_query($con, $sql);
while($x = mysqli_fetch_array($query)){
	$banco = $x['banco'];
	$codigo = $x['codigo'];
	$json = "{'codigo':'".$codigo."'}";
	$sql_insert = "INSERT INTO `sc_tipo` (`id_tipo`, `tipo`, `descricao`, `abreviatura`) VALUES (NULL, '$banco', '', 'banco')";
	$query_insert = mysqli_query($con,$sql_insert);
	if($query_insert){
		
		
	}
}

?>