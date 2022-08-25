<?php include "header.php"; ?>

<body>
<?php include "menu/me_giap.php"; ?>
	<?php require __DIR__ . '/vendor/autoload.php'; ?>
	
	<?php 
	if(isset($_GET['p'])){
		$p = $_GET['p'];
	}else{
		$p = 'inicio';
	}
	
	switch($p){
		case 'inicio':
		?>
		
		<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
			<h1>Importar GIAP</h1>

			<div>
				

				<br />
				<?php 
				if(isset($_POST['enviar'])){ //01
					$pathToSave = 'uploads/';
					if( $_FILES['arquivo']['name'] != '' ){
						$pre = date('Ymdhis')."_";
						$data =  date('Y-m-d H:i:s');
						$arquivoTmp = $_FILES['arquivo']['tmp_name'];
						$arquivo = $pathToSave.$pre.$_FILES['arquivo']['name'];
						$arquivo_base = $_FILES['arquivo']['name'];
						if(file_exists($arquivo)){
							echo "O arquivo ".$arquivo_base." já existe! Renomeie e tente novamente<br />";
						}else{
							if( !move_uploaded_file( $arquivoTmp, $arquivo ) ){
								$msg = 'Erro no upload do arquivo ';
							}else{
								$msg = 'Upload do arquivo foi um sucesso!';
							}
						}
					}
					
					
					
					echo $msg."<br />";
					
			// Apaga a tabela sc_contabil
			ini_set('max_execution_time', 0); // para não parar a execução
			$ano_atual = date('Y');
			 


			$sql_truncate = "DELETE FROM sc_contabil WHERE ano =  '$ano_atual'";
			$wpdb->query($sql_truncate);
		
			
			

			$fileName = $arquivo;
					
			# Create a new Xls Reader
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();

			// Tell the reader to only read the data. Ignore formatting etc.
			$reader->setReadDataOnly(true);

			// Read the spreadsheet file.
			$spreadsheet = $reader->load(__DIR__ ."/".$arquivo);

			$sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
			$matriz = $sheet->toArray();

			//echo "<pre>";str_replace("%body%", "black", "<body text='%body%'>");
			//var_dump($matriz);
			//echo "</pre>";


			for($i = 1; $i < count($matriz); $i++){

			
							$empenho = $matriz[$i][2];
							$cpfcnpj = array("CNPJ","CPF");
							$doc_credor = trim(str_replace($cpfcnpj,"",$matriz[$i][9]));
							$credor = $matriz[$i][8];
							$ano  = $matriz[$i][3];
							$data= exibirDataMysql($matriz[$i][6]);
							$ficha  = $matriz[$i][10];
							$projeto  = $matriz[$i][31];
							$v_empenho  = $matriz[$i][32];
							$v_estorno  = $matriz[$i][33];
							$v_anulado  = $matriz[$i][34];
							$v_n_processado  = $matriz[$i][35];
							$v_processado = $matriz[$i][36];
							$v_op  = $matriz[$i][37];
							$v_op_baixado = $matriz[$i][38];
							$v_saldo = $matriz[$i][39];
							$n_processo = $matriz[$i][40];
							$historico = addslashes($matriz[$i][43]);
							$hoje = date("Y-m-d H:i:s");		
							
							$sql_ins = "INSERT INTO `sc_contabil` (`id`, `empenho`,`doc_credor`, `credor`, `ano`, `data`, `ficha`, `projeto`, `v_empenho`, `v_estorno`, `v_anulado`, `v_n_processado`, `v_processado`, `v_op`, `v_op_baixado`, `v_saldo`, `nProcesso`, `historico`, `atualizacao`) VALUES (NULL, '$empenho', '$doc_credor','$credor','$ano', '$data', '$ficha', '$projeto', '$v_empenho', '$v_estorno', '$v_anulado', '$v_n_processado', '$v_processado', '$v_op', '$v_op_baixado', '$v_saldo', '$n_processo', '$historico','$hoje')";
							
							$x = $wpdb->query($sql_ins);
							if($x){
								echo "$empenho inserido com sucesso.<br />";
							}else{
								echo "$empenho erro ao inserir. $sql_ins<br />";
							}
			}		
			
							
		
					
					
	}else{ // formulário para importação do arquivo 
		?>
		<div class = "center">
			<p>Enviar somente o arquivo do ano <?php echo date('Y'); ?></p>
			<form method='POST' enctype='multipart/form-data' action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
				<p><input type='file' name='arquivo'></p>

				<br>
				<input type='submit' value='Enviar' name='enviar'>
			</form>
		</div>
		
		
		<?php
		
	}
	?>

</div>	
<?php 
break;
case "bartira":

	if(isset($_POST['nProcesso'])){
		$nProcesso = $_POST['nProcesso'];
		$idPedidoContratacao = $_POST['idPedidoContratacao'];
		$sql_atualiza = "UPDATE sc_contratacao SET nProcesso = '$nProcesso' WHERE idPedidoContratacao = '$idPedidoContratacao'";
		$update = $wpdb->query($sql_atualiza);
		if($update){
			$mensagem = alerta("Atualizado com sucesso","success"); 
				// success, info, warning, danger;	
		}else{
			$mensagem = alerta("Erro ao atualizar".$sql_atualiza,"danger"); 
		}	



	}

?>
<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
	<h1>Relatório de inconsistências</h1>
	<?php if(isset($mensagem)){echo $mensagem;}	?>
	<h2>Bartira para GIAP</h2>
	<p>Pedidos de contratação em Bartira que não possui correspondência no GIAP ou que possuem inconsistências</p>
	<?php  // Processo, Título evento ou atividade, Razão Social, Doc, Data, valor, Projeto/Ficha, Responsável da secretaria, [indicador de erro, tipo de erro]



?>
	<table border='1'>

		<tr>
		<th>Pedido</th>
		<th>Processo</th>
			<th>Título evento ou atividade</th>
			<th>Razão Social</th>
			<th>CNPJ/CPF</th>
			<th>Data</th>
			<th>Valor</th>
			<th>Projeto/Ficha</th>
			<th>Responsável</th>
			<th></th>
			<th></th>


		</tr>
<?php 
ini_set('max_execution_time', 0); // para não parar a execução
// contratacoes , publicados = 1, processos iguais, se for evento (com status válido 3 e 4)
	$sql_contratacoes = "SELECT idPedidoContratacao,nProcesso FROM sc_contratacao WHERE publicado = '1' 
	AND 
	(idEvento IN (SELECT idEvento FROM sc_evento WHERE publicado = '1' AND (status = '3' OR status = '4')) 
	OR idAtividade IN (SELECT idAtividade FROM sc_atividade WHERE publicado = '1'))  
	AND nProcesso NOT IN (SELECT nProcesso FROM sc_contabil) AND nLiberacao <> ''";


	$res = $wpdb->get_results($sql_contratacoes,ARRAY_A);
	//var_dump($res);

	for($i = 0; $i < count($res); $i++){
			$pedido = retornaPedido($res[$i]['idPedidoContratacao']);



		?>
		<tr>
		<td><?php echo $res[$i]['idPedidoContratacao']; ?></td>
		<td><?php echo $res[$i]['nProcesso']; ?></td>
		<td><?php echo $pedido['evento_atividade']."/".$pedido['objeto']; ?></td>
		<td><?php echo $pedido['nome_razaosocial']; ?></td>
		<td><?php echo $pedido['cpf_cnpj']; ?></td>
		<td><?php echo $pedido['dataEnvio']; ?></td>
		<td><?php echo $pedido['valor']; ?></td>
		<td><?php echo $pedido['projeto']."/".$pedido['ficha']; ?></td>
		<td><?php echo $pedido['usuario']; ?></td>
		<form method="POST" action="?p=bartira" class="form-horizontal" role="form">
				<td><input type="text" name="nProcesso" value="" /></td>
				<td>
					<input type="hidden" name = 'idPedidoContratacao' value="<?php echo $res[$i]['idPedidoContratacao']; ?>">
					<input type="submit" class="btn btn-theme btn-sm btn-block" value="Salvar">
				</td>
		</form>
		
	</tr >
		
		
		<?php
	}

?>
	</table>
<?php 	
break;
case "giap":
	
	if(isset($_POST['nProcesso'])){
		$nProcesso = $_POST['nProcesso'];
		$idPedidoContratacao = $_POST['idPedidoContratacao'];
		$sql_atualiza = "UPDATE sc_contratacao SET nProcesso = '$nProcesso' WHERE idPedidoContratacao = '$idPedidoContratacao'";
		$update = $wpdb->query($sql_atualiza);
		if($update){
			$mensagem = alerta("Atualizado com sucesso","success"); 
				// success, info, warning, danger;	
		}else{
			$mensagem = alerta("Erro ao atualizar".$sql_atualiza,"danger"); 
		}	



	}


?>
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
	<h1>Relatório de inconsistências</h1>

	


	<table border='1'>
	<h2>GIAP</h2>
	<p>Registros do GIAP que não possui correspondência no Bartira ou que possuem inconsistências</p>
	<?php  // Processo, Histórico, Credor, Doc Credor,  Data, Projeto/Ficha, valor

?>


		<tr>
		<th>Processo</th>
			<th>Doc</th>
			<th>Credor</th>

			<th>Data</th>
			<th>Valor</th>
			<th>Projeto/Ficha</th>
			<th></th>
			<th></th>


		</tr>
<?php 
ini_set('max_execution_time', 0); // para não parar a execução
// contratacoes , publicados = 1, processos iguais, se for evento (com status válido 3 e 4)




	$sql_contratacoes = "SELECT * FROM sc_contabil WHERE projeto NOT LIKE '600' AND ano <> '2017'";  


	$res = $wpdb->get_results($sql_contratacoes,ARRAY_A);
	//var_dump($res);

	for($i = 0; $i < count($res); $i++){
			
		$x = comparaProcesso($res[$i]['nProcesso']);

		if($x == 0){

		?>
		<tr>
		<td><?php echo $res[$i]['nProcesso']; ?></td>
		<td><?php echo $res[$i]['doc_credor']; ?></td>
		<td><?php echo $res[$i]['credor']; ?></td>
		<td><?php echo $res[$i]['data']; ?></td>
		<td><?php echo $res[$i]['v_empenho']; ?></td>

		<td><?php echo $res[$i]['projeto']."/".$res[$i]['ficha']; ?></td>
		<form method="POST" action="?p=giap" class="form-horizontal" role="form">
				<td><input type="text" name="idPedidoContratacao" value="" /></td>
				<td>
					<input type="hidden" name = 'nProcesso' value="<?php echo $res[$i]['nProcesso']; ?>">
					<input type="submit" class="btn btn-theme btn-sm btn-block" value="Salvar">
				</td>
		</form>
	</tr >
		
		
		<?php } ?>




<?php } ?>

</table>
	<div>


	</div>	
<?php break; ?>
<?php } //fim da switch ?> 	
<?php 
include "footer.php";
?>