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
			<h1>Importar Eventos do CulturAZ</h1>

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
							
							$numero = $matriz["Número"];
							$agentes_abc = $matriz["Quantos agentes da região ABC a proposta comporta?"];
							$release = $matriz["Release do trabalho e objetivo principal:"];
							$links = $matriz["Referências a respeito do trabalho artístico (proposta)"];
							$nome_evento = $matriz["Título"];
							$sinopse = $matriz["Sinopse do evento"];

							$sql_ins = "INSERT INTO `sc_evento` (`idEvento`, `inscricao`, `n_agentes_abc`, `releaseCom`, `linksCom`, `nomeEvento`, `sinopse`, `publicado`, `ano_base`, `idUsuario`, `idResponsavel`, `idSuplente`, `idRespAprovacao`, `status` ) VALUES (NULL, '$numero', '$agentes_abc', '$release', '$links', '$nome_evento', '$sinopse', '1', '2019', '1', '70', '143', '5', '1')";
							
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