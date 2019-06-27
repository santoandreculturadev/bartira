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
					$sql_list =  "SELECT idEvento FROM sc_evento WHERE publicado = '1' AND idEvento NOT IN (SELECT idEvento FROM sc_contratacao) $order";
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