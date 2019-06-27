<?php include "header.php"; ?>

<?php 
if(isset($_POST['projeto'])){
	$projeto = $_POST['projeto'];
	$responsavel = $_POST['responsavel'];
	$programa = $_POST['programa'];
	$descricao = $_POST['descricao'];
	
	$desc = json_encode(
		array(
			'responsavel' => $responsavel,
			'programa' => $programa,
			'descricao' => $descricao
			
		)
	);
	global $wpdb;
	$sql = "INSERT INTO `sc_tipo` (`tipo`, `descricao`, `abreviatura`) 
	VALUES ('$projeto', '$desc', 'projeto');";
	$ins = $wpdb->query($sql);
	if($ins){
		$mensagem = "Inserido com sucesso.".var_dump($ins);
		
	}else{
		$mensagem = "Erro ao inserir.".var_dump($ins);
		
		
	}

}

?>


<body>
	
	<?php include "menu.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<section id="inserir" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">

						<h3>Evento - Informações Gerais</h3>
						<h1></h1>
						<p><?php if(isset($mensagem)){ echo $mensagem;} ?></p>

					</div>
				</div> 
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form method="POST" action="?" class="form-horizontal" role="form">
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Nome do Projeto *</label>
									<input type="text" name="projeto" class="form-control" id="inputSubject" value=""/>
								</div> 
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Responsável</label>
									<select class="form-control" name="responsavel" id="inputSubject" >
										
										<?php
										$dir = get_users('role=diretor_de_area');
							//var_dump($diretores);
										foreach ( $dir as $diretor ) {
											echo '<option value="'.$diretor->ID.'">' . esc_html( $diretor->display_name ) . '</option>';
										}
										
										?>
									</select>

								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Programa *</label>
									<select class="form-control" name="programa" id="inputSubject" >
										<option>Escolha uma opção</option>
										<?php geraTipoOpcao("programa") ?>
									</select>					
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<label>Descrição *</label>
									<textarea name="descricao" class="form-control" rows="10" placeholder=""></textarea>
								</div> 
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<input type="hidden" name="atualizar" value="1" />
									<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
								</div>
							</div>
							
						</form>
					</div>
				</div>
			</div>
		</section>

		
		
	</main>
</div>
</div>

<?php 
include "footer.php";
?>