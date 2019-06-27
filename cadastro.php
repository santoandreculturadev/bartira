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
	
	<?php include "menu/evento.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<?php 
		switch($p){
			case "inicio": 
			if(isset($_SESSION['id'])){
				unset($_SESSION['id']);
			}
			?>
			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="row">    
						<div class="col-md-offset-2 col-md-8">
							<h1>Meus Eventos</h1>
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

								<h3>Evento - Informações Gerais</h3>
								<h1></h1>
								<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
							</div>
						</div> 
						<div class="row">
							<div class="col-md-offset-1 col-md-10">
								<form method="POST" action="?p=editar" class="form-horizontal" role="form">
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Nome do Evento *</label>
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
										<div class="col-md-offset-2">
											<label>Linguagem principal *</label>
											<select class="form-control" name="linguagem" id="inputSubject" >
												<option>Escolha uma opção</option>
												<?php geraTipoOpcao("linguagens") ?>
											</select>					
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Tipo de evento *</label>
											<select class="form-control" name="tipo_evento" id="inputSubject" >
												<option>Escolha uma opção</option>
												<?php geraTipoOpcao("tipo_evento") ?>
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
										<div class="col-md-offset-2">
											<input type="checkbox" name="subEvento" id="subEvento" <?php //checar($campo['subEvento']) ?>/><label style="padding:0 10px 0 5px;"> Haverá evento(s) complementar(es) (sub-evento)?</label>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Autor*</label>
											<textarea name="autor" class="form-control" rows="10" placeholder="Artista, banda, coletivo, companhia, palestrantes, etc autor da obra/espetáculo."></textarea>
										</div> 
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Nome do Grupo</label>
											<input type="text" name="nomeGrupo" class="form-control" maxlength="100" id="inputSubject" placeholder="Nome do coletivo, grupo teatral, etc." value=""/>
										</div> 
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Ficha técnica completa*</label>
											<textarea name="fichaTecnica" class="form-control" rows="10" placeholder="Elenco, técnicos, programa do concerto, outros profissionais envolvidos."><?php ////echo $campo["fichaTecnica"] ?></textarea>
										</div> 
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Classificação/indicação etária</label>
											<select class="form-control" name="faixaEtaria" id="inputSubject" >
												<option>Escolha uma opção</option>
												<?php geraTipoOpcao("faixa_etaria") ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Sinopse *</label>
											<textarea name="sinopse" class="form-control" rows="10" placeholder="Texto para divulgação e sob editoria da area de comunicação. Não ultrapassar 400 caracteres."><?php //echo $campo["sinopse"] ?></textarea>
										</div> 
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Release *</label>
											<textarea name="releaseCom" class="form-control" rows="10" placeholder="Texto auxiliar para as ações de comunicação. Releases do trabalho, pequenas biografias, currículos, etc"><?php ////echo $campo["releaseCom"] ?></textarea>
										</div> 
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Links </label>
											<textarea name="linksCom" class="form-control" rows="10" placeholder="Links para auxiliar a divulgação e o jurídico. Site oficinal, vídeos, clipping, artigos, etc "><?php ////echo $campo["linksCom"] ?></textarea>
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
				
				if(isset($_SESSION['id'])){
					$id = $_SESSION['id'];
					$sql_select = "SELECT * FROM sc_evento WHERE idEvento = '$id'";
					$evento = $wpdb->get_row($sql_select,ARRAY_A);
				}

				if(isset($_POST['atualizar']) OR isset($_POST['inserir'])){
					$nomeEvento = addslashes($_POST["nomeEvento"]);
					$programa    = $_POST["programa"];
					$linguagem    = $_POST["linguagem"];
					$tipo_evento = $_POST["tipo_evento"];
					$projeto = $_POST["projeto"];
					$nomeResponsavel    = $_POST["nomeResponsavel"];
					$suplente    = $_POST["suplente"];
					$autor    = addslashes($_POST["autor"]);
					$nomeGrupo    = addslashes($_POST["nomeGrupo"]);
					$fichaTecnica    = addslashes($_POST["fichaTecnica"]);
					$faixaEtaria    = $_POST["faixaEtaria"];
					$sinopse    = addslashes($_POST["sinopse"]);
					$releaseCom    = addslashes($_POST["releaseCom"]);
					$linksCom    = $_POST["linksCom"];
					if(isset($_POST['subEvento'])){
						$subEvento = $_POST['subEvento'];
					}else{
						$subEvento = NULL;
					}
				}
				
				if(isset($_POST['carregar'])){
					$id = $_POST['carregar'];
					$sql_select = "SELECT * FROM sc_evento WHERE idEvento = '$id'";
					$evento = $wpdb->get_row($sql_select,ARRAY_A);	
					$_SESSION['id'] = $id;
				}
				
				$idUser = $user->ID;
				

	// Inserir evento
				if(isset($_POST['inserir'])){
					$sql = "INSERT INTO `sc_evento` (`idEvento`, `idTipo`, `idPrograma`, `idProjeto`, `idLinguagem`, `nomeEvento`, `idResponsavel`, `idSuplente`, `autor`, `nomeGrupo`, `fichaTecnica`, `faixaEtaria`, `sinopse`, `releaseCom`, `publicado`, `idUsuario`, `linksCom`, `subEvento`, `dataEnvio`) 
					VALUES (NULL, '$tipo_evento', '$programa', '$projeto', '$linguagem', '$nomeEvento', '$nomeResponsavel', '$suplente', '$autor', '$nomeGrupo', '$fichaTecnica', '$faixaEtaria', '$sinopse', '$releaseCom', '1', '$idUser', '$linksCom', 'subEvento', NULL)";		$ins = $wpdb->query($sql);
					if($ins){
						$mensagem = "Inserido com sucesso";
						$id = $wpdb->insert_id;
						$sql_select = "SELECT * FROM sc_evento WHERE idEvento = '$id'";
						$evento = $wpdb->get_row($sql_select,ARRAY_A);
						$_SESSION['id'] = $evento['idEvento'];
						
					}else{
						$mensage = "Erro ao inserir";
						
					}
					
				}

				if(isset($_POST['atualizar'])){
					$atualizar    = $_POST["atualizar"];	
					$sql_atualizar = "UPDATE sc_evento SET
					`idTipo` = '$tipo_evento',
					`idPrograma` = '$programa' ,
					`idProjeto` =  '$projeto',
					`idLinguagem` = '$linguagem',
					`nomeEvento` = '$nomeEvento',
					`idResponsavel` = '$nomeResponsavel',
					`idSuplente` = '$suplente',
					`autor` = '$autor',
					`nomeGrupo` = '$nomeGrupo',
					`fichaTecnica` = '$fichaTecnica',
					`faixaEtaria` = '$faixaEtaria',
					`sinopse` = '$sinopse',
					`releaseCom` = '$releaseCom',
					`linksCom` = '$linksCom',
					`subEvento` = '$subEvento'
					WHERE `idEvento` = '$atualizar';
					";
					$atual = $wpdb->query($sql_atualizar);
					$sql_select = "SELECT * FROM sc_evento WHERE idEvento = '$atualizar'";
					$evento = $wpdb->get_row($sql_select,ARRAY_A);
					$_SESSION['id'] = $evento['idEvento'];
					
					if($atual == 1){
						$mensagem = "Evento atualizado com sucesso.";
					}else{
			//$mensagem = "Erro ao atualizar.";
					}

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

								<h3>Evento - Informações Gerais</h3>
								<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

							</div>
						</div> 
						<div class="row">
							<div class="col-md-offset-1 col-md-10">
								<form method="POST" action="?p=editar" class="form-horizontal" role="form">
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Nome do Evento *</label>
											<input type="text" name="nomeEvento" class="form-control" id="inputSubject" value="<?php echo $evento['nomeEvento']; ?>"/>
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
										<div class="col-md-offset-2">
											<label>Linguagem principal *</label>
											<select class="form-control" name="linguagem" id="inputSubject" >
												<option>Escolha uma opção</option>
												<?php geraTipoOpcao("linguagens",$evento['idLinguagem']) ?>
											</select>					
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Tipo de evento *</label>
											<select class="form-control" name="tipo_evento" id="inputSubject" >
												<option>Escolha uma opção</option>
												<?php geraTipoOpcao("tipo_evento",$evento['idTipo']) ?>
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
												<?php geraOpcaoUsuario($evento['idResponsavel'])	?>							

											</select>	                
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Segundo responsável (Suplente)</label>
											<select class="form-control" name="suplente" id="inputSubject" >
												<option>Escolha uma opção</option>
												<?php geraOpcaoUsuario($evento['idSuplente'])	?>							

											</select>	
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<input type="checkbox" name="subEvento" id="subEvento" <?php //checar($campo['subEvento']) ?>/><label style="padding:0 10px 0 5px;"> Haverá evento(s) complementar(es) (sub-evento)?</label>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Autor*</label>
											<textarea name="autor" class="form-control" rows="10" placeholder="Artista, banda, coletivo, companhia, palestrantes, etc autor da obra/espetáculo."><?php echo $evento['autor']; ?></textarea>
										</div> 
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Nome do Grupo</label>
											<input type="text" name="nomeGrupo" class="form-control" maxlength="100" id="inputSubject" placeholder="Nome do coletivo, grupo teatral, etc." value="<?php echo $evento['nomeGrupo']; ?>"/>
										</div> 
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Ficha técnica completa*</label>
											<textarea name="fichaTecnica" class="form-control" rows="10" placeholder="Elenco, técnicos, programa do concerto, outros profissionais envolvidos."><?php echo $evento["fichaTecnica"] ?></textarea>
										</div> 
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Classificação/indicação etária</label>
											<select class="form-control" name="faixaEtaria" id="inputSubject" >
												<option>Escolha uma opção</option>
												<?php geraTipoOpcao("faixa_etaria",$evento['faixaEtaria']) ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Sinopse *</label>
											<textarea name="sinopse" class="form-control" rows="10" placeholder="Texto para divulgação e sob editoria da area de comunicação. Não ultrapassar 400 caracteres."><?php echo $evento["sinopse"] ?></textarea>
										</div> 
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Release *</label>
											<textarea name="releaseCom" class="form-control" rows="10" placeholder="Texto auxiliar para as ações de comunicação. Releases do trabalho, pequenas biografias, currículos, etc"><?php echo $evento["releaseCom"] ?></textarea>
										</div> 
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Links </label>
											<textarea name="linksCom" class="form-control" rows="10" placeholder="Links para auxiliar a divulgação e o jurídico. Site oficinal, vídeos, clipping, artigos, etc "><?php echo $evento["linksCom"] ?></textarea>
										</div> 
									</div>
									<div class="form-group">
										<div class="col-md-offset-2">
											<input type="hidden" name="atualizar" value="<?php echo $evento['idEvento']; ?>" />
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
				case "meuseventos":
				?>
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