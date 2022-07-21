<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
session_start();
$_SESSION['entidade'] = 'atividade';

?>

<body>
	
	<?php include "menu/me_atividade.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<?php 
		switch($p){
			case "inicio": 
			if(isset($_SESSION['id'])){
				unset($_SESSION['id']);
			}

			if(isset($_POST['apagar'])){
				$id = $_POST['apagar'];
				$sql = "UPDATE sc_atividade SET publicado = '0' WHERE id = '$id'";
				$query = $wpdb->query($sql);
				if($query == 1){
					$sql_sel = "UPDATE sc_contratacao SET publicado = '0' WHERE idAtividade = '$id'";
					$query_sel = $wpdb->query($sql_sel);
				}

				
			}
			?>
			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="row">    
						<div class="col-md-offset-2 col-md-8">
							<h1>Minhas Atividades</h1>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Atividade</th>
									<th>Programa</th>
									<th>Projeto</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								global $wpdb;
								$id_user = $user->ID;
								if($user->ID == 1 OR $user->ID == 5 ){
									$sql_list =  "SELECT * FROM sc_atividade WHERE publicado = '1' ORDER BY id DESC";
								}else{
									$sql_list =  "SELECT * FROM sc_atividade WHERE publicado = '1' AND (idRes = '$id_user' OR idSuplente = '$id_user' OR id_usuario = '$id_user' ) ORDER BY id DESC";
								}
								$res = $wpdb->get_results($sql_list,ARRAY_A);
								for($i = 0; $i < count($res); $i++){
									$evento = atividade($res[$i]['id']);
									
									?>
									<tr>
										<td><?php echo $res[$i]['id']; ?></td>
										<td><?php echo $res[$i]['titulo']; ?></td>
										<td><?php echo $evento['programa']; ?></td>
										<td><?php echo $evento['projeto']; ?></td>
										<td>	
											<form method="POST" action="?p=editar" class="form-horizontal" role="form">
												<input type="hidden" name="carregar" value="<?php echo $res[$i]['id']; ?>" />
												<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
											</form>
											<?php 
											
											?></td>
											<td>	
												<form method="POST" action="?" class="form-horizontal" role="form">
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
					case "enviar":
					if(isset($_SESSION['id'])){
						unset($_SESSION['id']);
					}

					?>

					<link href="css/jquery-ui.css" rel="stylesheet">
					<script src="js/jquery-ui.js"></script>
					<script src="js/mask.js"></script>
					<script src="js/maskMoney.js"></script> 

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
							$( ".calendario" ).datepicker();
							$( ".hora" ).mask("99:99");
							$( ".min" ).mask("999");
							$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
							
						});

					</script>

										<section id="enviar" class="home-section bg-white">
						<div class="container">
							<div class="row">
								<div class="col-md-offset-2 col-md-8">

									<h3>Atividade enviada com sucesso!</h3>
									<h1></h1>
									<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
								</div>
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
					<link href="css/jquery-ui.css" rel="stylesheet">
					<script src="js/jquery-ui.js"></script>
					<script src="js/mask.js"></script>
					<script src="js/maskMoney.js"></script> 

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

									<h3>Atividades - Informações Gerais</h3>
									<h1></h1>
									<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
								</div>
							</div> 
							<div class="row">
								<div class="col-md-offset-1 col-md-10">
									<form method="POST" action="?p=editar" class="form-horizontal" role="form">
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Nome da Atividade *</label>
												<input type="text" name="nomeEvento" class="form-control" id="inputSubject" value=""/>
											</div> 
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Programa</label>
												<select class="form-control" name="programa" id="programa" >
													<option>Escolha uma opção</option>
													<?php geraTipoOpcao("programa") ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Projeto</label>
												<select class="form-control" name="projeto" id="projeto" >
												</select>
											</div>
										</div>
										<div class="form-group">
											<br />
											<p>O responsável e suplente devem estar cadastrados como usuários do sistema.</p>
											<div class="col-md-offset-2">
												<label>Primeiro responsável (Fiscal)</label>
												<select class="form-control" name="nomeResponsavel" id="inputSubject" >
													<option>Escolha uma opção</option>
													<?php geraOpcaoUsuario();	?>							
												</select>	                
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Segundo responsável (Suplente)</label>
												<select class="form-control" name="suplente" id="inputSubject" >
													<option>Escolha uma opção</option>
													<?php geraOpcaoUsuario();	?>							

												</select>	
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2 col-md-8">
												<label>Data de Início:</label>
												<input type='text' class="form-control calendario" name="data_inicio"/>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2 col-md-8">
												<label>Data de Encerramento:</label>
												<input type='text' class="form-control calendario" name="data_final"/>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Ano Base *</label>
												<input type="text" name="ano" class="form-control" id="inputSubject" value="<?php echo date('Y'); ?>"/>
											</div> 
										</div>

										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Descrição*</label>
												<textarea name="descricao" class="form-control" rows="10" placeholder="Artista, banda, coletivo, companhia, palestrantes, etc autor da obra/espetáculo."></textarea>
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
					case "editar":

					global $wpdb;	
	//session_start();
					
					if(isset($_SESSION['id'])){
						$id = $_SESSION['id'];
						$sql_select = "SELECT * FROM sc_atividade WHERE id = '$id'";
						$evento = $wpdb->get_row($sql_select,ARRAY_A);
					}

					if(isset($_POST['atualizar']) OR isset($_POST['inserir'])){
						$nomeEvento = addslashes($_POST["nomeEvento"]);
						$programa    = $_POST["programa"];
						$projeto = $_POST["projeto"];
						$nomeResponsavel    = $_POST["nomeResponsavel"];
						$suplente    = $_POST["suplente"];
						$ano    = $_POST["ano"];
						$descricao    = addslashes($_POST["descricao"]);
						$data_inicio = exibirDataMysql($_POST["data_inicio"]);
						if($_POST["data_final"] != ''){
							$data_final   = exibirDataMysql($_POST["data_final"]);
						}else{
							$data_final = '0000-00-00';
						}
					}
					
					if(isset($_POST['carregar'])){
						$id = $_POST['carregar'];
						$sql_select = "SELECT * FROM sc_atividade WHERE id = '$id'";
						$evento = $wpdb->get_row($sql_select,ARRAY_A);	
						$_SESSION['id'] = $id;
					}
					
					$idUser = $user->ID;
					

	// Inserir evento
					if(isset($_POST['inserir'])){
						$sql = "INSERT INTO `sc_atividade` (`titulo`, `idRes`, `idSuplente`, `idProjeto`, `idPrograma`, `periodo_inicio`, `periodo_fim`, `ano_base`, `descricao`, `id_usuario`, `publicado`) 
						VALUES ('$nomeEvento', '$nomeResponsavel', '$suplente', '$projeto', '$programa', '$data_inicio', '$data_final', '$ano', '$descricao', '$idUser', '1')";
						$ins = $wpdb->query($sql);
						if($ins){
							$mensagem = "Inserido com sucesso";
							$id = $wpdb->insert_id;
							$sql_select = "SELECT * FROM sc_atividade WHERE id = '$id'";
							$evento = $wpdb->get_row($sql_select,ARRAY_A);
							$_SESSION['id'] = $evento['id'];
							
						}else{
							$mensage = "Erro ao inserir".var_dump($ins);
							
						}
						
					}

					if(isset($_POST['atualizar'])){
						$atualizar    = $_POST["atualizar"];	
						$sql_atualizar = "UPDATE sc_atividade SET
						`idPrograma` = '$programa' ,
						`idProjeto` =  '$projeto',
						`titulo` = '$nomeEvento',
						`idRes` = '$nomeResponsavel',
						`idSuplente` = '$suplente',
						`ano_base` = '$ano',
						`periodo_inicio` = '$data_inicio',
						`periodo_fim` = '$data_final',
						`descricao` = '$descricao'
						WHERE `id` = '$atualizar';
						";
						$atual = $wpdb->query($sql_atualizar);
						$sql_select = "SELECT * FROM sc_atividade WHERE id = '$atualizar'";
						$evento = $wpdb->get_row($sql_select,ARRAY_A);
						$_SESSION['id'] = $evento['id'];
						
						if($atual == 1){
							$mensagem = "Evento atualizado com sucesso.";
						}else{
							$mensagem = var_dump($atual);
						}

					}
						
					?>
					<link href="css/jquery-ui.css" rel="stylesheet">
					<script src="js/jquery-ui.js"></script>
					<script src="js/mask.js"></script>
					<script src="js/maskMoney.js"></script> 

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

									<h3>Atividades - Informações Gerais</h3>
									<h1></h1>
									<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
								</div>
							</div> 
							<div class="row">
								<div class="col-md-offset-1 col-md-10">
									<form method="POST" action="?p=editar" class="form-horizontal" role="form">
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Nome da Atividade *</label>
												<input type="text" name="nomeEvento" class="form-control" id="inputSubject" value="<?php echo $evento['titulo']; ?>"/>
											</div> 
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Programa</label>
												<select class="form-control" name="programa" id="programa" >
													<option>Escolha uma opção</option>
													<?php geraTipoOpcao("programa",$evento['idPrograma']) ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Projeto</label>
												<select class="form-control" name="projeto" id="projeto" >
													<option>Escolha uma opção</option>
													<?php geraTipoOpcao("projeto",$evento['idProjeto']) ?>								
												</select>
											</div>
										</div>
										<div class="form-group">
											<br />
											<p>O responsável e suplente devem estar cadastrados como usuários do sistema.</p>
											<div class="col-md-offset-2">
												<label>Primeiro responsável (Fiscal)</label>
												<select class="form-control" name="nomeResponsavel" id="inputSubject" >
													<option>Escolha uma opção</option>
													<?php geraOpcaoUsuario($evento['idRes']);	?>							
												</select>	                
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Segundo responsável (Suplente)</label>
												<select class="form-control" name="suplente" id="inputSubject" >
													<option>Escolha uma opção</option>
													<?php geraOpcaoUsuario($evento['idSuplente']);	?>							

												</select>	
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Data de Início:</label>
												<input type='text' class="form-control calendario" name="data_inicio" value="<?php echo exibirDataBr($evento['periodo_inicio']); ?>"/>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<label>Data de Encerramento:</label>
												<input type='text' class="form-control calendario" name="data_final" value="<?php echo exibirDataBr($evento['periodo_fim']); ?>"/>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-offset-2">
												<div class="col-md-offset-2">
													<label>Ano Base *</label>
													<input type="text" name="ano" class="form-control" id="inputSubject" value="<?php echo $evento['ano_base']; ?>"/>
												</div> 
											</div>

											<div class="form-group">
												<div class="col-md-offset-2">
													<label>Descrição*</label>
													<textarea name="descricao" class="form-control" rows="10" placeholder="Artista, banda, coletivo, companhia, palestrantes, etc autor da obra/espetáculo."><?php echo $evento['descricao']; ?></textarea>
												</div> 
											</div>
											<div class="form-group">
												<div class="col-md-offset-2">
													<input type="hidden" name="atualizar" value="<?php echo $evento['id']; ?>" />
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