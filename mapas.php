<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
//session_start();
$_SESSION['entidade'] = 'mapas';
?>


<body>
	
	<?php include "menu/me_mapas.php"; ?>
	
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
	$sql_enviar = "UPDATE sc_evento SET dataEnvio = '$hoje' WHERE idEvento = '$idEvento'";
	$upd = $wpdb->query($sql_enviar);
	if($upd == 1){
		atualizarAgenda($idEvento);
		$mensagem = alerta("Evento enviado com sucesso.","success");
	}else{
		$mensagem = alerta("Erro. Tente novamente.","warning");
		
	}
	
}

if(isset($_POST['publicar'])){
	$meta = metausuario($user->ID);	
		require "MapasSDK/vendor/autoload.php"; //carrega o sdk
		$url_mapas = $GLOBALS['url_mapas'];
		$chave01 = $meta['chave01'];
		$chave02 = $meta['chave02'];
		$chave03 = $GLOBALS['chave03'];

		$mapas = new MapasSDK\MapasSDK(
			$url_mapas,
			$chave01,
			$chave02,
			$chave03
		);

		$event = evento($_POST['publicar']);
		
	//instancia o objeto
		
		$new_event = $mapas->createEntity('event', [
			'name' => $event['titulo'],
			'shortDescription' => substr($event['sinopse'], 0, 400),
			'longDescription' => $event['descricao'],
			'terms' => [
				'linguagem' => [$event['linguagem']]
			],
			'classificacaoEtaria' => $event['faixa_etaria'],
		]);	
		
		$new_event = converterObjParaArray($new_event);

		if($new_event['id'] > 0){
		// Atualiza evento
			$new_event['id'];
			$sql_upd = "UPDATE sc_evento SET mapas = '".$new_event['id']."' WHERE idEvento = '".$_SESSION['id']."'";
			$wpdb->query($sql_upd);

		// acontecendo uma única vez no dia 28 de Setembro de 2017 às 12:00 com duração de 120min e preço Gratuíto
			$oc = $event['mapas']['ocorrencia'];
			
			
			for($i = 0; $i < count($oc); $i++){
				
				
				$oc_le = ocorrencia($event['mapas']['ocorrencia']['idOcorrencia']);
				

				if($oc[$i]['frequency'] == 'once'){	
					$occurrence = $mapas->apiPost('eventOccurrence/create',[
						'eventId' => $new_event['id'],
						'spaceId' => $oc[$i]['spaceId'],
						'startsAt' => $oc[$i]['startsAt'],
						'duration' => $oc[$i]['duration'],
				// 'endsAt' => '14:00',
						'frequency' => $oc[$i]['frequency'],
						'startsOn' => $oc[$i]['startsOn'],
						'until' => '',
						'description' => $oc[$i]['description'],
						'price' => $oc[$i]['price']
					]);

				}else{
			// acontecendo Toda seg, qua e sex de 1 a 30 de setembro de 2017 às 10:00


					$occurrence = $mapas->apiPost('eventOccurrence/create',[
						'eventId' => $new_event['id'],
						'spaceId' => $oc[$i]['spaceId'],
						'startsAt' => $oc[$i]['startsAt'],
						'duration' => $oc[$i]['duration'],
				// 'endsAt' => '12:00',
						'frequency' => $oc[$i]['frequency'],
						'startsOn' => $oc[$i]['startsOn'],
						'until' => $oc[$i]['until'],
						'day' => $oc[$i]['day'],
						'description' => $oc[$i]['description'],
						'price' => $oc[$i]['price']
					]);
					;

				}
			}
			
	} //if ok criar evento
	
	}// fim publicar


	if(isset($_SESSION['id'])){
		unset($_SESSION['id']);
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
							<th>Título</th>
							<th>Data</th>
							<th>Status</th>
							<th>ID MAPAS</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						global $wpdb;
						$idUser = $user->ID;
						if($idUser == 63 OR $idUser == 1 OR $idUser == 12 OR $idUser == 77 OR $idUser == 68){
							$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL ORDER BY idEvento DESC";					
						}else{
							$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND (idUsuario = '$idUser' OR idResponsavel = '$idUser' OR idSuplente = '$idUser')   AND dataEnvio IS NOT NULL ORDER BY idEvento DESC";
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
								<td>
									<?php
									if($evento['mapas']['id'] != 0){
										echo "<a href='".$GLOBALS['url_mapas']."evento/".$evento['mapas']['id']."' target='_blank'>".$evento['mapas']['id']."</a>"; 
									}
									?>
								</td>
								<td>	
									<?php if($evento['mapas']['id'] == 0){ ?>
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
					if($idUser == 63 OR $idUser == 1 OR $idUser == 12 OR $idUser == 77  OR $idUser == 68){
						$sql_list =  "SELECT idEvento, inscricao, categoria FROM sc_evento WHERE publicado = '1' AND  inscricao <> '' AND dataEnvio IS NOT NULL ORDER BY idEvento DESC";
					}else{
						$sql_list =  "SELECT idEvento, inscricao, categoria FROM sc_evento WHERE publicado = '1'  AND (idUsuario = '$idUser' OR idResponsavel = '$idUser' OR idSuplente = '$idUser') AND  inscricao <> '' AND dataEnvio IS NOT NULL ORDER BY idEvento DESC";
						
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
	case "editar":
	
	global $wpdb;	
	
	
	if(isset($_SESSION['id'])){
		$id = $_SESSION['id'];
		$sql_select = "SELECT * FROM sc_evento WHERE idEvento = '$id'";
		$evento = $wpdb->get_row($sql_select,ARRAY_A);
		$meta = metausuario($user->ID);
		$event = evento($_SESSION['id']);

	}

	if(isset($_POST['atualizar']) OR isset($_POST['inserir'])){
		$nomeEvento = addslashes($_POST["nomeEvento"]);
		$linguagem    = $_POST["linguagem"];
		$faixaEtaria    = $_POST["faixaEtaria"];
		$sinopse    = addslashes($_POST["sinopse"]);
		$descricao    = addslashes($_POST["descricao"]);
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
		$sql = "INSERT INTO `sc_evento` (`idEvento`, `idTipo`, `idPrograma`, `idProjeto`, `idLinguagem`, `nomeEvento`, `idResponsavel`, `idSuplente`, `autor`, `nomeGrupo`, `fichaTecnica`, `faixaEtaria`, `sinopse`, `releaseCom`, `publicado`, `idUsuario`, `linksCom`, `subEvento`, `dataEnvio`,  `planejamento` ) 
		VALUES (NULL, '$tipo_evento', '$programa', '$projeto', '$linguagem', '$nomeEvento', '$nomeResponsavel', '$suplente', '$autor', '$nomeGrupo', '$fichaTecnica', '$faixaEtaria', '$sinopse', '$releaseCom', '1', '$idUser', '$linksCom', 'subEvento', NULL, '$planejamento')";		
		$ins = $wpdb->query($sql);
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
		`idLinguagem` = '$linguagem',
		`nomeEvento` = '$nomeEvento',
		`faixaEtaria` = '$faixaEtaria',
		`sinopse` = '$sinopse',
		`descricao` = '$descricao'
		
		WHERE `idEvento` = '$atualizar';
		";
		$atual = $wpdb->query($sql_atualizar);
		$sql_select = "SELECT * FROM sc_evento WHERE idEvento = '$atualizar'";
		$evento = $wpdb->get_row($sql_select,ARRAY_A);
		$_SESSION['id'] = $evento['idEvento'];
		
		if($atual == 1){
			$mensagem = alerta("Evento atualizado com sucesso.","success");
		}else{
			$mensagem = alerta("Erro ao atualizar.","warning");
		}

	}
	
	if(isset($_POST['publicar'])){
		require "MapasSDK/vendor/autoload.php"; //carrega o sdk
		$url_mapas = $GLOBALS['url_mapas'];
		$chave01 = $meta['chave01'];
		$chave02 = $meta['chave02'];
		$chave03 = $GLOBALS['chave03'];

		$mapas = new MapasSDK\MapasSDK(
			$url_mapas,
			$chave01,
			$chave02,
			$chave03
		);
		
	//instancia o objeto
		
		$new_event = $mapas->createEntity('event', [
			'name' => $event['titulo'],
			'shortDescription' => substr($event['sinopse'], 0, 400),
			'longDescription' => $event['descricao'],
			'terms' => [
				'linguagem' => [$event['linguagem']]
			],
			'classificacaoEtaria' => $event['faixa_etaria'],
		]);	
		
		$new_event = converterObjParaArray($new_event);

		if($new_event['id'] > 0){
		// Atualiza evento
			$new_event['id'];
			$sql_upd = "UPDATE sc_evento SET mapas = '".$new_event['id']."' WHERE idEvento = '".$_SESSION['id']."'";
			$wpdb->query($sql_upd);

		// acontecendo uma única vez no dia 28 de Setembro de 2017 às 12:00 com duração de 120min e preço Gratuíto
			$oc = $event['mapas']['ocorrencia'];
			
			
			for($i = 0; $i < count($oc); $i++){

				$oc_le = ocorrencia($event['mapas']['ocorrencia']['idOcorrencia']);

				if($oc[$i]['frequency'] == 'once'){	
					$occurrence = $mapas->apiPost('eventOccurrence/create',[
						'eventId' => $new_event['id'],
						'spaceId' => $oc[$i]['spaceId'],
						'startsAt' => $oc[$i]['startsAt'],
						'duration' => $oc[$i]['duration'],
				// 'endsAt' => '14:00',
						'frequency' => $oc[$i]['frequency'],
						'startsOn' => $oc[$i]['startsOn'],
						'until' => '',
						'description' => $oc[$i]['description'],
						'price' => $oc[$i]['price']
					]);

				}else{
			// acontecendo Toda seg, qua e sex de 1 a 30 de setembro de 2017 às 10:00


					$occurrence = $mapas->apiPost('eventOccurrence/create',[
						'eventId' => $new_event['id'],
						'spaceId' => $oc[$i]['spaceId'],
						'startsAt' => $oc[$i]['startsAt'],
						'duration' => $oc[$i]['duration'],
				// 'endsAt' => '12:00',
						'frequency' => $oc[$i]['frequency'],
						'startsOn' => $oc[$i]['startsOn'],
						'until' => $oc[$i]['until'],
						'day' => $oc[$i]['day'],
						'description' => $oc[$i]['description'],
						'price' => $oc[$i]['price']
					]);
					;

				}

			}
			
			
	} //if ok criar evento
	
	
	}// fim publicar
	

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
								<label>Linguagem principal *</label>
								<select class="form-control" name="linguagem" id="inputSubject" >
									<option>Escolha uma opção</option>
									<?php geraTipoOpcao("linguagens",$evento['idLinguagem']) ?>
								</select>					
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
								<label>Descrição Longa </label>
								<textarea name="descricao" class="form-control" rows="10" placeholder="Texto para divulgação e sob editoria da area de comunicação. Não ultrapassar 400 caracteres."><?php echo $evento["descricao"] ?></textarea>
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
					<?php if($evento['mapas'] == 0){ ?>
						
						<form method="POST" action="?" class="form-horizontal" role="form">				
							<div class="form-group">
								<div class="col-md-offset-2">
									<input type="hidden" name="publicar" value="<?php echo $evento['idEvento']; ?>" />
									<?php if($evento['mapas'] == 0){
										?>
										<input type="submit" class="btn btn-theme btn-lg btn-block" value="Publicar Mapas Culturais">
									<?php } else { ?>
										<a href="<?php echo $GLOBALS['url_mapas']."evento/".$evento['mapas']; ?>" class="btn btn-theme btn-lg btn-block" target="_blank">Acessar Mapas Culturais</a> 
									<?php } ?>
								</div>
							</form>	</div>
						<?php }else{ ?>
							<div class="form-group">
								<div class="col-md-offset-2">
									<a href="<?php echo $GLOBALS['url_mapas']."evento/".$event['mapas']['id']; ?>" target="_blank" class="btn btn-theme btn-lg btn-block" ><?php echo $GLOBALS['url_mapas']."evento/".$event['mapas']['id']; ?></a>
								</div>
							</div>
							<?php
							
						} ?>
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
} // fim da switch p

?>

</main>
</div>
</div>

<?php 
include "footer.php";
?>