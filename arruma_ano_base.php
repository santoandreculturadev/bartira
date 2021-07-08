<?php include "header.php"; ?>

<body>
	
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		
		<h2>Arruma ano base</h2>
   <?php 
   
   /*
   
   */
   
   
   global $wpdb;
   // pesquisa todos os movimentos orçamentários de 2021
	function dotacaoArruma($dotacao){
		global $wpdb;
		$x = array();
		$sql = "SELECT projeto, ficha, ano_base FROM sc_orcamento WHERE id = '$dotacao'";
        $res = $wpdb->get_results($sql,ARRAY_A);		
		for($i = 0; $i < count($res); $i++){
			if($res[$i]['ano_base'] == '2021'){
				$x['status'] = 'correto';
			}
			if($res[$i]['ano_base'] == '2020'){
				$sql_retorna_2021 = "SELECT id FROM sc_orcamento WHERE projeto = '".$res[$i]['projeto']."' AND ficha = '".$res[$i]['ficha']."' AND ano_base = '2021'";
				 $res2 = $wpdb->get_results($sql_retorna_2021,ARRAY_A);
				
				if($res2 != NULL){
					$x['eq'] = $res2[0]['id'];
					$x['status'] = 'errado';
				}else{
					$x['status'] = 'inexiste';
				}
			 
			}
				
		}	
	return $x;
	
	}



   $sql = "SELECT * FROM sc_mov_orc WHERE data BETWEEN '2021-01-01' AND '2021-12-31' AND publicado = '1'";
   $res = $wpdb->get_results($sql,ARRAY_A);
   for($i = 0; $i < count($res); $i++){
		//echo $res[$i]['dotacao']."<br />";
		$x = dotacaoArruma($res[$i]['dotacao']);
		$texto = "A movimentacao ".$res[$i]['id']." está ".$x['status'];
		if($x['status'] == 'errado'){
			$sql_atualiza = "UPDATE sc_mov_orc SET tipo = '".$x['eq']."' WHERE id = '".$res[$i]['id']."'";
			$exec = $wpdb->query($sql_atualiza);
			if($exec){
				$texto .= ". Atualização foi feita com sucesso";
				
			}else{
				$texto .= ". Erro na atualização";
			}			
				
		}
		$texto .= "<br >";
		echo $texto;
	
	}
	
  
  
  ?>
  
  
</main>
</div>
</div>

<?php 
include "footer.php";
?>