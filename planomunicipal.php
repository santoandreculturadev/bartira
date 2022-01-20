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
									<th>Meta</th>
									<th>Data</th>
									<th></th>
									<th></th>

								</tr>
							</thead>
							<tbody>
								<?php 
								for($i = 0; $i < count($peds); $i++){
									?>
									<tr>
										<td><?php echo $peds[$i]['objetivos']; ?></td>
										<td><?php echo $peds[$i]['meta_descricao']; ?></td>
										<td><?php echo exibirDataBr($peds[$i]['data']); ?></td>
										
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
											<input type="submit" class="btn btn-theme btn-sm btn-block" value="Atualização">
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
						<center><h3>Não há contatos.</h3></center>
						
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

					<h2>Editar Contato</h2>
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
								<input type="submit" class="btn btn-theme btn-lg btn-block" value="Atualizar Contato">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>	
	


	
	<?php 
	break;
	case "inserir":
	
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

					<h2>Inserir Contato</h2>
					<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

				</div>
			</div> 
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
						<div class="row">
							<div class="col-12">
								<label>Nome Completo *</label>
								<input type="text" name="nome" class="form-control" id="inputSubject" />
							</div>
						</div>
						<br />
						<div class="row">
							<div class="col-12">
								<label>Nome Artístico *</label>
								<input type="text" name="nomeartistico" class="form-control" id="inputSubject" />
							</div>
						</div>
						<br />

						<br />
						<div class="row">
							<div class="col-6">
								<label>Local de Nascimento</label>
								<input type="text" class="form-control" name="localnascimento" > 
							</div>						<div class="col-6">
								<label>Data de Nascimento</label>
								<input type="text" class="form-control calendario" name="datanascimento"> 
							</div>
						</div>	
						<br />
						<div class="row">
							<div class="col-6">
								<label>CEP</label>
								<input type="text" class="form-control cep" name="cep" id="CEP" > 
							</div>
							<div class="col-6">
								<label>Número</label>
								<input type="text" class="form-control" name="numero" > 
							</div>
						</div>	
						<br />
						<div class="row">
							<div class="col-12">
								<label>Logradouro *</label>
								<input type="text" name="rua" class="form-control" id="rua" />
							</div>
						</div>
						<br />
						<div class="row">
							<div class="col-6">
								<label>Bairro</label>
								<input type="text" class="form-control" name="bairro" id="bairro" > 
							</div>
							<div class="col-6">
								<label>Complemento</label>
								<input type="text" class="form-control" name="complemento"> 
							</div>
						</div>	
						<br />
						<div class="row">
							<div class="col-6">
								<label>Cidade</label>
								<input type="text" class="form-control" name="cidade" id="cidade"> 
							</div>
							<div class="col-6">
								<label>Estado</label>
								<input type="text" class="form-control" name="uf" id="uf"> 
							</div>
						</div>	
						<br />					
						<div class="row">
							<div class="col-6">
								<label>Telefone 01</label>
								<input type="text" class="form-control" name="telefone1" > 
							</div>
							<div class="col-6">
								<label>Telefone 02</label>
								<input type="text" class="form-control" name="telefone2"> 
							</div>
						</div>	
						<br />
						<div class="row">
							<div class="col-6">
								<label>Telefone 03</label>
								<input type="text" class="form-control" name="telefone3"> 
							</div>
							<div class="col-6">
								<label>E-mail</label>
								<input type="text" class="form-control" name="email"> 
							</div>
						</div>	
						<br />
						<div class="row">
							<div class="col-12">
								<label>Biografia / Relato </label>
								<textarea name="biografia" class="form-control" rows="10" ></textarea>					
							</div>
						</div>
						<br />	
						
						<div class="row">
							<div class="col-12">
								<label>Área de atuação </label>
								<textarea name="area_atuacao" class="form-control" rows="10" ></textarea>					
							</div>
						</div>
						<br />
						<div class="row">
							<div class="col-12">
								<label>Local de atuação </label>
								<textarea name="local_atuacao" class="form-control" rows="10" ></textarea>					
							</div>
						</div>
						<br />				
						<div class="row">
							<div class="col-12">
								<label>Acervo </label>
								<textarea name="acervo" class="form-control" rows="10" ></textarea>					
							</div>
						</div>
						<br />		
						<div class="row">
							<div class="col-12">
								<label>Links </label>
								<textarea name="links" class="form-control" rows="10" ></textarea>					
							</div>
						</div>
						<br />		
						<div class="row">
							<div class="col-12">
								<label>Link CulturAZ</label>
								<input type="text" name="culturaz" class="form-control" id="inputSubject" />
							</div>
						</div>
						<br />

						<div class="form-group">
							<div class="col-md-offset-2">
								<input type="hidden" name="inserir" value="1" />
								<?php 
								?>
								<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir Contato">
							</div>
						</div>
					</form>
				</div>
			</div>
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