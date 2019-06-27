<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';
}

?>
<body>
	
	<?php include "menu/me_view.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Visualização</h1>		
		<?php 
		switch($p){
			case 'inicio':
			?>
			
			<?php 
			break;
			case 'atualiza_categoria_ranking':  
			if(isset($_GET['id_mapas'])){
				$id_mapas = $_GET['id_mapas'];
				?>		  
				<?php 
				$sql_sel_ins = "SELECT inscricao FROM ava_inscricao WHERE id_mapas = '$id_mapas'";
				$res = $wpdb->get_results($sql_sel_ins,ARRAY_A);
				
				
				for($i = 0; $i < count($res); $i++){
					$id_insc = $res[$i]['inscricao'];
					$sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$id_insc'";	
					$json = $wpdb->get_row($sel,ARRAY_A);	
					$res_json = converterObjParaArray(json_decode(($json['descricao'])));
					$filtro = $res_json['3.2 - Categoria'];
					$sql_atualiza = "UPDATE ava_ranking SET filtro = '$filtro' WHERE inscricao = '$id_insc'";
					if($wpdb->query($sql_atualiza)){
						echo "$id_insc - Filtro atualizado.<br />";
					}else{
						echo "$id_insc - $sql_atualiza.<br />";
						
					}
				}
				
			}else{
				?>
				<div class="container">
					<div class="row">    
						<div class="col-md-offset-2 col-md-8">
							<h1>Não há Edital indicado</h1>
						</div>
					</div>
				</div>
			<?php 	} ?>

			<?php 
			break;
			case 'projeto':  

			?>  

			<h1>Programa / Projeto</h1>
		<!--<div><select>
		<option></option>
		<input class="btn btn-sm btn-default" type="submit" value="Filtrar" />
	</select></div>-->
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th></th>
					<th>Programa</th>
					<th>Projeto</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$sel_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'programa'";
				$res_programa = $wpdb->get_results($sel_programa,ARRAY_A);
				for($i = 0; $i < count($res_programa); $i++){
					
					?>
					<tr>
						<td></td>
						<td><?php echo $res_programa[$i]['tipo'] ?></td>
						<td></td>
						<td></td>				
					</tr>
					<?php 
					$sel_projeto = "SELECT * FROM sc_tipo WHERE abreviatura = 'projeto'";
					$res_projeto = $wpdb->get_results($sel_projeto,ARRAY_A);
					//var_dump($res_projeto);	
					for($k = 0; $k < count($res_projeto); $k++){
						$pro_json = json_decode(utf8_encode($res_projeto[$k]['descricao']),true);
						//var_dump($pro_json);
						if($pro_json['programa'] == $res_programa[$i]['id_tipo']){
							
							?>
							<tr>
								<td></td>
								<td></td>

								<td><?php echo $res_projeto[$k]['tipo'] ?></td>
								<td><?php echo utf8_decode($pro_json['descricao']) ?></td>
							</tr>
						<?php } 
					} ?>
					
					
					<?php 
				}

				?>

			</tbody>
		</table>
	</div>      </div>
</div>
<div>
	<?php 
	
	?>
</div>

<?php 
break;
case 'projeto2':  

?>  
<script type="text/javascript" src="visual/vis.js"></script>
<link href="visual/vis-network.min.css" rel="stylesheet" type="text/css" />

<style type="text/css">
#mynetwork {
	width: 1200px;
	height: 1200px;
	border: 1px solid lightgray;
}
</style>
<div id="mynetwork"></div>

<script type="text/javascript">
  // create an array with nodes
  var nodes = new vis.DataSet([
  	<?php 
  	$sel_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'programa'";
  	$res_programa = $wpdb->get_results($sel_programa,ARRAY_A);
  	for($i = 0; $i < count($res_programa); $i++){
  		?>
  		{id: <?php echo $res_programa[$i]['id_tipo']; ?>, label: '<?php echo $res_programa[$i]['tipo'] ?>', color: 'red', widthConstraint: { minimum: 120 }},
  		<?php 
  		$sel_projeto = "SELECT * FROM sc_tipo WHERE abreviatura = 'projeto'";
  		$res_projeto = $wpdb->get_results($sel_projeto,ARRAY_A);
		//var_dump($res_projeto);	
  		for($k = 0; $k < count($res_projeto); $k++){
  			$pro_json = json_decode(utf8_encode($res_projeto[$k]['descricao']),true);
			//var_dump($pro_json);
  			if($pro_json['programa'] == $res_programa[$i]['id_tipo']){ ?>
  				{id: <?php echo $res_projeto[$k]['id_tipo']; ?>, label: '<?php echo $res_projeto[$k]['tipo'] ?>', color: 'yellow', widthConstraint: { minimum: 120 } },
  				<?php
  			}
  		}
  	}		
  	?>
  	
  	{id: 200, label: 'Node 5'}
  	]);

  // create an array with edges
  var edges = new vis.DataSet([
  	<?php 
  	$sel_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'programa'";
  	$res_programa = $wpdb->get_results($sel_programa,ARRAY_A);
  	$id = 1;
  	for($i = 0; $i < count($res_programa); $i++){
  		?>
  		<?php 
  		$id++;
  		$sel_projeto = "SELECT * FROM sc_tipo WHERE abreviatura = 'projeto'";
  		$res_projeto = $wpdb->get_results($sel_projeto,ARRAY_A);
		//var_dump($res_projeto);	
  		for($k = 0; $k < count($res_projeto); $k++){
  			$pro_json = json_decode(utf8_encode($res_projeto[$k]['descricao']),true);
			//var_dump($pro_json);
  			if($pro_json['programa'] == $res_programa[$i]['id_tipo']){ ?>
  				{from: <?php echo $res_projeto[$k]['id_tipo'] ?> , to: <?php echo $res_programa[$i]['id_tipo']; ?>},
  				
  				<?php $id++;
  			}
  		}
  	}		
  	?>
  	
  	{from: 99, to: 99}
  	]);

  // create a network
  var container = document.getElementById('mynetwork');
  var data = {
  	nodes: nodes,
  	edges: edges
  };
  var options = {};
  var network = new vis.Network(container, data, options);
</script>

<?php 

?>		  

	<?php 
	break;
}//fim da switch
?>		  

</main>
</div>
</div>

<?php 
include "footer.php";
?>