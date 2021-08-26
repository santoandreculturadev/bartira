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
			if($res[$i]['ano_base'] == '2020'){
				$x['status'] = 'correto';
			}
			if($res[$i]['ano_base'] == '2021'){
				$sql_retorna_2020 = "SELECT id FROM sc_orcamento WHERE projeto = '".$res[$i]['projeto']."' AND ficha = '".$res[$i]['ficha']."' AND ano_base = '2020'";
				 $res2 = $wpdb->get_results($sql_retorna_2020,ARRAY_A);
				
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


	//cria backup
	$datebackup = date('YmdHis');
	$sql_backup01 = "CREATE TABLE sc_mov_orc_".$datebackup." SELECT * FROM sc_mov_orc;";
	$sql_backup02 = "ALTER TABLE sc_mov_orc_".$datebackup." ADD PRIMARY KEY(`id`)";
	$sql_backup03 = "ALTER TABLE sc_mov_orc_".$datebackup." MODIFY COLUMN id auto_increment;";
	
	$backup = false;
	
	$backup = $wpdb->query($sql_backup01);
	$wpdb->query($sql_backup02);
	$wpdb->query($sql_backup03);
	
	var_dump($backup);
	if($backup == true){



   $sql = "SELECT * FROM sc_mov_orc WHERE data BETWEEN '2020-01-01' AND '2020-12-31' AND publicado = '1'";
   $res = $wpdb->get_results($sql,ARRAY_A);
   for($i = 0; $i < count($res); $i++){
		//echo $res[$i]['dotacao']."<br />";
		$x = dotacaoArruma($res[$i]['dotacao']);
		$texto = "A movimentacao ".$res[$i]['id']." está ".$x['status'];
		if($x['status'] == 'errado'){
			$sql_atualiza = "UPDATE sc_mov_orc SET dotacao = '".$x['eq']."' WHERE id = '".$res[$i]['id']."'";
			$exec = $wpdb->query($sql_atualiza);
			if($exec){
				$texto .= ". Atualização foi feita com sucesso";
				if($res[$i]['idPedidoContratacao'] != 0){
					$sql_atualiza_pedido = "UPDATE sc_contratacao SET dotacao = '".$x['eq']."' WHERE idPedidoContratacao = '".$res[$i]['idPedidoContratacao']."'";
					$exec2 = $wpdb->query($sql_atualiza_pedido);
					if($exec2){
						$texto .= "Atualização do pedido foi feita com sucesso tb";
					}else{
						$texto .= "Atualizacao do pedido deu merda.Chora.";
					}
				}
				
				
				
			}else{
				$texto .= ". Erro na atualização";
			}			
				
		}
		$texto .= "<br >";
		echo $texto;
	
	}
	
	}
  
  ?>
  
  
</main>
</div>
</div>

<?php 
include "footer.php";
?>