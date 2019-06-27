<?php include "header.php"; ?>

<body>
	
	<?php include "menu/me_admin.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Importar inscrições</h1>

		<div>
			<br />
			<?php 
			@ini_set('display_errors', '1');
			error_reporting(E_ALL); 
			set_time_limit(0);
			$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
			require_once dirname(__FILE__) . '/classes/PHPExcel.php';
			
			if(isset($_GET['file'])){
				
				$fileName = $_GET['file'];
				
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
							$matriz[$row][$indice[$k]] = $rowData[0][$k];
						}
						
					}	

					echo "<pre>";
					var_dump($matriz);
					echo "</pre>";

				}

				$depois = strtotime(date('Y-m-d H:i:s'));
				$tempo = $depois - $antes;
				echo "<br /><br /> Importação executada em $tempo segundos";
			}
			?>
		</div>	
		
		<?php 
		include "footer.php";
		?>