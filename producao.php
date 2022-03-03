<?php include "header.php"; ?>
<?php 
session_start();

if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
?>


<body>
	
	<?php include "menu/me_producao.php"; ?>
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
							<h1>Produção - Resumo</h1>
							<h2></h2>
							<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
						</div>
					</div>
					<?php 
					
					?>
				</div>
			</section>		
			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="row">    
					</div>
					<div class="table-responsive">
						
						<h3>Infraestrutura ATA</h3>
						<?php 

						if(retornaInfra($_SESSION['id']) != NULL){
							echo retornaInfra($_SESSION['id']);
							echo "</p>";

						}

						$valor = infraAta($_SESSION['id']);

						?>
						<br />
						<?php 
						for($i = 0; $i < count($valor) - 1; $i++){
							?>
							<?php if($valor[$i]['total'] != 0){ ?>
								<p><?php echo $valor[$i]['razao_social']?> : <?php echo dinheiroParaBr($valor[$i]['total']); ?> </p>
							<?php } ?>

							<?php	
						}
						?>	
						Total:<a style="text-decoration: underline;"><?php echo dinheiroParaBr($valor['total']);?> </a>
						<hr>
						<h3>Produção</h3>

						<?php 
						$x = producao($_SESSION['id']);
						for($i = 0; $i < count($x); $i++){
							
							$y = retornaProducao($x[$i]['id_lista_producao']);
							if($y != false){					
								if($y['tipo'] == "infra"){
									if($x[$i]['valor'] != ""){	
										echo "<li>".$y['titulo']." : ".$x[$i]['valor']."</li>";
									}
								}
							}
							
						}
						
						
						?>
						
						<hr>
						<h3>Comunicação</h3>
						<?php 
						$x = producao($_SESSION['id']);
						for($i = 0; $i < count($x); $i++){
							
							$y = retornaProducao($x[$i]['id_lista_producao']);
							if($y != false){					
								if($y['tipo'] == "com"){
									if($x[$i]['valor'] != ""){	
										echo "<li>".$y['titulo']." : ".$x[$i]['valor']."</li>";
									}
								}
							}
							
						}
						
						
						?>
						<hr>
						<h3>Apoio</h3>
						<?php 
						$x = producao($_SESSION['id']);
						for($i = 0; $i < count($x); $i++){
							
							$y = retornaProducao($x[$i]['id_lista_producao']);
							if($y != false){					
								if($y['tipo'] == "apoio"){
									if($x[$i]['valor'] != ""){	
										echo "<li>".$y['titulo']." : ".$x[$i]['valor']."</li>";
									}
								}
							}
							
						}
						
						
						?>

					</div>
				</div>	
			</section>		

			<?php 
			break;	 
case "infraestrutura": //Lista as contratações

if(isset($_SESSION['idPessoa'])){
	unset($_SESSION['idPessoa']);
	unset($_SESSION['tipo']);
}



if($_SESSION['entidade'] == 'evento'){
	$e = evento($_SESSION['id']);
	$n = $e['titulo'];
}else{
	$e = atividade($_SESSION['id']);
	$n = $e['titulo'];
}



if(isset($_POST['prod'])){

	foreach($_POST as $post=>$valor){
		if($post != 'prod'){
			insereAta($_SESSION['id'],substr($post,3),dinheiroDeBr($valor));
		}	
	}
}


?>

<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Infraestrutura</h1>
				<h2><?php echo $n;?></h2>
				<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
			</div>
		</div>
		<?php 
		// se existe pedido, listar
		$total = 0;
		$sql = "SELECT * FROM sc_ata WHERE ano_base = '2019' ORDER BY cod";
		$peds = $wpdb->get_results($sql,ARRAY_A);
		?>
	</div>
</section>		
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Cód</th>
						<th>Infra</th>
						<th>Descrição</th>
						<th>Valor/Diária</th>
						<th width='5%'>Qde</th>

					</tr>
				</thead>
				<tbody>
					<form method="POST" action="?p=infraestrutura" class="form-horizontal" role="form">
						<?php 
						for($i = 0; $i < count($peds); $i++){
							?>
							<tr>
								<td><?php echo $peds[$i]['cod']; ?></td>
								<td><?php echo $peds[$i]['nome']; ?></td>
								<td><?php echo $peds[$i]['descricao']; ?></td>
								<td><?php echo dinheiroParaBr($peds[$i]['valor_diaria']); ?></td>
								<td><input type="text" name="id_<?php echo $peds[$i]['id']; ?>" value="<?php echo recAta($_SESSION['id'],$peds[$i]['id']); ?>" ></td>
								<?php $total = $total + ($peds[$i]['valor_diaria'] * recAta($_SESSION['id'],$peds[$i]['id']));?>
							</tr>
						<?php } // fim do for?>	
						<tr>
							<td></td>
							<td>Total:</td>
							<td><?php echo dinheiroParaBr($total);?></td>
							<td></td>
							<td>
								<input type="hidden" name="prod">
								<input type="submit" class="btn btn-theme btn-sm btn-block" value="Salvar"></form></td></tr>
							</tbody>
						</table>
					</div>

				</div>
			</section>		

			<?php 
			break;
			case "comunicacao":

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

							<h3>Comunicação</h3>
							<h1></h1>
							<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
						</div>
					</div> 
					<div class="row">
						<div class="col-md-offset-1 col-md-10">
							<form method="POST" action="?p=comunicacao" class="form-horizontal" role="form">
								<div class="form-group">
									<div class="col-md-offset-2">
										<!--<input type="checkbox" name="planejamento" id="subEvento" <?php //checar($campo['subEvento']) ?>/><label style="padding:0 10px 0 5px;"> Evento em planejamento?</label>-->
									</div>
								</div>
								<?php 
								$sql_campo = "SELECT * FROM sc_lista_producao WHERE tipo = 'com'";
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
										<!--<input type="checkbox" name="planejamento" id="subEvento" <?php //checar($campo['subEvento']) ?>/><label style="padding:0 10px 0 5px;"> Evento em planejamento?</label>-->
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