<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
?>

<body>
	
	<?php include "menu/me_comunicacao.php"; ?>
	<link href="css/jquery-ui.css" rel="stylesheet">
	<script src="js/jquery-ui.js"></script>
	<script src="js/mask.js"></script>
	<script src="js/maskMoney.js"></script> 
	<script>
		$(function() {
			$( ".calendario" ).datepicker();
			$(".cpf").mask("999.999.999-99");
			$(".cnpj").mask("99.999.999/9999-99");
			$( ".hora" ).mask("99:99");
			$( ".min" ).mask("999");
			$( ".cep" ).mask("99999-999");
			$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});

		});

	</script>
	<?php include "inc/js_cep.php";?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<?php 
		switch($p){
			case "inicio":
			?>
			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="row">    
						<div class="col-md-offset-2 col-md-8">
							<h1>Comunicação</h1>
							<h2></h2>
							<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
						</div>
					</div>
					<?php 
					
					?>
				</div>
			</section>

			<?php 
			break;	 
case "revisao": //Lista as contratações
$mensagem = "";
if(isset($_POST['gerar'])){
	if($_POST['inicio'] == ""){
		$mensagem .= alerta("É preciso inserir uma data inicial","warning");
	}

	if($_POST['fim'] == ""){
		$mensagem .= alerta("É preciso inserir uma data final","warning");
	}
	
	if($_POST['inicio'] != "" AND $_POST['fim'] != ""){
		$sql = "SELECT DISTINCT idEvento FROM sc_agenda WHERE data >= '".exibirDataMysql($_POST['inicio'])."' AND data <= '".exibirDataMysql($_POST['fim'])."'  ORDER BY data,hora ASC";
		$id_evento = $wpdb->get_results($sql,ARRAY_A);
		
	}
	
}

?>
<script type="text/javascript">
	$(function() {
		$( ".calendario" ).datepicker();
		$( ".hora" ).mask("99:99");
		$( ".min" ).mask("999");
		$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
	});
</script>

<section id="inserir" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">

				<h3>Revisão de Sinopses</h3>
				<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=revisao_lista" class="form-horizontal" role="form">

					<div class="row">
						<div class="col-6">
							<label>Data Inicial</label>
							<input type="text" class="form-control calendario" name="inicio"> 
						</div>
						<div class="col-6">
							<label>Data Final</label>
							<input type="text" class="form-control calendario" name="fim"> 
						</div>
					</div>	
					<br />
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Revisado</label>
							<select class="form-control" name="revisado" id="programa" >
								<option value='0'>Todos</option>
								<option value='1'>Somente os revisados</option>
								<option value='2'>Somente os não revisados</option>
							</select>
						</div>
					</div>
					<br />
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="gerar" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Buscar eventos">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<?php 
			if(isset($id_evento)){
				for($i = 0; $i < count($id_evento); $i++){
					$evento = evento($id_evento[$i]['idEvento']);
					echo "<li>".$evento['titulo']." - ".$evento['periodo']['legivel']." - ".$evento['local']."</li>";		
				}
				
			}
			?>
			
		</div>
	</div>
</section>		
<?php 
break;
case "revisao_lista":
if(isset($_POST['atualizar'])){

	//Apaga os checks
	foreach($_POST as $x=>$y){
		$id_evento = substr($x,3);
		$sql_check = "UPDATE sc_evento SET revisado = '0' WHERE idEvento = '".$id_evento."'";
		$wpdb->query($sql_check);	
	}

	foreach($_POST as $x=>$y){
		$id_evento = substr($x,3);
		$campo = substr($x,0,2);
		
		switch($campo){
			case "re":
			$field = "revisado";
			$y = '1';
			break;
			
			case "ti":
			$field = "nomeEvento";
			$y = addslashes($y);
			break;

			case "si":
			$field = "sinopse";
			$y = addslashes($y);
			break;
		}
		


		$upd = "UPDATE sc_evento SET ".$field." = '".$y."' WHERE idEvento = '".$id_evento."'";
		$wpdb->query($upd);
	}
	
}


?>
<script type="text/javascript">
	$(function() {
		$( ".calendario" ).datepicker();
		$( ".hora" ).mask("99:99");
		$( ".min" ).mask("999");
		$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
	});
</script>

<section id="inserir" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">

				<h3>Revisão de Sinopses</h3>
				<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=revisao_lista" class="form-horizontal" role="form">
					<?php
					if(isset($_POST['inicio'])){
						if($_POST['inicio'] != "" AND $_POST['fim'] != ""){

							$inicio = exibirDataMysql($_POST['inicio']);
							$fim = exibirDataMysql($_POST['fim']);
							$sql = "SELECT DISTINCT idEvento FROM sc_agenda WHERE data >= '".$inicio."' AND data <= '".$fim."'ORDER BY data ASC";
							$id_evento = $wpdb->get_results($sql,ARRAY_A);
							for($i =0; $i < count($id_evento); $i++){
								
								
								$evento = evento($id_evento[$i]['idEvento']);
								$sql_o = "SELECT idOcorrencia FROM sc_ocorrencia WHERE idEvento = '".$id_evento[$i]['idEvento']."' AND publicado = '1'";
								$o = $wpdb->get_results($sql_o,ARRAY_A);
								
					if($_POST['revisado'] == 0){ //todos
						
						?>
						<input type="checkbox" name="re_<?php echo $id_evento[$i]['idEvento'];  ?>" <?php if($evento['revisado'] == 1){ echo "checked";} ?> > Revisado <br />
						<input type='text' name='ti_<?php echo $id_evento[$i]['idEvento'];  ?>' class="form-control" value="<?php echo stripslashes($evento['titulo']) ?>">
						<textarea name="si_<?php echo $id_evento[$i]['idEvento'];  ?>"  class="form-control" rows="10">
							<?php echo stripslashes($evento['sinopse']) ?>
						</textarea>
						
						<?php  
						for($w = 0; $w < count($o); $w++){
							$ocor = ocorrencia($o[$w]['idOcorrencia']);
							echo "<li>".$ocor['data']."<br />";
							echo $ocor['local']."</li>";

						}
						echo "<hr>";
					} else
					if($_POST['revisado'] == '1'  AND $evento['revisado'] == '1'){ //somente os revisados
						?>
						<input type="checkbox" name="re_<?php echo $id_evento[$i]['idEvento'];  ?>" <?php if($evento['revisado'] == 1){ echo "checked";} ?> > Revisado <br />
						<input type='text' name='ti_<?php echo $id_evento[$i]['idEvento'];  ?>' class="form-control" value="<?php echo stripslashes($evento['titulo']) ?>">
						<textarea name="si_<?php echo $id_evento[$i]['idEvento'];  ?>"  class="form-control" rows="10">
							<?php echo stripslashes($evento['sinopse']) ?>
						</textarea>
						
						<?php  
						for($w = 0; $w < count($o); $w++){
							$ocor = ocorrencia($o[$w]['idOcorrencia']);
							echo "<li>".$ocor['data']."<br />";
							echo $ocor['local']."</li>";

						}
						echo "<hr>";
						
						
					} else
					
					if($_POST['revisado'] == '2'  AND $evento['revisado'] == '0'){ //somente os revisados
						?>
						<input type="checkbox" name="re_<?php echo $id_evento[$i]['idEvento'];  ?>" <?php if($evento['revisado'] == 1){ echo "checked";} ?> > Revisado <br />
						<input type='text' name='ti_<?php echo $id_evento[$i]['idEvento'];  ?>' class="form-control" value="<?php echo stripslashes($evento['titulo']) ?>">
						<textarea name="si_<?php echo $id_evento[$i]['idEvento'];  ?>"  class="form-control" rows="10">
							<?php echo stripslashes($evento['sinopse']) ?>
						</textarea>
						
						<?php  
						for($w = 0; $w < count($o); $w++){
							$ocor = ocorrencia($o[$w]['idOcorrencia']);
							echo "<li>".$ocor['data']."<br />";
							echo $ocor['local']."</li>";

						}
						echo "<hr>";						
					}
				}
			}
		}
		?>

		<br />
		<div class="form-group">
			<div class="col-md-offset-2">
				<input type="hidden" name="atualizar" value="1" />
				<input type="hidden" name="inicio" value="<?php echo $_POST['inicio']; ?>" />
				<input type="hidden" name="fim" value="<?php echo $_POST['fim']; ?>" />
				
				<?php 
				?>
				<input type="submit" class="btn btn-theme btn-lg btn-block" value="Salvar">
			</div>
		</div>
	</form>
</div>
</div>

</div>
</section>		

<?php 
break;
case "agenda":

$mensagem = "";
if(isset($_POST['gerar'])){
	if($_POST['inicio'] == ""){
		$mensagem .= alerta("É preciso inserir uma data inicial","warning");
	}

	if($_POST['fim'] == ""){
		$mensagem .= alerta("É preciso inserir uma data final","warning");
	}
	
}

$url_mapas = "http://culturaz.santoandre.sp.gov.br/api/";
$url = $url_mapas."event/findByLocation";

?>
<script type="text/javascript">
	$(function() {
		$( ".calendario" ).datepicker();
		$( ".hora" ).mask("99:99");
		$( ".min" ).mask("999");
		$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
	});
</script>

<section id="inserir" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">

				<h3>Agenda do Prefeito</h3>
				<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=agenda" class="form-horizontal" role="form">

					<div class="row">
						<div class="col-6">
							<label>Data Inicial</label>
							<input type="text" class="form-control calendario" name="inicio"> 
						</div>
						<div class="col-6">
							<label>Data Final</label>
							<input type="text" class="form-control calendario" name="fim"> 
						</div>
					</div>	
					<br />
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="gerar" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Buscar eventos">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-2 col-md-8">
				<?php 
				
				
				if(isset($_POST['inicio'])){
					if($_POST['inicio'] != "" AND $_POST['fim'] != ""){

						$inicio = exibirDataMysql($_POST['inicio']);
						$fim = somarDatas(exibirDataMysql($_POST['fim']),"+1");
						while($inicio != $fim ){
							echo "<b>".exibirDataBr($inicio)."</b><br />";
							$sql = "SELECT * FROM sc_agenda WHERE data = '".$inicio."' ORDER BY hora ASC";
							$id_evento = $wpdb->get_results($sql,ARRAY_A);
							$titulo = "";
							for($i =0; $i < count($id_evento); $i++){
								$evento = evento($id_evento[$i]['idEvento']);
								$local = tipo($id_evento[$i]['idLocal']);
								echo $evento['titulo']." - ".substr($id_evento[$i]['hora'],0,-3)."<br />";
								echo $local['tipo']."<br /><br />";
								
							}
							$inicio = somarDatas($inicio,"+1");
							
						}
					}
				}
				?>
				
			</div>
		</div>
	</div>
</section>	
<?php 
break;
case "agenda_culturaz":

$mensagem = "";
if(isset($_POST['gerar'])){
	if($_POST['inicio'] == ""){
		$mensagem .= alerta("É preciso inserir uma data inicial","warning");
	}

	if($_POST['fim'] == ""){
		$mensagem .= alerta("É preciso inserir uma data final","warning");
	}
}

$url_mapas = "http://culturaz.santoandre.sp.gov.br/api/";
$url = $url_mapas."event/findByLocation";

?>
<script type="text/javascript">
	$(function() {
		$( ".calendario" ).datepicker();
		$( ".hora" ).mask("99:99");
		$( ".min" ).mask("999");
		$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
	});
</script>

<section id="inserir" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">

				<h3>Agenda do Prefeito</h3>
				<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=agenda_culturaz" class="form-horizontal" role="form">

					<div class="row">
						<div class="col-6">
							<label>Data Inicial</label>
							<input type="text" class="form-control calendario" name="inicio"> 
						</div>
						<div class="col-6">
							<label>Data Final</label>
							<input type="text" class="form-control calendario" name="fim"> 
						</div>
					</div>	
					<br />
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="gerar" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Buscar eventos">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-2 col-md-8">
				<?php 
				
				
				if(isset($_POST['inicio'])){	
					if($_POST['inicio'] != "" AND $_POST['fim'] != ""){

						$inicio = exibirDataMysql($_POST['inicio']);
						$fim = somarDatas(exibirDataMysql($_POST['fim']),"+1");
						while($inicio != $fim ){
							$n_eventos = 0;
							echo "<b>".exibirDataBr($inicio)."</b><br />";
							$n_semana = date('w', strtotime($inicio));
							$url_mapas = "http://culturaz.santoandre.sp.gov.br/api/";
							$url = $url_mapas."event/findByLocation";
							$data = array(
								"@from" => $inicio,
								"@to" => $inicio,
								"@select" => "id, name, occurrences",
								"@seals" => "1,2,3"
							);
							
							
							$e = chamaAPI($url,$data);
							for($i = 0; $i < count($e); $i++){

								
								for($k = 0; $k < count($e[$i]['occurrences']); $k++){
									$data_o = array(
										"@select" => "space,_startsAt,rule",
										"@seals" => "1,2,3",
										"id" => "EQ(".$e[$i]['occurrences'][$k].")"
									);
									
									$o = chamaAPI($url_mapas."eventOccurrence/find",$data_o);
									
									$data_l = array(
										"@select" =>  "name",
										"id" => "EQ(".$o[0]['space'].")"
									);

									$l = chamaAPI($url_mapas."space/find",$data_l);
									$b = false;
									for($t = 0; $t < 7; $t++){
										if(isset($o[0]['rule']['day'][$t]) AND $t == $n_semana){
											$b = true;
										}
									}	
									if($b == true OR $o[0]['rule']['frequency'] == 'once'){
										echo $e[$i]['name']." - ".substr(substr($o[0]['_startsAt']['date'],0,-10),11)."<br />";
										echo $l[0]['name']."<br /><br />";
										
									}
								}
								
								
							}
							echo "<br />";
							
							$inicio = somarDatas($inicio,"+1");

						}
					}
				}
				?>

			</div>
		</div>
	</div>
</section>	

<?php 
break;
case "material":

$mensagem = "";
if(isset($_POST['gerar'])){
	if($_POST['inicio'] == ""){
		$mensagem .= alerta("É preciso inserir uma data inicial","warning");
	}

	if($_POST['fim'] == ""){
		$mensagem .= alerta("É preciso inserir uma data final","warning");
	}
	
	
	
	
}

?>
<script type="text/javascript">
	$(function() {
		$( ".calendario" ).datepicker();
		$( ".hora" ).mask("99:99");
		$( ".min" ).mask("999");
		$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
	});
</script>



<section id="inserir" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">

				<h3>Lista de Material</h3>
				<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=material" class="form-horizontal" role="form">

					<div class="row">
						<div class="col-6">
							<label>Data Inicial</label>
							<input type="text" class="form-control calendario" name="inicio"> 
						</div>
						<div class="col-6">
							<label>Data Final</label>
							<input type="text" class="form-control calendario" name="fim"> 
						</div>
					</div>	
					<br />
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="gerar" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Buscar eventos">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-2 col-md-8">
				<?php 
				
				
				if(isset($_POST['inicio'])){
					if($_POST['inicio'] != "" AND $_POST['fim'] != ""){

						$inicio = exibirDataMysql($_POST['inicio']);
						$fim = somarDatas(exibirDataMysql($_POST['fim']),"+1");
						$sql = "SELECT DISTINCT sc_agenda.idEvento FROM sc_agenda, sc_evento WHERE data >= '".$inicio."' AND data <= '".$fim."' AND sc_evento.idEvento = sc_agenda.idEvento AND (sc_evento.status = '3' OR sc_evento.status = '4') ORDER BY data ASC";
						$id_evento = $wpdb->get_results($sql,ARRAY_A);

						for($i = 0; $i < count($id_evento); $i++){
							$evento = evento($id_evento[$i]['idEvento']);
							$x = producao($id_evento[$i]['idEvento']);
							echo "<h3>".$evento['titulo']."</h3>";
							echo "<br />";	
							echo $evento['periodo']['legivel']." - ".$evento['local'] ;
							echo "<hr>";


							for($k = 0; $i < count($x); $k++){
								
								$y = retornaProducao($x[$k]['id_lista_producao']);
								if($y != false){					
									if($y['tipo'] == "com"){
										if($x[$k]['valor'] != ""){	
											echo "<li>".$y['titulo']." : ".$x[$k]['valor']."</li>";
										}
									}
								}
								
							}

							
						}
						
					}
				}
				?>
				
			</div>
		</div>
	</div>
</section>	


<?php 
break;
case "infra":

$mensagem = "";
if(isset($_POST['inserir'])){
		// limpa os checks
	$sql_limpa_check = "UPDATE sc_producao_ext SET valor = '' WHERE valor = 'on' AND id_evento = '".$_SESSION['id']."'";
	$wpdb->query($sql_limpa_check);
	
	foreach($_POST as $x=>$y){
		if($y != ""){
			$x = insereProducao($x,$y,$_SESSION['id']);
		}
	}
}

?>
<section id="inserir" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">

				<h3>Infraestrutura</h3>
				<h1></h1>
				<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=infra" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<!--<input type="checkbox" name="planejamento" id="subEvento" <?php //checar($campo['subEvento']) ?>/><label style="padding:0 10px 0 5px;"> Evento em planejamento?</label>-->
						</div>
					</div>
					<?php 
					$sql_campo = "SELECT * FROM sc_lista_producao WHERE tipo = 'infra'";
					$campo = $wpdb->get_results($sql_campo,ARRAY_A);
					for($i = 0; $i < count($campo); $i++){
						$json_campo = json_decode($campo[$i]['descricao'],true);
						
						geraCampo($json_campo['tipo'],$campo[$i]['id'],$campo[$i]['titulo'],recuperaProducao($campo[$i]['id'],$_SESSION['id']));
						

					}
					?>

					<div class="form-group">
						<div class="col-md-offset-2">
							<?php 
							
							
							?>		
						</div> 
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="inserir" value="1" />
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<?php 
break;
case "apoio":

$mensagem = "";
if(isset($_POST['inserir'])){
		// limpa os checks
	$sql_limpa_check = "UPDATE sc_producao_ext SET valor = '' WHERE valor = 'on' AND id_evento = '".$_SESSION['id']."'";
	$wpdb->query($sql_limpa_check);
	
	foreach($_POST as $x=>$y){
		if($y != ""){
			$x = insereProducao($x,$y,$_SESSION['id']);
		}
	}
}

?>
<section id="inserir" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">

				<h3>Apoio Institucional</h3>
				<h1></h1>
				<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=apoio" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
						</div>
					</div>
					<?php 
					$sql_campo = "SELECT * FROM sc_lista_producao WHERE tipo = 'apoio'";
					$campo = $wpdb->get_results($sql_campo,ARRAY_A);
					for($i = 0; $i < count($campo); $i++){
						$json_campo = json_decode($campo[$i]['descricao'],true);
						
						geraCampo($json_campo['tipo'],$campo[$i]['id'],$campo[$i]['titulo'],recuperaProducao($campo[$i]['id'],$_SESSION['id']));

					}
					?>

					<div class="form-group">
						<div class="col-md-offset-2">
							<?php 
							
							
							?>		
						</div> 
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="inserir" value="1" />
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<?php 
break;
} // fim da switch p

?>

</main>
</div>
</div>

<?php 
include "footer.php";
?>