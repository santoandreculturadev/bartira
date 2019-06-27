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
			<h1>Importar Ações de Incentivo</h1>

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
							
							$equipamento = $matriz["1"];
							$outros = $matriz["2"];
							$bairro = $matriz["3"];
							$projeto = $matriz["4"];
							$tipo_acao = $matriz["5"];
							$titulo_acao = $matriz["6"];
							$ocor_inicio = $matriz["7"];
							$ocor_fim = $matriz["8"];
							$disciplinas = $matriz["9"];
							$linguagem = $matriz["10"];
							$carga_horaria = $matriz["11"];
							$n_concluintes = $matriz["12"];
							$n_evasao = $matriz["13"];
							$nome_profissional = $matriz["14"];
							$santo_andre = $matriz["15"];
							$custo_hora_aula = $matriz["16"];
							$carga_horaria_prof = $matriz["17"];
							$custo_total = $matriz["18"];
							$material_consumo = $matriz["19"];
							$parceria = $matriz["20"];
							$parceiro = $matriz["21"];
							$vagas = $matriz["22"];
							$rematriculas = $matriz["23"];
							$inscritos = $matriz["24"];
							$espera = $matriz["25"];
							$janeiro = $matriz["26"];
							$janeiro_sa = $matriz["27"];
							$fevereiro = $matriz["28"];
							$fevereiro_sa = $matriz["29"];
							$marco = $matriz["30"];
							$marco_sa = $matriz["31"];
							$abril = $matriz["32"];
							$abril_sa = $matriz["33"];
							$maio = $matriz["34"];
							$maio_sa = $matriz["35"];
							$junho = $matriz["36"];
							$junho_sa = $matriz["37"];
							$julho = $matriz["38"];
							$julho_sa = $matriz["39"];
							$agosto = $matriz["40"];
							$agosto_sa = $matriz["41"];
							$setembro = $matriz["42"];
							$setembro_sa = $matriz["43"];
							$outubro = $matriz["44"];
							$outubro_sa = $matriz["45"];
							$novembro = $matriz["46"];
							$novembro_sa = $matriz["47"];
							$dezembro = $matriz["48"];
							$dezembro_sa = $matriz["49"];
							
							$sql_ins = "INSERT INTO `sc_ind_incentivo` (`id`, `equipamento`, `outros`, `bairro`, `projeto`, `tipo_acao`, `titulo_acao`, `ocor_inicio`, `ocor_fim`, `disciplinas`, `linguagem`, `carga_horaria`, `n_concluintes`, `n_evasao`, `nome_profissional`, `santo_andre`, `custo_hora_aula`, `carga_horaria_prof`, `custo_total`, `material_consumo`, `parceria`, `parceiro`, `vagas`, `rematriculas`, `inscritos`, `espera`, `janeiro`, `janeiro_sa`, `fevereiro`, `fevereiro_sa`, `marco`, `marco_sa`, `abril`, `abril_sa`, `maio`, `maio_sa`, `junho`, `junho_sa`, `julho`, `julho_sa`, `agosto`, `agosto_sa`, `setembro`, `setembro_sa`, `outubro`, `outubro_sa`, `novembro`, `novembro_sa`, `dezembro`, `dezembro_sa`, `atualizacao`,`idUsuario`, `publicado`,`ano_base`) VALUES (NULL, '$equipamento', '$outros', '$bairro','$projeto','$tipo_acao','$titulo_acao', '$ocor_inicio', '$ocor_fim','$disciplinas','$linguagem','$carga_horaria','$n_concluintes','$n_evasao','$nome_profissional','$santo_andre','$custo_hora_aula','$carga_horaria_prof','$custo_total','$material_consumo','$parceria','$parceiro','$vagas','$rematriculas','$inscritos','$espera','$janeiro','$janeiro_sa','$fevereiro','$fevereiro_sa','$marco','$marco_sa','$abril','$abril_sa','$maio','$maio_sa','$junho','$junho_sa','$julho','$julho_sa','$agosto','$agosto_sa','$setembro','$setembro_sa','$outubro','$outubro_sa','$novembro','$novembro_sa','$dezembro','$dezembro_sa', '".date("Y-m-d")."', '1', '1','2017')";
							
							$x = $wpdb->query($sql_ins);
							
						}
					}
					
	}else{ // formulário para importação do arquivo 
		?>
		<div class = "center">
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
?>

<?php } //fim da switch ?> 	
<?php 
include "footer.php";
?>