<?php include "header.php"; ?>

<body>
	
	<?php //include "menu/me_inicio.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Ambiente teste / Importar Plano Municipal</h1>
		<?php 

/*		$sql_lista_temp = "SELECT * FROM meta_temp";
		$result = $wpdb->get_results($sql_lista_temp,ARRAY_A);
	//echo "<pre>";
	//var_dump($result);
	//echo "</pre>";

	for($i = 0; $i < count($result); $i++){
		$resto = $result[$i]['id'] % 2;
		echo "A sobra de ".$result[$i]['id']. "divido por 2 é". $resto ."<br />";
		
		if($result[$i]['id'] % 2 == 0){
			$objetivos =  $result[$i]['DESCRIÇÃO OBJETIVO'];
			$objetivos_descricao = "";
			$meta = $result[$i]['META'];
			$meta_descricao = $result[$i]['DESCRIÇÃO META'];
			$publicado = 1;
		
			$insert = "INSERT INTO `sc_plano_municipal` (`id`, `objetivos`, `objetivos_descricao`, `meta`, `meta_descricao`, `data`, `revisado`, `publicado`) VALUES (NULL, '$objetivos', '$objetivos_descricao', '$meta', '$meta_descricao', '', '', '$publicado')";
			$ins = $wpdb->query($insert);
			echo $insert."<br />";
			var_dump($ins);
			
		}
		
	}


	$teste = geraOpcaoMeta();

	echo "<pre>";
	var_dump($teste);
	echo "</pre>";
	
*/

	//atualizaMetaOrcamento(10);
	//metaOrcamento(21);
	//var_dump(orcamentoPai(1017));
	function bairro($bairro){
		global $wpdb;
		$sql = "SELECT id_tipo FROM sc_tipo WHERE tipo LIKE '$bairro' AND abreviatura LIKE 'bairro'";
		$result = $wpdb->get_row($sql,ARRAY_A);
		return $result;
		
	}
	
	
	
	echo "<h1>Importar Bairros </h1>";
	$sql_bairros = "SELECT * FROM sc_bairros";
	$result = $wpdb->get_results($sql_bairros,ARRAY_A);
	for($i = 0; $i < count($result); $i++){
		$id_tipo = $result[$i]['id_tipo'];
		$bairro = strtoupper($result[$i]['bairro']);
		$id_bairro = bairro($bairro);
		$descricao = json_decode($result[$i]['descricao'],true);
		$descricao['bairro'] = $id_bairro['id_tipo'];
		$descricao_json = json_encode($descricao);
		if($id_bairro != NULL){
			//atualiza
			$sql_update = "UPDATE sc_tipo SET descricao = '$descricao_json' WHERE id_tipo = '$id_tipo'";
			$wpdb->query($sql_update);	
			
		}else{
			echo "O local ".$result[$i]['tipo']." nao tem bairro válido ".$bairro."<br />";
		}
		
		echo "<pre>";
		var_dump($descricao_json);
		echo "</pre>";
		
	}
	

		?>
	</main>

	
	<?php 
	include "footer.php";
	?>