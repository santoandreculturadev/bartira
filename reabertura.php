<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
//session_start();
$_SESSION['entidade'] = 'reabertura';
?>


<body>
	
	<?php include "menu/me_reabertura.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<?php 
		switch($p){
			case "inicio": 

}
if(isset($_SESSION['id'])){
	unset($_SESSION['id']);
}

if(isset($_GET['order'])){
	$order = ' ORDER BY nomeEvento ASC ';
}else{
	$order = ' ORDER BY idEvento DESC ';
}

if(isset($_POST['reabrir_evento'])){
	$id = $_POST['reabrir_evento'];
	$sql_reabre = "UPDATE sc_evento SET dataEnvio = NULL WHERE idEvento = '$id'";
	$query_reabre = $wpdb->query($sql_reabre);
	$sql_status_reabre = "UPDATE sc_evento SET status = '1' WHERE idEvento = '$id'";
	$query_status_reabre = $wpdb->query($sql_status_reabre);
	if($query_reabre == 1){
		$mensagem = '<div class="alert alert-success"> Evento reaberto com sucesso. </div>';
	}
}



?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">

				<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="row">    
						<div class="col-md-offset-2 col-md-8">
							<h3>Reabertura de Eventos</h3>
						</div>
					</div>
					<div class="table-responsive">
						<p>A reabertura de um evento é necessária quando há necessidade de alteração de informações no mesmo.</p>
						<p>Nessa listagem você encontra:</p>
						<p>Os eventos <strong>sem contratação</strong> que tem o status <strong>APROVADO</strong>;</p>
						<p>Os eventos <strong>com</strong> ou <strong>sem contratação</strong> que tem o status <strong>PLANEJADO</strong> (os quais estão aguardando a aprovação da gerência).</p>
						<p>Quando o evento é reaberto, o mesmo some dessa listagem e seu status é modificado para <strong>RASCUNHO</strong>, o qual possibilita que os responsáveis pelo mesmo editem as informações necessárias, e solicitem novamente a aprovação.</p>


					</div>

				</div>
				</section>

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
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$idUser = $user->ID;
					//$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND status != '1' AND idEvento NOT IN (SELECT idEvento FROM sc_contratacao) $order";
					$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND status != '1' $order";
					$res = $wpdb->get_results($sql_list,ARRAY_A);
					for($i = 0; $i < count($res); $i++){
						$evento = evento($res[$i]['idEvento']);
						
						?>
						<tr>
							<td><?php echo $res[$i]['idEvento']; ?></td>
							<td>				
									<a href="busca.php?p=view&tipo=evento&id=<?php echo $res[$i]['idEvento'] ?>" target=_blank>
									<?php echo $evento['titulo']; ?>
									<?php
									if($idUser == 63 OR $idUser == 1 OR $idUser == 5 OR $idUser == 77){
										?>
									</a>
								<?php } ?>
							</td>

							
							<td><?php echo $evento['periodo']['legivel']; ?></td>
							<td><?php echo $evento['status']; ?></td>
							
								<td>	
								<form method="POST" action="?p=inicio" class="form-horizontal" role="form">
									<input type="hidden" name="reabrir_evento" value="<?php echo $res[$i]['idEvento']; ?>" />
									<input type="submit" class="btn btn-theme btn-sm btn-block" value="Reabrir evento">
								</form>	

								</td>

							<?php } ?>

						</tr>
					
				</tbody>
			</table>
		</div>

	</div>
</section>