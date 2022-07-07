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
	
	<?php include "menu/me_orcamento.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<?php 
		switch($p){
			case "inicio": 
			case "listar": 
			if(isset($_SESSION['id'])){
				unset($_SESSION['id']);
			}

			if(isset($_GET['ano_base'])){
				$anobase = $_GET['ano_base'];
			}else{
				$anobase = date('Y');
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
										<div class="row">    
						<div class="col-md-offset-2 col-md-8">
									<form method="GET" action="orcamento.php?p=listar" class="form-horizontal" role="form">
					<div class="col-md-offset-2">
						<label>Ano Base *</label>
						<select class="form-control" name="ano_base" id="inputSubject" >
							<option value='0'>Escolha uma opção</option>
							<?php 
							$ano_b = anoOrcamento();
							for($i = 0; $i < sizeof($ano_b); $i++){
							?>
							<option value='<?php echo $ano_b[$i]['ano_base']; ?>' <?php echo select($anobase,$ano_b[$i]['ano_base']);?>><?php echo $ano_b[$i]['ano_base']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Aplicar">
				</div>
			</div>	
						</form>
						
						</div>
						
					
					
					
					
					
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Projeto</th>
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
								$sql_list =  "SELECT * FROM sc_orcamento WHERE planejamento = '0' AND publicado = '1' AND ano_base = '$anobase' AND dotacao IS NOT NULL ORDER BY projeto ASC, ficha ASC";
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
                                                    <option value="7" >7</option>
                                                    <option value="8" >8</option>

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
												<input type="text" name="ano" class="form-control" id="inputSubject" value="" />
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
                                <option value="7" <?php checado($orcamento['fonte'],array(7)); ?>>7</option>
                                <option value="8" <?php checado($orcamento['fonte'],array(8)); ?>>8</option>

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
// ano_base -> dotação projeto/ficha

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

<script type="application/javascript">
	$(function()
	{
		$('#anobase').change(function()
		{
			if( $(this).val() )
			{
				$('#dotacao').hide();
				$('.carregando').show();
				$.getJSON('inc/projetoficha.ajax.php?v=1',{anobase: $(this).val(), ajax: 'true'}, function(j)
				{
					var options = '<option value="0"></option>';	
					for (var i = 0; i < j.length; i++)
					{
						options += '<option value="' + j[i].id + '">' + j[i].projeto + '</option>';
					}	
					$('#dotacao').html(options).show();
					$('.carregando').hide();
				});
			}
			else
			{
				$('#dotacao').html('<option value="">-- Escolha um projeto/ficha --</option>');
			}
		});
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
							<label>Ano Base</label>
							<select class="form-control" name="anobase" id="anobase" >
							
							<?php 
							
							$anobase = anoOrcamento();
							
							?>
								<option>Escolha uma opção</option>
								<?php 
																
								for($i = 0; $i < count($anobase); $i++){
									?>
									<option value="<?php echo $anobase[$i]['ano_base']; ?>"><?php echo $anobase[$i]['ano_base']; ?></option>
									
									<?php
								}
								?>
								
							</select>
						</div>
					</div>	
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Dotação</label>
							<select class="form-control" name="dotacao" id="dotacao" >
							
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
							<label>Data da movimentação *</label>
							<input type="text"  class="form-control calendario" name="data_x" id="inputSubject" />
						</div>
					</div>					
						
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Descrição / Observação*</label>
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
	$mov = $wpdb->get_row("SELECT * FROM sc_mov_orc WHERE id =  '$id_orc' AND data NOT LIKE '%2018%' AND data NOT LIKE '%2019%'",ARRAY_A);
}

if(isset($_POST['mov_inserir']) OR isset($_POST['mov_editar']) ){
	$titulo = addslashes($_POST["titulo"]);
	$tipo = $_POST["tipo"];
	$dotacao = $_POST["dotacao"];
	$valor = dinheiroDeBr($_POST["valor"]);
	if($_POST["data_x"] == '' OR $_POST["data_x"] == '0000-00-00'){
		$data = date('Y-m-d');
	}else{
		$data = exibirDataMysql($_POST["data_x"]);	
	}
	$descricao = addslashes($_POST["descricao"]);
}

if(isset($_POST['mov_inserir'])){
	global $wpdb;
	$idUsuario = $user->ID;
	$sql = "INSERT INTO `sc_mov_orc` (`titulo`, `tipo`, `dotacao`, `data`, `valor`, `descricao`, `idUsuario`, `publicado`) 
	VALUES ('$titulo', '$tipo', '$dotacao', '$data', '$valor', '$descricao', '$idUsuario', '1')";
	$ins = $wpdb->query($sql);
	$id_orc = $wpdb->insert_id;
	if($ins == 1){
		$mensagem = alerta("Movimentação inserida com sucesso.","sucess");	
	}else{
		$mensagem = alerta("Erro[4]. Tente novamente.","warning");				
	}

	$mov = $wpdb->get_row("SELECT * FROM sc_mov_orc WHERE id =  '$id_orc'  AND data NOT LIKE '%2018%' AND data NOT LIKE '%2019%'",ARRAY_A);
	
}

if(isset($_POST['mov_editar'])){
	$id_orc = $_POST['mov_editar'];
	global $wpdb;
	$idUsuario = $user->ID;
	$sql = "UPDATE `sc_mov_orc` SET
	`titulo` = '$titulo', 
	`tipo` = '$tipo', 
	`dotacao` = '$dotacao', 
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
	$mov = $wpdb->get_row("SELECT * FROM sc_mov_orc WHERE id =  '$id_orc'  AND data NOT LIKE '%2018%' AND data NOT LIKE '%2019%'",ARRAY_A);
	
}


?>
<link href="css/jquery-ui.css" rel="stylesheet">
<script src="js/jquery-ui.js"></script>
<script src="js/mask.js"></script>
<script src="js/maskMoney.js"></script> 
<script>
	$(function() {
		$( "#calendario" ).datepicker({showButtonPanel:true});
		$( ".calendario2" ).datepicker();
		$( ".hora" ).mask("99:99");
		$( ".min" ).mask("999");
		$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
	});



</script>

<script type="application/javascript">
	$(function()
	{
		$('#anobase').change(function()
		{
			if( $(this).val() )
			{
				$('#dotacao').hide();
				$('.carregando').show();
				$.getJSON('inc/projetoficha.ajax.php?v=1',{anobase: $(this).val(), ajax: 'true'}, function(j)
				{
					var options = '<option value="0"></option>';	
					for (var i = 0; i < j.length; i++)
					{
						options += '<option value="' + j[i].id + '">' + j[i].projeto + '</option>';
					}	
					$('#dotacao').html(options).show();
					$('.carregando').hide();
				});
			}
			else
			{
				$('#dotacao').html('<option value="">-- Escolha um projeto/ficha --</option>');
			}
		});
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
							<label>Ano Base</label>
							<select class="form-control" name="anobase" id="anobase" >
							
							<?php 
							
							$anobase = anoOrcamento();
							$dota = retornaDot($mov['dotacao']);

							
							?>
								<option>Escolha uma opção</option>
								<?php 
																
								for($i = 0; $i < count($anobase); $i++){
									?>
									<option value="<?php echo $anobase[$i]['ano_base']; ?>"  
									<?php 
									if($anobase[$i]['ano_base'] == $dota['ano_base']){
										echo " selected ";
									}
									?> >				
									
									
									
									
									<?php echo $anobase[$i]['ano_base']; ?></option> 									
									<?php
								}
								?>
								
							</select>
						</div>
					</div>	
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Dotação</label>
							<select class="form-control" name="dotacao" id="dotacao" >
							<option value='0'>Escolha uma opção</option>
								<?php echo geraOpcaoDotacao($dota['ano_base'],$mov['dotacao']); ?>
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
<<<<<<< HEAD
							<label>Data da movimentação *</label>
							<input name="data_x" class="form-control calendario2" value="<?php echo exibirDataBr($mov['data']) ?>" />
						</div>
					</div>		

			
=======
							<label>Data *</label>
							<input type="text" name="dia" class="form-control calendario"   value="<?php echo exibirDataBr($mov['data']) ?>"/>
						</div>                                                             
					</div>					
>>>>>>> d2d08bc48c224f431cc2b62be7dd4e51b5c6eadb
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Descrição / Observação*</label>
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
					$sql_list =  "SELECT * FROM sc_mov_orc WHERE publicado = '1'  AND data NOT LIKE '%2018%' AND data NOT LIKE '%2019%'ORDER BY data DESC";
					$res = $wpdb->get_results($sql_list,ARRAY_A);
					for($i = 0; $i < count($res); $i++){
						$dot = recuperaDados("sc_orcamento",$res[$i]['dotacao'],"id");
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

	if(!isset($_GET['ano_base']) AND !isset($_GET['unidade']) AND !isset($_GET['fonte'])){
		$anobase_option = date('Y');
		$ano_base = " AND ano_base ='".$anobase_option."'";
		$unidade = "";
		$fonte = "";
		$fonte_option = 0; 	
		$projeto = "";	
		$ficha = "";	
	}



	if(isset($_GET['ano_base']) AND $_GET['ano_base'] != 0 ){
		$ano_base = " AND ano_base ='".$_GET['ano_base']."' ";
		$anobase_option = $_GET['ano_base']; 	
	}else{
		$ano_base = "";
		$anobase_option = date('Y'); 	

	}

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
	<section id="contact" class="home-section bg-white barra-horizontal">
		<div class="container">
			<div class="row">    
				<div class="col-md-offset-2 col-md-8">
					<h1>Dotações</h1>
				</div>
			</div>
			<h3>Filtro</h3>
			<font color="#ff0000"><strong>Atenção! Escolha o ano base para iniciar.</strong></font>
			<div class="col-md-offset-1 col-md-10">
				<form method="GET" action="orcamento.php?p=visaogeral" class="form-horizontal" role="form">
					<div class="col-md-offset-2">
						<label>Ano Base *</label>
						<select class="form-control" name="ano_base" id="inputSubject" >
							<option value='0'>Escolha uma opção</option>
							<?php 
							$ano_b = anoOrcamento();
							for($i = 0; $i < sizeof($ano_b); $i++){
							?>
							<option value='<?php echo $ano_b[$i]['ano_base']; ?>' <?php echo select($anobase_option,$ano_b[$i]['ano_base']);?>><?php echo $ano_b[$i]['ano_base']; ?></option>
							<?php } ?>
						</select>
					</div>
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
                                <option <?php echo select(7,$fonte_option) ?> >7</option>
                                <option <?php echo select(8,$fonte_option) ?> >8</option>
								<option value= '0'>Todas as opções</option>

							</select>
						</div>
					</div>		

					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="submit" class="btn btn-theme btn-sm btn-block" value="Aplicar">
						</form>

				</div>
			</div>		
			
		</form>			
	</div>		
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Ano Base</th>
					<th width='10%'>Proj/Fic</th>
					<th width='10%'>Descrição</th>
					<th width='10%'>Nat/Fon</th>
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
				$sql_list =  "SELECT id FROM sc_orcamento WHERE publicado = '1' AND planejamento = '0' $ano_base $unidade $fonte $projeto $ficha 
                                ORDER BY projeto ASC, ficha ASC";
				$res = $wpdb->get_results($sql_list,ARRAY_A);
				
				$anos = anoOrcamento(); //puxa todos os anos-base existentes no banco

				
				for($j = 0; $j < count($anos); $j++){
					$total_orc[$anos[$j]['ano_base']] = 0;
					$total_con[$anos[$j]['ano_base']] = 0;
					$total_des[$anos[$j]['ano_base']] = 0;
					$total_sup[$anos[$j]['ano_base']] = 0;
					$total_res[$anos[$j]['ano_base']] = 0;
					$total_tot[$anos[$j]['ano_base']] = 0;
					$total_pla[$anos[$j]['ano_base']] = 0;
					$total_lib[$anos[$j]['ano_base']] = 0;
					$total_anul[$anos[$j]['ano_base']] = 0;
					$total_rev[$anos[$j]['ano_base']] = 0;
				
				}

				for($i = 0; $i < count($res); $i++){
					$orc = orcamento($res[$i]['id']);
					$total = $orc['total'] - $orc['contigenciado'] + $orc['descontigenciado'] + $orc['suplementado'] - $orc['liberado'] - $orc['anulado'];
					
					if($i % 10 == 0 AND $i != 0){
						?>
						<tr>
							
							<th>Ano Base</th>
							<th width='10%'>Proj/Fic</th>
							<th width='10%'>Descrição</th>
							<th width='10%'>Nat/Fon</th>
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
							<td><?php echo $orc['ano_base']; ?></td>
							<td title="<?php echo $orc['descricao']; ?>"><a href="?p=historico&id=<?php echo $res[$i]['id']?>" target='_blank' ><?php echo $orc['visualizacao']; ?></a></td>
							<td><?php echo $orc['descricao']; ?></td>
							<td><?php echo $orc['natureza']; ?></td>
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
								<td><?php echo $orc['ano_base']; ?></td>
								<td title="<?php echo $orc['descricao']; ?>"><a href="?p=historico&id=<?php echo $res[$i]['id']?>" target='_blank' ><?php echo $orc['visualizacao']; ?></a></td>
								<td><?php echo $orc['descricao']; ?></td>
								<td><?php echo $orc['natureza']; ?></td>
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
					
					$total_orc[$orc['ano_base']] = $total_orc[$orc['ano_base']] + $orc['total'];
					$total_con[$orc['ano_base']] = $total_con[$orc['ano_base']] + $orc['contigenciado'];
					$total_des[$orc['ano_base']] = $total_des[$orc['ano_base']] + $orc['descontigenciado'];
					$total_sup[$orc['ano_base']] = $total_sup[$orc['ano_base']] + $orc['suplementado'];
					$total_lib[$orc['ano_base']] = $total_lib[$orc['ano_base']] + $orc['liberado'];
					$total_pla[$orc['ano_base']] = $total_pla[$orc['ano_base']] + $orc['planejado'];
					$total_anul[$orc['ano_base']] = $total_anul[$orc['ano_base']] + $orc['anulado'];
					$total_rev[$orc['ano_base']] = $total_rev[$orc['ano_base']] + ($orc['total'] - $orc['contigenciado'] + $orc['descontigenciado'] + $orc['suplementado'] - $orc['anulado']);
				//$total_res = $total_res;
					$total_tot[$orc['ano_base']] = $total_tot[$orc['ano_base']] + $total;					
					
					
					
					
				} // fim do for?>	
				<?php  ?>

						
				<?php for($j = 0; $j < count($anos); $j++){ 
					if(isset($_GET['ano_base']) AND $_GET['ano_base'] == $anos[$j]['ano_base'] ){
				
				
				
				?>
				
					
				<tr>
				<td></td>
					<td>TOTAL <?php echo $anos[$j]['ano_base']; ?>:</td>
					<td></td>
					<td></td>
					<td><?php echo dinheiroParaBr($total_orc[$anos[$j]['ano_base']]); ?></td>
					<td><?php echo dinheiroParaBr($total_con[$anos[$j]['ano_base']]); ?></td>
					<td><?php echo dinheiroParaBr($total_des[$anos[$j]['ano_base']]); ?></td>
					<td><?php echo dinheiroParaBr($total_sup[$anos[$j]['ano_base']]); ?></td>
					<td><?php echo dinheiroParaBr($total_anul[$anos[$j]['ano_base']]); ?></td>
					<td><?php echo dinheiroParaBr($total_rev[$anos[$j]['ano_base']]); ?></td>
					
					<td><?php echo dinheiroParaBr($total_lib[$anos[$j]['ano_base']]); ?></td>

					<td><?php echo dinheiroParaBr($total_tot[$anos[$j]['ano_base']]); ?></td>
					<td><?php echo dinheiroParaBr($total_pla[$anos[$j]['ano_base']]); ?></td>
					<td><?php echo dinheiroParaBr($total_tot[$anos[$j]['ano_base']] - $total_pla[$anos[$j]['ano_base']] + $total_lib[$anos[$j]['ano_base']]); ?></td>
					<td></td>
				</tr>
				<?php 
					}
					
				} ?>	

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
	$ano = " AND ano_base = '2019' ";	
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
<section id="contact" class="home-section bg-white ">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Dotações</h1>
			</div>
		</div>
		<h3>Filtro</h3>
		<div class="col-md-offset-1 col-md-10">
			<form method="GET" action="orcamento.php?p=visaogeral&ano=2019" class="form-horizontal" role="form">
				<div class="form-group">
					<div class="col-md-offset-2">
						<label>Ano Base *</label>
						<select class="form-control" name="ano_base" id="inputSubject" >
							<option value='0'>Escolha uma opção</option>
							<option <?php echo select(1,$fonte_option) ?> >2018</option>
							<option <?php echo select(2,$fonte_option) ?> >2019</option>
							<option <?php echo select(3,$fonte_option) ?> >2020</option>
						</select>
					</div>
					<div class="col-md-offset-2">
						<label>Unidade *</label>
						<select class="form-control" name="unidade" id="inputSubject" >
							<option value='0'>Escolha uma opção</option>
							<?php echo geraTipoOpcao('unidade',$_GET['unidade']); ?>
							<option value='0'>Todas as unidades</option>
						</select>
					</div>
				</div>		
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
                        <option <?php echo select(7,$fonte_option) ?> >7</option>
                        <option <?php echo select(8,$fonte_option) ?> >8</option>
						<option value= '0'>Todas as opções</option>

					</select>
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
				<th>Ano Base</th>
				<th width='10%'>Proj/Fic</th>
				<th width='10%'>Descrição</th>
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
			$sql_list =  "SELECT id FROM sc_orcamento WHERE publicado = '1' AND dotacao IS NOT NULL $ano_base $unidade $fonte $projeto $ficha ORDER BY projeto ASC, ficha ASC";
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
						<th>Ano Base</th>
						<th width='10%'>Proj/Fic</th>
						<th width='10%'>Nat/Fon</th>
						<th width='10%'>Descrição</th>
						<th>Inicial</th>
						<th>Anulado</th>
						<th>Suplementado</th>
						<th>Contigenciado</th>
						<th>Saldo</th>		


					</tr>
					<tr>
						<td><?php echo $orc['ano_base']; ?></td>
						<td title="<?php echo $orc['descricao']; ?>"><a href="?p=historico&id=<?php echo $res[$i]['id']?>" target='_blank' ><?php echo $orc['visualizacao']; ?></a></td>
						<td><?php echo $orc['descricao']; ?></td>
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
							<td><?php echo $orc['ano_base']; ?></td>
							<td title="<?php echo $orc['descricao']; ?>"><a href="?p=historico&id=<?php echo $res[$i]['id']?>" target='_blank' ><?php echo $orc['visualizacao']; ?></a></td>
							<td><?php echo $orc['descricao']; ?></td>
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
							<?php $autorizados = array(1,5,62);
							if(in_array($user->ID,$autorizados)){ ?>
								<form method="POST" action="?p=mov_inserir" class="form-horizontal" role="form" name="form1">
									<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" >
									<input type="submit" class="btn btn-theme btn-lg btn-block"  name="gravar" value="Inserir movimentação">
								</td>
							</form>
						<?php } ?>
					</tr>

					
				</tbody>
			</table>				  
			<h3>Valores Planejados</h3>
			<table class="table table-striped">
				<thead>

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

										<h3>GIAP</h3>
										<table class="table table-striped">
											<thead>
												<tr>
													<th>Descrição</th>
													<th>Empenho</th>
													<th>Estorno</th>
													<th>Anulado</th>
													<th>Não processado</th>
													<th>Processado</th>
													<th>Ordem de Pagamento</th>
													<th>Ordem Baixado</th>
													<th>Saldo dos Empenhos</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												$ficha = $historico['ficha'];
												$projeto = $historico['projeto'];
												$ano = $historico['ano_base'];

												$sql_soma_emp = "SELECT SUM(v_saldo) FROM sc_contabil WHERE projeto = '$projeto' AND ficha = '$ficha' AND ano = '$ano'";
												$soma_emp = $wpdb->get_results($sql_soma_emp,ARRAY_A);	

												$sql_lista = "SELECT * FROM sc_contabil WHERE projeto = '$projeto' AND ficha = '$ficha'  AND ano = '$ano' ORDER BY data DESC";
												$x = $wpdb->get_results($sql_lista,ARRAY_A);

//echo $sql_lista;
												for($i = 0; $i < count($x); $i++){


													
													?>

													<tr>
														<td><?php echo $x[$i]['historico']; ?></td>
														<td><?php echo dinheiroParaBr($x[$i]['v_empenho']); // empenho ?></td>
														<td><?php echo dinheiroParaBr($x[$i]['v_estorno']); // estorno ?></td>
														<td><?php echo dinheiroParaBr($x[$i]['v_anulado']); // anulado ?></td>
														<td><?php echo dinheiroParaBr($x[$i]['v_n_processado']); // nao processado?></td>
														<td><?php echo dinheiroParaBr($x[$i]['v_processado']); // processado?></td>
														<td><?php echo dinheiroParaBr($x[$i]['v_op']); // ordem de pagamento?></td>
														<td><?php echo dinheiroParaBr($x[$i]['v_op_baixado']); // ordem de pagamento baixado ?></td>
														<td><?php echo dinheiroParaBr($x[$i]['v_saldo']); ?></td>
													</tr>

													<?php

												}



												?>	

												<tr>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th>Soma Total dos Empenhos:</th>
													<td><?php echo dinheiroParaBr($soma_emp[0]['SUM(v_saldo)']) ?></td>
												</tr>

												<tr>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
													<th>Saldo Total dos Empenhos:</th>
													<td><?php echo dinheiroParaBr($total_planejado - $soma_emp[0]['SUM(v_saldo)']) ?></td>
												</tr>

											</tbody>
										</table>
									</div>

								</div>
							</section>   
							
							
							
							
							
							
						</div>

						
						
						
					</div>
				</section>
				<?php 
				break;
				case "planejamento":
				if(isset($_GET['ano'])){
					$anobase = $_GET['ano'];
				}else{
					$anobase = date('Y');
					
				}
				
				
	if(isset($_POST['atualiza'])){
		$idPlan = $_POST['atualiza'];
		$valor = dinheiroDeBr($_POST['valor']);
		$dotacao = $_POST['dotacao'];
		$obs = addslashes($_POST['obs']);					
		$ver = retornaPlanejamento($idPlan,$anobase);
	if($ver['bool'] == FALSE){ // insere
		$sql_ins = "INSERT INTO `sc_orcamento` (`valor`,`planejamento`, `idPai`, `publicado`, `obs`,`ano_base`) 
            VALUES ('$valor','$idPlan','$dotacao','1','$obs','$anobase')";
		$ins = $wpdb->query($sql_ins);
		atualizaMetaOrcamento();
		if($ins == 1){
			$mensagem = alerta("Planejamento atualizado.","success");	

		}else{
			$mensagem = alerta("Erro. Tente novamente","warning");	
		}
		
	}else{ // atualiza
		$sql_ins = "UPDATE `sc_orcamento` SET `valor` = '$valor',
		`idPai` = '$dotacao' ,
		`obs` = '$obs' 
		WHERE planejamento = '$idPlan' AND ano_base = '$anobase'";
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
				<h1>Planejamento <?php echo $anobase;?></h1>
				<p><?php if(isset($mensagem)){echo $mensagem;}?></p>
			</div>
		</div>

		<div class="col-md-offset-1 col-md-10">
			
		</div>		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
							<th>Programa</th>					
						<th>Projeto</th>
						<th>Meta</th>
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
					$sql_list =  "SELECT * FROM sc_tipo WHERE abreviatura = 'projeto' AND publicado = '1' 
                        AND ano_base = '$anobase' ORDER BY tipo ASC";
					$res = $wpdb->get_results($sql_list,ARRAY_A);
					
					for($i = 0; $i < count($res); $i++){
						$json = json_decode($res[$i]['descricao'],true);
						$programa = tipo($json['programa']);
						$plan = retornaPlanejamento($res[$i]['id_tipo'],$anobase);
						?>
						<tr>
							
							
							<td><?php echo $programa['tipo'];  ?></td>
							<td><?php echo $res[$i]['tipo']; ?><?php //var_dump($orc); ?></td>
							<td><?php if(isset($json['meta'])){echo $json['meta'];}; ?><?php //var_dump($orc); ?></td>
							<form method="POST" action="?p=planejamento&ano=<?php echo $anobase; ?>" class="form-horizontal" role="form">
								<td><?php //var_dump($plan); ?><input type="text" name="valor" class="form-control valor"
                                              value="<?php echo dinheiroParaBr($plan['valor']); ?>"/>
                                </td>
								<td>					
									
									<select class="form-control" name="dotacao" id="inputSubject" >
										<option value="NULL">Escolha uma opção</option>
										<?php //echo geraOpcaoDotacao('$anobase'); ?>
										<?php echo geraOpcaoDotacao($anobase,$plan['dotacao']); ?>
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
									<form method="POST" action="?p=planejamento&ano=<?php echo $anobase; ?>" class="form-horizontal" role="form">
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
							$plan = retornaPlanejamento2020($res[$i]['id_tipo']);
							?>
							<tr>
								
								<td><?php echo $res[$i]['tipo']; ?><?php //var_dump($orc); ?></td>

								<form method="POST" action="?p=planejamento2019" class="form-horizontal" role="form">
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

    if(isset($_GET['ano_base']) AND $_GET['ano_base'] != 0 ){
        $ano_base = " AND ano_base ='".$_GET['ano_base']."' ";
        $anobase_option = $_GET['ano_base'];
    }else{
        $ano_base = "";
        $anobase_option = 0;

    }
    ?>

    <?php
	if(isset($_POST['inserir'])){
		$titulo = $_POST['titulo'];
		$programa = $_POST['programa'];
		$inicio = (date("Y-m-d"));
		$fim = (date("Y-m-d"));
		$responsavel = "";
		$descricao = "";
		$meta = $_POST['meta'];
		$ano_base = $_POST['ano-base'];
		$json = array(
			"programa" => "$programa",
			"inicio" => "$inicio",
			"responsavel" => "$responsavel",
			"fim" => "$fim",
			"descricao" => "$descricao",
			"meta" => "$meta"
		);
		$des = json_encode($json);
		$sql_upd = "INSERT INTO `sc_tipo` (`id_tipo`, `tipo`, `descricao`, `abreviatura`, `publicado`, `ano_base`) 
            VALUES (NULL, '$titulo', '$des', 'projeto', '1', '$ano_base')";
		$upd = $wpdb->query($sql_upd);
		if($upd == 1){
			$mensagem = alerta("Inserido com sucesso.","success");
		}else{
			$mensagem = alerta("Não inserido. Tente novamente.","warning");
		}

	atualizaMetaOrcamento();
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
	//gatilho
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
				<form method="GET" action="orcamento.php?p=listaprojeto" class="form-horizontal" role="form">
				<select class="form-control" name="ano_base" id="inputSubject" >
				<option value='0'>Escolha uma opção</option>
				<?php echo opcaoAnoBase($anobase_option) ?>
				</select>
				<input type="hidden" name="p" value="listaprojeto">
				<input type="submit" class="btn btn-theme btn-sm btn-block" value="Filtrar">
				</form>
			</div>		
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							
							<th>Projeto</th>
							<th>Programa</th>
							<th>Meta</th>
							<th>Ano-base</th>
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
									<select class="form-control" name="meta" id="inputSubject" >
										<option value='0'>Escolha uma opção</option>
										<?php echo geraOpcaoMeta("meta") ?>
									</select>			
								</td>

								<td>
									<input type="text" name="ano-base" class="form-control" id="inputSubject" />
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
						$sql_list =  "SELECT * FROM sc_tipo WHERE publicado = '1' AND abreviatura = 'projeto' 
                               $ano_base ORDER BY tipo ASC";
						$res = $wpdb->get_results($sql_list,ARRAY_A);
						
						for($i = 0; $i < count($res); $i++){
							$json = json_decode($res[$i]['descricao'],true);
							$programa = tipo($json['programa']);
							$plan = retornaPlanejamento($res[$i]['id_tipo'],date('Y'));
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
		$meta = $_POST["meta"];
		$ano_base = $_POST['ano_base'];
		$json = array(
			"programa" => "$programa",
			"inicio" => "$inicio",
			"responsavel" => "$responsavel",
			"fim" => "$fim",
			"descricao" => "$descricao",
			"meta" =>  "$meta"
		);
		$des = json_encode($json,JSON_UNESCAPED_UNICODE );
		$sql_upd = "UPDATE sc_tipo SET
		tipo = '$titulo',
		descricao = '$des'
		WHERE id_tipo = '$id';	
		";
		$upd = $wpdb->query($sql_upd);
		atualizaMetaOrcamento();
		if($upd == 1){
			$mensagem = alerta("Atualizado com sucesso.","success");
			atualizaMetaOrcamento();
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
							<label>Meta</label>
							<select class="form-control" name="meta" id="inputSubject" >
								<option value='0'>Escolha uma opção</option>
								<?php echo geraOpcaoMeta($pro_json['meta']); ?>
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
							<label>Ano Base </label>
							<input type="text" name="ano_base" class="form-control" id="inputSubject" value="<?php echo $projeto['ano_base'] ?>" />
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
case 'giap':  

$sql_giap = "SELECT DISTINCT projeto, ficha, ano FROM `sc_contabil` ORDER BY ano ASC";
$giap = $wpdb->get_results($sql_giap,ARRAY_A);

$sql_msg = "SELECT DISTINCT atualizacao FROM `sc_contabil` ORDER BY projeto, ficha ASC";
$msg = $wpdb->get_results($sql_msg,ARRAY_A);

$mensagem = "Atualizado em ".exibirDataBr($msg[0]['atualizacao']);



?>





<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>GIAP</h1>
				<?php if(isset($mensagem)){echo $mensagem;}?>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Ano Base</th>
						<th>Projeto</th>
						<th>Ficha</th>
						<th>Empenho</th>
						<th>Estorno</th>
						<th>Anulado</th>
						<th>Não processado</th>
						<th>Processado</th>
						<th>Ordem de Pagamento</th>
						<th>Ordem Baixado</th>
						<th>Saldo dos Empenhos</th>

					</tr>
				</thead>
				<tbody>
					<?php 


					for($i = 1; $i < count($giap); $i++){
						$ficha = $giap[$i]['ficha'];
						$projeto = $giap[$i]['projeto'];
						$ano = $giap[$i]['ano'];
						$sql_soma = "SELECT SUM(v_op) FROM sc_contabil WHERE projeto = '$projeto' AND ficha = '$ficha' AND ano = '$ano'";
						$soma = $wpdb->get_results($sql_soma,ARRAY_A);
						
						$sql_soma2 = "SELECT SUM(v_empenho) FROM sc_contabil WHERE projeto = '$projeto' AND ficha = '$ficha' AND ano = '$ano'";
						$soma2 = $wpdb->get_results($sql_soma2,ARRAY_A);

						$sql_soma3 = "SELECT SUM(v_estorno) FROM sc_contabil WHERE projeto = '$projeto' AND ficha = '$ficha' AND ano = '$ano'";
						$soma3 = $wpdb->get_results($sql_soma3,ARRAY_A);	

						$sql_soma4 = "SELECT SUM(v_n_processado) FROM sc_contabil WHERE projeto = '$projeto' AND ficha = '$ficha' AND ano = '$ano'";
						$soma4 = $wpdb->get_results($sql_soma4,ARRAY_A);

						$sql_soma5 = "SELECT SUM(v_anulado) FROM sc_contabil WHERE projeto = '$projeto' AND ficha = '$ficha' AND ano = '$ano'";
						$soma5 = $wpdb->get_results($sql_soma5,ARRAY_A);	

						$sql_soma6 = "SELECT SUM(v_processado) FROM sc_contabil WHERE projeto = '$projeto' AND ficha = '$ficha' AND ano = '$ano'";
						$soma6 = $wpdb->get_results($sql_soma6,ARRAY_A);

						$sql_soma7 = "SELECT SUM(v_op_baixado) FROM sc_contabil WHERE projeto = '$projeto' AND ficha = '$ficha' AND ano = '$ano'";
						$soma7 = $wpdb->get_results($sql_soma7,ARRAY_A);	

						$sql_soma8 = "SELECT SUM(v_saldo) FROM sc_contabil WHERE projeto = '$projeto' AND ficha = '$ficha' AND ano = '$ano'";
						$soma8 = $wpdb->get_results($sql_soma8,ARRAY_A);	
						
						
						
						
						
						?>

						<tr>
							<td><?php echo $ano ?></td>
							<td><?php echo $projeto ?></td>
							<td><?php echo $ficha ?></td>
							<td><?php echo dinheiroParaBr($soma2[0]['SUM(v_empenho)']); // empenho ?></td>
							<td><?php echo dinheiroParaBr($soma3[0]['SUM(v_estorno)']); // estorno ?></td>
							<td><?php echo dinheiroParaBr($soma5[0]['SUM(v_anulado)']); // anulado ?></td>
							<td><?php echo dinheiroParaBr($soma4[0]['SUM(v_n_processado)']); // nao processado?></td>
							<td><?php echo dinheiroParaBr($soma6[0]['SUM(v_processado)']); // processado?></td>
							<td><?php echo dinheiroParaBr($soma[0]['SUM(v_op)']); // ordem de pagamento?></td>
							<td><?php echo dinheiroParaBr($soma7[0]['SUM(v_op_baixado)']); // ordem de pagamento baixado ?></td>
							<td><?php echo dinheiroParaBr($soma8[0]['SUM(v_saldo)']); ?></td>



						</tr>

						<?php

					}



					?>	
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
