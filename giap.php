<?php include "header.php"; ?>

<body>
	
	<?php //include "menu/me_inicio.php"; ?>
	
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
				require_once dirname(__FILE__) . '/classes/PHPExcel.php';
				
				if(isset($_POST['enviar'])){
					$pathToSave = 'upload/';
					if( $_FILES['arquivo']['name'] != '' ){
						$pre = date('Ymdhis')."_";
						$data =  date('Y-m-d H:i:s');
						$arquivoTmp = $_FILES['arquivo']['tmp_name'];
						$arquivo = $pathToSave.$pre.$_FILES['arquivo']['name'];
						$arquivo_base = $_FILES['arquivo']['name'];
						if(file_exists($arquivo))
						{
							echo "O arquivo ".$arquivo_base." já existe! Renomeie e tente novamente<br />";
						}
						else
						{
							
							if( !move_uploaded_file( $arquivoTmp, $arquivo ) )
							{
								$msg = 'Erro no upload do arquivo ';
							}
							else
							{
								$msg = 'Upload do arquivo foi um sucesso!';
							}
						}
					}
					
					
					
					echo $msg."<br />";
					
			// Apaga a tabela sc_contabil
					$sql_truncate = "TRUNCATE TABLE sc_contabil";
					$wpdb->query($sql_truncate);
					
					$fileName = $arquivo;
					
			// detecta automaticamente o tipo de arruivo que será carregado 
					$excelReader = PHPExcel_IOFactory::createReaderForFile($fileName);

			//Se não precisarmos de formatação
					$excelReader->setReadDataOnly();

			//carregar apenas algumas abas
			//$loadSheets = array('aba1', 'aba2');
			//$excelReader->setLoadSheetsOnly($loadSheets);

			//o comportamente padrão é carregar todas as abas
					$excelReader->setLoadAllSheets();
					
					$excelObj = $excelReader->load($fileName);
					
			//$excelObj->getActiveSheet()->toArray(null, true,true,true);


					$sheet = $excelObj->getSheet(0);
					$highestRow = $sheet->getHighestRow(); 
					$highestColumn = $sheet->getHighestColumn();
					
			//echo "Linhas:  ".$highestRow;
					
					$matriz = array();
					
			//  Loop through each row of the worksheet in turn
					for ($row = 1; $row <= $highestRow; $row++){ 
				//  Read a row of data into an array
						$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							NULL,
							TRUE,
							FALSE);
						
				// Gera os índices
						
						if($row == 1){
							$indice = $rowData[0]; 		
						}else{
							for($k = 0; $k < count($rowData[0]); $k++){
								$matriz[$indice[$k]] = $rowData[0][$k];
								
							}
							

					//echo "<pre>";
					//var_dump($matriz);
					//echo "</pre>";
							
							$empenho = $matriz["Empenho"];
							$ano  = $matriz["Ano Empenho"];
							$unixTimestamp = PHPExcel_Shared_Date::ExcelToPHP($matriz["Data"]);
							$data  =  date('Y-m-d', $unixTimestamp);
							$ficha  = $matriz["Ficha"];
							$projeto  = $matriz["Projeto"];
							$v_empenho  = $matriz["Empenho2"];
							$v_estorno  = $matriz["Estorno"];
							$v_anulado  = $matriz["Anulado"];
							$v_n_processado  = $matriz["Não processado"];
							$v_processado = $matriz["Processado"];
							$v_op  = $matriz["Valor OP"];
							$v_op_baixado = $matriz["OP Baixada"];
							$v_saldo = $matriz["Saldo a pagar"];
							$n_processo = $matriz["Processo"];
							$historico = $matriz["Histórico"];
							$hoje = date("Y-m-d H:i:s");		
							
							$sql_ins = "INSERT INTO `sc_contabil` (`id`, `empenho`, `ano`, `data`, `ficha`, `projeto`, `v_empenho`, `v_estorno`, `v_anulado`, `v_n_processado`, `v_processado`, `v_op`, `v_op_baixado`, `v_saldo`, `nProcesso`, `historico`, `atualizacao`) VALUES (NULL, '$empenho', '$ano', '$data', '$ficha', '$projeto', '$v_empenho', '$v_estorno', '$v_anulado', '$v_n_processado', '$v_processado', '$v_op', '$v_op_baixado', '$v_saldo', '$n_processo', '$historico','$hoje')";
							
							$x = $wpdb->query($sql_ins);
							
							
						}
					}
					
	}else{ // formulário para importação do arquivo 
		?>
		<div class = "center">
			<p>Não se esqueça de nomear o segundo campo Empenho como "Empenho2" (normalmente a coluna AE)</p>
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
case "lista":

$sql = "SELECT DISTINCT idPedidoContratacao, data, empenho, sc_contabil.nProcesso, v_empenho, nLiberacao  FROM sc_contratacao,sc_contabil WHERE sc_contabil.nProcesso = sc_contratacao.nProcesso AND publicado = 1 ORDER BY data DESC"; 

$peds = $wpdb->get_results($sql,ARRAY_A);

?>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Evento/Atividade</th>
			<th>Data</th>
			<th>Empenho</th>
			<th>Processo</th>
			<th>N de Liberação</th>

			<th>Valor do Emepnho</th>
			<th></th>

		</tr>
	</thead>
	<tbody>
		<?php 
		for($i = 0; $i < count($peds); $i++){
			$pedido = retornaPedido($peds[$i]['idPedidoContratacao']);
			
			?>
			<tr>
				<td><?php echo $pedido['objeto']; ?></td>
				<td><?php echo exibirDataBr($peds[$i]['data']); ?></td>
				<td><?php echo $peds[$i]['empenho']; ?></td>
				<td><?php echo $peds[$i]['nProcesso']; ?></td>
				<td><?php echo $peds[$i]['nLiberacao']; ?></td>					  <td><?php echo $peds[$i]['v_empenho']; ?></td>
				<td>	

					<?php 
					
					?></td>

				</tr>
			<?php } // fim do for?>	
			
		</tbody>
	</table>

	<?php 
	break;
	?>
	
<?php } //fim da switch ?> 	
<?php 
include "footer.php";
?>