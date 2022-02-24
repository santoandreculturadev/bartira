<?php include "header.php"; ?>

<body>
	
	<?php //include "menu/me_inicio.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Atualizar ano-base</h1>
		<?php 
	
echo "<h1>Contratação</h1>";	
$sql_lista = "SELECT dataEnvio, idPedidoContratacao FROM sc_contratacao";
$result = $wpdb->get_results($sql_lista,ARRAY_A);
for($i = 0; $i < count($result); $i++){
	$ano = substr($result[$i]['dataEnvio'], 0, 4);
	$idPedidoContratacao = $result[$i]['idPedidoContratacao'];
	$sql_update = "UPDATE sc_contratacao SET ano_base = '$ano' WHERE idPedidoContratacao = '$idPedidoContratacao' AND dataEnvio <> '0000-00-00'";
	if($wpdb->query($sql_update)){
		echo "Pedido $idPedidoContratacao atualizado com ano-base $ano <br />";
	}else{
		echo "Erro ao atualizar ($idPedidoContratacao)<br />";
	}
}	
echo "<h1>Evento</h1>";	
	
$sql_lista = "SELECT dataEnvio, idEvento FROM sc_evento";
$result = $wpdb->get_results($sql_lista,ARRAY_A);
for($i = 0; $i < count($result); $i++){
	$ano = substr($result[$i]['dataEnvio'], 0, 4);
	$idEvento = $result[$i]['idEvento'];
	$sql_update = "UPDATE sc_evento SET ano_base = '$ano' WHERE idEvento = '$idEvento' AND dataEnvio <> '0000-00-00'";
	if($wpdb->query($sql_update)){
		echo "Pedido $idEvento atualizado com ano-base $ano <br />";
	}else{
		echo "Erro ao atualizar ($idEvento)<br />";
	}
	
}		
	

		?>
	</main>

	
	<?php 
	include "footer.php";
	?>