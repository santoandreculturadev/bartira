<?php include "header.php"; ?>

<body>
	
	<?php //include "menu/me_inicio.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Ambiente teste / Importar Plano Municipal</h1>

	<?php 
	
	/* lê os pedidos contratação válidos
		procura no giap o cnpj e o valor
			se acha, ele insere no pedido contratação

	$sql_contratacoes = "SELECT idPedidoContratacao, valor, idEvento, idAtividade, tipoPessoa, idPessoa FROM sc_contratacao WHERE publicado = '1' 
	AND 
	(idEvento IN (SELECT idEvento FROM sc_evento WHERE publicado = '1' AND (status = '3' OR status = '4')) 
	OR idAtividade IN (SELECT idAtividade FROM sc_atividade WHERE publicado = '1'))";
	$res = $wpdb->get_results($sql_contratacoes,ARRAY_A);
	
	for($i = 0; $i < count($res); $i++){
		$valor = $res[$i]['valor'];
		$pessoa = retornaPessoa($res[$i]['idPessoa'],$res[$i]['tipoPessoa']);
		$doc = $pessoa['cpf_cnpj'];
	
		$sql_giap = "SELECT nProcesso FROM sc_contabil WHERE doc_credor LIKE '$doc' AND v_empenho = '$valor'";
		$res_giap = $wpdb->get_results($sql_giap,ARRAY_A);
		if($res_giap){
			echo "<pre>";
			var_dump($res_giap);
			echo "</pre>";
		}	

	}
	*/
$ano_base = $_GET['ano'];
	for($n = 1; $n < 13; $n++){

		$json = "[";

			$res = orcamentoDataTotal($ano_base,$n);
			$json .= json_encode($res);


		//$json = substr($json,0,-1);	
		$json .= "]";

		$sql_insert = "INSERT INTO `sc_api` (`id`, `src`, `ano`, `total`, `mes`, `json`) VALUES (NULL, 'orcamento', '$ano_base', '1',' $n', '$json')";
		$wpdb->query($sql_insert);	

	
	}
	
	echo "<pre>";
	var_dump($json);
	echo "</pre>";


?>

	</main>

	
	<?php 
	include "footer.php";
	?>


[{
			"periodo": "2021-12",
			"Público - Biblioteca Central" : "155",
			"Público - Biblioteca Descentralizada" : "0",
			"Empréstimos - Biblioteca Central" : "436",
			"Empréstimos - Biblioteca Descentralizada" : "0",
			"Sócios - Biblioteca Central" : "0",
			"Sócios - Biblioteca Descentralizada" : "0",
			"Itens Acervo - Biblioteca Central" : "0",
			"Itens Acervo - Biblioteca Descentralizada" : "0",
			"Itens Acervo - Biblioteca Digital" : "0",
			"Novas Incorporações - Biblioteca Central" : "770",
			"Novas Incorporações - Biblioteca Descentralizada" : "0",
			"Novas Incorporações - Biblioteca Digital" : "13",
			"Downloads - Digital" : "13"
			}]