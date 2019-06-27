<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
//session_start();
$_SESSION['entidade'] = 'evento';
?>


<body>
	
	<?php include "menu/me_aprovacao.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<?php 
		switch($p){
			case "inicio": 
if(isset($_POST['enviar'])){  // envia
	// muda status de dataEnvio para hoje
	// atualiza a agenda
	$idEvento = $_POST['idEvento'];
	$hoje = date("Y-m-d H:i:s");
	global $wpdb;
	$sql_enviar = "UPDATE sc_evento SET dataEnvio = '$hoje', status = '3' WHERE idEvento = '$idEvento'";
	$upd = $wpdb->query($sql_enviar);
	if($upd == 1){
		atualizarAgenda($idEvento);
		$mensagem = alerta("Evento enviado com sucesso.","success");
		gravarLog($sql_enviar, $user->ID);
	}else{
		$mensagem = alerta("Erro. Tente novamente.","warning");
		gravarLog($sql_enviar, $user->ID);
	}
	
}

if(isset($_POST['aprovar'])){
	$mensagem = "";
	foreach($_POST as $x=>$y){
		if(is_int($x)){
			$update = "UPDATE sc_evento SET status = '3' WHERE idEvento = '".$x."'";
			$w = $wpdb->query($update);
			if($w == 1){
				$e = evento($x);
				$mensagem .= alerta("O status do evento ".$e['titulo']." foi atualizado com sucesso.","success");
			}else{
				$mensagem .= alerta("Erro","warning");
			}	
		}


		
	}
}


if(isset($_SESSION['id'])){
	unset($_SESSION['id']);
}

if(isset($_GET['order'])){
	$order = ' ORDER BY nomeEvento ASC ';
}else{
	$order = ' ORDER BY idEvento DESC ';
}

?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Meus Eventos para Aprovação</h1>
				<?php if(isset($mensagem)){echo $mensagem;}?>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th><a href="?<?php if(isset($_GET['order'])){ echo "";}else{ echo "order"; } ?>">Título</a></th>
						<th>Data</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					if($user->ID == 1){
						$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND status = '2' $order";
						
					}else{				
						
						$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND status = '2' AND idRespAprovacao = '".$user->ID."' $order";
					}					


					$res = $wpdb->get_results($sql_list,ARRAY_A);
					for($i = 0; $i < count($res); $i++){
						$evento = evento($res[$i]['idEvento']);
						
						?>
						<tr>
							<td><?php echo $res[$i]['idEvento']; ?></td>
							<td>
								
								<a href="busca.php?p=view&tipo=evento&id=<?php echo $res[$i]['idEvento'] ?>" target=_blank>
									
									<?php echo $evento['titulo']; ?>
									
								</a>
								
							</td>

							
							<td><?php echo $evento['periodo']['legivel']; ?></td>
							<td><?php echo $evento['status']; ?></td>
							<td>	<form method="POST" action="?p=editar" class="form-horizontal" role="form">
								<input type="hidden" name="carregar" value="<?php echo $res[$i]['idEvento']; ?>" />
								<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
							</form>
						</td>
					</tr>
				<?php } // fim do for?>	
				
			</tbody>
		</table>
	</div>

</div>
</section>

<?php 
break;
case "aprovados": 
if(isset($_POST['enviar'])){  // envia
	// muda status de dataEnvio para hoje
	// atualiza a agenda
	$idEvento = $_POST['idEvento'];
	$hoje = date("Y-m-d H:i:s");
	global $wpdb;
	$sql_enviar = "UPDATE sc_evento SET dataEnvio = '$hoje', status = '3' WHERE idEvento = '$idEvento'";
	$upd = $wpdb->query($sql_enviar);
	if($upd == 1){
		atualizarAgenda($idEvento);
		$mensagem = alerta("Evento enviado com sucesso.","success");
		gravarLog($sql_enviar, $user->ID);
	}else{
		$mensagem = alerta("Erro. Tente novamente.","warning");
		gravarLog($sql_enviar, $user->ID);
	}
	
}

if(isset($_POST['aprovar'])){
	$mensagem = "";
	foreach($_POST as $x=>$y){
		if(is_int($x)){
			$update = "UPDATE sc_evento SET status = '3' WHERE idEvento = '".$x."'";
			$w = $wpdb->query($update);
			if($w == 1){
				$e = evento($x);
				$mensagem .= alerta("O status do evento ".$e['titulo']." foi atualizado com sucesso.","success");
			}else{
				$mensagem .= alerta("Erro","warning");
			}	
		}
		
	}
}


if(isset($_SESSION['id'])){
	unset($_SESSION['id']);
}

if(isset($_GET['order'])){
	$order = ' ORDER BY nomeEvento ASC ';
}else{
	$order = ' ORDER BY idEvento DESC ';
}

?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Meus Eventos Aprovados</h1>
				<?php if(isset($mensagem)){echo $mensagem;}?>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th><a href="?<?php if(isset($_GET['order'])){ echo "";}else{ echo "order"; } ?>">Título</a></th>
						<th>Data</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					if($user->ID == 1){
						$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND status = '3' OR status = '4' $order";
						
					}else{				
						
						$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND (status = '3' OR status = '4') AND idRespAprovacao = '".$user->ID."' $order";
					}					


					$res = $wpdb->get_results($sql_list,ARRAY_A);
					for($i = 0; $i < count($res); $i++){
						$evento = evento($res[$i]['idEvento']);
						
						?>
						<tr>
							<td><?php echo $res[$i]['idEvento']; ?></td>
							<td>
								
								<a href="busca.php?p=view&tipo=evento&id=<?php echo $res[$i]['idEvento'] ?>" target=_blank>
									
									<?php echo $evento['titulo']; ?>
									
								</a>
								
							</td>

							
							<td><?php echo $evento['periodo']['legivel']; ?></td>
							<td><?php echo $evento['status']; ?></td>
							<td>	
							</td>
						</tr>
					<?php } // fim do for?>	
					
				</tbody>
			</table>
		</div>

	</div>
</section>

<?php 
break;
case "serie": 

if(isset($_GET['order'])){
	$order = ' ORDER BY nomeEvento ASC ';
}else{
	$order = ' ORDER BY idEvento DESC ';
}

if(isset($_POST['enviar'])){  // envia
	// muda status de dataEnvio para hoje
	// atualiza a agenda
	$idEvento = $_SESSION['id'];
	$hoje = date("Y-m-d H:i:s");
	global $wpdb;
	$sql_enviar = "UPDATE sc_evento SET dataEnvio = '$hoje' WHERE idEvento = '$idEvento'";
	$upd = $wpdb->query($sql_enviar);
	if($upd == 1){
		atualizarAgenda($idEvento);
		$mensagem = alerta("Evento enviado com sucesso.","success");
	}else{
		$mensagem = alerta("Erro. Tente novamente.","warning");
		
	}
	
}
if(isset($_SESSION['id'])){
	unset($_SESSION['id']);
}
?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Meus Eventos para Aprovação</h1>
				<?php if(isset($mensagem)){echo $mensagem;}?>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th><a href="?<?php if(isset($_GET['order'])){ echo "";}else{ echo "order"; } ?>">Título</a></th>
						<th>Data</th>
						<th>Responsável</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<form method="POST" action="?" class="form-horizontal" role="form">
						<?php 
						global $wpdb;
						if($user->ID == 1){
							$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND status = '2' $order";
							
						}else{		
							
							$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND status = '2' AND idRespAprovacao = '".$user->ID."' $order";
						}					


						$res = $wpdb->get_results($sql_list,ARRAY_A);
						for($i = 0; $i < count($res); $i++){
							$evento = evento($res[$i]['idEvento']);
							
							?>
							<tr>
								<td><?php echo $res[$i]['idEvento']; ?></td>
								<td>
									
									<a href="busca.php?p=view&tipo=evento&id=<?php echo $res[$i]['idEvento'] ?>" target=_blank>
										
										<?php echo $evento['titulo']; ?>
										
									</a>
									
								</td>

								
								<td><?php echo $evento['periodo']['legivel']; ?></td>
								<td><?php echo $evento['responsavel']; ?></td>
								<td><input type="checkbox" class="form-check-input" id="exampleCheck1" name="<?php echo $res[$i]['idEvento'] ?>">
								</td>
							</tr>
						<?php } // fim do for?>	
					</tbody>
				</table>
				<input type="submit" name="aprovar" value="Aprovar todos os eventos selecionados." class="btn btn-primary">
			</form>
		</div>

	</div>
</section>

<?php 
break;
case "foradeprazo": 

if(isset($_POST['enviar'])){
	// muda status de dataEnvio para hoje
	// atualiza a agenda
	$idEvento = $_POST['idEvento'];
	$hoje = date("Y-m-d H:i:s");
	global $wpdb;
	$sql_enviar = "UPDATE sc_evento SET dataEnvio = '$hoje', status = '3' WHERE idEvento = '$idEvento'";
	$upd = $wpdb->query($sql_enviar);
	if($upd == 1){
		atualizarAgenda($idEvento);
		$mensagem = alerta("Evento enviado com sucesso.","success");
		gravarLog($sql_enviar, $user->ID);
	}else{
		$mensagem = alerta("Erro. Tente novamente.","warning");
		gravarLog($sql_enviar, $user->ID);
	}
	
}


?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Eventos</h1>
				<?php if(isset($mensagem)){echo $mensagem;}?>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Título</th>
						<th>Data</th>
						<th>Responsável</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$idUser = $user->ID;
					$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND status = '1' ORDER BY idEvento DESC";
					$res = $wpdb->get_results($sql_list,ARRAY_A);
					for($i = 0; $i < count($res); $i++){

						
						
						
						$evento = evento($res[$i]['idEvento']);
						
						?>
						<tr>
							<td><?php echo $res[$i]['idEvento']; ?></td>
							<td><?php echo $evento['titulo']; ?></td>
							<td><?php echo $evento['periodo']['legivel']; ?></td>
							<td><?php echo $evento['responsavel']; ?></td>
							<td></td>
							<td></a></td>

							<td>	<?php if($evento['dataEnvio'] == NULL){ ?>
								<form method="POST" action="?p=editar" class="form-horizontal" role="form">
									<input type="hidden" name="carregar" value="<?php echo $res[$i]['idEvento']; ?>" />
									<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
								</form>
								<?php 
							}
							?></td>
						</tr>
						
						<?php 
						
					} // fim do for?>	
					
				</tbody>
			</table>
		</div>

	</div>
</section>

<?php
break ;
case "editar":

?>
<link href="css/jquery-ui.css" rel="stylesheet">
<script src="js/jquery-ui.js"></script>
<script src="js/mask.js"></script>
<script src="js/maskMoney.js"></script> 
<script>
	$(function() {
		$( ".calendario" ).datepicker();
		$( ".hora" ).mask("99:99");
		$( ".min" ).mask("999");
		$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
	});



</script>

<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
	<?php 
	$evento = evento($_POST['carregar']);
	?>

	<section id="contact" class="home-section bg-white">
		<div class="container">
			<div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h3>Status </h3>
					<h1><?php echo $evento['objeto'];?></h1>
					<h2><?php if(isset($mensagem)){echo $mensagem;} ?></h2>
					<p>O evento está com status de Rascunho. Para que o responsável pela aprovação analise seu evento é preciso mudar o status para "Planejado" clicando no botão abaixo. Caso esteja disponível é porque algum campo obrigatório não foi completado.</p>
				</div>
			</div>
			<div class="row">    
				<div class="col-md-offset-2 col-md-8">


				</ul>
				<p>Se houver alguma pendência, o sistema não permitirá o envio.</p>
			</div>
		</div>
		<br /><br />
		
		
		
		<?php 
		if(isset($_SESSION['entidade'])){
		//verifica se todos os campos obrigatórios foram atualizados
			switch($_SESSION['entidade']){
				case 'evento':
				
				$evento = evento($_POST['carregar']);
				?>
				<hr>			
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<h3>Dados do Evento</h3>
						<br />
						<p>Programa: <?php echo $evento['programa']; ?></p>
						<p>Projeto: <?php echo $evento['projeto']; ?></p>
						<p>Linguagem principal: <?php echo $evento['linguagem']; ?></p>
						<p>Responsável: <?php echo $evento['responsavel']; ?></p>
						<p>Autor/Artista: <?php echo $evento['autor']; ?></p>
						<p>Ficha técnica: <?php echo $evento['grupo']; ?></p>
						<p>Classificação etária: <?php echo $evento['faixa_etaria']; ?></p>
						<p>Sinopse: <br /><?php echo $evento['sinopse']; ?></p>
						<p>Release: <br /><?php echo $evento['release']; ?></p>
						<p>Links: <?php //echo $evento['links']; ?></p>
						<p>Ocorrências:<br /> <?php
						$sql_lista_ocorrencia = "SELECT idOcorrencia FROM sc_ocorrencia WHERE idEvento = '".$_POST['carregar']."' AND publicado = '1'";
						$res = $wpdb->get_results($sql_lista_ocorrencia,ARRAY_A);
						if(count($res)){
							for($i = 0; $i < count($res); $i++){
								$ocorrencia = ocorrencia($res[$i]['idOcorrencia']);
								echo $ocorrencia['tipo']."<br />";
								echo $ocorrencia['data']."<br />";
								echo $ocorrencia['local']."<br /><br />";
								
							}
							
						}else{
							echo "Não há ocorrências cadastradas.";
							
						}
			
			//echo $evento['']; ?></p>
			<hr>
			<h3>Pedidos de Contratação</h3>
			<?php 
			$ped = listaPedidos($_POST['carregar'],'evento');
		//var_dump($ped);
			for($i = 0; $i < count($ped); $i++){
				$pedido = retornaPedido($ped[$i]['idPedidoContratacao']);
				?>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<p><br />
							<li><b>Tipo:</b> <?php echo $ped[$i]['tipo'] ?>  / <b>Nome/Razão Social:</b> <a href="busca.php?p=view&tipo=pj&id=<?php echo $ped[$i]['idPessoa']?>" ><?php echo $ped[$i]['nome'] ?> </a>/ <b>Projeto/Ficha:</b> <?php echo $pedido['projeto'] ?>/<?php echo $pedido['ficha'] ?>  / <b>Valor: </b><a style="text-decoration: underline;"><?php echo $pedido['valor'] ?></a>  
								<?php 
								$cont = retornaContabil($pedido['nProcesso']);
								if(count($cont > 0)){
									for($k = 0; $k < count($cont);$k++){
										?>
										/ <b>Processo: </b><?php echo $cont[$k]['nProcesso']; ?>/ <b>Número da Liberação:  </b> <?php echo $pedido['nLiberacao'] ?>/ <b>Número do Empenho: </b><?php echo $cont[$k]['empenho']; ?> / <b>Ordem de Pagamento: </b><?php echo dinheiroParaBr($cont[$k]['v_op_baixado']); ?><br />
										
										<?php 
									}
								}
								
								?>
								
								
							</li>
							
							
							<?php //var_dump($ped); ?>	
						<?php } ?>
						
						<hr>
						<h3>Infraestrutura ATA</h3>
						<?php 

						if(retornaInfra($_POST['carregar']) != NULL){
							echo retornaInfra($_POST['carregar']);
							echo "</p>";

						}

						$valor = infraAta($_POST['carregar']);

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
						$x = producao($_POST['carregar']);
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
						$x = producao($_POST['carregar']);
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
						$x = producao($_POST['carregar']);
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
						
						<hr>
						<h3>Arquivos</h3>
						<br /> <?php $arquivo = listaArquivos("evento",$_POST['carregar']); 
						
						for($i = 0; $i < count($arquivo); $i++){
							echo "<a href='upload/".$arquivo[$i]['arquivo']."' target='_blank' >".$arquivo[$i]['arquivo']."</a><br />";	
							
						}
						
						
						
						?></p>
						
					</div>
				</div>  
				

				<hr>
				<br /><br />
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<h3>Pendências</h3>
						<?php $pendencia = verificaEvento($_POST['carregar']);
						if($pendencia['erros'] == 0){
							echo "<p>Não há pendencias.</p>";
						}else{
							echo "<p>".$pendencia['relatorio']."</p>";		
						}
						
						
						?>
						
						
						<form action="aprovacao.php" method="POST" class="form-horizontal">
							<input type="hidden" name="idEvento" value="<?php echo $_POST['carregar']; ?>">
							<input type="submit" class="btn btn-theme btn-lg btn-block" name="enviar" value="Mudar Status do evento para 'Aprovado'" />
						</form>	
						
						<?php 
						
						
						

						?>

					</div>
				</div>  		

				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<?php if($evento['planejamento'] == 1){ ?>
							<form action="?" method="POST" class="form-horizontal">
								<input type="submit" class="btn btn-theme btn-lg btn-block" name="agenda" value="Atualizar Agenda" />
							</form>

						<?php } ?>
					</div>
				</div>  
				
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<?php if($evento['planejamento'] == 1){ ?>
							<form action="?" method="POST" class="form-horizontal">
								<input type="submit" class="btn btn-theme btn-lg btn-block" name="agenda" value="Atualizar Agenda" />
							</form>

						<?php } ?>
					</div>
				</div>  
				
				
				<?php
				break;
			}
			?>

			<?php
		}
		?>
		
	</div>
</section>

<?php 
break;
case "enviar":

?>

<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Enviar eventos fora do prazo</h1>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Título</th>
						<th>Data</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$sql_list =  "SELECT idEvento FROM sc_evento AND publicado ='1' AND status = '1' ORDER BY idEvento DESC";
					$res = $wpdb->get_results($sql_list,ARRAY_A);
					for($i = 0; $i < count($res); $i++){
						$evento = evento($res[$i]['idEvento']);
						
						?>
						<tr>
							<td><?php echo $res[$i]['idEvento']; ?></td>
							<td><?php echo $evento['titulo']; ?></td>
							<td><?php echo $evento['programa']; ?></td>
							<td><?php echo $evento['projeto']; ?></td>
							<td>	
								<form method="POST" action="?p=editar" class="form-horizontal" role="form">
									<input type="hidden" name="carregar" value="<?php echo $res[$i]['idEvento']; ?>" />
									<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
								</form>
								<?php 
								
								?></td>
							</tr>
						<?php } // fim do for?>	
						
					</tbody>
				</table>
			</div>

		</div>
	</section>
	<?php 
	break;
	case "pedido":
	if(isset($_GET['order'])){
		$order = ' ORDER BY nomeEvento ASC ';
	}else{
		$order = ' ORDER BY sc_evento.idEvento DESC ';
	}

	?>
	<section id="contact" class="home-section bg-white">
		<div class="container">
			<div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Pedidos de Contratação</h1>
					<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
				</div>
			</div>
			<div class="row">    
				<div class="col-md-offset-2 col-md-8">

				</div>
			</div>

			<?php 
		// se existe pedido, listar
			
			?>
			
			<div class="container">
				<div class="row">    
				</div>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Num</th>

								<th>Liberação</th>
								<th>Pessoa</th>
								<th>Nome / Razão Social</th>
								<th><a href="?p=pedido<?php if(isset($_GET['order'])){ echo ""; }else{ echo "&order"; }  ?>">Objeto</a></th>
								<th>Período</th>
								<th>Valor</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$idUser = $user->ID;
							if(isset($_GET['f'])){
								$f = "AND (liberado = '0000-00-00' OR nLiberacao = '') ";
							}else{
								$f = "";
							}
							
							

							$sql_seleciona = "SELECT DISTINCT idPedidoContratacao,sc_evento.idEvento, valor FROM sc_contratacao,sc_evento WHERE sc_contratacao.publicado = 1 AND sc_evento.dataEnvio IS NOT NULL AND (idUsuario = '$idUser' OR idResponsavel = '$idUser' OR idSuplente = '$idUser') AND sc_contratacao.idEvento = sc_evento.idEvento $order";
							
							$peds = $wpdb->get_results($sql_seleciona,ARRAY_A);
				//echo $sql_seleciona;
							
							for($i = 0; $i < count($peds); $i++){
								if($peds[$i]['idEvento'] != 0 AND $peds[$i]['idEvento'] != NULL){
									$pedido = retornaPedido($peds[$i]['idPedidoContratacao']);
								}else{
						//$pedido = atividade($peds[$i]['idAtividade']);
									$pedido = retornaPedido($peds[$i]['idPedidoContratacao']);
								}
					//var_dump($pedido);
								?>
								<tr>
									<td><?php echo $peds[$i]['idPedidoContratacao']; ?></td>
									<td><?php if($pedido['liberado'] != '0000-00-00'){echo exibirDataBr($pedido['liberado']);} ?></td>

									
									<td><?php echo $pedido['tipoPessoa']; ?></td>
									<td><?php echo $pedido['nome']; ?></td>
									<td><?php echo $pedido['objeto']; ?></td>
									<td><?php echo $pedido['periodo']; ?></td>
									<td><?php echo dinheiroParaBr($peds[$i]['valor']); ?></td>
									<?php if($pedido['tipo'] == 'Pessoa Física'){ ?>
										<td>	
											<form method="POST" action="contratacao.php?p=editar_pf" class="form-horizontal" role="form">
												<input type="hidden" name="editar_pf" value="<?php echo $peds[$i]['idPessoa']; ?>" />
												<input type="submit" class="btn btn-theme btn-sm btn-block" value="Editar Pessoa">
											</form>
										</td>
									<?php }else{ ?>
										<td>	
											<form method="POST" action="contratacao.php?p=editar_pj" class="form-horizontal" role="form">
												<input type="hidden" name="editar_pj" value="<?php echo $peds[$i]['idPessoa']; ?>" />
												<input type="submit" class="btn btn-theme btn-sm btn-block" value="Editar Pessoa">
											</form>
										</td>
									<?php } ?>

									<td>	
										<form method="POST" action="contratacao.php?p=editar_pedido" class="form-horizontal" role="form">
											<input type="hidden" name="editar_pedido" value="<?php echo $peds[$i]['idPedidoContratacao']; ?>" />
											<input type="submit" class="btn btn-theme btn-sm btn-block" value="Editar Pedido">
										</form>
										<?php 
										
										?></td>
										<td>	
											
											<?php 
											
											?></td>

										</tr>
									<?php } // fim do for?>	
									
								</tbody>
							</table>
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