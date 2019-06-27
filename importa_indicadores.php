<?php include "header.php"; ?>

<body>
	
  <?php //include "menu/me_inicio.php"; 
  set_time_limit(0);
  ?>
  
  <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
  	<h1>Importação de Indicadores</h1>

  	<?php echo exibeHoje();?>
  	<?php 

  	if(isset($_GET['p'])){
  		$p = $_GET['p'];
  	}else{
  		$p = "inicio";
  	}


  	switch($p){
  		case "inicio":
  		?>
  		
  		<h2>Escolha uma opção</h2>
  		<p><a href="?p=verifica_culturaz"> Verificar tabela temp_culturaz, sc_evento e temp_eventos</a></p>
  		
  		<?php 
  		break;
  		case "verifica_culturaz";
  		?>
  		
  		<h1>Verificar tabela temp_culturaz e sc_evento</h1>
  		
  		<table border="1">
  			<h3>Eventos do CulturAZ que não estão no Bartira</h3>
  			<tr>
  				<th>#</th>
  				<th>Nome do Evento</th>
  				<th></th>
  				<th></th>
  			</tr>
  			<?php 
  			$sql_evento = "SELECT * FROM `temp_culturaz` WHERE Id NOT IN(SELECT mapas FROM sc_evento WHERE mapas <> 0)";
  			$evento = $wpdb->get_results($sql_evento,ARRAY_A);
  			
  			for($i = 0; $i < count($evento); $i++){	
  				?>
  				<tr>
  					<td><?php echo $i ?></td>
  					<td><?php echo $evento[$i]["Nome"]?></td>
  					<td></td>
  					<td><a href="http://culturaz.santoandre.sp.gov.br/evento/<?php echo $evento[$i]["Id"]?>/" target=_blank ><?php echo $evento[$i]["Id"]?></a></td>
  				</tr>
  			<?php } ?>
  			<tr><td>
  				Total:<?php echo count($evento) ?> 
  			</td></tr>
  		</table>
  		
  		<hr >

  		<table border="1">
  			<h3>Eventos do Bartira que não estão no CulturAZ</h3>
  			<tr>
  				<th>#</th>
  				<th>Nome do Evento</th>
  				<th></th>
  				<th></th>
  			</tr>
  			<?php
  			if(isset($_POST['id_culturaz'])){
  				$sql_upd = "UPDATE sc_evento SET mapas = '".$_POST['id_culturaz']."' WHERE idEvento = '".$_POST['id_evento']."'";
  				$upd = $wpdb->query($sql_upd);
  				
  			}


  			
  			$sql_evento = "SELECT * FROM `sc_evento` WHERE mapas = 0 AND dataEnvio IS NOT NULL AND publicado = 1";
  			$evento = $wpdb->get_results($sql_evento,ARRAY_A);
  			
  			for($i = 0; $i < count($evento); $i++){	
  				?>
  				<tr>
  					<td><?php echo $i ?></td>
  					<td><?php echo $evento[$i]["nomeEvento"]?></td>
  					<form action="?p=verifica_culturaz" method="POST">
  						<td><input type="text" name="id_culturaz"></td>
  						<input type="hidden" value="<?php echo $evento[$i]['idEvento'];?>" name="id_evento">
  						<td><input type="submit" value="Enviar"></td>
  					</form>


  				</tr>
  			<?php } ?>
  			<tr><td>
  				Total:<?php echo count($evento) ?> 
  			</td></tr>
  		</table>
  		<hr >
  		<table border="1">
  			<h3>Eventos que estão no Bartira e no CulturAZ</h3>
  			<tr>
  				<th>#</th>
  				<th>Nome do Evento</th>
  				<th></th>
  				<th></th>
  			</tr>
  			<?php 
  			$sql_evento = "SELECT * FROM `sc_evento` WHERE mapas <> 0 AND dataEnvio IS NOT NULL AND publicado = 1";
  			$evento = $wpdb->get_results($sql_evento,ARRAY_A);
  			
  			for($i = 0; $i < count($evento); $i++){	
  				?>

  			<?php } ?>
  			<tr><td>
  				Total:<?php echo count($evento) ?> 
  			</td></tr>
  		</table>
  		<hr >
  		<table border="1">
  			<h3>Eventos que estão no CulturAZ e no temp_eventos</h3>
  			<tr>
  				<th>#</th>
  				<th>Nome[ temp_eventos ]</th>
  				<th>Nome [ CulturAZ ]</th>
  				<th></th>
  			</tr>
  			<?php 
  			$sql_evento = "SELECT DISTINCT `NOME DO EVENTO` FROM `temp_eventos`";
  			$evento = $wpdb->get_results($sql_evento,ARRAY_A);
  			
  			for($i = 0; $i < count($evento); $i++){
  				$sql_culturaz = "SELECT Nome FROM temp_culturaz WHERE Nome LIKE'%".addslashes($evento[$i]["NOME DO EVENTO"])."%'";
  				$culturaz = $wpdb->get_results($sql_culturaz,ARRAY_A);
  				$str_culturaz = "";
  				for($k = 0; $k < count($culturaz); $k++){
  					$str_culturaz .= $culturaz[$k]['Nome'].", ";
  				}
          
  				?>
  				<tr>
  					<td><?php echo $i ?></td>
  					<td><?php echo $evento[$i]["NOME DO EVENTO"]?></td>
  					<td><?php echo $str_culturaz; ?></td>
  				</tr>
  			<?php } ?>
  			<tr><td>
  				Total:<?php echo count($evento) ?> 
  			</td></tr>
  		</table>
  		<?php 
  		break;
  		case "importa_culturaz":
  		$sql_evento = "SELECT * FROM `temp_culturaz` WHERE Id NOT IN(SELECT mapas FROM sc_evento WHERE mapas <> 0)";
  		$evento = $wpdb->get_results($sql_evento,ARRAY_A);
  		
  		for($i = 0; $i < count($evento); $i++){	
  			$nomeEvento = $evento[$i]['Nome'];
  			$sinopse = $evento[$i]['Descrição Curta'];
  			$releaseCom = $evento[$i]['Descrição Longa'];
  			$mapas = $evento[$i]['Id'];
  			$linksCom = $evento[$i]['Ocorrências'];
  			
  			
  			
  			$sql_ins = "INSERT INTO sc_evento (`nomeEvento`,`sinopse`,`releaseCom`,`mapas`,`linksCom`,`idResponsavel`) VALUES ('$nomeEvento','$sinopse','$releaseCom', '$mapas','$linksCom','1');";
  			$x = $wpdb->query($sql_ins);
  			echo $x->insert_id."<br />";

  		}	
  		?>
  		
  		
  		<?php
	break; //fim da switch
}

?>

</main>
</div>
</div>

<?php 
include "footer.php";
?>