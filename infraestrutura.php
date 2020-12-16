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
	
	<?php include "menu/me_infraestrutura.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<?php 
		switch($p){
			case "inicio": 

			if(isset($_SESSION['id'])){
				unset($_SESSION['id']);
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
		gravarLog($sql_enviar, $user->ID);
	}else{
		$mensagem = alerta("Erro. Tente novamente.","warning");
		gravarLog($sql_enviar, $user->ID);
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
						<th>Total</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$idUser = $user->ID;
					$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND idEvento IN(SELECT DISTINCT id_evento from sc_producao)  ORDER BY idEvento DESC";					
					$res = $wpdb->get_results($sql_list,ARRAY_A);
					for($i = 0; $i < count($res); $i++){
						$evento = evento($res[$i]['idEvento']);
						
						?>
						<tr>
							<td><?php echo $res[$i]['idEvento']; ?></td>
							<td>
								<?php
								if($idUser == 63 OR $idUser == 1 OR $idUser == 5 OR $idUser == 77){
									?>
									<a href="busca.php?p=view&tipo=evento&id=<?php echo $res[$i]['idEvento'] ?>" target=_blank>
									<?php  } ?>
									<?php echo $evento['titulo']; ?>
									<?php
									if($idUser == 63 OR $idUser == 1 OR $idUser == 5 OR $idUser == 77){
										?>
									</a>
								<?php } ?>
							</td>

							
							<td><?php echo $evento['periodo']['legivel']; ?></td>
							<td><?php 
							$valor = infraAta($res[$i]['idEvento']);
							echo dinheiroParaBr($valor['total']);

							?></td>
							<td>	
								<form method="POST" action="?p=editar" class="form-horizontal" role="form">
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
case "editar": 
if(isset($_SESSION['idPessoa'])){
	unset($_SESSION['idPessoa']);
	unset($_SESSION['tipo']);
}

if(isset($_POST['carregar'])){
	$_SESSION['id'] = $_POST['carregar'];
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

$valor = infraAta($_SESSION['id']); 

?>

<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Infraesturtura</h1>
				<h2><?php echo $n;?> / Total:<?php echo dinheiroParaBr($valor['total']);?> </h2>
				<?php 
				for($i = 0; $i < count($valor) - 1; $i++){
					?>
					<?php if($valor[$i]['total'] != 0){ ?>
						<p><?php echo $valor[$i]['razao_social']?> : <?php echo dinheiroParaBr($valor[$i]['total']); ?> </p>
					<?php } ?>

					<?php	
				}
				?>
				<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
			</div>
		</div>
		<?php 
		// se existe pedido, listar
		$total = 0;
		$sql = "SELECT * FROM sc_ata WHERE ano_base = '2019' ORDER BY cod";
		$peds = $wpdb->get_results($sql,ARRAY_A);
		?>
		
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
							<form method="POST" action="?p=editar" class="form-horizontal" role="form">
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
					case "enviar":
					$event = evento($_SESSION['id']);
					?>

					<section id="contact" class="home-section bg-white">
						<div class="container">
							<div class="row">    
								<div class="col-md-offset-2 col-md-8">
									<h1><?php echo $event['nomeEvento']; ?></h1>
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
										$sql_list =  "SELECT idEvento FROM sc_evento ORDER BY idEvento DESC";
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
						?>
						<section id="contact" class="home-section bg-white">
							<div class="container">
								<div class="row">    
									<div class="col-md-offset-2 col-md-8">
										<h1>Gerar Pedidos de Contratação</h1>
										<?php if(isset($mensagem)){echo $mensagem;}?>
									</div>
								</div>
								<div class="table-responsive">
									<form method="POST" action="?p=gerar" class="form-horizontal" role="form">
										<label>Título da atividade</label>
										<input type="text" name="titulo" class="form-control cpf">
										<table class="table table-striped">
											<thead>
												<tr>
													
													<th>#</th>
													<th>Título</th>
													<th>Data</th>
													<th>Total</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												global $wpdb;
												$idUser = $user->ID;
												$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND idEvento IN(SELECT DISTINCT id_evento from sc_producao) ORDER BY idEvento DESC";					
												$res = $wpdb->get_results($sql_list,ARRAY_A);
												for($i = 0; $i < count($res); $i++){
													$evento = evento($res[$i]['idEvento']);
													
													?>
													<tr>
														<td><center><input type="checkbox" class="form-check-input" id="exampleCheck1" name="<?php echo $res[$i]['idEvento'] ?>"></center></td>
														<td>
															<?php
															if($idUser == 63 OR $idUser == 1 OR $idUser == 5 OR $idUser == 77){
																?>
																<a href="busca.php?p=view&tipo=evento&id=<?php echo $res[$i]['idEvento'] ?>" target=_blank>
																<?php  } ?>
																<?php echo $evento['titulo']; ?>
																<?php
																if($idUser == 63 OR $idUser == 1 OR $idUser == 5 OR $idUser == 77){
																	?>
																</a>
															<?php } ?>
														</td>

														
														<td><?php echo $evento['periodo']['legivel']; ?></td>
														<td><?php 
														$valor = infraAta($res[$i]['idEvento']);
														echo dinheiroParaBr($valor['total']);

														?></td>
													</tr>
												<?php } // fim do for?>	
												
											</tbody>
										</table>
										<input type="submit" name="Gerar" value="Gerar" class="btn btn-primary">
									</form>
									
								</div>

							</div>
						</section>
						<?php 
						break;
						case "gerar":
						if($_POST['titulo'] == ''){
							$mensagem = "É preciso que a atividade tenha um título. Tente novamente.";
						}else{
	// Insere a atividade	
							$nomeEvento = addslashes($_POST["titulo"]);
							$ano    = date('Y');
							$descricao = "Infraestrutura para os seguintes eventos:";
							$idUser = $user->ID;
							$sql = "INSERT INTO `sc_atividade` (`titulo`, `ano_base`, `descricao`, `id_usuario`, `publicado`) 
							VALUES ('$nomeEvento', '$ano', '$descricao', '$idUser', '1')";
							$ins = $wpdb->query($sql);
							if($ins){
								$mensagem = "<div class='alert alert-success'>Atividade criado com sucesso.</div>";
								$id_atividade = $wpdb->insert_id;
		// Insere os pedidos
		// lista de eventos 
								$eventos = "";
								$str_eventos = "";
								foreach($_POST as $post=>$valor){
									if($post != 'titulo' AND $post != 'Gerar' ){
										$eventos .= $post.",";
										$e = evento($post); 
										$str_eventos .= $e['titulo'].", ";
									}	
								}
								$descricao .= substr($str_eventos,0,-1);
								$upd = "UPDATE sc_atividade SET descricao = '$descricao' WHERE id = '$id_atividade'";
								$wpdb->query($upd);
								$eventos = substr($eventos,0,-1);
		//verifica as empresas
								$sql_empresas = "SELECT DISTINCT pj FROM sc_ata";
								$emp = $wpdb->get_results($sql_empresas,ARRAY_A);
								for($i = 0; $i < count($emp); $i++){
									$idPj = $emp[$i]['pj'];
			// recupera todos os objetos da ata
									$sql_soma = "SELECT * FROM sc_producao WHERE id_evento IN($eventos) AND id_ata IN(SELECT id FROM sc_ata WHERE pj = '$idPj')";
			//echo $sql_soma;
									$soma = $wpdb->get_results($sql_soma,ARRAY_A);
									$t = 0;
									for($k =0;$k < count($soma); $k++){
										$v = recuperaDados("sc_ata",$soma[$k]['id_ata'],"id");
				//echo "<pre>";
				//var_dump($v);
				//echo "</pre>";
										$t = $t + ($soma[$k]['quantidade'] * $v['valor_diaria']);
				//$mensagem .= $t."<br />";
									}
									
									if($t != 0){	
			// insere pedido
										$idUsuario = $user->ID;
										$evento = $id_atividade;
										$pessoa = 2;
										$id_pessoa = $idPj;
										$valor = $t;
										$sql_insere_pedido = "INSERT INTO `sc_contratacao` (`idAtividade`, `tipoPessoa`, `idPessoa`, `valor`,  `publicado`, `ano_base`) 
										VALUES ('$evento', '2', '$id_pessoa','$valor', '1', '2019')";
										$query_pedido = $wpdb->query($sql_insere_pedido);
										if($wpdb->insert_id > 0){
											$mensagem .= '<div class="alert alert-success">Pedido criado com sucesso.</div>';
										}else{
											$mensagem .= '<div class="alert alert-warning">Erro ao criar Pedido.</div>';
										}
									}
								}
							}
						}
						
						?>
						<section id="contact" class="home-section bg-white">
							<div class="container">
								<div class="row">    
									<div class="col-md-offset-2 col-md-8">
										<h1>Gerar Pedidos de Contratação</h1>
										<?php if(isset($mensagem)){echo $mensagem;}?>
									</div>
								</div>
								<div class="row">
									<div class="col-md-offset-1 col-md-10">
										<div class="col-md-offset-2">
											<p>É preciso definir os projetos e fichas dos pedidos de contratação para gerar a liberação de verba. <a href="atividade.php">Clique aqui</a>.</p>
										</div>
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