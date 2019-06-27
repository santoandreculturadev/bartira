<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
//session_start(); // carrega a sessão

?>


<body>
	
	<?php include "menu/me_mapas.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<?php 
		switch($p){
			case "inicio": ?>
			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="row">    
						<div class="col-md-offset-2 col-md-8">
							<h3>Meus Eventos - Ocorrência</h3>
							<?php
					// listar o evento;
							$evento = evento($_SESSION['idEvento']);
							?>
							<h1><?php echo $evento['titulo']; ?></h1>
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
								<h3>Meus Eventos - Ocorrência - Inserir</h3>
								<?php
					// listar o evento;
								$evento = evento($_SESSION['id']);
								?>
								<h1><?php echo $evento['titulo']; ?></h1>
							</div>
						</div>
						
					</div>

					<div class="row">
						<form class="formocor" action="?p=editar" method="POST" role="form">

							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Data de Início:</label>
									<input type='text' class="form-control calendario" name="data_inicio"/>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Data de Encerramento <font color="#FF0000">(se for data única, não preencher):</font></label>									<input type='text' class="form-control calendario" name="data_final"/>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Dias da semana <font color="#FF0000">(selecione apenas se existr data de encerramento):</font></label>									<p>
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
									<label>Valor do ingresso * (se for entrada franca, inserir 0)</label>
									<input type="text" name="valorIngresso" class="form-control" >
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Horário de início</label>
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
										<option>Escolha uma opção</option>
										<?php echo geraTipoOpcao("local") ?>
									</select>
								</div>
							</div>	
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Ingressos disponíveis</label>
									<input type="text" class="form-control" name="ingressos" placeholder="">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Descricao</label>
									<input type="text" class="form-control" name="descricao"  />
								</div>
							</div>							
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<input type="hidden" name="inserir" value="1" />
									<button type="submit" class="btn btn-theme btn-lg btn-block">Inserir ocorrência</button>
								</div>
							</div>
						</form>
					</div>

				</section>

				<?php 	 
				break;	 
				case "editar":

				if(isset($_POST['editar']) OR isset($_POST['inserir'])){ 
					$data_inicio = exibirDataMysql($_POST["data_inicio"]);
					if($_POST["data_final"] != ''){
						$data_final   = exibirDataMysql($_POST["data_final"]);
					}else{
						$data_final = '0000-00-00';
					}
					$hora   = $_POST["hora"].":00";
					$duracao   = $_POST["duracao"];
					$local   = $_POST["local"];
					$ingressos   = $_POST["ingressos"];
					$descricao   = $_POST["descricao"];
					
					if(isset($_POST["domingo"])){$domingo  = 1; }else{ $domingo  = 0;}
					if(isset($_POST["segunda"])){$segunda  = 1; }else{ $segunda  = 0;}
					if(isset($_POST["terca"])){$terca = 1; }else{ $terca  = 0;}
					if(isset($_POST["quarta"])){$quarta  = 1; }else{ $quarta  = 0;}
					if(isset($_POST["quinta"])){$quinta  = 1; }else{ $quinta  = 0;}
					if(isset($_POST["sexta"])){$sexta  = 1; }else{ $sexta  = 0;}
					if(isset($_POST["sabado"])){$sabado  = 1; }else{ $sabado  = 0;}
					
	//colocar if do cara que esqueceu de marcar	
					
				}
				
				if(isset($_POST['inserir'])){
					global $wpdb;
					$id_evento = $_SESSION['id'];
					$sql = "INSERT INTO `sc_ocorrencia` (`local`, `idEvento`, `segunda`, `terca`, `quarta`, `quinta`, `sexta`, `sabado`, `domingo`, `dataInicio`, `dataFinal`, `horaInicio`,`valorIngresso`, `lotacao`, `duracao`,  `publicado`,  `descricao`) 
					VALUES ('$local', '$id_evento', '$segunda', '$terca', '$quarta', '$quinta', '$sexta', '$sabado', '$domingo', '$data_inicio', '$data_final', '$hora', '$valorIngresso', '$ingressos',  '$duracao',  '1', '$descricao')";	
					$res = $wpdb->query($sql);
					$id_ocorrencia = $wpdb->insert_id;
					$sql_ocor = "SELECT * FROM sc_ocorrencia WHERE idOcorrencia = '$id_ocorrencia'";
					$ocor = $wpdb->get_row($sql_ocor,ARRAY_A);
				} 
				
				if(isset($_POST['editar'])){
					global $wpdb;
					$id_ocorrencia = $_POST['editar'];
					$id_evento = $_SESSION['id'];
					$sql = "UPDATE `sc_ocorrencia` SET
					`local` = '$local',
					`idEvento` = '$id_evento',
					`segunda` = '$segunda',
					`terca` =  '$terca',
					`quarta` = '$quarta',
					`quinta` = '$quinta',
					`sexta` = '$sexta',
					`sabado` = '$sabado',
					`domingo` = '$domingo',
					`dataInicio` = '$data_inicio',
					`dataFinal` = '$data_final',
					`horaInicio` = '$hora',
					`valorIngresso` = '$valorIngresso',
					`lotacao` = '$ingressos', 
					`duracao` = '$duracao',
					`descricao` = '$descricao'

					WHERE `idOcorrencia` = '$id_ocorrencia'";
					$res = $wpdb->query($sql);
					$sql_ocor = "SELECT * FROM sc_ocorrencia WHERE idOcorrencia = '$id_ocorrencia'";
					$ocor = $wpdb->get_row($sql_ocor,ARRAY_A);
				} 

				if(isset($_POST['carregar'])){
					$id_ocorrencia = $_POST['carregar'];
					$sql_ocor = "SELECT * FROM sc_ocorrencia WHERE idOcorrencia = '$id_ocorrencia'";
					$ocor = $wpdb->get_row($sql_ocor,ARRAY_A);

					
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
								<h3>Meus Eventos - Ocorrência - Editar</h3>
								<?php
					// listar o evento;
								$evento = evento($_SESSION['id']);
								?>
								<h1><?php echo $evento['titulo']; ?></h1>
								<p><?php //echo $sql; ?></p>
							</div>
						</div>
						
					</div>
					<div class="row">

						<form class="formocor" action="?p=editar" method="POST" role="form">
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Data de Início:</label>
									<input type='text' class="form-control calendario" name="data_inicio" value="<?php echo exibirDataBr($ocor['dataInicio']); ?>"/>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Data de Encerramento (se for data única, não preencher):</label>
									<input type='text' class="form-control calendario" name="data_final" value="<?php if($ocor['dataFinal'] != '0000-00-00'){ echo exibirDataBr($ocor['dataFinal']);} ?>"/>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Selecione apenas se existr Data de Encerramento</label>
									<p>
										<input type='checkbox'  name="domingo" <?php if($ocor['domingo'] == 1){ echo "checked";} ?> /> Dom | 
										<input type='checkbox' name="segunda" <?php if($ocor['segunda'] == 1){ echo "checked";} ?>/> Seg |
										<input type='checkbox' name="terca" <?php if($ocor['terca'] == 1){ echo "checked";} ?>/> Ter |
										<input type='checkbox' name="quarta" <?php if($ocor['quarta'] == 1){ echo "checked";} ?>/> Qua |
										<input type='checkbox' name="quinta" <?php if($ocor['quinta'] == 1){ echo "checked";} ?>/> Quin |
										<input type='checkbox' name="sexta" <?php if($ocor['sexta'] == 1){ echo "checked";} ?>/> Sex |
										<input type='checkbox' name="sabado"<?php if($ocor['sabado'] == 1){ echo "checked";} ?> /> Sab 
									</p>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Valor do ingresso * (se for entrada franca, inserir 0)</label>
									<input type="text" name="valorIngresso" class="form-control" value="<?php echo dinheiroParaBr($ocor['valorIngresso']); ?>" />
								</div>
							</div>


							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Horário de início</label>
									<input type="text" name="hora" class="form-control hora" value="<?php echo $ocor['horaInicio']; ?>" />
								</div> 
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Duração do evento em minutos *</label>
									<input type="text" id="duracao" name="duracao" class="form-control minutos" value="<?php echo ($ocor['duracao']); ?>"/>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Sala / espaço</label>
									<select class="form-control" name="local" id="inputSubject" >
										<option>Escolha uma opção</option>
										<?php echo geraTipoOpcao("local",$ocor['local']) ?>
									</select>
								</div>
							</div>	
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Ingressos disponíveis</label>
									<input type="text" class="form-control" name="ingressos" value="<?php echo ($ocor['lotacao']); ?>" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Descricao</label>
									<input type="text" class="form-control" name="descricao" value="<?php echo ($ocor['descricao']); ?>" />
								</div>
							</div>							
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<input type="hidden" name="editar" value="<?php echo ($ocor['idOcorrencia']); ?>" />
									<button type="submit" class="btn btn-theme btn-lg btn-block">Editar ocorrência</button>
								</div>
							</div>
						</form>
					</div>

				</section>


				<?php 
				break;
				case "listar":

				if(isset($_POST['apagar'])){
					global $wpdb;
					$id = $_POST['apagar'];
					$sql = "UPDATE sc_ocorrencia SET publicado = '0' WHERE idOcorrencia = '$id'";
					$apagar = $wpdb->query($sql);	
				}

				if(isset($_POST['duplicar'])){
					global $wpdb;
					$id = $_POST['duplicar'];
					$sql = "INSERT INTO sc_ocorrencia (`local`, `idEvento`, `segunda`, `terca`, `quarta`, `quinta`, `sexta`, `sabado`, `domingo`, `dataInicio`, `dataFinal`, `horaInicio`,`valorIngresso`, `lotacao`, `duracao`,  `publicado`) 
					SELECT `local`, `idEvento`, `segunda`, `terca`, `quarta`, `quinta`, `sexta`, `sabado`, `domingo`, `dataInicio`, `dataFinal`, `horaInicio`, `valorIngresso`, `lotacao`, `duracao`,  `publicado` FROM sc_ocorrencia WHERE `idOcorrencia` = '$id'";
					$duplicar = $wpdb->query($sql);
				}

				if(isset($_POST['agenda'])){
					atualizarAgenda($_POST['agenda']);	
					
				}

				?>


				<div class="row">    
					<div class="col-md-offset-2 col-md-8">
						<h3>Meus Eventos - Ocorrência - Listar</h3>
						<?php
					// listar o evento;
						$evento = evento($_SESSION['id']);
						?>
						<h1><?php echo $evento['titulo']; ?></h1>
					</div>		
				</div>
				
				<?php 
				$sel = "SELECT idOcorrencia FROM sc_ocorrencia WHERE idEvento = '".$_SESSION['id']."' AND publicado = '1' ORDER BY dataInicio";
				$ocor = $wpdb->get_results($sel,ARRAY_A);
				if(count($ocor) > 0){
					?>
					
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Ocorrência</th>
									<th></th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php
								for($i = 0; $i < count($ocor); $i++){
									$ocorrencia = ocorrencia($ocor[$i]['idOcorrencia']);
									?>
									<tr>
										<td><?php 
										echo $ocorrencia['tipo']."<br />".$ocorrencia['data']."<br />".$ocorrencia['local']."<br />".$ocorrencia['descricao'];
										
										?></td>
										<td>
											<form method="POST" action="?p=editar" class="form-horizontal" role="form">
												<input type="hidden" name="carregar" value="<?php echo $ocor[$i]['idOcorrencia']; ?>" />
												<input type="submit" class="btn btn-theme btn-sm btn-block" value="Carregar">
											</form>
										</td>
										<td>
											<form method="POST" action="?p=listar" class="form-horizontal" role="form">
												<input type="hidden" name="duplicar" value="<?php echo $ocor[$i]['idOcorrencia']; ?>" />
												<input type="submit" class="btn btn-theme btn-sm btn-block" value="Duplicar">
											</form>
										</td>
										<td>
											<form method="POST" action="?p=listar" class="form-horizontal" role="form">
												<input type="hidden" name="apagar" value="<?php echo $ocor[$i]['idOcorrencia']; ?>" />
												<input type="submit" class="btn btn-theme btn-sm btn-block" value="Apagar">
											</form>
										</td>
									</tr>
								<?php } ?>

							</tbody>
						</table>
						
						<form class="form-horizontal" action="?p=listar" method="POST" role="form">
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									
									<input type="hidden" name="agenda" value="<?php echo $_SESSION['id']; ?>" />
									<input type="submit" class="btn btn-theme btn-sm btn-block" value="Atualizar Agenda">
								</div>
							</div>
							
						</div>
					</form>
				</div>

			<?php } else { ?>
				<div class="row">    
					<div class="col-md-offset-2 col-md-8">
						<p> Não há ocorrências cadastradas </p>
					</div>		
				</div>

				
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