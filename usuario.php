<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
//session_start();
	//$_SESSION['entidade'] = 'evento';
?>


<body>
	
	<?php include "menu/me_usuario.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<?php 
		switch($p){
			case "inicio": 
if(isset($_POST['atualizar'])){  // envia

	$meta_edit = metausuario($user->ID);
	$departamento = $_POST['departamento'];
	$funcao = $_POST['funcao'];
	$cr = $_POST['cr'];
	$chave01 = $_POST['chave01'];
	$chave02 = $_POST['chave02'];
	$chave01est = $_POST['chave01est'];
	$chave02est = $_POST['chave02est'];
	$idMapas = $_POST['idMapas'];
	$telefone = $_POST['telefone'];
	
	$usuario = array(
		'modulos' => $meta_edit['modulos'] ,
		'departamento' => $departamento,
		'cr' => $cr,
		'funcao' => $funcao,
		'chave01' => $chave01,
		'chave02' => $chave02,
		'chave01est' => $chave01est,
		'chave02est' => $chave02est,
		'idMapas' => $idMapas,
		'telefone' => $telefone
	);

	$opcao = json_encode($usuario);	

	$sql_upd = "UPDATE sc_opcoes SET opcao = '$opcao' WHERE entidade = 'usuario' AND id_entidade = '".$user->ID."'";
	$upd = $wpdb->query($sql_upd);
	if($upd == 1){
		$mensagem = alerta("Dados atualizados","success");
	}
	
}

/*
{"modulos": ["evento","atividade", "orcamento"," contrato","editais","relatorio"], "departamento": "Departamento de Planejamento e Projetos Especiais - CR 70500", "funcao": "Assessor de Gabinete", "edital":["273","1"]  }
*/

if(isset($_SESSION['id'])){
	unset($_SESSION['id']);
}
$meta = metausuario($user->ID);



?>
<section id="inserir" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">

				<h3>Editar Usuário</h3>
				<h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
					<div class="row">
						<div class="col-12">
							<label>Departamento</label>
							<select class="form-control" name="departamento" id="inputSubject" name="IdEstadoCivil">
								<option value='0'>Escolha uma opção</option>
								<?php echo geraTipoOpcao("unidade",$meta['departamento']) ?>
							</select>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-12">
							<label>CR</label>
							<input type="text" name="cr" class="form-control" id="inputSubject" value="<?php if(isset($meta['cr'])){echo $meta['cr'];} ?>" />
						</div>
					</div>
					<br />


					<div class="row">
						<div class="col-12">
							<label>Função</label>
							<input type="text" name="funcao" class="form-control" id="inputSubject" value="<?php if(isset($meta['funcao'])){echo $meta['funcao'];} ?>" />
						</div>
					</div>
					<br />

					<div class="row">
						<div class="col-12">
							<label>Telefone</label>
							<input type="text" name="telefone" class="form-control" id="inputSubject" value="<?php if(isset($meta['telefone'])){echo $meta['telefone'];} ?>" />
						</div>
					</div>
					<br />
					
					<div class="row">
						<div class="col-12">
							<label>ID Agente Mapas (somente o número)</label>
							<input type="text" name="idMapas" class="form-control" id="inputSubject" value="<?php if(isset($meta['idMapas'])){echo $meta['idMapas'];} ?>" />
						</div>
					</div>
					<br />	
					<div class="row">
						<div class="col-12">
							<label>CulturAZ Chave 01</label>
							<input type="text" name="chave01" class="form-control" id="inputSubject" value="<?php if(isset($meta['chave01'])){echo $meta['chave01'];} ?>"/>
						</div>
					</div>
					<br />					<div class="row">
						<div class="col-12">
							<label>CulturAZ Chave 02</label>
							<input type="text" name="chave02" class="form-control" id="inputSubject" value="<?php if(isset($meta['chave02'])){echo $meta['chave02'];} ?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<label>Estado Chave 01</label>
							<input type="text" name="chave01est" class="form-control" id="inputSubject" value="<?php if(isset($meta['chave01est'])){echo $meta['chave01est'];} ?>"/>
						</div>
					</div>
					<br />					<div class="row">
						<div class="col-12">
							<label>Estado Chave 02</label>
							<input type="text" name="chave02est" class="form-control" id="inputSubject" value="<?php if(isset($meta['chave02est'])){echo $meta['chave02est'];} ?>" />
						</div>
					</div>

					<br />					
					
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="atualizar" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Salvar">
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