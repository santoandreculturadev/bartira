<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'listarmetas';	
}
?>


<body>
	
	<?php include "menu/me_planomunicipal.php"; ?>
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
case "listarmetas": //Lista as contratações



// Insere Pessoa Física e Cria Pedido de Contratação
if(isset($_POST['inserir'])){


	$nome   = $_POST["nome"];
	$nomeartistico   = $_POST["nomeartistico"];
	$localnascimento   = $_POST["localnascimento"];
	$datanascimento   = exibirDataMysql($_POST["datanascimento"]);
	$cep   = $_POST["cep"];
	$numero   = $_POST["numero"];
	$complemento   = $_POST["complemento"];
	$telefone1   = $_POST["telefone1"];
	$telefone2   = $_POST["telefone2"];
	$telefone3   = $_POST["telefone3"];
	$email   = $_POST["email"];
	$biografia   = $_POST["biografia"];
	$area_atuacao   = $_POST["area_atuacao"];
	$local_atuacao   = $_POST["local_atuacao"];
	$acervo   = $_POST["acervo"];
	$links   = $_POST["links"];
	$culturaz   = $_POST["culturaz"];
	$usuario = $user->ID;
	$hoje = date('Y-m-d');

	$sql_sel = "SELECT id FROM sc_contatos WHERE nome = '$nome'";
	$y = $wpdb->get_results($sql_sel,ARRAY_A);
	if(count($y) == 0){
		

		
		
		
		$sql_inserir = "INSERT INTO `sc_contatos` (`nome`, `nome_artistico`, `telefone1`, `nascimento`, `area`, `local`, `bio`, `email`, `acervo`, `culturaz`, `atualizacao`, `publicado`, `telefone2`, `telefone3`, `cep`, `numero`, `complemento`,`local_atuacao`,`links`,`idUsuario`) VALUES ('$nome', '$nomeartistico', '$telefone1', '$datanascimento', '$area_atuacao', '$localnascimento', '$biografia', '$email', '$acervo', '$culturaz',  '$hoje', '1', '$telefone2', '$telefone3', '$cep', '$numero', '$complemento', '$local_atuacao','$links','$usuario')";

		$ins = $wpdb->query($sql_inserir);
		if($ins){
			$mensagem = alerta("Contato inserido com sucesso.","success");
		}else{
			$mensagem = alerta("Erro. Tente novamente.","warning");
		}
		
	}else{
		$mensagem = alerta("Nome já inserido.","warning");
	}
}

?>

<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Metas</h1>
				<h2></h2>
				<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
			</div>
		</div>
		<?php 
		$m = orderMeta();
		$sql_contatos = "SELECT * FROM sc_plano_municipal WHERE id IN ($m) ORDER BY meta ASC";
		$peds = $wpdb->get_results($sql_contatos,ARRAY_A);
		if(count($peds) > 0){
			?>
			
			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="row">    
					</div>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Objetivo</th>
									<th width="53%">Meta</th>
									<th>Versão</th>
									<th>P %</th>
									<th>Status</th>
									<th>Relatório</th>
									<th width="10%"></th>
									<th width="10%"></th>

								</tr>
							</thead>
							<tbody>
								<?php 
								for($i = 0; $i < count($peds); $i++){
									$status = statusPlano($peds[$i]['meta']);
									?>
									<tr>
										<td><?php echo $peds[$i]['objetivos']; ?></td>
										<td><a href="?p=relatorio_meta&meta=<?php echo $peds[$i]['meta'] ?>" target="_blank"><?php echo $peds[$i]['meta_descricao']; ?></a></td>
										<td><?php echo exibirDataBr($peds[$i]['data']); ?></td>
										<td><?php echo $status['execucao']."%"; ?></td>										
										<td><?php echo $status['status']; ?></td>										
										<td><?php echo $status['data']; ?></td>		
										<td>	
											<form method="POST" action="?p=editar" class="form-horizontal" role="form">
												<input type="hidden" name="editar" value="<?php echo $peds[$i]['id']; ?>" />
												<input type="submit" class="btn btn-theme btn-sm btn-block" value="Editar">
											</form>
											<?php 
											
											?></td>
										<td>
										<form method="POST" action="?p=editar" class="form-horizontal" role="form">
											<input type="hidden" name="versao" value="<?php echo $peds[$i]['id']; ?>" />
											<input type="submit" class="btn btn-theme btn-sm btn-block" value="Criar Versão">
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
		// se não existir, exibir
			}else{
				?>
				<div class="row">    
					<div class="col-md-offset-2 col-md-8">
						<center><h3>Não há metas.</h3></center>
						
					</div>
				</div>
				

				<?php 
		// fim do if existir pedido
			}
			?>
			
			
			
		</div>
	</section>


	<?php 
	break;
	case "editar":
	if(isset($_POST['editar'])){
		$contato = recuperaDados("sc_plano_municipal",$_POST['editar'],"id");
	}
	
if(isset($_POST['versao'])){
		$contato = recuperaDados("sc_plano_municipal",$_POST['versao'],"id");
		$sql_versao = "INSERT INTO `sc_plano_municipal` (`id`, `objetivos`, `objetivos_descricao`, `meta`, `meta_descricao`, `data`, `revisado`, `publicado`) VALUES (NULL, '".$contato['objetivos']."', '', '".$contato['meta']."', '[nova versão] ".$contato['meta_descricao']."', '".$contato['data']."', '".$contato['id']."', '1')";
		$id = $wpdb->query($sql_versao);
		$contato = recuperaDados("sc_plano_municipal",$wpdb->insert_id,"id");
		
	}
	
	
	
	if(isset($_POST['atualizar'])){
		$meta_descricao   = $_POST["meta_descricao"];
		$data   = exibirDataMysql($_POST["data"]);
		
		$upd = "UPDATE sc_plano_municipal SET 
		meta_descricao = '$meta_descricao',
		data = '$data'
		WHERE id = '".$_POST['atualizar']."'";

		$x = $wpdb->query($upd);
		if($x == 1){
			$mensagem = alerta("Contato atualizado com sucesso.","success");
		}else{
			$mensagem = alerta("Erro. Tente novamente.","warning");
			
		}	
		$contato = recuperaDados("sc_plano_municipal",$_POST['atualizar'],"id");
		
		
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

					<h2>Editar Meta</h2>
					<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

				</div>
			</div> 
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<form method="POST" action="?p=editar" class="form-horizontal" role="form">
						<div class="row">
							<div class="col-12">
								<label>Meta *</label>
							
							
								<textarea class="form-control"  name="meta_descricao" class="form-control"  rows="10"><?php echo $contato['meta_descricao'] ?></textarea>
							</div>
						</div>
						<br />
						<div class="row">
							<div class="col-12">
								<label>Data</label>
								<input type="text" class="form-control calendario" name="data" value="<?php echo exibirDataBr($contato['data']) ?>"> 
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-2">
								<input type="hidden" name="atualizar" value="<?php echo $contato['id']; ?>" />
								<?php 
								?>
								<input type="submit" class="btn btn-theme btn-lg btn-block" value="Atualizar Meta">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>	
	


	
	<?php 
	break;
	case "inserir_relatorio":
	
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

					<h2>Inserir Relatório de Progressão</h2>
					<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

				</div>
			</div> 
			<br />
			<br />
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<form method="POST" action="?p=editar_relatorio" class="form-horizontal" role="form">
						<div class="row">
							<div class="col-12">
							<label>Meta *</label>
								<select class="form-control" name="meta" id="inputSubject" >
										<option value='0'>Escolha uma opção</option>
										<?php echo geraOpcaoMeta() ?>
									</select>	
							</div>
						</div>
						<br />

						<br />
						<div class="row">
							<div class="col-6">
								<label>Execução * (em porcentagem)</label>
								<input type="text" class="form-control" name="execucao" > 
							</div>						<div class="col-6">
								<label>Data do relatório</label>
								<input type="text" class="form-control calendario" name="insert_date"> 
							</div>
						</div>	
						<br />
						<br />
						<div class="row">
							<div class="col-12">
								<label>Relatório </label>
								<textarea name="relatorio" class="form-control" rows="10" ></textarea>					
							</div>
						</div>
						<br />	
						<div class="row">
							<div class="col-12">
								<label>Análise dos fóruns </label>
								<textarea name="analise_foruns" class="form-control" rows="10" ></textarea>					
							</div>
						</div>
						<br />	
						<div class="row">
							<div class="col-12">
								<label>Status </label>
									<select class="form-control" name="status" id="inputSubject" >
										<option value='0'>Escolha uma opção</option>
										<?php echo geraTipoOpcao("meta") ?>
									</select>	
							</div>
						</div>
						<br />	


						
						<div class="form-group">
							<div class="col-md-offset-2">
								<input type="hidden" name="inserir" value="1" />
								<?php 
								?>
								<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir Relatório">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>	
	
	<?php 
	break;
	case "editar_relatorio":


	if(isset($_POST['carregar'])){
		$relatorio = recuperaDados("sc_plano_municipal_progressao",$_POST['carregar'],"id");
	}

	if(isset($_POST['inserir']) OR isset($_POST['editar'])){
		$meta = $_POST["meta"];
		$execucao = $_POST["execucao"];
		$insert_date = exibirDataMysql($_POST["insert_date"]);
		$relatorio = $_POST["relatorio"];
		$analise_foruns = $_POST["analise_foruns"];
		$status = $_POST["status"];
		
	}
	
	if(isset($_POST['inserir'])){
	

		$sql_insert = "INSERT INTO `sc_plano_municipal_progressao` (`id`, `meta`, `execucao`, `id_usuario`, `relatorio`, `analise_foruns`, `status`, `insert_date`, `publicado`) VALUES (NULL, '$meta', '$execucao', '$user->ID', '$relatorio', '$analise_foruns', '$status', '$insert_date', '1')";

		$insert = $wpdb->query($sql_insert);
		$id_relatorio =  $wpdb->insert_id;
		
		if($insert){
			$mensagem = "Relatório inserido com sucesso";
		}else{
			$mensagem = "Erro (1)";
		}
		
		$relatorio = recuperaDados("sc_plano_municipal_progressao",$id_relatorio,"id");
	}
	
	if(isset($_POST['editar'])){
		$id = $_POST['editar'];
		$sql_update = "UPDATE `sc_plano_municipal_progressao` SET `meta` = '$meta', `execucao` = '$execucao', `id_usuario` = '$user->ID', `relatorio` = '$relatorio', `analise_foruns` = '$analise_foruns', `status` = '$status', `insert_date` = '$insert_date'  WHERE `id` = '$id'";
		$atualizar = $wpdb->query($sql_update);
		if($atualizar){
			$mensagem = "Relatório atualizado com sucesso";
		}else{
			$mensagem = "Erro (2)<br />".$sql_update;
		}
		
		$relatorio = recuperaDados("sc_plano_municipal_progressao",$id,"id");
		
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

					<h2>Editar Relatório de Progressão</h2>
					<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

				</div>
			</div> 
			<br />
			<br />
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<form method="POST" action="?p=editar_relatorio" class="form-horizontal" role="form">
						<div class="row">
							<div class="col-12">
							<label>Meta *</label>
								<select class="form-control" name="meta" id="inputSubject" >
										<option value='0'>Escolha uma opção</option>
										<?php echo geraOpcaoMeta($relatorio['meta']) ?>
									</select>	
							</div>
						</div>
						<br />

						<br />
						<div class="row">
							<div class="col-6">
								<label>Execução * (em porcentagem)</label>
								<input type="text" class="form-control" name="execucao" value="<?php echo $relatorio['execucao']; ?>" > 
							</div>						<div class="col-6">
								<label>Data do relatório</label>
								<input type="text" class="form-control calendario" name="insert_date" value="<?php echo exibirDataBr($relatorio['insert_date']); ?>"> 
							</div>
						</div>	
						<br />
						<br />
						<div class="row">
							<div class="col-12">
								<label>Relatório </label>
								<textarea name="relatorio" class="form-control" rows="10" ><?php echo $relatorio['relatorio']; ?></textarea>					
							</div>
						</div>
						<br />	
						<div class="row">
							<div class="col-12">
								<label>Análise dos fóruns </label>
								<textarea name="analise_foruns" class="form-control" rows="10" ><?php echo $relatorio['analise_foruns']; ?></textarea>					
							</div>
						</div>
						<br />	
						<div class="row">
							<div class="col-12">
								<label>Status </label>
									<select class="form-control" name="status" id="inputSubject" >
										<option value='0'>Escolha uma opção</option>
										<?php echo geraTipoOpcao("meta",$relatorio['status']) ?>
									</select>	
							</div>
						</div>
						<br />	


						
						<div class="form-group">
							<div class="col-md-offset-2">
								<input type="hidden" name="editar" value="<?php echo $relatorio['id']; ?>" />
								<?php 
								?>
								<input type="submit" class="btn btn-theme btn-lg btn-block" value="Atualizar Relatório">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>	
	
	
	<?php 
	
	break;
	case "relatorio_meta": //Lista as contratações

	$meta = $_GET['meta'];
	$sql = "SELECT * FROM sc_plano_municipal WHERE meta = '$meta' AND publicado = '1' ORDER BY id DESC LIMIT 0,1";
	$res = $wpdb->get_row($sql,ARRAY_A);
	$status =   statusPlano($res['meta']);


?>

<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Metas</h1>
				<h2></h2>
				<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
			</div>
		</div>
		
		<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="row">    
					</div>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Objetivo</th>
									<th width="53%">Meta</th>
									<th>Versão</th>
									<th>P %</th>
									<th>Status</th>
									<th>Relatório</th>
									<th width="10%"></th>
									<th width="10%"></th>

								</tr>
							</thead>
							<tbody>
<tr>
										<td><?php echo $res['objetivos']; ?></td>
										<td><?php echo $res['meta_descricao']; ?></a></td>
										<td><?php echo exibirDataBr($res['data']); ?></td>
										<td><?php echo $status['execucao']."%"; ?></td>										
										<td><?php echo $status['status']; ?></td>										
										<td><?php echo $status['data']; ?></td>		
										<td>	
											<form method="POST" action="?p=editar" class="form-horizontal" role="form">
												<input type="hidden" name="editar" value="<?php echo $peds[$i]['id']; ?>" />
												<input type="submit" class="btn btn-theme btn-sm btn-block" value="Editar">
											</form>
											<?php 
											
											?></td>
										<td>
										<form method="POST" action="?p=editar" class="form-horizontal" role="form">
											<input type="hidden" name="versao" value="<?php echo $peds[$i]['id']; ?>" />
											<input type="submit" class="btn btn-theme btn-sm btn-block" value="Criar Versão">
										</form>
										</td>
										</tr>									
								</tbody>
							</table>
						</div>

					</div>
				</section>		
			
			
			
		</div>
	</section>
		
		
		<h1>Relatório de execução</h1>
		
		
		
		<?php 
		//$m = orderMeta();
		$sql_relatorios = "SELECT * FROM sc_plano_municipal_progressao WHERE meta = '$meta' AND publicado = '1' ORDER BY id DESC";
		$peds = $wpdb->get_results($sql_relatorios,ARRAY_A);
		
		if(count($peds) > 0){
			?>
			
			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="row">    
					</div>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Data</th>
									<th>Execução %</th>
									<th>Status</th>
									<th>Relatório</th>
									<th>Fóruns</th>
									<th>Usuário</th>
									<th width="10%"></th>


								</tr>
							</thead>
							<tbody>
								<?php 
								for($i = 0; $i < count($peds); $i++){
									$tipo = tipo($peds[$i]['status']);
									?>
									<tr>
										<td><?php echo exibirDataBr($peds[$i]['insert_date']); ?></td>
										<td><?php echo $peds[$i]['execucao']; ?></a></td>
										<td><?php echo $tipo['tipo']; ?></td>
										<td><?php echo nl2br($peds[$i]['relatorio']) ?></td>										
										<td><?php echo nl2br($peds[$i]['analise_foruns']); ?></td>										
										<td><?php echo $user->user_nicename; ?></td>	
										<td>	
											<form method="POST" action="?p=editar_relatorio" class="form-horizontal" role="form">
												<input type="hidden" name="carregar" value="<?php echo $peds[$i]['id']; ?>" />
												<input type="submit" class="btn btn-theme btn-sm btn-block" value="Editar">
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
		// se não existir, exibir
			}else{
				?>
				<div class="row">    
					<div class="col-md-offset-2 col-md-8">
						<center><h3>Não há metas.</h3></center>
						
					</div>
				</div>
				

				<?php 
		// fim do if existir pedido
			}
			?>
			
			
			
		</div>
	</section>

<?php 
	break;
	case "visaogeral": //Lista as contratações

?>


<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Metas</h1>
				<h2></h2>
				<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
			</div>
		</div>
		<?php 
		$m = orderMeta();
		$sql_contatos = "SELECT * FROM sc_plano_municipal WHERE id IN ($m) ORDER BY meta ASC";
		$peds = $wpdb->get_results($sql_contatos,ARRAY_A);
		if(count($peds) > 0){
			?>
			
			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="row">    
					</div>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Objetivo</th>
									<th width='50%'>Meta</th>
									<th>Versão</th>
									<th>P %</th>
									<th>Status</th>
									<th>Data Rel</th>
									<th>Relatório</th>
									<th>Fórum</th>
									<th>Valor Previsto</th>
									<th>Valor/Projeto/Ficha/Ano</th>

								</tr>
							</thead>
							<tbody>
								<?php 
								for($i = 0; $i < count($peds); $i++){
									$status = statusPlano($peds[$i]['meta']);
									$orc = metaOrcamento($peds[$i]['meta']);
									$orcp = metaOrcamento($peds[$i]['meta'],true);
									?>
									<tr>
										<td><?php echo $peds[$i]['objetivos']; ?></td>
										<td><a href="?p=relatorio_meta&meta=<?php echo $peds[$i]['meta'] ?>" target="_blank"><?php echo $peds[$i]['meta_descricao']; ?></a></td>
										<td><?php echo exibirDataBr($peds[$i]['data']); ?></td>
										<td><?php echo $status['execucao']."%"; ?></td>										
										<td><?php echo $status['status']; ?></td>										
										<td><?php echo $status['data']; ?></td>		
										<td><?php echo $status['relatorio']; ?></td>
										<td><?php echo $status['forum']; ?></td>
										<td>
										<?php 
										foreach ($orc as $chave => $valor) {
											echo dinheiroParaBr($valor)." (".$chave."),  ";
											// Na variável $chave vai ter a chave da iteração atual (cpf, titular ou saldo)
											// Na variável $valor você vai ter o valor referente à chave atual
										}
										
										?>
										
										
										</td>
										<td>
										<?php
											for($j = 0; $j < count($orcp); $j++){
												echo dinheiroparaBr($orcp[$j]['valor'])."/".$orcp[$j]['projeto']."/".$orcp[$j]['ficha']."/".$orcp[$j]['ano_base']."<br />";
											}

										?>
										
										</td>
										
										</tr>
									<?php } // fim do for?>	
									
								</tbody>
							</table>
						</div>

					</div>
				</section>		
				<?php 
		// se não existir, exibir
			}else{
				?>
				<div class="row">    
					<div class="col-md-offset-2 col-md-8">
						<center><h3>Não há metas.</h3></center>
						
					</div>
				</div>
				

				<?php 
		// fim do if existir pedido
			}
			?>
			
			
			
		</div>
	</section>

	
	
	
	<?php 
	break;
	case "buscar":

	if(isset($_POST['busca'])){
		$busca = $_POST['busca'];
		$sql_contatos = "SELECT * FROM sc_contatos WHERE 
		nome LIKE '%$busca%' OR
		nome_artistico LIKE '%$busca%' OR
		area LIKE '%$busca%' OR
		local LIKE '%$busca%' OR
		bio LIKE '%$busca%' OR
		email LIKE '%$busca%' OR
		acervo LIKE '%$busca%' OR
		local_atuacao LIKE '%$busca%' OR
		links LIKE '%$busca%'

		
		
		ORDER BY nome ASC";
		$peds = $wpdb->get_results($sql_contatos,ARRAY_A);
		if(count($peds) > 0){
			?>
			<h2>Resultados para "<?php echo $busca ?>"</h2>
			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="row">    
					</div>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Nome Artístico</th>
									<th>Email</th>
									<th>Telefone</th>
									<th>Área</th>
									<th></th>

								</tr>
							</thead>
							<tbody>
								<?php 
								for($i = 0; $i < count($peds); $i++){
									?>
									<tr>
										<td><?php echo $peds[$i]['nome']; ?></td>
										<td><?php echo $peds[$i]['nome_artistico']; ?></td>
										<td><?php echo $peds[$i]['email']; ?></td>
										<td><?php echo $peds[$i]['telefone1']."/".$peds[$i]['telefone2']."/".$peds[$i]['telefone3']; ?></td>
										<td><?php echo $peds[$i]['area']; ?></td>
										<td>	
											<form method="POST" action="?p=editar" class="form-horizontal" role="form">
												<input type="hidden" name="editar" value="<?php echo $peds[$i]['id']; ?>" />
												<input type="submit" class="btn btn-theme btn-sm btn-block" value="Editar">
											</form>
											<?php 
											
											?></td>

										</tr>
				<?php } // fim do for
				
			}else{ //fim do if ?>	
				<h3>Não foram encontrados registros para a pesquisa. <a href="?p=buscar">Tente novamente</a>.</h3>
			<?php } ?>
			
		</tbody>
	</table>
</div>

</div>
</section>	
<?php 
}else{

	?>
	<section id="inserir" class="home-section bg-white">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-2 col-md-8">

					<h2>Busca Contato</h2>
					
				</div>
			</div> 
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<form method="POST" action="?p=buscar" class="form-horizontal" role="form">
						<div class="row">
							<div class="col-12">
								<label>Digite pelo menos 3 caracteres</label>
								<input type="text" name="busca" class="form-control" id="inputSubject" />
							</div>
						</div><br />
						<div class="form-group">
							<div class="col-md-offset-2">
								<input type="hidden" name="buscar" value="1" />
								<?php 
								?>
								<input type="submit" class="btn btn-theme btn-lg btn-block" value="Busca">
							</div>
						</div>
					</form>
				</div>
			</section>	
		<?php } ?>
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