<?php include "header.php"; ?>

<body>
	
	<?php //include "menu/me_inicio.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Ambiente teste / Importar Plano Municipal</h1>
		<?php 
		 //indicadores('2019','evento','769');
		 
	//echo sanitizeString('março');	 
		 $total = 0;
$sel_hist_data = "SELECT id, titulo,valor, descricao, tipo, idUsuario,data,idPedidoContratacao FROM sc_mov_orc WHERE dotacao = '12' AND publicado = '1' AND data BETWEEN '2018-07-01' AND '2018-07-31' AND tipo = '311' ORDER BY id ASC ";
	$hist_data = $wpdb->get_results($sel_hist_data,ARRAY_A);
	
	for($i=0; $i < count($hist_data); $i++){
		$total = $hist_data[$i]['valor'] + $total;
	}
	echo "<pre>";
	var_dump($hist_data);	
	echo "</pre>";

	echo "Total: ".$total;
	?>
	
	</main>

	
	<?php 
	include "footer.php";
	?>