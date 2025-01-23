<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
session_start();
//$_SESSION['entidade'] = 'evento';
?>


<body>
	
	<?php include "menu/me_agendateatros.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<?php 
		include "dadosteatro.php";
		
		
		
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
						<th></th>
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
							<td><?php echo $res[$i]['idEvento'];  ?></td>
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

							<?php ?>
							<td><?php echo $evento['periodo']['legivel']; ?></td>
							<?php ?>				
							
							<td><?php echo $evento['status']; ?></td>
<td></td>
							
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
								</td>
							<?php }else{
								?>
								<td></td>
								
								<?php
							}

							} ?>	
							
						<td>
							<?php
							if($evento['status'] != '1' AND $evento['status'] != 'NULL' ){
							?>
						<form method="POST" action="mapas.php?p=editar" class="form-horizontal" role="form">
						<input type="hidden" name="carregar" value="<?php echo $res[$i]['idEvento']; ?>" />
						<input type="submit" class="btn btn-theme btn-sm btn-block" value="CulturAZ">
								</form>
						<?php } ?>
						</td><!-- mapas culturais -->
						

							
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
				//$.getJSON('inc/projeto.ajax.php?ano_base=all&',{programa: $(this).val(), ajax: 'true'}, function(j)
				{
					var options = '<option value="0"></option>';	
					for (var i = 0; i < j.length; i++)
					{
						options += '<option value="' + j[i].id + '">' + j[i].projeto + ' </option>';
					}
					// options += '<option value="' + j[i].id + '">' + j[i].projeto + ' ('+ j[i].ano_base +')</option>'; -> mostra todos os anos 
					
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
							<label>Tipo de evento *</label>
							<select class="form-control" name="tipo_evento" id="inputSubject" >
								<option>Escolha uma opção</option>
								<?php geraTipoOpcao("tipo_evento") ?>
							</select>					
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
							<label>Descrição</label>
							<textarea name="descricao" class="form-control" rows="10" placeholder=""></textarea>
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
									<label>Data de Encerramento <font color="#FF0000">(se for data única, não preencher):</font></label>
									<input type='text' class="form-control calendario" name="data_final"/>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Dias da semana <font color="#FF0000">(selecione apenas se existr data de encerramento):</font></label>
									<p>
										<input type='checkbox' name="domingo"/> Dom | 
										<input type='checkbox' name="segunda"/> Seg |
										<input type='checkbox' name="terca"/> Ter |
										<input type='checkbox' name="quarta"/> Qua |
										<input type='checkbox' name="quinta"/> Quin |
										<input type='checkbox' name="sexta"/> Sex |
										<input type='checkbox' name="sabado"/> Sab 
									</p>
								</div>
							</div>



							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Horário de início *</label>
									<input type="text" name="hora" class="form-control hora" />
								</div> 
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Duração do evento em minutos *</label>
									<input type="text" id="duracao" name="duracao" class="form-control minutos" >
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Sala / espaço</label>
									<select class="form-control" name="local" id="inputSubject" >
										<option>Escolha uma opção *</option>
										<?php echo geraTipoOpcao("local") ?>
									</select>
								</div>
							</div>	

					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="inserir" value="1" />
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="SALVAR">
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



if(isset($_GET['id'])){
	$id = $_GET['id'];
	$sql_select = "SELECT * FROM sc_ocorrencia_teatro WHERE idOcorrencia = '$id'";
	$agenda = $wpdb->get_row($sql_select,ARRAY_A);

}

if(isset($_POST['atualizar']) OR isset($_POST['inserir'])){
	$nomeEvento = addslashes($_POST["nomeEvento"]);

	$tipo_evento = $_POST["tipo_evento"];

	$nomeResponsavel = $_POST["nomeResponsavel"];
	$suplente = $_POST["suplente"];
	$descricao = addslashes($_POST["descricao"]);
	$data_inicio = exibirDataMysql($_POST["data_inicio"]);
	$data_final =  exibirDataMysql($_POST["data_final"]);
	$hora =  ($_POST["hora"]);
	$duracao =  $_POST["duracao"];
	$horaFinal = somaMinutos($hora,$duracao);
	$local =   $_POST["local"];
	if(isset($_POST["domingo"])){$domingo  = 1; }else{ $domingo  = 0;}
	if(isset($_POST["segunda"])){$segunda  = 1; }else{ $segunda  = 0;}
	if(isset($_POST["terca"])){$terca = 1; }else{ $terca  = 0;}
	if(isset($_POST["quarta"])){$quarta  = 1; }else{ $quarta  = 0;}
	if(isset($_POST["quinta"])){$quinta  = 1; }else{ $quinta  = 0;}
	if(isset($_POST["sexta"])){$sexta  = 1; }else{ $sexta  = 0;}
	if(isset($_POST["sabado"])){$sabado  = 1; }else{ $sabado  = 0;}


}



$idUser = $user->ID;


	// Inserir evento
if(isset($_POST['inserir'])){
	$sql = "INSERT INTO `sc_ocorrencia_teatro` (`idOcorrencia`, `titulo`,  `tipo_evento`, `nomeResponsavel`, `suplente`, `descricao`, `local`, `segunda`, `terca`, `quarta`, `quinta`, `sexta`, `sabado`, `domingo`, `dataInicio`, `dataFinal`, `horaInicio`, `horaFinal`, `duracao`, `publicado`) VALUES (NULL, '$nomeEvento', '$tipo_evento', '$nomeResponsavel', '$suplente', '$descricao', '$local', '$segunda', '$terca', '$quarta', '$quinta', '$sexta', '$sabado', '$domingo', '$data_inicio', '$data_final', '$hora', '', '$duracao', '1')";
	$ins = $wpdb->query($sql);
	if($ins){
		$mensagem = "Inserido com sucesso";
		$id = $wpdb->insert_id;
		$sql_select = "SELECT * FROM sc_ocorrencia_teatro WHERE idOcorrencia = '$id'";
		$agenda = $wpdb->get_row($sql_select,ARRAY_A);
		atualizarAgendaTeatros($id);
		
		gravarLog($sql, $user->ID);
		
		
	}else{
		$mensage = "Erro ao inserir";
		gravarLog($sql, $user->ID);
		
	}
	
}

if(isset($_POST['atualizar'])){
	$id  = $_POST["atualizar"];	
	$sql_atualizar = "UPDATE `sc_ocorrencia_teatro` SET 
`titulo`='$nomeEvento',
`tipo_evento`='$tipo_evento',
`nomeResponsavel`='$nomeResponsavel',
`suplente`='$suplente',
`descricao`='$descricao',
`local`='$local',
`segunda`='$segunda',
`terca`='$terca',
`quarta`='$quarta',
`quinta`='$quinta',
`sexta`='$sexta',
`sabado`='$sabado',
`domingo`='$domingo',
`dataInicio`='$data_inicio',
`dataFinal`='$data_final',
`horaInicio`='$hora',
`horaFinal`='$horaFinal',
`duracao`='$duracao',
`observacao`='$observacao' 
	WHERE `idOcorrencia` = '$id'
	";
	$atual = $wpdb->query($sql_atualizar);
		$sql_select = "SELECT * FROM sc_ocorrencia_teatro WHERE idOcorrencia = '$id'";
		$agenda = $wpdb->get_row($sql_select,ARRAY_A);
		atualizarAgendaTeatros($id);	
	
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
							<input type="text" name="nomeEvento" class="form-control" id="inputSubject" value="<?php echo $agenda['titulo']; ?>"/>
						</div> 
					</div>

					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Tipo de evento *</label>
							<select class="form-control" name="tipo_evento" id="inputSubject" >
								<option>Escolha uma opção</option>
								<?php geraTipoOpcao("tipo_evento",$agenda['tipo_evento']) ?>
							</select>					
						</div>
					</div>
					<div class="form-group">
						<br />
						<p>O responsável e suplente devem estar cadastrados como usuários do sistema. </p>
						<div class="col-md-offset-2">
							<label>Primeiro responsável (Fiscal) *</label>
							<select class="form-control" name="nomeResponsavel" id="inputSubject" >
								<option value="0"></option>
								<?php geraOpcaoUsuario($agenda['nomeResponsavel']);	?>							
							</select>	                
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Segundo responsável (Suplente)</label>
							<select class="form-control" name="suplente" id="inputSubject" >
								<option value="0"></option>
								<?php geraOpcaoUsuario($agenda['suplente']);	?>							

							</select>	
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2">
							<label>Descrição</label>
							<textarea name="descricao" class="form-control" rows="10" placeholder=""><?php echo $agenda['descricao'] ?></textarea>
						</div> 
					</div>						



							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Data de Início:</label>
									<input type='text' class="form-control calendario" name="data_inicio" value="<?php echo exibirDataBr($agenda['dataInicio']) ?>"/>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Data de Encerramento <font color="#FF0000">(se for data única, não preencher):</font></label>
									<input type='text' class="form-control calendario" name="data_final" value="<?php echo exibirDataBr($agenda['dataFinal']) ?>"/>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Dias da semana <font color="#FF0000">(selecione apenas se existr data de encerramento):</font></label>
									<p>
										<input type='checkbox'  name="domingo" <?php if($agenda['domingo'] == 1){ echo "checked";} ?> /> Dom | 
										<input type='checkbox' name="segunda" <?php if($agenda['segunda'] == 1){ echo "checked";} ?>/> Seg |
										<input type='checkbox' name="terca" <?php if($agenda['terca'] == 1){ echo "checked";} ?>/> Ter |
										<input type='checkbox' name="quarta" <?php if($agenda['quarta'] == 1){ echo "checked";} ?>/> Qua |
										<input type='checkbox' name="quinta" <?php if($agenda['quinta'] == 1){ echo "checked";} ?>/> Quin |
										<input type='checkbox' name="sexta" <?php if($agenda['sexta'] == 1){ echo "checked";} ?>/> Sex |
										<input type='checkbox' name="sabado"<?php if($agenda['sabado'] == 1){ echo "checked";} ?> /> Sab 
									</p>
								</div>
							</div>



							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Horário de início *</label>
									<input type="text" name="hora" class="form-control hora" value="<?php echo $agenda['horaInicio'] ?>"/>
								</div> 
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Duração do evento em minutos *</label>
									<input type="text" id="duracao" name="duracao" class="form-control minutos" value="<?php echo $agenda['duracao'] ?>">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Sala / espaço</label>
									<select class="form-control" name="local" id="inputSubject" >
										<option>Escolha uma opção *</option>
										<?php echo geraTipoOpcao("local",$agenda['local']) ?>
									</select>
								</div>
							</div>	

					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="atualizar" value="<?php echo $id ?>" />
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="SALVAR">
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
} // fim da switch p

?>

</main>
</div>
</div>

<?php 
include "footer.php";
?>