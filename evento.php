<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
session_start();
$_SESSION['entidade'] = 'evento';
?>


<body>
	
	<?php include "menu/me_evento.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<?php 
		switch($p){
			case "inicio": 
if(isset($_POST['enviar'])){  // envia
	// muda status de dataEnvio para hoje
	// atualiza a agenda
	$idEvento = $_SESSION['id'];
	$hoje = date("Y-m-d H:i:s");
	global $wpdb;
	$sql_enviar = "UPDATE sc_evento SET dataEnvio = '$hoje', status = '2' WHERE idEvento = '$idEvento'";
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

if(isset($_GET['order'])){
	$order = ' ORDER BY nomeEvento ASC ';
}else{
	$order = ' ORDER BY idEvento DESC ';
}

if(isset($_POST['apagar'])){
	$id = $_POST['apagar'];
	$sql = "UPDATE sc_evento SET publicado = '0' WHERE idEvento = '$id'";
	$query = $wpdb->query($sql);
	if($query == 1){
		$sql_sel = "UPDATE sc_contratacao SET publicado = '0' WHERE idEvento = '$id'";
		$query_sel = $wpdb->query($sql_sel);

	$sql_apaga_mov = "UPDATE sc_mov_orc SET publicado = '0' WHERE idPedidoContratacao = '".$_POST['apagar']."'";
	$query_apaga_mov = $wpdb->query($sql_apaga_mov);

	}
	
	
}

?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Meus Eventos</h1>
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
					$idUser = $user->ID;
					if($idUser == 63 OR $idUser == 1 OR $idUser == 5 OR $idUser == 77 OR $idUser == 15){
						$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' $order LIMIT 0,200" ;					
					}else{
						$sql_list =  "SELECT idEvento FROM sc_evento WHERE  publicado = '1' AND (idUsuario = '$idUser' OR idResponsavel = '$idUser' OR idSuplente = '$idUser')  $order LIMIT 0,200";
					}
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
							<td><?php echo $evento['status']; ?></td>
							<td>	<?php if($evento['dataEnvio'] == NULL){ ?>
								<form method="POST" action="?p=editar" class="form-horizontal" role="form">
									<input type="hidden" name="carregar" value="<?php echo $res[$i]['idEvento']; ?>" />
									<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
								</form>
							</td>

							<?php if ($evento['status'] = '1') { ?>
								<td>	
								<form method="POST" action="?" class="form-horizontal" role="form">
									<input type="hidden" name="apagar" value="<?php echo $res[$i]['idEvento']; ?>" />
									<input type="submit" class="btn btn-theme btn-sm btn-block" value="Apagar">
								</form>
							<?php }

							} ?>	
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
case "dotacoes": 
			if(isset($_SESSION['id'])){
				unset($_SESSION['id']);
			}

			$ano_base = date('Y');

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
									<th>Ficha</th>
									<th>Dotação</th>
									<th>Descricao</th>
									<th>Ano Base</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								global $wpdb;
								$sql_list =  "SELECT * FROM sc_orcamento WHERE planejamento = '0' AND publicado = '1' AND ano_base = '$ano_base' AND dotacao IS NOT NULL ORDER BY projeto ASC, ficha ASC";
								$res = $wpdb->get_results($sql_list,ARRAY_A);
								for($i = 0; $i < count($res); $i++){
									
									?>
									<tr>
										<td><?php echo $res[$i]['projeto']; ?></td>
										<td><?php echo $res[$i]['ficha']; ?></td>

										<td><?php echo $res[$i]['dotacao']; ?></td>
										<td><?php echo $res[$i]['descricao']; ?></td>
										<td><?php echo $res[$i]['ano_base']; ?></td>	
									</tr>
										<?php } // fim do for?>	
									</tbody>
								</table>
							</div>

						</div>
					</section>

<?php 
break;
case "aniversario": 
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
				<h1>Meus Eventos - Aniversário 2018</h1>
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
						<th>Status</th>
						<th>Categoria</th>
						<th>CulturAZ</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$idUser = $user->ID;
				if($idUser == 63 OR $idUser == 1 OR $idUser == 5 OR $idUser == 77 OR $idUser == 15){ //admin, juliana, moretto, leonete
					$sql_list =  "SELECT idEvento, inscricao, categoria FROM sc_evento WHERE publicado = '1' AND  inscricao <> '' ORDER BY idEvento DESC";
				}else{
					$sql_list =  "SELECT idEvento, inscricao, categoria FROM sc_evento WHERE publicado = '1'  AND (idUsuario = '$idUser' OR idResponsavel = '$idUser' OR idSuplente = '$idUser') AND  inscricao <> '' ORDER BY idEvento DESC";
					
				}
				$res = $wpdb->get_results($sql_list,ARRAY_A);
				for($i = 0; $i < count($res); $i++){
					$evento = evento($res[$i]['idEvento']);
					
					?>
					<tr>
						<td><?php echo $res[$i]['idEvento']; ?></td>
						<td><?php echo $evento['titulo']; ?></td>
						<td><?php echo $evento['periodo']['legivel']; ?></td>
						<td><?php echo $evento['status']; ?></td>
						<td><?php echo str_replace("CATEGORIA","",$res[$i]['categoria']); ?></td>
						<td><a href="http://culturaz.santoandre.sp.gov.br/inscricao/<?php echo substr($res[$i]['inscricao'],3); ?>" target="_blank" ><?php echo $res[$i]['inscricao']; ?> </a></td>

						<td>	<?php if($evento['dataEnvio'] == NULL){ ?>
							<form method="POST" action="?p=editar" class="form-horizontal" role="form">
								<input type="hidden" name="carregar" value="<?php echo $res[$i]['idEvento']; ?>" />
								<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
							</form>
							<?php 
						}
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
case "fip2018": 

$selecionados = array("on-1738877893","on-1453010115","on-781389061","on-1046440738","on-1773097257","on-783829307","on-1761685716","on-352832","on-732854095","on-1442268823","on-1566051262","on-1683241002","on-1714966032","on-118036985","on-743253080","on-1048183298","on-757466696","on-816928171","on-206463587","on-802625839","on-1577808338","on-1911167732","on-21575494","on-692984084","on-1619996948","on-597512233","on-238034968","on-1968119092","on-833444987","on-947680953","on-1322976383","on-1820229336","on-2052139008","on-1717118768","on-1400064695","on-275136340","on-764674688","on-81144614","on-1097209228","on-2083747890","on-772235373","on-1489454805","on-1064335160","on-575366804","on-199453234","on-1038431609","on-1386686453","on-998397921","on-1901353153","on-63316958","on-1093220644","on-31740023","on-467012070","on-1511533568","on-549538762","on-1542680140","on-1762919233","on-840918750","on-1579498570","on-144863959","on-998053853","on-1014304746","on-1873687417","on-2059946682","on-1637835576","on-1213339754","on-1790838746","on-1686202074","on-1335892498","on-700738777","on-924806377","on-2114852335");


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
				<h1>Meus Eventos - FIP2018</h1>
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
						<th>Status</th>
						<th>Categoria</th>
						<th>CulturAZ</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$idUser = $user->ID;
				if($idUser == 63 OR $idUser == 1 OR $idUser == 5 OR $idUser == 77 OR $idUser == 15){ //admin, juliana, moretto
					$sql_list =  "SELECT idEvento, inscricao, categoria FROM sc_evento WHERE publicado = '1' AND  inscricao <> '' ORDER BY idEvento DESC";
				}else{
					$sql_list =  "SELECT idEvento, inscricao, categoria FROM sc_evento WHERE publicado = '1'  AND (idUsuario = '$idUser' OR idResponsavel = '$idUser' OR idSuplente = '$idUser') AND  inscricao <> '' ORDER BY idEvento DESC";
					
				}
				$res = $wpdb->get_results($sql_list,ARRAY_A);
				for($i = 0; $i < count($res); $i++){
					if(in_array($res[$i]['inscricao'],$selecionados)){
						
						
						
						$evento = evento($res[$i]['idEvento']);
						
						?>
						<tr>
							<td><?php echo $res[$i]['idEvento']; ?></td>
							<td><?php echo $evento['titulo']; ?></td>
							<td><?php echo $evento['periodo']['legivel']; ?></td>
							<td><?php echo $evento['status']; ?></td>
							<td><?php echo str_replace("CATEGORIA","",$res[$i]['categoria']); ?></td>
							<td><a href="http://culturaz.santoandre.sp.gov.br/inscricao/<?php echo substr($res[$i]['inscricao'],3); ?>" target="_blank" ><?php echo $res[$i]['inscricao']; ?> </a></td>

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
					} // fim do if
				} // fim do for?>	
				
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
				$.getJSON('inc/projeto.ajax.php?ano_base=all&',{programa: $(this).val(), ajax: 'true'}, function(j)
				{
					var options = '<option value="0"></option>';	
					for (var i = 0; i < j.length; i++)
					{
						options += '<option value="' + j[i].id + '">' + j[i].projeto + ' ('+ j[i].ano_base +')</option>';
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
							<!--<input type="checkbox" name="planejamento" id="subEvento" <?php //checar($campo['subEvento']) ?>/><label style="padding:0 10px 0 5px;"> Evento em planejamento?</label>-->
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Nome do Evento *</label>
							<input type="text" name="nomeEvento" class="form-control" id="inputSubject" value=""/>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Programa *</label>
							<select class="form-control" name="programa" id="programa" >
								<option>Escolha uma opção</option>
								<?php geraTipoOpcao("programa") ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Projeto *</label>
							<select class="form-control" name="projeto" id="projeto" >
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Linguagem Principal *</label>
							<select class="form-control" name="linguagem" id="inputSubject" >
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
						<div class="col-md-offset-2">
							<label>Projeto Interno</label>
							<input type="text" name="pInterno" class="form-control" id="inputSubject" />
						</div> 
					</div>	
					<div class="form-group">
						<br />
						<p>O responsável e suplente devem estar cadastrados como usuários do sistema. </p>
						<div class="col-md-offset-2">
							<label>Primeiro responsável (Fiscal) *</label>
							<select class="form-control" name="nomeResponsavel" id="inputSubject" >
								<option value="0"></option>
								<?php geraOpcaoUsuario();	?>							
							</select>	                
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Segundo responsável (Suplente)</label>
							<select class="form-control" name="suplente" id="inputSubject" >
								<option value="0"></option>
								<?php geraOpcaoUsuario();	?>							

							</select>	
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Responsável pela Aprovação *</label>
							<select class="form-control" name="id_aprovacao" id="inputSubject" >
								<option value="0"></option>
								<?php geraOpcaoUsuario()	?>						
							</select>	
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Nome do Artista/Cia/Banda/Grupo/Dupla</label>
							<input type="text" name="nomeGrupo" class="form-control" maxlength="100" id="inputSubject" placeholder="Nome do coletivo, grupo teatral, etc." value=""/>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Número de Inscrição CulturAZ (caso tenha sido selecionado via plataforma)</label>
							<input type="text" name="inscricao" class="form-control" maxlength="100" id="inputSubject" placeholder="" value=""/>
						</div> 
					</div>
                     <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Edital/Convocatoria</label>
                                <select class="form-control" name="nome_convocatoria" id="nome_convocatoria">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("convocatoria",$evento['edital']) ?>
                                </select>
                            </div>
                        </div>
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Público Previsto</label>
							<input type="text" name="previsto" class="form-control" maxlength="100" id="inputSubject" placeholder="" value=""/>
						</div> 
					</div>
					
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Ficha técnica completa * <red>(preencher com os nomes de quem assina a autorização separados por vírgula)</red></label>
							<textarea name="fichaTecnica" class="form-control" rows="10" placeholder="Elenco, técnicos, programa do concerto, outros profissionais envolvidos."><?php ////echo $campo["fichaTecnica"] ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Classificação/indicação etária *</label>
							<select class="form-control" name="faixaEtaria" id="inputSubject" >
								<option value=''>Escolha uma opção</option>
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
							<label>Descrição Longa</label>
							<textarea name="descricao" class="form-control" rows="10" placeholder=""></textarea>
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
							<label>Evento online? *</label>
							<select class="form-control" name="online" id="inputSubject" >
								<option value="0">Não</option>
								<option value="1">Sim</option>
							</select>	
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Endereço/Link do evento online (não esqueça http:// ou https://)</label>
							<input type="text" name="urlonline" class="form-control" maxlength="255" id="inputSubject" placeholder="" value=""/>
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
	$nomeResponsavel = $_POST["nomeResponsavel"];
	$suplente = $_POST["suplente"];
	$nomeGrupo = addslashes($_POST["nomeGrupo"]);
	$fichaTecnica = addslashes($_POST["fichaTecnica"]);
	$faixaEtaria = $_POST["faixaEtaria"];
	$sinopse = addslashes($_POST["sinopse"]);
	$descricao = addslashes($_POST["descricao"]);
	$releaseCom = addslashes($_POST["releaseCom"]);
	$linksCom = addslashes($_POST["linksCom"]);
	$inscricao = $_POST['inscricao'];
	$p_interno = addslashes($_POST['pInterno']);
	$id_aprovacao = $_POST['id_aprovacao'];
	$previsto = $_POST['previsto'];		
	$online = $_POST['online'];
	$urlonline = addslashes($_POST['urlonline']);
	$edital = $_POST['nome_convocatoria'];
	

	if(isset($_POST['subEvento'])){
		$subEvento = $_POST['subEvento'];
	}else{
		$subEvento = NULL;
	}
	if(isset($_POST['planejamento'])) : $planejamento = 1; else: $planejamento = NULL; endif;
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
	$sql = "INSERT INTO `sc_evento` (`idEvento`, `idTipo`, `idPrograma`, `idProjeto`, `idLinguagem`, `nomeEvento`, `idResponsavel`, `idSuplente`, `nomeGrupo`, `fichaTecnica`, `faixaEtaria`, `sinopse`, `releaseCom`, `publicado`, `idUsuario`, `linksCom`, `subEvento`, `dataEnvio`, `planejamento`, `inscricao`, `convocatoria_edital` ,`pInterno` , `idRespAprovacao`, `status` , `previsto`, `descricao`,`ano_base`,`online`, `url` ) 
	VALUES (NULL, '$tipo_evento', '$programa', '$projeto', '$linguagem', '$nomeEvento', '$nomeResponsavel', '$suplente', '$nomeGrupo', '$fichaTecnica', '$faixaEtaria', '$sinopse', '$releaseCom', '1', '$idUser', '$linksCom', 'subEvento', NULL, '$planejamento','$inscricao', '$edital','$p_interno', '$id_aprovacao','1','$previsto','$descricao','2021','$online','$urlonline')";
	$ins = $wpdb->query($sql);
	if($ins){
		$mensagem = "Inserido com sucesso";
		$id = $wpdb->insert_id;
		$sql_select = "SELECT * FROM sc_evento WHERE idEvento = '$id'";
		$evento = $wpdb->get_row($sql_select,ARRAY_A);
		$_SESSION['id'] = $evento['idEvento'];
		gravarLog($sql, $user->ID);
		
	}else{
		$mensage = "Erro ao inserir";
		gravarLog($sql, $user->ID);
		
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
	`nomeGrupo` = '$nomeGrupo',
	`fichaTecnica` = '$fichaTecnica',
	`faixaEtaria` = '$faixaEtaria',
	`sinopse` = '$sinopse',
	`releaseCom` = '$releaseCom',
	`linksCom` = '$linksCom',
	`planejamento` = '$planejamento',
	`subEvento` = '$subEvento',
	`pInterno` = '$p_interno',
	`idRespAprovacao` = '$id_aprovacao',
	`inscricao` = '$inscricao',
	`convocatoria_edital` = '$edital',
		
	`descricao` = '$descricao',

	`previsto` = '$previsto',
	`online` = '$online',
	`url` = '$urlonline'
	
	
	WHERE `idEvento` = '$atualizar';
	";
	$atual = $wpdb->query($sql_atualizar);
	$sql_select = "SELECT * FROM sc_evento WHERE idEvento = '$atualizar'";
	$evento = $wpdb->get_row($sql_select,ARRAY_A);
	$_SESSION['id'] = $evento['idEvento'];
	
	if($atual == 1){
		$mensagem = alerta("Evento atualizado com sucesso.","success");
		gravarLog($sql_atualizar, $user->ID);
	}else{
			$mensagem = "Erro ao atualizar.<br />";
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
				$.getJSON('inc/projeto.ajax.php?ano_base=all&',{programa: $(this).val(), ajax: 'true'}, function(j)
				{
					var options = '<option value="0"></option>';	
					for (var i = 0; i < j.length; i++)
					{
						options += '<option value="' + j[i].id + '">' + j[i].projeto + ' ('+ j[i].ano_base +')</option>';
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
							<!--<input type="checkbox" name="planejamento" id="subEvento" <?php checar($evento['planejamento']) ?>/><label style="padding:0 10px 0 5px;"> Evento em planejamento?</label>-->
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Nome do Evento *</label>
							<input type="text" name="nomeEvento" class="form-control" id="inputSubject" value="<?php echo stripslashes($evento['nomeEvento']); ?>"/>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Programa *</label>
							<select class="form-control" name="programa" id="programa" >
								<option>Escolha uma opção</option>
								<?php geraTipoOpcao("programa",$evento['idPrograma']) ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Projeto *</label>
							<select class="form-control" name="projeto" id="projeto" >
								<option>Escolha uma opção</option>
								<?php geraTipoOpcao("projeto",$evento['idProjeto']) ?>								
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Linguagem Principal *</label>
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
						<div class="col-md-offset-2">
							<label>Projeto Interno</label>
							<input type="text" name="pInterno" class="form-control" id="inputSubject" value="<?php echo stripslashes($evento['pInterno']); ?>"/>
						</div> 
					</div>					
					<div class="form-group">
						<br />
						<p>O responsável e suplente devem estar cadastrados como usuários do sistema.</p>
						<div class="col-md-offset-2">
							<label>Primeiro responsável (Fiscal) *</label>
							<select class="form-control" name="nomeResponsavel" id="inputSubject" >
								<option value="0"></option>	
								<?php geraOpcaoUsuario($evento['idResponsavel'])	?>							

							</select>	                
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Segundo responsável (Suplente)</label>
							<select class="form-control" name="suplente" id="inputSubject" >
								<option value="0"></option>
								<?php geraOpcaoUsuario($evento['idSuplente'])	?>							

							</select>	
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Responsável pela Aprovação *</label>
							<select class="form-control" name="id_aprovacao" id="inputSubject" >
								<option value="0"></option>
								<?php geraOpcaoUsuario($evento['idRespAprovacao'])	?>						
							</select>	
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Nome do Artista/Cia/Banda/Grupo/Dupla</label>
							<input type="text" name="nomeGrupo" class="form-control" maxlength="100" id="inputSubject" placeholder="Nome do coletivo, grupo teatral, etc." value="<?php echo stripslashes($evento['nomeGrupo']); ?>"/>
						</div> 
					</div>		
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Número de Inscrição CulturAZ (caso tenha sido selecionado via plataforma)</label>
							<input type="text" name="inscricao" class="form-control" maxlength="100" id="inputSubject" placeholder="" value="<?php echo $evento['inscricao']; ?>"/>
						</div> 
					</div>
					
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Edital/Convocatoria</label>
                                <select class="form-control" name="nome_convocatoria" id="nome_convocatoria">
                                    <option>Escolha uma opção</option>
                                    <?php geraTipoOpcao("convocatoria",$evento['convocatoria_edital']) ?>
                                </select>
                            </div>
                        </div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Público Previsto</label>
							<input type="text" name="previsto" class="form-control" maxlength="100" id="inputSubject" placeholder="" value="<?php echo $evento['previsto']; ?>"/>
						</div> 
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Ficha técnica completa * <red>(preencher com os nomes de quem assina a autorização, separados por vírgula)</red></label>
							<textarea name="fichaTecnica" class="form-control" rows="10" placeholder="Elenco, técnicos, programa do concerto, outros profissionais envolvidos."><?php echo stripslashes($evento["fichaTecnica"]) ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Classificação/indicação etária *</label>
							<select class="form-control" name="faixaEtaria" id="inputSubject" >
								<option value=''>Escolha uma opção</option>
								<?php geraTipoOpcao("faixa_etaria",$evento['faixaEtaria']) ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Sinopse *</label>
							<textarea name="sinopse" class="form-control" rows="10" placeholder="Texto para divulgação e sob editoria da area de comunicação. Não ultrapassar 400 caracteres."><?php echo stripslashes($evento["sinopse"]) ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Descrição Longa</label>
							<textarea name="descricao" class="form-control" rows="10" placeholder=""><?php echo stripslashes($evento["descricao"]) ?></textarea>
						</div> 
					</div>					
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Release *</label>
							<textarea name="releaseCom" class="form-control" rows="10" placeholder="Texto auxiliar para as ações de comunicação. Releases do trabalho, pequenas biografias, currículos, etc"><?php echo stripslashes($evento["releaseCom"]) ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Links </label>
							<textarea name="linksCom" class="form-control" rows="10" placeholder="Links para auxiliar a divulgação e o jurídico. Site oficinal, vídeos, clipping, artigos, etc "><?php echo stripslashes($evento["linksCom"]) ?></textarea>
						</div> 
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Evento online? *</label>
							<select class="form-control" name="online" id="inputSubject" >
								<option value="0" <?php if($evento['online'] == 0){echo 'selected';} ?>>Não</option>
								<option value="1" <?php if($evento['online'] == 1){echo 'selected';} ?>>Sim</option>
							</select>	
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Endereço/Link do evento online (não esqueça http:// ou https://)</label>
							<input type="text" name="urlonline" class="form-control" maxlength="255" id="inputSubject" placeholder="" value="<?php echo stripslashes($evento['url']); ?>"/>
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
	if(isset($_GET['order'])){
		$order = ' ORDER BY nomeEvento ASC ';
	}else{
		$order = ' ORDER BY sc_evento.idEvento DESC ';
	}

	?>
	<style>
	@media (min-width: 1200px)
	.container {
		width: 1440px !important;
		max-width: 100%;
	}

</style>
<section id="contact" class="home-section bg-white">
	<div class="container" style="margin-left:0px;width:1400px !important">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Pedidos de Contratação</h1>
				<p>Para que as informações de Empenho e Pagamento sejam visualizadas, é preciso que seja inserido o número do processo (XXXXX/2020). </p>
				<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
			</div>
		</div>
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">

			</div>
		</div>
	</div>
	<?php 
		// se existe pedido, listar
	
	?>
	
	<div class="container" style="margin-left:0px;width=1400px !important;" >
		<div class="row">    
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>

						<th>Liberação</th>
						<th>Pessoa</th>
						<th>Nome / Razão Social</th>
						<th><a href="?p=pedido<?php if(isset($_GET['order'])){ echo ""; }else{ echo "&order"; }  ?>">Objeto</a></th>
						<th>Período</th>
						<th>Valor</th>
						<th>Empenho</th>
						<th>OP</th>
						
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
					
					
				//$sql_seleciona = "SELECT * FROM sc_contratacao WHERE publicado = '1' AND (idEvento IN (SELECT idEvento FROM sc_evento WHERE dataEnvio IS NOT NULL  AND (idUsuario = '$idUser' OR idResponsavel = '$idUser' OR idSuplente = '$idUser') $order )) $f ";

					if($idUser != 1 OR $idUser != 193){		
						$sql_seleciona = "SELECT DISTINCT idPedidoContratacao,sc_evento.idEvento, valor FROM sc_contratacao,sc_evento WHERE sc_contratacao.publicado = 1 AND sc_evento.dataEnvio IS NOT NULL AND (idUsuario = '$idUser' OR idResponsavel = '$idUser' OR idSuplente = '$idUser') AND sc_contratacao.idEvento = sc_evento.idEvento $order";
					}else{
						$sql_seleciona = "SELECT DISTINCT idPedidoContratacao,sc_evento.idEvento, valor FROM sc_contratacao,sc_evento WHERE sc_contratacao.publicado = 1 AND sc_evento.dataEnvio IS NOT NULL AND sc_contratacao.idEvento = sc_evento.idEvento $order";
						
					}
					$peds = $wpdb->get_results($sql_seleciona,ARRAY_A);
				//echo $sql_seleciona;
					
					for($i = 0; $i < count($peds); $i++){
						if($peds[$i]['idEvento'] != 0 AND $peds[$i]['idEvento'] != NULL){
							$pedido = retornaPedido($peds[$i]['idPedidoContratacao']);
							$contabil = retornaContabil($pedido['nProcesso']);
							
							
						}else{
						//$pedido = atividade($peds[$i]['idAtividade']);
							$pedido = retornaPedido($peds[$i]['idPedidoContratacao']);
						}
					//var_dump($pedido);
						
						
						?>
						<tr>

							<td><?php if($pedido['liberado'] != '0000-00-00'){echo exibirDataBr($pedido['liberado']);} ?></td>

							
							<td><?php echo $pedido['tipoPessoa']; ?></td>
							<td><?php echo $pedido['nome']; ?></td>
							<td><?php echo $pedido['objeto']; ?></td>
							<td><?php echo $pedido['periodo']; ?></td>
							<td><?php echo dinheiroParaBr($peds[$i]['valor']); ?></td>
							<td><?php if(isset($contabil[0]['empenho'])){echo $contabil[0]['empenho']; }?></td>
							<td><?php if(isset($contabil[0]['v_op_baixado'])){echo dinheiroParaBr($contabil[0]['v_op_baixado']); }?></td>
							
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
										<input type="submit" class="btn btn-theme btn-sm btn-block" value="Ed Pessoa">
									</form>
								</td>
							<?php } ?>

							<td>	
								<form method="POST" action="contratacao.php?p=editar_pedido" class="form-horizontal" role="form">
									<input type="hidden" name="editar_pedido" value="<?php echo $peds[$i]['idPedidoContratacao']; ?>" />
									<input type="submit" class="btn btn-theme btn-sm btn-block" value="Ed Pedido">
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