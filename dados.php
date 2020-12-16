<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'visaogeral';	
}
//session_start();
$_SESSION['entidade'] = 'orcamento';
?>

<style>
@media(min-width: 1400px){
	.container{
		margin-left: 0px !important;
		width: 1400px !important;
	}
}
</style>
<body>
	
	<?php include "menu/me_dados.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<?php 
		switch($p){
			case "inicio": 
			case "listar": 
			if(isset($_SESSION['id'])){
				unset($_SESSION['id']);
			}

			if(isset($_POST['apagar'])){
				$id = $_POST['apagar'];
				$sql_upd = "UPDATE `sc_orcamento` SET `publicado` = '0' WHERE `id` = '$id'";
				$upd = $wpdb->query($sql_upd);
				if($upd == 1){
					$mensagem = alerta("Dotação apagada com sucesso.","success");
				}else{
					$mensagem = alerta("Erro [1]. ","warning");
				}
				
			}

			?>
			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="row">    
						<div class="col-md-offset-2 col-md-8">
							<h1>Dotações</h1>
							<?php if(isset($mensagem)){echo $mensagem;}?>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Projeto</th>
									<th>Descrição</th>
									<th>Ficha</th>

									<th>Dotação</th>
									<th>Descricao</th>
									<th>Valor</th>
									<th>Ano Base</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								global $wpdb;
								$sql_list =  "SELECT * FROM sc_orcamento WHERE planejamento = '0' AND publicado = '1' ORDER BY projeto ASC, ficha ASC";
								$res = $wpdb->get_results($sql_list,ARRAY_A);
								for($i = 0; $i < count($res); $i++){
									
									?>
									<tr>
										<td><?php echo $res[$i]['projeto']; ?></td>
										<td><?php echo $res[$i]['ficha']; ?></td>

										<td><?php echo $res[$i]['dotacao']; ?></td>
										<td><?php echo $res[$i]['descricao']; ?></td>
										<td><?php echo dinheiroParaBr($res[$i]['valor']); ?></td>
										<td><?php echo $res[$i]['ano_base']; ?></td>
										<td>	
											<form method="POST" action="?p=editar" class="form-horizontal" role="form">
												<input type="hidden" name="carregar" value="<?php echo $res[$i]['id']; ?>" />
												<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
											</form>
											<?php 
											
											?></td>
											<td>	
												<form method="POST" action="?p=listar" class="form-horizontal" role="form">
													<input type="hidden" name="apagar" value="<?php echo $res[$i]['id']; ?>" />
													<input type="submit" class="btn btn-theme btn-sm btn-block" value="Apagar">
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
					case "inserir":
					if(isset($_SESSION['id'])){
						unset($_SESSION['id']);
					}

					?>
					<script type="application/javascript">
						$(function()
						{
							$('#programa').change(function()
							{
								if( $(this).val() )
								{
									$('#projeto').hide();
									$('.carregando').show();
									$.getJSON('inc/projeto.ajax.php?programa=',{programa: $(this).val(), ajax: 'true'}, function(j)
									{
										var options = '<option value="0"></option>';	
										for (var i = 0; i < j.length; i++)
										{
											options += '<option value="' + j[i].id + '">' + j[i].projeto + '</option>';
										}	
										$('#projeto').html(options).show();
										$('.carregando').hide();
									});
								}
								else
								{
									$('#projeto').html('<option value="">-- Escolha um projeto --</option>');
								}
							});
						});
					</script>

					<section id="inserir" class="home-section bg-white">
						<div class="container">
							<div class="row">
								<div class="col-md-offset-2 col-md-8">

									<h3>Dotação</h3>
									<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

								</div>
							</div> 
							<div class="row">
								<div class="col-md-offset-1 col-md-10">
									<form method="POST" action="?p=editar" class="form-horizontal" role="form">
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Unidade</label>
												<select class="form-control" name="unidade" id="projeto" >
													<option>Escolha uma opção</option>
													<?php geraTipoOpcao('unidade'); ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Projeto *</label>
												<input type="text" name="projeto" class="form-control" id="inputSubject" />
											</div>
										</div>

										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Ficha *</label>
												<input type="text" name="ficha" class="form-control" id="inputSubject" />
											</div> 
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Dotação *</label>
												<input type="text" name="dotacao" class="form-control" id="inputSubject" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Descricao *</label>
												<input type="text" name="descricao" class="form-control" id="inputSubject" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Natureza *</label>
												<input type="text" name="natureza" class="form-control" id="inputSubject" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Fonte</label>
												<select class="form-control" name="fonte" id="projeto" >
													<option value="1" >1</option>							
													<option value="2" >2</option>							
													<option value="3" >3</option>							
													<option value="4" >4</option>							
													<option value="5" >5</option>							
													<option value="6" >6</option>							

												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Valor</label>
												<input type="text" name="valor" class="form-control" id="inputSubject" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Ano Base</label>
												<input type="text" name="ano" class="form-control" id="inputSubject" value="2018" />
											</div> 
										</div>

										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Observação</label>
												<textarea name="autor" class="form-control" rows="10" ></textarea>
											</div> 
										</div>
										
										<div class="form-group">
											<div class="col-md-offset-2">
												<input type="hidden" name="inserir" value="1" />
												<?php 
												?>
												<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir">
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</section>



					<?php 
					break;
					case "editar":
					global $wpdb;	

					if((isset($_POST['inserir'])) OR (isset($_POST['atualizar']))){
						$projeto = $_POST["projeto"];
						$ficha  = $_POST["ficha"];
						$dotacao = $_POST["dotacao"];
						$descricao  = $_POST["descricao"];
						$natureza   = $_POST["natureza"];
						$fonte   = $_POST["fonte"];
						$unidade = $_POST['unidade'];
						$valor  = dinheiroDeBr($_POST["valor"]);
						$ano_base  = $_POST["ano"];
						$obs  = addslashes($_POST["autor"]);
					}
					$idUser = $user->ID;
					
					if(isset($_POST['inserir'])){
						$sql = "INSERT INTO `sc_orcamento` (`projeto`, `ficha`, `unidade`, `dotacao`, `descricao`, `natureza`, `fonte`,  `valor`, `obs`, `publicado`, `idUsuario`, `ano_base`) 
						VALUES ('$projeto','$ficha', '$unidade', '$dotacao', '$descricao', '$natureza', '$fonte', '$valor', '$obs', '1', '$idUser', '$ano_base')";	
						$r = $wpdb->query($sql);
						if($r == 1){
							$mensagem = alerta("Dotação inserida com sucesso.","sucess");	
						}else{
							$mensagem = alerta("Erro[2]. Tente novamente.","warning");				
						}
						$orcamento =  recuperaDados('sc_orcamento',$wpdb->insert_id,'id');	
						
					}

					if(isset($_POST['atualizar'])){
						$idOrc = $_POST['atualizar'];
						$sql = "UPDATE sc_orcamento SET
						`projeto` = '$projeto', 
						`ficha` = '$ficha', 
						`dotacao` = '$dotacao', 
						`descricao` = '$descricao', 
						`natureza` = '$natureza', 
						`fonte` = '$fonte',  
						`valor`= '$valor', 
						`obs` = '$obs', 
						`unidade` = '$unidade', 
						`idUsuario` =  '$idUser', 
						`ano_base` = '$ano_base'
						WHERE id = '$idOrc'
						"; 	
		//echo $sql;
						$r = $wpdb->query($sql);
						if($r == 1){
							$mensagem = alerta("Dotação inserida com sucesso.","sucess");	
						}else{
							$mensagem = alerta("Erro[3]. Tente novamente.","warning");				
						}

						$orcamento =  recuperaDados('sc_orcamento',$idOrc,'id');	
					}
					
					if(isset($_POST['carregar'])){
						$orcamento =  recuperaDados('sc_orcamento',$_POST['carregar'],'id');	
					}
					
					
					?>
					<script type="application/javascript">
						$(function()
						{
							$('#programa').change(function()
							{
								if( $(this).val() )
								{
									$('#projeto').hide();
									$('.carregando').show();
									$.getJSON('inc/projeto.ajax.php?programa=',{programa: $(this).val(), ajax: 'true'}, function(j)
									{
										var options = '<option value="0"></option>';	
										for (var i = 0; i < j.length; i++)
										{
											options += '<option value="' + j[i].id + '">' + j[i].projeto + '</option>';
										}	
										$('#projeto').html(options).show();
										$('.carregando').hide();
									});
								}
								else
								{
									$('#projeto').html('<option value="">-- Escolha um projeto --</option>');
								}
							});
						});
					</script>

					<section id="inserir" class="home-section bg-white">
						<div class="container">
							<div class="row">
								<div class="col-md-offset-2 col-md-8">

									<h3>Dotação</h3>
									<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

								</div>
							</div> 
							<div class="row">
								<div class="col-md-offset-1 col-md-10">
									<form method="POST" action="?p=editar" class="form-horizontal" role="form">
					<!-- Verificar com a área
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Visualizar?</label>
							<select class="form-control" name="visualizar" id="projeto" >
							<option value='0'></option>
							<option value='1'></option>
							
							</select>
						</div>
					</div>-->

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Unidade</label>
							<select class="form-control" name="unidade" id="projeto" >
								<option>Escolha uma opção</option>
								<?php geraTipoOpcao('unidade',$orcamento['unidade']); ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Projeto *</label>
							<input type="text" name="projeto" class="form-control" id="inputSubject" value="<?php echo $orcamento['projeto']; ?>"/>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Ficha *</label>
							<input type="text" name="ficha" class="form-control" id="inputSubject" value="<?php echo $orcamento['ficha']; ?>"/>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Dotação *</label>
							<input type="text" name="dotacao" class="form-control" id="inputSubject" value="<?php echo $orcamento['dotacao']; ?>"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Natureza *</label>
							<input type="text" name="natureza" class="form-control" id="inputSubject" value="<?php echo $orcamento['natureza']; ?>"/>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Descricao *</label>
							<input type="text" name="descricao" class="form-control" id="inputSubject" value="<?php echo $orcamento['descricao']; ?>"/>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Fonte</label>
							<select class="form-control" name="fonte" id="projeto" >
								<option value="1" <?php checado($orcamento['fonte'],array(1)); ?>>1</option>							
								<option value="2" <?php checado($orcamento['fonte'],array(2)); ?>>2</option>							
								<option value="3" <?php checado($orcamento['fonte'],array(3)); ?>>3</option>							
								<option value="4" <?php checado($orcamento['fonte'],array(4)); ?>>4</option>							
								<option value="5" <?php checado($orcamento['fonte'],array(5)); ?>>5</option>							
								<option value="6" <?php checado($orcamento['fonte'],array(6)); ?>>6</option>							

							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Valor</label>
							<input type="text" name="valor" class="form-control" id="inputSubject" value="<?php echo dinheiroParaBr($orcamento['valor']); ?>"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Ano Base</label>
							<input type="text" name="ano" class="form-control" id="inputSubject" value="<?php echo $orcamento['ano_base']; ?>"/>
						</div> 
					</div>

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Observação</label>
							<textarea name="autor" class="form-control" rows="10" ><?php echo $orcamento['obs']; ?></textarea>
						</div> 
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="atualizar" value="<?php echo $orcamento['id']; ?>" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Atualizar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>


<?php 
break;
case "mov_inserir":
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
<section id="inserir" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">

				<h3>Movimentação Orçamentária</h3>
				<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=mov_editar" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Titulo *</label>
							<input type="text" name="titulo" class="form-control" id="inputSubject" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Tipo de movimentação</label>
							<select class="form-control" name="tipo" id="inputSubject" >
								<option>Escolha uma opção</option>
								<?php echo geraTipoOpcao("mov_orc") ?>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Dotação</label>
							<select class="form-control" name="dotacao" id="inputSubject" >
								<option>Escolha uma opção</option>
								<?php 
								if(isset($_POST['id'])){
									echo geraOpcaoDotacao('2018',$_POST['id']); 
								}else{
									echo geraOpcaoDotacao('2018'); 
								}	
								?>
								
							</select>
						</div>
					</div>	
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Valor *</label>
							<input type="text" name="valor" class="form-control valor" id="inputSubject" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Data *</label>
							<input type="text" name="data" class="form-control calendario"  />
						</div>
					</div>					
					
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Descição / Observação*</label>
							<textarea name="descricao" class="form-control" rows="10" ></textarea>
						</div> 
					</div>	
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="mov_inserir" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir Movimentação">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<?php 
break;
case "mov_editar":

if(isset($_POST['carregar'])){
	$id_orc = $_POST['carregar'];
	$mov = $wpdb->get_row("SELECT * FROM sc_mov_orc WHERE id =  '$id_orc'",ARRAY_A);
}

if(isset($_POST['mov_inserir']) OR isset($_POST['mov_editar']) ){
	$titulo = addslashes($_POST["titulo"]);
	$tipo = $_POST["tipo"];
	$dotacao = $_POST["dotacao"];
	$valor = dinheiroDeBr($_POST["valor"]);
	if($_POST["data"] = '' OR $_POST["data"] = '0000-00-00'){
		$data = date('Y-m-d');
	}else{
		$data = exibirDataMysql($_POST["data"]);	
	}
	$descricao = addslashes($_POST["descricao"]);
}

if(isset($_POST['mov_inserir'])){
	global $wpdb;
	$idUsuario = $user->ID;
	$sql = "INSERT INTO `sc_mov_orc` (`titulo`, `tipo`, `idOrc`, `data`, `valor`, `descricao`, `idUsuario`, `publicado`) 
	VALUES ('$titulo', '$tipo', '$dotacao', '$data', '$valor', '$descricao', '$idUsuario', '1')";
	$ins = $wpdb->query($sql);
	$id_orc = $wpdb->insert_id;
	if($ins == 1){
		$mensagem = alerta("Movimentação inserida com sucesso.","sucess");	
	}else{
		$mensagem = alerta("Erro[4]. Tente novamente.","warning");				
	}

	$mov = $wpdb->get_row("SELECT * FROM sc_mov_orc WHERE id =  '$id_orc'",ARRAY_A);
	
}

if(isset($_POST['mov_editar'])){
	$id_orc = $_POST['mov_editar'];
	global $wpdb;
	$idUsuario = $user->ID;
	$sql = "UPDATE `sc_mov_orc` SET
	`titulo` = '$titulo', 
	`tipo` = '$tipo', 
	`idOrc` = '$dotacao', 
	`data` = '$data', 
	`valor` = '$valor', 
	`descricao` = '$descricao', 
	`idUsuario` = '$idUsuario'
	WHERE id = '$id_orc'";
	$ins = $wpdb->query($sql);
	if($ins == 1){
		$mensagem = alerta("Movimentação atualizada com sucesso.","sucess");	
	}else{
		$mensagem =  alerta("Erro. Tente novamente.","warning");	
	}
	$mov = $wpdb->get_row("SELECT * FROM sc_mov_orc WHERE id =  '$id_orc'",ARRAY_A);
	
}


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



</script>
<section id="inserir" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">

				<h3>Movimentação Orçamentária</h3>
				<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=mov_editar" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Titulo *</label>
							<input type="text" name="titulo" class="form-control" id="inputSubject" value="<?php echo $mov['titulo'] ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Tipo de movimentação</label>
							<select class="form-control" name="tipo" id="inputSubject" >
								<option value='0'>Escolha uma opção</option>
								<?php echo geraTipoOpcao("mov_orc",$mov['tipo']) ?>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Dotação</label>
							<select class="form-control" name="dotacao" id="inputSubject" >
								<option value='0'>Escolha uma opção</option>
								<?php echo geraOpcaoDotacao('2018',$mov['dotacao']); ?>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Valor *</label>
							<input type="text" name="valor" class="form-control valor" id="inputSubject"  value="<?php echo dinheiroParaBr($mov['valor']) ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Data *</label>
							<input type="text" name="data" class="form-control calendario"   value="<?php echo exibirDataBr($mov['data']) ?>"/>
						</div>
					</div>					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Descição / Observação*</label>
							<textarea name="descricao" class="form-control" rows="10" ><?php echo $mov['descricao'] ?></textarea>
						</div> 
					</div>	
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="mov_editar" value="<?php echo $mov['id'] ?>" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Atualizar Movimentação">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<?php 
break;
case "mov_listar":
if(isset($_POST['deletar'])){
	$mensagem = "Teste 123";
	global $wpdb;
	$id = $_POST['deletar'];
	$sql_del = "UPDATE sc_mov_orc SET publicado = '0' WHERE id = '$id'";
	$upd = $wpdb->query($sql_del);
	if($upd == 1){
		$mensagem = alerta("Movimentação deletada com sucesso.","success");	
	}else{
		$mensagem = alerta("Erro. Tente novamente.","warning");	
		
	}
	
}

?>

<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Movimentações Orçamentárias</h1>
				<?php if(isset($mensagem)){echo $mensagem;}?>
			</div>
			
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Data</th>
						<th>Título</th>
						<th>Projeto/Ficha/Natureza</th>
						<th>Tipo</th>
						<th>Valor</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>

					<?php 
					global $wpdb;
					$sql_list =  "SELECT * FROM sc_mov_orc WHERE publicado = '1' ORDER BY data DESC";
					$res = $wpdb->get_results($sql_list,ARRAY_A);
					for($i = 0; $i < count($res); $i++){
						$dot = recuperaDados("sc_orcamento",$res[$i]['idOrc'],"id");
						$tipo = tipo($res[$i]['tipo']);
						?>
						<tr>
							<td><?php echo $res[$i]['id']; ?></td>

							<td><?php echo exibirDataBr($res[$i]['data']); ?></td>
							<td><?php echo $res[$i]['titulo']; ?></td>
							<td><?php echo $dot['projeto']." / ".$dot['ficha']." / ".$dot['natureza']; ?></td>
							<td><?php echo $tipo['tipo']; ?></td>
							<td><?php echo dinheiroParaBr($res[$i]['valor']); ?></td>
							<td>	
								<form method="POST" action="?p=mov_editar" class="form-horizontal" role="form">
									<input type="hidden" name="carregar" value="<?php echo $res[$i]['id']; ?>" />
									<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
								</form>
								<?php 
								
								?></td>
								<td>
									<form method="POST" action="?p=mov_listar" class="form-horizontal" role="form">
										<input type="hidden" name="deletar" value="<?php echo $res[$i]['id']; ?>" />
										<input type="submit" class="btn btn-theme btn-sm btn-block" value="Deletar">
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
	case "visaogeral": 

	if(isset($_GET['unidade']) AND $_GET['unidade'] != 0 ){
		$unidade = " AND unidade ='".$_GET['unidade']."' ";	
	}else{
		$unidade = "";
	}

	if(isset($_GET['fonte']) AND $_GET['fonte'] != 0 ){
		$fonte = " AND fonte ='".$_GET['fonte']."' ";
		$fonte_option = $_GET['fonte']; 	
	}else{
		$fonte = "";
		$fonte_option = 0; 	

	}


	if(isset($_GET['ano'])){
		$ano = " AND ano_base = '".$_GET['ano']."' ";	
	}else{
		$ano = " AND ano_base = '2018' ";	
	}

	if(isset($_GET['projeto']) AND $_GET['projeto'] != 0 ){
		$projeto = " AND projeto = '".$_GET['projeto']."' ";	
	}else{
		$projeto = "";	
	}

	if(isset($_GET['ficha']) AND $_GET['ficha'] != 0){
		$ficha = " AND ficha = '".$_GET['ficha']."' ";	
	}else{
		$ficha = "";	
	}

//filtros projeto e ficha
	?>
	<section id="contact" class="home-section bg-white">
		<div class="container">
			<div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Dotações</h1>
				</div>
			</div>
			<h3>Filtro</h3>
			<div class="col-md-offset-1 col-md-10">
				<form method="GET" action="orcamento.php?p=visaogeral&ano=2018" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Unidade *</label>
							<select class="form-control" name="unidade" id="inputSubject" >
								<option value='0'>Escolha uma opção</option>
								<?php echo geraTipoOpcao('unidade',$_GET['unidade']); ?>
								<option value='0'>Todas as unidades</option>
							</select>
						</div>
					</div>		
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Fonte *</label>
							<select class="form-control" name="fonte" id="inputSubject" >
								<option value= '0'>Escolha uma opção</option>
								<option <?php echo select(1,$fonte_option) ?> >1</option>
								<option <?php echo select(2,$fonte_option) ?> >2</option>
								<option <?php echo select(3,$fonte_option) ?> >3</option>
								<option <?php echo select(4,$fonte_option) ?> >4</option>
								<option <?php echo select(5,$fonte_option) ?> >5</option>
								<option <?php echo select(6,$fonte_option) ?> >6</option>
								<option value= '0'>Todas as opções</option>

							</select>
						</div>
					</div>		

					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Aplicar">
						</form>
					</select>
				</div>
			</div>		
			
		</form>			
	</div>		
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					
					<th width='10%'>Proj/Fic</th>
					<th width='10%'>Nat/Fon</th>
					<th>Desc</th>
					<th>Ini</th>
					<th>Con</th>
					<th>Des</th>
					<th>Sup</th>
					<th>Anul</th>
					<th>Rev</th>
					<th>Lib</th>

					<th>Saldo Lib</th> <!-- O saldo Planejado é o Saldo Liberado - Valor Planejado -->
					<th>Pla</th>	
					<th>Saldo Pla</th>

				</tr>
			</thead>
			<tbody>
				<form method="POST" action="?" />
				<?php 
				global $wpdb;
				$sql_list =  "SELECT id FROM sc_orcamento WHERE publicado = '1' $ano $unidade $fonte $projeto $ficha ORDER BY projeto ASC, ficha ASC";
				$res = $wpdb->get_results($sql_list,ARRAY_A);
				$total_orc = 0;
				$total_con = 0;
				$total_des = 0;
				$total_sup = 0;
				$total_res = 0;
				$total_tot = 0;
				$total_pla = 0;
				$total_lib = 0;
				$total_anul = 0;
				$total_rev = 0;
				
				for($i = 0; $i < count($res); $i++){
					$orc = orcamento($res[$i]['id']);
					$total = $orc['total'] - $orc['contigenciado'] + $orc['descontigenciado'] + $orc['suplementado'] - $orc['liberado'] - $orc['anulado'];
					
					if($i % 10 == 0 AND $i != 0){
						?>
						<tr>
							
							<th width='10%'>Proj/Fic</th>
							<th width='10%'>Nat/Fon</th>
							<th>Des</th>
							<th>Ini</th>
							<th>Con</th>
							<th>Des</th>
							<th>Sup</th>
							<th>Anul</th>
							<th>Rev</th>
							<th>Lib</th>
							<th>Saldo Lib</th> <!-- O saldo Planejado é o Saldo Liberado - Valor Planejado -->
							<th>Pla</th>	
							<th>Saldo Pla</th>

						</tr>
						<tr>

							<td title="<?php echo $orc['descricao']; ?>"><a href="?p=historico&id=<?php echo $res[$i]['id']?>" target='_blank' ><?php echo $orc['visualizacao']; ?></a></td>
							<td><?php echo $orc['natureza']; ?></td>
							<td><?php echo $orc['descricao']; ?></td>

							<td><?php echo dinheiroParaBr($orc['total']); ?></td>
							<td><?php echo dinheiroParaBr($orc['contigenciado']); ?></td>
							<td><?php echo dinheiroParaBr($orc['descontigenciado']); ?></td>
							<td><?php echo dinheiroParaBr($orc['suplementado']); ?></td>
							<td><?php echo dinheiroParaBr($orc['anulado']); ?></td>
							
							<td><?php echo dinheiroParaBr( $orc['total'] - $orc['contigenciado'] + $orc['descontigenciado'] + $orc['suplementado'] - $orc['anulado']); ?></td>					  
							<td><?php echo dinheiroParaBr($orc['liberado']); ?></td>

							<td><?php echo dinheiroParaBr($total); ?></td>
							<td><?php echo dinheiroParaBr($orc['planejado']) ?><?php //var_dump($orc); ?></td>
							<td><?php echo dinheiroParaBr( $orc['total'] - $orc['contigenciado'] + $orc['descontigenciado'] + $orc['suplementado'] - $orc['anulado'] - $orc['planejado']); ?></td>				
							
							
							
							<?php
						}else{
							
							?>
							
							<tr>

								<td title="<?php echo $orc['descricao']; ?>"><a href="?p=historico&id=<?php echo $res[$i]['id']?>" target='_blank' ><?php echo $orc['visualizacao']; ?></a></td>
								<td><?php echo $orc['natureza']; ?></td>
								<td><?php echo $orc['descricao']; ?></td>
								<td><?php echo dinheiroParaBr($orc['total']); ?></td>
								<td><?php echo dinheiroParaBr($orc['contigenciado']); ?></td>
								<td><?php echo dinheiroParaBr($orc['descontigenciado']); ?></td>
								<td><?php echo dinheiroParaBr($orc['suplementado']); ?></td>
								<td><?php echo dinheiroParaBr($orc['anulado']); ?></td>
								<td><?php echo dinheiroParaBr( $orc['total'] - $orc['contigenciado'] + $orc['descontigenciado'] + $orc['suplementado'] - $orc['anulado']); ?></td>						  
								<td><?php echo dinheiroParaBr($orc['liberado']); ?></td>

								<td><?php echo dinheiroParaBr($total); ?></td>
								<td><?php echo dinheiroParaBr($orc['planejado']) ?><?php //var_dump($orc); ?></td>
								<td><?php echo dinheiroParaBr( $orc['total'] - $orc['contigenciado'] + $orc['descontigenciado'] + $orc['suplementado'] - $orc['anulado'] - $orc['planejado']); ?></td>			
	<!--<td>	
							<form method="POST" action="?p=editar" class="form-horizontal" role="form">
							<input type="hidden" name="carregar" value="<?php echo $res[$i]['id']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
							</form>
							<?php 
					  
							?></td>-->
						</tr>
						
						
						<?php 
					}
					$total_orc = $total_orc + $orc['total'];
					$total_con = $total_con + $orc['contigenciado'];
					$total_des = $total_des + $orc['descontigenciado'];
					$total_sup = $total_sup + $orc['suplementado'];
					$total_lib = $total_lib + $orc['liberado'];
					$total_pla = $total_pla + $orc['planejado'];
					$total_anul = $total_anul + $orc['anulado'];
					$total_rev = $total_rev + ($orc['total'] - $orc['contigenciado'] + $orc['descontigenciado'] + $orc['suplementado'] - $orc['anulado']);
				//$total_res = $total_res;
					$total_tot = $total_tot + $total;					
					
					
					
					
				} // fim do for?>	
				<tr>
					<td>TOTAL:</td>
					<td></td>
					<td></td>
					<td><?php echo dinheiroParaBr($total_orc); ?></td>
					<td><?php echo dinheiroParaBr($total_con); ?></td>
					<td><?php echo dinheiroParaBr($total_des); ?></td>
					<td><?php echo dinheiroParaBr($total_sup); ?></td>
					<td><?php echo dinheiroParaBr($total_anul); ?></td>
					<td><?php echo dinheiroParaBr($total_rev); ?></td>
					
					<td><?php echo dinheiroParaBr($total_lib); ?></td>

					<td><?php echo dinheiroParaBr($total_tot); ?></td>
					<td><?php echo dinheiroParaBr($total_pla); ?></td>
					<td><?php echo dinheiroParaBr($total_tot - $total_pla + $total_lib); ?></td>
					<td></td>
					
				</tr>
			</tbody>
		</table>
	</div>

</div>
</section>

<?php 
break;
case "visaogeralv2": 

if(isset($_GET['unidade']) AND $_GET['unidade'] != 0 ){
	$unidade = " AND unidade ='".$_GET['unidade']."' ";	
}else{
	$unidade = "";
}

if(isset($_GET['fonte']) AND $_GET['fonte'] != 0 ){
	$fonte = " AND fonte ='".$_GET['fonte']."' ";
	$fonte_option = $_GET['fonte']; 	
}else{
	$fonte = "";
	$fonte_option = 0; 	

}


if(isset($_GET['ano'])){
	$ano = " AND ano_base = '".$_GET['ano']."' ";	
}else{
	$ano = " AND ano_base = '2018' ";	
}

if(isset($_GET['projeto']) AND $_GET['projeto'] != 0 ){
	$projeto = " AND projeto = '".$_GET['projeto']."' ";	
}else{
	$projeto = "";	
}

if(isset($_GET['ficha']) AND $_GET['ficha'] != 0){
	$ficha = " AND ficha = '".$_GET['ficha']."' ";	
}else{
	$ficha = "";	
}

//filtros projeto e ficha
?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Dotações</h1>
			</div>
		</div>
		<h3>Filtro</h3>
		<div class="col-md-offset-1 col-md-10">
			<form method="GET" action="orcamento.php?p=visaogeral&ano=2018" class="form-horizontal" role="form">
				<div class="form-group">
					<div class="col-md-offset-2">
						<label>Unidade *</label>
						<select class="form-control" name="unidade" id="inputSubject" >
							<option value='0'>Escolha uma opção</option>
							<?php echo geraTipoOpcao('unidade',$_GET['unidade']); ?>
							<option value='0'>Todas as unidades</option>
						</select>
					</div>
				</div>		
				<div class="form-group">
					<div class="col-md-offset-2">
						<label>Fonte *</label>
						<select class="form-control" name="fonte" id="inputSubject" >
							<option value= '0'>Escolha uma opção</option>
							<option <?php echo select(1,$fonte_option) ?> >1</option>
							<option <?php echo select(2,$fonte_option) ?> >2</option>
							<option <?php echo select(3,$fonte_option) ?> >3</option>
							<option <?php echo select(4,$fonte_option) ?> >4</option>
							<option <?php echo select(5,$fonte_option) ?> >5</option>
							<option <?php echo select(6,$fonte_option) ?> >6</option>
							<option value= '0'>Todas as opções</option>

						</select>
					</div>
				</div>		

				<div class="form-group">
					<div class="col-md-offset-2">
						<input type="submit" class="btn btn-theme btn-sm btn-block" value="Aplicar">
					</form>
				</select>
			</div>
		</div>		
		
	</form>			
</div>		
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				
				<th width='10%'>Proj/Fic</th>
				<th width='10%'>Nat/Fon</th>
				<th>Inicial</th>
				<th>Anulado</th>
				<th>Suplementado</th>
				<th>Contigenciado</th>
				<th>Saldo</th>		


			</tr>
		</thead>
		<tbody>
			<form method="POST" action="?" />
			<?php 
			global $wpdb;
			$sql_list =  "SELECT id FROM sc_orcamento WHERE publicado = '1' $ano $unidade $fonte $projeto $ficha ORDER BY projeto ASC, ficha ASC";
			$res = $wpdb->get_results($sql_list,ARRAY_A);
			$total_orc = 0;
			$total_con = 0;
			$total_des = 0;
			$total_sup = 0;
			$total_res = 0;
			$total_tot = 0;
			$total_pla = 0;
			$total_lib = 0;
			$total_anul = 0;
			$total_rev = 0;
			
			for($i = 0; $i < count($res); $i++){
				$orc = orcamento($res[$i]['id']);
					//$contigenciado = $orc['contigenciado'] - $orc['descontigenciado'] - $orc['suplementado'] + $orc['anulado'];
				$contigenciado = $orc['contigenciado'] - $orc['descontigenciado']; 
				
				if($i % 10 == 0 AND $i != 0){
					?>
					<tr>
						
						<th width='10%'>Proj/Fic</th>
						<th width='10%'>Nat/Fon</th>
						<th>Inical</th>
						<th>Anulado</th>
						<th>Suplementado</th>
						<th>Contigenciado</th>
						<th>Saldo</th>		


					</tr>
					<tr>

						<td title="<?php echo $orc['descricao']; ?>"><a href="?p=historico&id=<?php echo $res[$i]['id']?>" target='_blank' ><?php echo $orc['visualizacao']; ?></a></td>
						<td><?php echo $orc['natureza']; ?></td>
						<td><?php echo dinheiroParaBr($orc['total']); ?></td>
						<td><?php echo dinheiroParaBr($orc['anulado']); ?></td>	
						<td><?php echo dinheiroParaBr($orc['suplementado']); ?></td>	
						<td><?php echo dinheiroParaBr($contigenciado); ?></td>
						<td><?php echo dinheiroParaBr($orc['total'] - $contigenciado - $orc['anulado'] + $orc['suplementado']); ?></td>
						
						
						
						<?php
					}else{
						
						?>
						
						<tr>

							<td title="<?php echo $orc['descricao']; ?>"><a href="?p=historico&id=<?php echo $res[$i]['id']?>" target='_blank' ><?php echo $orc['visualizacao']; ?></a></td>
							<td><?php echo $orc['natureza']; ?></td>
							<td><?php echo dinheiroParaBr($orc['total']); ?></td>
							<td><?php echo dinheiroParaBr($orc['anulado']); ?></td>	
							<td><?php echo dinheiroParaBr($orc['suplementado']); ?></td>	
							<td><?php echo dinheiroParaBr($contigenciado); ?></td>
							<td><?php echo dinheiroParaBr($orc['total'] - $contigenciado - $orc['anulado'] + $orc['suplementado']); ?></td>					 
	<!--<td>	
							<form method="POST" action="?p=editar" class="form-horizontal" role="form">
							<input type="hidden" name="carregar" value="<?php echo $res[$i]['id']; ?>" />
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
							</form>
							<?php 
					  
							?></td>-->
						</tr>
						
						
						<?php 
					}
					$total_orc = $total_orc + $orc['total'];
					$total_con = $total_con + $orc['contigenciado'];
					$total_des = $total_des + $orc['descontigenciado'];
					$total_sup = $total_sup + $orc['suplementado'];
					$total_lib = $total_lib + $orc['liberado'];
					$total_pla = $total_pla + $orc['planejado'];
					$total_anul = $total_anul + $orc['anulado'];
					$total_rev = $total_rev + ($orc['total'] - $contigenciado - $orc['anulado'] + $orc['suplementado']);
				//$total_res = $total_res;
				//$total_tot = $total_tot + $total;					
					
					
					
					
				} // fim do for?>	
				<tr>
					<td>TOTAL:</td>
					<td></td>
					<td><?php echo dinheiroParaBr($total_orc); ?></td>
					<td><?php echo dinheiroParaBr($total_con); ?></td>
					<td><?php echo dinheiroParaBr($total_des); ?></td>
					<td><?php echo dinheiroParaBr($total_tot); ?></td>
					<td><?php echo dinheiroParaBr($total_pla); ?></td>
					<td><?php echo dinheiroParaBr($total_tot - $total_pla + $total_lib); ?></td>
					<td></td>
					
				</tr>
			</tbody>
		</table>
	</div>

</div>
</section>


<?php 
break;
case 'historico':
$id_hist = $_GET['id'];
$historico = orcamento($id_hist);
?>

<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Movimentação Orçamentária - Histórico</h1>
				<h3><?php echo $historico['visualizacao']." / ".$historico['descricao'];?> </h3>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Lib</th>
						<th>Data</th>
						<th>Tipo</th>
						<th>Título</th>
						<th>Descrição</th>
						<th>Valor</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td></td>
						<td>Inicial</td>
						<td>Orçamento aprovado</td>
						<td></td>
						<td></td>
						<td><?php echo dinheiroParaBr($historico['total']);?></td>

					</tr>
					
					<?php 
					
					for($i = 0; $i < count($historico['historico']); $i++){
						$tipo = tipo($historico['historico'][$i]['tipo']);
						if($historico['historico'][$i]['tipo'] == 286 OR $historico['historico'][$i]['tipo'] == 311 OR $historico['historico'][$i]['tipo'] == 394  ){
							$valor = "(".dinheiroParaBr($historico['historico'][$i]['valor']).")";
						}else{
							$valor = dinheiroParaBr($historico['historico'][$i]['valor']);
						}
						?>
						<tr>
							<td><?php echo $historico['historico'][$i]['id']; ?></td>
							<td><?php 
							$ped = retornaPedido($historico['historico'][$i]['idPedidoContratacao']);	
							echo $ped['nLiberacao']; ?></td>
							<td><?php echo exibirDataBr($historico['historico'][$i]['data']); ?></td>
							<td><?php echo  $tipo['tipo']; ?></td>
							<td><?php echo $historico['historico'][$i]['titulo']; ?></td>
							<td><?php echo $historico['historico'][$i]['descricao']." - ".$ped['obs']; ?></td>
							<td><?php echo $valor; ?></td>
						</tr>
						<?php 
						
						
					} // fim do for?>	
					<tr>
						<td></td>
						<td></td>
						<td><td>
							<td></td>
							<td>Total em <?php echo date('d/m/Y') ?></td>
							<td><?php echo dinheiroParaBr($historico['total'] - $historico['contigenciado'] + $historico['descontigenciado'] + $historico['suplementado'] - $historico['liberado'] - $historico['anulado']); ?></td>
							
						</tr>
						<tr><td colspan="6">		

						</tr>

						<tr>
							<td colspan="6"></td>
						</tr>
						<tr>
							<td colspan="6"><h3>Valores Planejados<h3></td>
							</tr>
							<tr>
								<th>#</th>
								<th>Projeto</th>
								<th>Programa</th>
								<th>Observação</th>
								<th>Valor</th>
							</tr>
							<?php 
							$sql_list_pla = "SELECT * FROM sc_orcamento, sc_tipo  WHERE idPai = '$id_hist' AND sc_orcamento.publicado = '1' AND sc_tipo.publicado ='1' AND sc_tipo.id_tipo = sc_orcamento.planejamento";
							$res_pla = $wpdb->get_results($sql_list_pla,ARRAY_A);	
							$total_planejado = 0;
							for($i = 0; $i < count($res_pla); $i++){	
								$projeto = tipo($res_pla[$i]['planejamento']);
								$pro_json = json_decode($projeto['descricao'],true);
								$programa = tipo($pro_json['programa']);
								?>
								<tr>
									<td></td>
									<td>
										<?php echo $projeto['tipo']; ?>
									</td>
									<td><?php echo $programa['tipo']; ?></td>

									<td><?php echo $res_pla[$i]['obs'] ?></td>
									<td>
										
										
										<?php echo dinheiroParaBr($res_pla[$i]['valor']); $total_planejado = $total_planejado + $res_pla[$i]['valor'] ?></td>
									</tr>
								<?php } ?>
								<tr>
									<td><td>


										<td>Total Planejado:<td>
											<td><?php echo dinheiroParaBr($total_planejado); ?><td>

											</tr>
											<tr>
												<td><td>


													<td>Total a planejar:<td>
														<td><?php echo dinheiroParaBr(($historico['total'] - $historico['contigenciado'] + $historico['descontigenciado'] + $historico['suplementado'] - $historico['anulado'] - $total_planejado ) ); ?><td>

														</tr>
														
													</tbody>
												</table>
											</div>

											
											
											
										</div>
									</section>

									<?php 
									break;
									case "planejamento":

									if(isset($_POST['atualiza'])){
										$idPlan = $_POST['atualiza'];
										$valor = dinheiroDeBr($_POST['valor']);
										$dotacao = $_POST['dotacao'];
										$obs = addslashes($_POST['obs']);
										
										$ver = retornaPlanejamento($idPlan);
	if($ver['bool'] == FALSE){ // insere
		$sql_ins = "INSERT INTO `sc_orcamento` (`valor`,`planejamento`, `idPai`, `publicado`, `obs`) VALUES ('$valor','$idPlan','$dotacao','1','$obs')";
		$ins = $wpdb->query($sql_ins);
		if($ins == 1){
			$mensagem = alerta("Planejamento atualizado.","success");	

		}else{
			$mensagem = alerta("Erro. Tente novamente","warning");	
		}
		
	}else{ // atualiza
		$sql_ins = "UPDATE `sc_orcamento` SET `valor` = '$valor',
		`idPai` = '$dotacao' ,
		`obs` = '$obs' 
		WHERE planejamento = '$idPlan'";
		$ins = $wpdb->query($sql_ins);
		if($ins == 1){
			$mensagem = alerta("Planejamento atualizado.","success");
		}else{
			$mensagem = alerta("Erro. Tente novamente","warning");	
		}
	}
}

if(isset($_POST['apagar'])){
	$id = $_POST['apagar'];
	$sql_upd = "UPDATE sc_tipo SET publicado = '0' WHERE id_tipo = '$id' ";
	$ins = $wpdb->query($sql_upd);
	if($ins == 1){
		$mensagem = alerta("Projeto apagado.","success");
	}else{
		$mensagem = alerta("Erro. Tente novamente","warning");	
	}
}


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
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Planejamento</h1>
				<p><?php if(isset($mensagem)){echo $mensagem;}?></p>
			</div>
		</div>

		<div class="col-md-offset-1 col-md-10">
			
		</div>		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						
						<th>Projeto</th>
						<th>Programa</th>
						<th width="15%">Valor</th>
						<th>Dotação</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$sql_list =  "SELECT * FROM sc_tipo WHERE abreviatura = 'projeto' AND publicado = '1' ORDER BY tipo ASC";
					$res = $wpdb->get_results($sql_list,ARRAY_A);
					
					for($i = 0; $i < count($res); $i++){
						$json = json_decode($res[$i]['descricao'],true);
						$programa = tipo($json['programa']);
						$plan = retornaPlanejamento($res[$i]['id_tipo']);
						?>
						<tr>
							
							<td><?php echo $res[$i]['tipo']; ?><?php //var_dump($orc); ?></td>
							<td><?php echo $programa['tipo']; //var_dump($json); ?></td>
							<form method="POST" action="?p=planejamento" class="form-horizontal" role="form">
								<td><?php //var_dump($plan); ?><input type="text" name="valor" class="form-control valor"   value="<?php echo dinheiroParaBr($plan['valor']); ?>"/></td>	
								<td>					
									
									<select class="form-control" name="dotacao" id="inputSubject" >
										<option value="NULL">Escolha uma opção</option>
										<?php echo geraOpcaoDotacao('2018',$plan['dotacao']); ?>
									</select>			
								</td>		
								<td>	
									<td><textarea class="form-control" name="obs" cols="120"><?php echo $plan['obs']; ?></textarea></td>
									<td>
										<input type="hidden" name="atualiza" value="<?php echo $res[$i]['id_tipo']; ?>" />
										<input type="submit" class="btn btn-theme btn-sm btn-block" value="Atualiza">
									</form>					  
								</td>
								<td>
									<form method="POST" action="?p=planejamento" class="form-horizontal" role="form">
										<input type="hidden" name="apagar" value="<?php echo $res[$i]['id_tipo']; ?>" />
										<input type="submit" class="btn btn-theme btn-sm btn-block" value="Apagar">
									</form>
								</td>
							</tr>		
							
						<?php } ?>

					</tbody>
				</table>
			</div>

		</div>
	</section>

	<?php 
	break;
	case "listaprograma":



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
	<section id="contact" class="home-section bg-white">
		<div class="container">
			<div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Programas</h1>
					<p><?php if(isset($mensagem)){echo $mensagem;}?></p>
				</div>
			</div>

			<div class="col-md-offset-1 col-md-10">
				
			</div>		
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							
							<th>Título</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						global $wpdb;
						$sql_list =  "SELECT * FROM sc_tipo WHERE publicado = '1' WHERE abreviatura = 'programa'";
						$res = $wpdb->get_results($sql_list,ARRAY_A);
						
						for($i = 0; $i < count($res); $i++){
							$json = json_decode($res[$i]['descricao'],true);
							$programa = tipo($json['programa']);
							$plan = retornaPlanejamento($res[$i]['id_tipo']);
							?>
							<tr>
								
								<td><?php echo $res[$i]['tipo']; ?><?php //var_dump($orc); ?></td>

								<form method="POST" action="?p=planejamento" class="form-horizontal" role="form">
									<td>	

										<input type="hidden" name="atualiza" value="<?php echo $res[$i]['id_tipo']; ?>" />
										<input type="submit" class="btn btn-theme btn-sm btn-block" value="Editar">
									</form>					  
								</td>
							</tr>		
							
						<?php } ?>		

					</tbody>
				</table>
			</div>

		</div>
	</section>
	<?php 
	break;
	case "listaprojeto":

	if(isset($_POST['inserir'])){
		$titulo = $_POST['titulo'];
		$programa = $_POST['programa'];
		$inicio = (date("Y-m-d"));
		$fim = (date("Y-m-d"));
		$responsavel = "";
		$descricao = "";
		$json = array(
			"programa" => "$programa",
			"inicio" => "$inicio",
			"responsavel" => "$responsavel",
			"fim" => "$fim",
			"descricao" => "$descricao"
		);
		$des = json_encode($json);
		$sql_upd = "INSERT INTO `sc_tipo` (`id_tipo`, `tipo`, `descricao`, `abreviatura`, `publicado`) VALUES (NULL, '$titulo', '$des', 'projeto', '1')";
		$upd = $wpdb->query($sql_upd);
		if($upd == 1){
			$mensagem = alerta("Inserido com sucesso.","success");
		}else{
			$mensagem = alerta("Não inserido. Tente novamente.","warning");
		}
	}

	if(isset($_POST['deleta'])){
		$deleta = $_POST['deleta'];
		$sql = "UPDATE sc_tipo SET publicado = '0' WHERE id_tipo = '$deleta'";
		$del = $wpdb->query($sql);
		if($del == 1){
			$mensagem = alerta("Deletado com sucesso.","success");
		}else{
			$mensagem = alerta("Não deletado Tente novamente. $sql","info");
		}	
	}

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
	<section id="contact" class="home-section bg-white">
		<div class="container">
			<div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Projetos</h1>
					<p><?php if(isset($mensagem)){echo $mensagem;}?></p>
				</div>
			</div>


			<div class="col-md-offset-1 col-md-10">
				
			</div>		
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							
							<th>Projeto</th>
							<th>Programa</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<form method="POST" action="?p=listaprojeto" class="form-horizontal" role="form">
								<td>
									<input type="text" name="titulo" class="form-control" id="inputSubject" />
								</td>
								<td>
									<select class="form-control" name="programa" id="inputSubject" >
										<option value='0'>Escolha uma opção</option>
										<?php echo geraTipoOpcao("programa") ?>
									</select>			
								</td>
								<td>
									
									<input type="hidden" name="inserir" value="1" />
									<input type="submit" class="btn btn-theme btn-sm btn-block" value="Inserir">
								</form>
							</td>
							<td></td>

						</tr>


						<?php 
						global $wpdb;
						$sql_list =  "SELECT * FROM sc_tipo WHERE publicado = '1' AND abreviatura = 'projeto' ORDER BY tipo ASC";
						$res = $wpdb->get_results($sql_list,ARRAY_A);
						
						for($i = 0; $i < count($res); $i++){
							$json = json_decode($res[$i]['descricao'],true);
							$programa = tipo($json['programa']);
							$plan = retornaPlanejamento($res[$i]['id_tipo']);
							?>
							<tr>
								
								<td><?php echo $res[$i]['tipo']; ?><?php //var_dump($orc); ?></td>
								<td><?php echo $programa['tipo']; //var_dump($json); ?></td>
								

								<td>	
									<form method="POST" action="?p=editaprojeto" class="form-horizontal" role="form">
										<input type="hidden" name="carregar" value="<?php echo $res[$i]['id_tipo']; ?>" />
										<input type="submit" class="btn btn-theme btn-sm btn-block" value="Editar">
									</form>					  
								</td>
								<td>	
									<form method="POST" action="?p=listaprojeto" class="form-horizontal" role="form">
										<input type="hidden" name="deleta" value="<?php echo $res[$i]['id_tipo']; ?>" />
										<input type="submit" class="btn btn-theme btn-sm btn-block" value="Deletar">
									</form>					  
								</td>
								
							</tr>		
							
						<?php } ?>		

					</tbody>
				</table>
			</div>

		</div>
	</section>
	<?php 
	break;
	case "editaprojeto":

	if(isset($_POST['carregar'])){
		$projeto = tipo($_POST['carregar']);
		$pro_json = json_decode($projeto['descricao'],true);
	//var_dump($pro_json);
	}

	if(isset($_POST['editaprojeto'])){
		$id = $_POST['editaprojeto'];
		$titulo = $_POST['titulo'];
		$programa = $_POST['programa'];
		$inicio = exibirDataMysql($_POST['inicio']);
		$fim = exibirDataMysql($_POST['fim']);
		$responsavel = $_POST['responsavel'];
		$descricao = $_POST['descricao'];
		$json = array(
			"programa" => "$programa",
			"inicio" => "$inicio",
			"responsavel" => "$responsavel",
			"fim" => "$fim",
			"descricao" => "$descricao"
		);
		$des = json_encode($json,JSON_UNESCAPED_UNICODE );
		$sql_upd = "UPDATE sc_tipo SET
		tipo = '$titulo',
		descricao = '$des'
		WHERE id_tipo = '$id';	
		";
		$upd = $wpdb->query($sql_upd);
		if($upd == 1){
			$mensagem = alerta("Atualizado com sucesso.","success");
		}else{
			$mensagem = alerta("Não atualizado. Tente novamente.","alert");
		}
		
		$projeto = tipo($id);
		$pro_json = json_decode($projeto['descricao'],true);
		
	}

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



</script>
<section id="inserir" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">

				<h2>Projeto</h2>
				<?php if(isset($mensagem)){ echo $mensagem;} ?>
				
				

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=editaprojeto" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Titulo *</label>
							<input type="text" name="titulo" class="form-control" id="inputSubject" value="<?php echo $projeto['tipo'] ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Programa</label>
							<select class="form-control" name="programa" id="inputSubject" >
								<option value='0'>Escolha uma opção</option>
								<?php echo geraTipoOpcao("programa",$pro_json['programa']) ?>
							</select>
						</div>
					</div>	
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Início *</label>
							<input type="text" name="inicio" class="form-control calendario"   value="<?php echo exibirDataBr($pro_json['inicio']) ?>"/>
							
						</div>
					</div>					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Fim *</label>
							<input type="text" name="fim" class="form-control calendario"   value="<?php echo exibirDataBr($pro_json['fim']) ?>"/>
							
						</div>
					</div>					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Responsável</label>
							<select class="form-control" name="responsavel" id="inputSubject" >
								<option value="0"></option>
								<?php geraOpcaoUsuario($pro_json['responsavel']);	?>							
							</select>	                
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Descrição *</label>
							<textarea name="descricao" class="form-control" rows="10" ><?php echo $pro_json['descricao'] ?></textarea>
						</div> 
					</div>	
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="editaprojeto" value="<?php echo $projeto['id_tipo'] ?>" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Atualizar Projeto">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<?php 
break;
case "editaprograma":

?>


<?php 
break;
case "eventos":
?>

<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Eventos</h1>
				<?php if(isset($mensagem)){echo $mensagem;}?>
			</div>
		</div>
		<h3>Por Programa</h3>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Programa</th>
						<th>Quantidade</th>

						<th>Porcentagem</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$sql_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'programa' ORDER BY tipo ASC";
					$res = $wpdb->get_results($sql_programa, ARRAY_A);
					$sql_evento = "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL";
					$x = $wpdb->get_results($sql_evento,ARRAY_A);
					
					for($i = 0; $i < count($res); $i++){
						$sql_count = "SELECT idEvento FROM sc_evento WHERE idPrograma = '".$res[$i]['id_tipo']."' AND publicado = '1' AND dataEnvio IS NOT NULL";
						$y = $wpdb->get_results($sql_count,ARRAY_A);
						?>
						<tr>
							<td><?php echo $res[$i]['tipo']; ?></td>
							<td><?php echo count($y); ?></td>

							<td><?php echo round((count($y)/count($x))*100,2) ." %"; ?></td>
						</tr>
					<?php } // fim do for?>	
					<tr><td>Total:</td><td><?php echo count($x);?></td><td></td></tr>
				</tbody>
			</table>
		</div>

		<h3>Por Espaço</h3>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Espaço</th>
						<th>Quantidade</th>

						<th>Porcentagem</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$sql_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'local' ORDER BY tipo ASC";
					$res = $wpdb->get_results($sql_programa, ARRAY_A);
					$sql_evento = "SELECT idOcorrencia FROM sc_ocorrencia WHERE publicado = '1' AND idEvento IN(SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL)";
					$x = $wpdb->get_results($sql_evento,ARRAY_A);
					
					for($i = 0; $i < count($res); $i++){
						$sql_count = "SELECT idOcorrencia FROM sc_ocorrencia WHERE local = '".$res[$i]['id_tipo']."' AND publicado = '1' AND idEvento IN(SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL)";
						$y = $wpdb->get_results($sql_count,ARRAY_A);
						if(count($y) != 0){
							?>
							<tr>
								<td><?php echo $res[$i]['tipo']; ?></td>
								<td><?php echo count($y); ?></td>

								<td><?php echo round((count($y)/count($x))*100,2) ." %"; ?></td>
							</tr>
							
							<?php 
						}
					} // fim do for?>	
				</tbody>
			</table>
		</div>		  

		<h3>Por Linguagem</h3>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Linguagem</th>
						<th>Quantidade</th>

						<th>Porcentagem</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$sql_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'linguagens' ORDER BY tipo ASC";
					$res = $wpdb->get_results($sql_programa, ARRAY_A);
					$sql_evento = "(SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL)";
					$x = $wpdb->get_results($sql_evento,ARRAY_A);
					
					for($i = 0; $i < count($res); $i++){
						$sql_count = "(SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL AND idLinguagem = '".$res[$i]['id_tipo']."')";
						$y = $wpdb->get_results($sql_count,ARRAY_A);
						if(count($y) != 0){
							?>
							<tr>
								<td><?php echo $res[$i]['tipo']; ?></td>
								<td><?php echo count($y); ?></td>

								<td><?php echo round((count($y)/count($x))*100,2) ." %"; ?></td>
							</tr>
							
							<?php 
						}
					} // fim do for?>	
				</tbody>
			</table>
		</div>
		<h3>Por Tipo</h3>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Tipo</th>
						<th>Quantidade</th>

						<th>Porcentagem</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$sql_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'tipo_evento' ORDER BY tipo ASC";
					$res = $wpdb->get_results($sql_programa, ARRAY_A);
					$sql_evento = "(SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL)";
					$x = $wpdb->get_results($sql_evento,ARRAY_A);
					
					for($i = 0; $i < count($res); $i++){
						$sql_count = "(SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL AND idTipo = '".$res[$i]['id_tipo']."')";
						$y = $wpdb->get_results($sql_count,ARRAY_A);
						if(count($y) != 0){
							?>
							<tr>
								<td><?php echo $res[$i]['tipo']; ?></td>
								<td><?php echo count($y); ?></td>

								<td><?php echo round((count($y)/count($x))*100,2) ." %"; ?></td>
							</tr>
							
							<?php 
						}
					} // fim do for?>	
				</tbody>
			</table>
		</div>
		
	</div>
</section>
<?php 
break;
case "publico":
?>

<?php 
$sql = "SELECT SUM(valor) FROM sc_indicadores WHERE publicado = 1";
$x = $wpdb->query($sql);
var_dump($x);

?>

<?php 
break;
case "atividades":
?>

<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Eventos</h1>
				<?php if(isset($mensagem)){echo $mensagem;}?>
			</div>
		</div>
		<h3>Por Programa</h3>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Programa</th>
						<th>Quantidade</th>

						<th>Porcentagem</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$sql_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'programa' ORDER BY tipo ASC";
					$res = $wpdb->get_results($sql_programa, ARRAY_A);
					$sql_evento = "SELECT id FROM sc_atividade WHERE publicado = '1'";
					$x = $wpdb->get_results($sql_evento,ARRAY_A);
					
					for($i = 0; $i < count($res); $i++){
						$sql_count = "SELECT id FROM sc_atividade WHERE idPrograma = '".$res[$i]['id_tipo']."' AND publicado = '1' AND dataEnvio IS NOT NULL";
						$y = $wpdb->get_results($sql_count,ARRAY_A);
						?>
						<tr>
							<td><?php echo $res[$i]['tipo']; ?></td>
							<td><?php echo count($y); ?></td>

							<td><?php echo round((count($y)/count($x))*100,2) ." %"; ?></td>
						</tr>
					<?php } // fim do for?>	
					<tr><td>Total:</td><td><?php echo count($x);?></td><td></td></tr>
				</tbody>
			</table>
		</div>

		<h3>Por Espaço</h3>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Espaço</th>
						<th>Quantidade</th>

						<th>Porcentagem</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$sql_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'local' ORDER BY tipo ASC";
					$res = $wpdb->get_results($sql_programa, ARRAY_A);
					$sql_evento = "SELECT idOcorrencia FROM sc_ocorrencia WHERE publicado = '1' AND idEvento IN(SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL)";
					$x = $wpdb->get_results($sql_evento,ARRAY_A);
					
					for($i = 0; $i < count($res); $i++){
						$sql_count = "SELECT idOcorrencia FROM sc_ocorrencia WHERE local = '".$res[$i]['id_tipo']."' AND publicado = '1' AND idEvento IN(SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL)";
						$y = $wpdb->get_results($sql_count,ARRAY_A);
						if(count($y) != 0){
							?>
							<tr>
								<td><?php echo $res[$i]['tipo']; ?></td>
								<td><?php echo count($y); ?></td>

								<td><?php echo round((count($y)/count($x))*100,2) ." %"; ?></td>
							</tr>
							
							<?php 
						}
					} // fim do for?>	
				</tbody>
			</table>
		</div>		  

		<h3>Por Linguagem</h3>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Linguagem</th>
						<th>Quantidade</th>

						<th>Porcentagem</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$sql_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'linguagens' ORDER BY tipo ASC";
					$res = $wpdb->get_results($sql_programa, ARRAY_A);
					$sql_evento = "(SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL)";
					$x = $wpdb->get_results($sql_evento,ARRAY_A);
					
					for($i = 0; $i < count($res); $i++){
						$sql_count = "(SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL AND idLinguagem = '".$res[$i]['id_tipo']."')";
						$y = $wpdb->get_results($sql_count,ARRAY_A);
						if(count($y) != 0){
							?>
							<tr>
								<td><?php echo $res[$i]['tipo']; ?></td>
								<td><?php echo count($y); ?></td>

								<td><?php echo round((count($y)/count($x))*100,2) ." %"; ?></td>
							</tr>
							
							<?php 
						}
					} // fim do for?>	
				</tbody>
			</table>
		</div>
		<h3>Por Tipo</h3>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Tipo</th>
						<th>Quantidade</th>

						<th>Porcentagem</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$sql_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'tipo_evento' ORDER BY tipo ASC";
					$res = $wpdb->get_results($sql_programa, ARRAY_A);
					$sql_evento = "(SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL)";
					$x = $wpdb->get_results($sql_evento,ARRAY_A);
					
					for($i = 0; $i < count($res); $i++){
						$sql_count = "(SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL AND idTipo = '".$res[$i]['id_tipo']."')";
						$y = $wpdb->get_results($sql_count,ARRAY_A);
						if(count($y) != 0){
							?>
							<tr>
								<td><?php echo $res[$i]['tipo']; ?></td>
								<td><?php echo count($y); ?></td>

								<td><?php echo round((count($y)/count($x))*100,2) ." %"; ?></td>
							</tr>
							
							<?php 
						}
					} // fim do for?>	
				</tbody>
			</table>
		</div>
		
	</div>
</section>

<?php
break;
case "graficos":
?>
<style>

.bar {
	fill: steelblue;
}

.bar:hover {
	fill: brown;
}

.axis--x path {
	display: none;
}

</style>



</div>

<div id="pieChart" align="center"></div>

<!--<div id="pieChart2" align="center"></div>-->
<div>
	<?php 
	//var_dump($programa);
	?>
</div>


<script src="js/jquery-3.2.1.js"></script>
<script src="https://d3js.org/d3.v4.js"></script>
<script src="visual/d3/d3pie.js"></script>

<?php 
global $wpdb;
$sql_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'programa' ORDER BY tipo ASC";
$res = $wpdb->get_results($sql_programa, ARRAY_A);
$sql_evento = "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL";
$x = $wpdb->get_results($sql_evento,ARRAY_A);

for($i = 0; $i < count($res); $i++){
	$sql_count = "SELECT idEvento FROM sc_evento WHERE idPrograma = '".$res[$i]['id_tipo']."' AND publicado = '1' AND dataEnvio IS NOT NULL";
	$y = $wpdb->get_results($sql_count,ARRAY_A);
	$programa[$i]['tipo'] = $res[$i]['tipo'];
	$programa[$i]['valor'] =  count($y);
} // fim do for?>	
<script>
	
	var pie = new d3pie("pieChart", {
		"header": {
			"title": {
				"text": "Planejamento por Programa",
				"fontSize": 24,
				"font": "open sans"
			},
			"subtitle": {
				"text": "",
				"color": "#999999",
				"fontSize": 12,
				"font": "open sans"
			},
			"titleSubtitlePadding": 9
		},
		"footer": {
			"color": "#999999",
			"fontSize": 10,
			"font": "open sans",
			"location": "bottom-left"
		},
		"size": {
			"canvasWidth": 800,
			"pieOuterRadius": "90%"
		},
		"data": {
			"sortOrder": "value-desc",
			"content": [
			
			<?php 
			
			
			?>
			
			<?php for ($i = 0; $i < count($programa); $i++){ ?>
				{
					"label": "<?php echo $programa[$i]['programa']?>",
					"value": <?php echo $programa[$i]['valor'] ?>,
					"color": "<?php echo '#' . dechex(rand(256,16777215)) ?>"
				},
			<?php } ?>

			]
		},
		"labels": {
			"outer": {
				"pieDistance": 32
			},
			"inner": {
				"hideWhenLessThanPercentage": 3
			},
			"mainLabel": {
				"fontSize": 11
			},
			"percentage": {
				"color": "#ffffff",
				"decimalPlaces": 0
			},
			"value": {
				"color": "#adadad",
				"fontSize": 11
			},
			"lines": {
				"enabled": true
			},
			"truncation": {
				"enabled": true
			}
		},
		"effects": {
			"pullOutSegmentOnClick": {
				"effect": "linear",
				"speed": 400,
				"size": 8
			}
		},
		"misc": {
			"gradient": {
				"enabled": true,
				"percentage": 100
			}
		}
	});
</script>
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