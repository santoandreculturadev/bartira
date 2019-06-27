<?php include "header.php"; ?>

<body>
	
	<?php //include "menu.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Importar Inscrições</h1>

		<div>
			

			<br />
			<?php 
			require_once dirname(__FILE__) . '/classes/PHPExcel.php';
			
			if(isset($_GET['file'])){
				$fileName = "upload/".$_GET['file'];
			/*
			/** detecta automaticamente o tipo de arruivo que será carregado */
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
			
			echo "Linhas:  ".$highestRow;
			global $wpdb;			
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

					$json = addslashes(json_encode($matriz,JSON_UNESCAPED_UNICODE));	
					$sql = "INSERT INTO `ava_inscricao` (`id`, `id_mapas`, `inscricao`, `edital`, `aprovado`, `descricao`) 
					VALUES (NULL, '".$_GET['mapas']."', '".($matriz['Número'])."', '".$_GET['edital']."', '', '".$json."')";
					$insert = $wpdb->query($sql);
					if($insert == FALSE){
						echo $sql."<br /><br />";
					}else{
						echo "Sucesso - $sql<br /><br />";
					}		

				}

			}									
			
		}else{
			echo "<h2>Nenhum arquivo foi selecionado.</h2>";	
			
		}	
		
		echo "<pre>";
		var_dump($matriz);
		echo "</pre>";
		
		?>
		
	</div>	
	
	
	<h2>Section title</h2>
	<div class="table-responsive">
		
	</div>
</main>
</div>
</div>

<?php 
include "footer.php";
?>