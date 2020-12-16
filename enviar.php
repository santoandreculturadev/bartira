<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
//session_start();
?>


<body>
	
	<?php include "menu/me_evento.php"; ?>
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
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<?php 
		switch($p){
			case "inicio": 
			$evento = evento($_SESSION['id']);
			?>

			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="row">    
						<div class="col-md-offset-2 col-md-8">
							<h3>Status </h3>
							<h1><?php echo $evento['objeto'];?></h1>
							<h2><?php if(isset($mensagem)){echo $mensagem;} ?></h2>
							<p>O evento está com status de <strong>Rascunho</strong>.</p>
							<p>Para que o responsável pela aprovação analise seu evento é preciso mudar o status para <strong>"Planejado"</strong> clicando no botão localizado no final da página.</p>
							<p>Caso não esteja disponível é porque algum campo obrigatório não foi preenchido, ou está fora do prazo de 45 dias de antecedência para envio. </p>
						</div>
					</div>
					<br /><br />



					<?php 
					if(isset($_SESSION['entidade'])){
		//verifica se todos os campos obrigatórios foram atualizados
						switch($_SESSION['entidade']){
							case 'evento':

							$evento = evento($_SESSION['id']);
							?>
							<hr>			
							<div class="row">
								<div class="col-md-offset-1 col-md-10">
									<h3>Dados do Evento</h3>
									<br />
									<p><strong>Programa:</strong> <?php echo $evento['programa']; ?></p>
									<p><strong>Projeto:</strong> <?php echo $evento['projeto']; ?></p>
									<p><strong>Linguagem principal:</strong> <?php echo $evento['linguagem']; ?></p>
									<p><strong>Responsável:</strong> <?php echo $evento['responsavel']; ?></p>
									<p><strong>Nome do Artista/Cia/Banda/Grupo/Dupla:</strong> <?php echo $evento['grupo']; ?></p>
									<p><strong>Ficha técnica:</strong> <?php echo $evento['ficha_tecnica']; ?></p>
									<p><strong>Classificação etária:</strong> <?php echo $evento['faixa_etaria']; ?></p>
									<p><strong>Sinopse:</strong> <br /><?php echo $evento['sinopse']; ?></p>
									<p><strong>Release:</strong> <br /><?php echo $evento['release']; ?></p>
									<p><strong>Links:</strong> <?php //echo $evento['links']; ?></p>
									<p><strong>Ocorrências:</strong><br /> <?php
									$sql_lista_ocorrencia = "SELECT idOcorrencia FROM sc_ocorrencia WHERE idEvento = '".$_SESSION['id']."' AND publicado = '1'";
									$res = $wpdb->get_results($sql_lista_ocorrencia,ARRAY_A);
									if(count($res)){
										for($i = 0; $i < count($res); $i++){
											$ocorrencia = ocorrencia($res[$i]['idOcorrencia']);
											echo $ocorrencia['tipo']."<br />";
											echo $ocorrencia['data']."<br />";
											echo $ocorrencia['local']."<br /><br />";

										}

									}else{
										echo "Não há ocorrências cadastradas.";
									}

			//echo $evento['']; ?></p>
			<hr>
			<h3>Pedidos de Contratação</h3>
			<?php 
			$ped = listaPedidos($_SESSION['id'],'evento');
		//var_dump($ped);
			for($i = 0; $i < count($ped); $i++){
				$pedido = retornaPedido($ped[$i]['idPedidoContratacao']);
				?>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<p><br />
							<li><b>Tipo:</b> <?php echo $ped[$i]['tipo'] ?>  / <b>Nome/Razão Social:</b> <a href="busca.php?p=view&tipo=pj&id=<?php echo $ped[$i]['idPessoa']?>" ><?php echo $ped[$i]['nome'] ?> </a>/ <b>Projeto/Ficha:</b> <?php echo $pedido['projeto'] ?>/<?php echo $pedido['ficha'] ?>  / <b>Valor: </b><a style="text-decoration: underline;"><?php echo $pedido['valor'] ?></a>  
								<?php 
								$cont = retornaContabil($pedido['nProcesso']);
								if(count($cont > 0)){
									for($k = 0; $k < count($cont);$k++){
										?>
										/ <b>Processo: </b><?php echo $cont[$k]['nProcesso']; ?>/ <b>Número da Liberação:  </b> <?php echo $pedido['nLiberacao'] ?>/ <b>Número do Empenho: </b><?php echo $cont[$k]['empenho']; ?> / <b>Ordem de Pagamento: </b><?php echo dinheiroParaBr($cont[$k]['v_op_baixado']); ?><br />
										
										<?php 
									}
								}
								
								?>
								
							</li>
							
							
							<?php //var_dump($ped); ?>	
						<?php } ?>
						
						<hr>
						<h3>Infraestrutura ATA</h3>
						<?php 

						if(retornaInfra($_SESSION['id']) != NULL){
							echo retornaInfra($_SESSION['id']);
							echo "</p>";

						}

						$valor = infraAta($_SESSION['id']);

						?>
						<br />
						<?php 
						for($i = 0; $i < count($valor) - 1; $i++){
							?>
							<?php if($valor[$i]['total'] != 0){ ?>
								<p><?php echo $valor[$i]['razao_social']?> : <?php echo dinheiroParaBr($valor[$i]['total']); ?> </p>
							<?php } ?>

							<?php	
						}
						?>	
						<strong>Total:</strong><a style="text-decoration: underline;"><?php echo dinheiroParaBr($valor['total']);?> </a>
						<hr>
						<h3>Produção</h3>

						<?php 
						$x = producao($_SESSION['id']);
						for($i = 0; $i < count($x); $i++){
							
							$y = retornaProducao($x[$i]['id_lista_producao']);
							if($y != false){					
								if($y['tipo'] == "infra"){
									if($x[$i]['valor'] != ""){	
										echo "<li>".$y['titulo']." : ".$x[$i]['valor']."</li>";
									}
								}
							}
							
						}
						
						
						?>
						
						<hr>
						<h3>Comunicação</h3>
						<?php 
						$x = producao($_SESSION['id']);
						for($i = 0; $i < count($x); $i++){
							
							$y = retornaProducao($x[$i]['id_lista_producao']);
							if($y != false){					
								if($y['tipo'] == "com"){
									if($x[$i]['valor'] != ""){	
										echo "<li>".$y['titulo']." : ".$x[$i]['valor']."</li>";
									}
								}
							}
							
						}
						
						
						?>
						<hr>
						<h3>Apoio</h3>
						<?php 
						$x = producao($_SESSION['id']);
						for($i = 0; $i < count($x); $i++){
							
							$y = retornaProducao($x[$i]['id_lista_producao']);
							if($y != false){					
								if($y['tipo'] == "apoio"){
									if($x[$i]['valor'] != ""){	
										echo "<li>".$y['titulo']." : ".$x[$i]['valor']."</li>";
									}
								}
							}
							
						}
						
						
						?>
						
						<hr>
						<h3>Arquivos</h3>
						<br /> <?php $arquivo = listaArquivos("evento",$_SESSION['id']); 
						
						for($i = 0; $i < count($arquivo); $i++){
							echo "<a href='upload/".$arquivo[$i]['arquivo']."' target='_blank' >".$arquivo[$i]['arquivo']."</a><br />";	
							
						}
						?></p>
						
					</div>
				</div>  
				

				<hr>
				<br /><br />
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<h3>Pendências</h3>
						<?php $pendencia = verificaEvento($_SESSION['id']);
						if($pendencia['erros'] == 0 ){
							echo "<p>Não há pendências.</p>";
							if($evento['dataEnvio'] == NULL){
								?>
								
								
								<form action="evento.php" method="POST" class="form-horizontal">
									<input type="submit" class="btn btn-theme btn-lg btn-block" name="enviar" value="Mudar Status do evento para 'Planejado'" />
								</form>	
								
							<?php }else{
								echo "<h4>Evento enviado ao sistema.</h4>";	
								
							}
							
						}else{
							echo "<p>".$pendencia['relatorio']."</p>";		
						}
						
						?>

					</div>
				</div>  		

				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<?php if($evento['planejamento'] == 1){ ?>
							<form action="?" method="POST" class="form-horizontal">
								<input type="submit" class="btn btn-theme btn-lg btn-block" name="agenda" value="Atualizar Agenda" />
							</form>

						<?php } ?>
					</div>
				</div>  
				
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<?php if($evento['planejamento'] == 1){ ?>
							<form action="?" method="POST" class="form-horizontal">
								<input type="submit" class="btn btn-theme btn-lg btn-block" name="agenda" value="Atualizar Agenda" />
							</form>

						<?php } ?>
					</div>
				</div>  
				
				<?php
				break;
			}
			?>

			<?php
		}
		?>
		
	</div>
</section>

<br /><br />

<?php 	 
break;	 
 case "inserir": //inserir contratação
 ?>


 <?php 
	switch ($_GET['t']){ // tipo de contratacao
		case 'apf':
		?>	
		
		<section id="inserir" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">

						<h3>Contratação - Artístico Pessoa Física</h3>
						<h1></h1>
						<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
					</div>
				</div> 
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form method="POST" action="?p=editar" class="form-horizontal" role="form">
						</form>
					</div>
				</div>
			</div>
		</section>
		<?php 
		break;
		case 'apj':
		?>
		<section id="inserir" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">

						<h3>Contratação - Artístico Pessoa Jurídica</h3>
						<h1></h1>
						<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
					</div>
				</div> 
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form method="POST" action="?p=editar" class="form-horizontal" role="form">
						</form>
					</div>
				</div>
			</div>
		</section>
		<?php 
		break;
		case 'pf':
		?>
		<section id="inserir" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">

						<h3>Contratação - Não-Artístico Pessoa Física</h3>
						<h1></h1>
						<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
					</div>
				</div> 
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form method="POST" action="?p=editar" class="form-horizontal" role="form">
						</form>
					</div>
				</div>
			</div>
		</section>
		<?php 
		break;
		case 'pj':
		?>
		<section id="inserir" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">

						<h3>Contratação - Não Artístico Pessoa Jurídica</h3>
						<h1></h1>
						<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
					</div>
				</div> 
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form method="POST" action="?p=editar" class="form-horizontal" role="form">
						</form>
					</div>
				</div>
			</div>
		</section>
		<?php 
		break;
		case 'orc':
		?>
		<section id="inserir" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">

						<h3>Orçamento - Previsão</h3>
						<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

					</div>
				</div> 
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form method="POST" action="?p=editar&t=orc" class="form-horizontal" role="form">
							<div class="form-group">
								<div class="col-md-offset-2">
									<label>Dotação</label>
									<select class="form-control" name="dotacao" >
										<option value="0">Escolha uma opção</option>
										<?php geraOpcaoDotacao() ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2">
									<label>Tipo de Pessoa</label>
									<select class="form-control" name="tipo_pessoa" >
										<option value='1'>Pessoa Física</option>
										<option value='2'>Pessoa Jurídica</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2">
									<label>Valor *</label>
									<input type="text" name="valor" class="form-control valor" id="inputSubject" value=""/>
								</div> 
							</div>
							<div class="form-group">
								<div class="col-md-offset-2">
									<label>Descrição *</label>
									<textarea name="descricao" class="form-control" rows="10""></textarea>
								</div> 
							</div>
							<div class="form-group">
								<div class="col-md-offset-2">
									<input type="hidden" name="atualizar" value="<?php echo $evento['idEvento']; ?>" />
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
	} // fim da switch insere contratacao
	?>
	
	<?php 
	break;
	case "editar":

	global $wpdb;	
	
	
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

	<?php 
	switch ($_GET['t']){ // tipo de contratacao
		case 'apf':
		?>	

	<?php } ?>	
	
	<?php 
	switch ($_GET['t']){ // tipo de contratacao
		case 'apf':
		?>	
		
		<section id="inserir" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">

						<h3>Contratação - Artístico Pessoa Física</h3>
						<h1></h1>
						<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
					</div>
				</div> 
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form method="POST" action="?p=editar" class="form-horizontal" role="form">
						</form>
					</div>
				</div>
			</div>
		</section>
		<?php 
		break;
		case 'apj':
		?>
		<section id="inserir" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">

						<h3>Contratação - Artístico Pessoa Jurídica</h3>
						<h1></h1>
						<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
					</div>
				</div> 
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form method="POST" action="?p=editar" class="form-horizontal" role="form">
						</form>
					</div>
				</div>
			</div>
		</section>
		<?php 
		break;
		case 'pf':
		?>
		<section id="inserir" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">

						<h3>Contratação - Não-Artístico Pessoa Física</h3>
						<h1></h1>
						<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
					</div>
				</div> 
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form method="POST" action="?p=editar" class="form-horizontal" role="form">
						</form>
					</div>
				</div>
			</div>
		</section>
		<?php 
		break;
		case 'pj':
		?>
		<section id="inserir" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">

						<h3>Contratação - Não Artístico Pessoa Jurídica</h3>
						<h1></h1>
						<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>
					</div>
				</div> 
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form method="POST" action="?p=editar" class="form-horizontal" role="form">
						</form>
					</div>
				</div>
			</div>
		</section>
		<?php 
		break;
		case 'orc':
		
		
		?>
		<section id="inserir" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">

						<h3>Orçamento - Previsão</h3>
						<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

					</div>
				</div> 
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form method="POST" action="?p=editar&t=orc" class="form-horizontal" role="form">
							<div class="form-group">
								<div class="col-md-offset-2">
									<label>Dotação</label>
									<select class="form-control" name="dotacao" >
										<option value="0">Escolha uma opção</option>
										<?php geraOpcaoDotacao() ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2">
									<label>Tipo de Pessoa</label>
									<select class="form-control" name="tipo_pessoa" >
										<option value='1'>Pessoa Física</option>
										<option value='2'>Pessoa Jurídica</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2">
									<label>Valor *</label>
									<input type="text" name="valor" class="form-control valor" id="inputSubject" value=""/>
								</div> 
							</div>
							<div class="form-group">
								<div class="col-md-offset-2">
									<label>Descrição *</label>
									<textarea name="descricao" class="form-control" rows="10""></textarea>
								</div> 
							</div>
							<div class="form-group">
								<div class="col-md-offset-2">
									<input type="hidden" name="atualizar" value="<?php echo $evento['idEvento']; ?>" />
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
	</section>

	<?php
	break;
	} // fim da switch edita contratacao
	?>



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