<?php include "header.php"; ?>

<body>
	
	<?php //include "menu/me_inicio.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Ambiente teste</h1>
		<?php 

		orcamentoDataTotal(2018,12);

	// quais pedidos de contratação válidos não tem movimentação orçamentária 

	// quais são as movimentações orçamentárias válidas que não tem uma contratação envolvida
	
	$sql = "SELECT * FROM sc_contratacao WHERE publicado = '1' AND liberado <> '0000-00-00' AND idPedidoContratacao NOT IN (SELECT idPedidoContratacao FROM sc_mov_orc WHERE publicado = '1')";

	$res = $wpdb->get_results($sql,ARRAY_A);
	echo "<h1>Pedidos válidos que não possuem movimentação orçamentária</h1>";
	echo "<table border='1'>";
	for($i = 0; $i < count($res); $i++){
	echo "<tr>";
	echo "<td>".$res[$i]['idPedidoContratacao']."<td>";	
	echo "<td>".$res[$i]['ano_base']."<td>";	
	echo "<td>".$res[$i]['valor']."<td>";	
	echo "<tr>";	

	}
	echo "</table>";

	$sql = "SELECT * FROM sc_mov_orc WHERE publicado = '1' AND tipo = '311' AND idPedidoContratacao = '0'";

	$res = $wpdb->get_results($sql,ARRAY_A);
	echo "<h1>Movimentações válidas de liberação que não possuem contratação</h1>";
	echo "<table border='1'>";
	for($i = 0; $i < count($res); $i++){
	echo "<tr>";
	echo "<td>".$res[$i]['titulo']."<td>";	
	echo "<td>".$res[$i]['valor']."<td>";	
	echo "<td>".$res[$i]['data']."<td>";	
	echo "<tr>";	

	}
	echo "</table>";




?>
	</main>

	
	<?php 
	include "footer.php";
	?>