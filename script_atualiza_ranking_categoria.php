<?php 
/* atualiza a tabela ranking com as categorias dos inscritos */


?>

<?php include "header.php"; ?>

<body>
	
	<?php //include "menu/me_inicio.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Ambiente teste</h1>
		<?php 
		global $wpdb;
$id_mapas = $_GET['id_mapas']; // é o id do culturaz

$sql_list = "SELECT * FROM ava_inscricao WHERE id_mapas = '$id_mapas'";
$insc = $wpdb->get_results($sql_list,ARRAY_A);

for($i = 0; $i < count($insc); $i++){
	echo $insc[$i]['inscricao'];
	echo " - ";
	$cat = json_decode($insc[$i]['descricao'],true);
	echo $cat["Categoria"];
	$sql_atualiza = "UPDATE ava_ranking SET filtro = '".$cat['Categoria']."' WHERE inscricao = '".$insc[$i]['inscricao']."'";  
	$inf = $wpdb->query($sql_atualiza);
	if($inf == 1){
		echo " - atualizado.<br />";
	}else{
		echo " - erro.<br />";
	}
}

/*
echo "<pre>";
var_dump($insc);
echo "</pre>";
*/

?>	
<?php 
include "footer.php";
?>