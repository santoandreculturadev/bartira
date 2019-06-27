<?php include "header.php"; ?>

<body>
	
	<?php include "menu/me_admin.php"; ?>
	<?php 
  //verifica se admin
	if(!isset($user->caps['administrator'])){ ?>
		<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
			<h1>Você não tem permissão para acessar esta página.</h1>
		</main>	
		<?php 	
	}else{ // se tiver autorização para acessar a página
		
		if(isset($_GET['p'])){ 
			$p = $_GET['p'];
		}else{ 
			$p = 'inicio'; 
		}
		
		
		switch($p){
			case "inicio" :
			?>
			<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
				<h1>Bem-vindo!</h1>
			</main>	
			
			<?php
			break;
			case "inserir_edital":
			?>
			<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
				<h1>Inserir Edital</h1>
				<div class="col-md-offset-1 col-md-10">	  
					<form class="form-horizontal" role="form" method="post" action="?p=editar_edital" >
						<div class="form-group">
							<label>Título do Edital</label>
							<input type="text" class="form-control" name="edital" />
						</div>
						<div class="form-group">
							<label>ID do Projeto no Mapas Culturais</label>
							<input type="text" class="form-control" name="id_mapas" />
						</div>
						<div class="form-group">
							<label>Número de fases</label>
							<input type="text" class="form-control" name="fases" />
						</div>
						<div class="form-group">
							<input type="hidden" name="inserir" value="1" />
							<input type="submit" value="Inserir Edital" class="btn btn-theme btn-lg btn-block" />
						</div>
					</div>
				</form>
				
			</main>	
			
			
			
			<?php
			break;	
			case "editar_edital";
			global $wpdb; 
			
			if(isset($_POST['edital'])){
				$edital = $_POST['edital'];	
				$id_mapas = $_POST['id_mapas'];
				$fases = $_POST['fases'];
			}
			
	if(isset($_POST['inserir'])){ //inserir
		
		$sql_inserir = "INSERT INTO `ava_edital` (`id`, `edital`, `id_mapas`, `fases`, `publicado`) 
		VALUES (NULL, '$edital', '$id_mapas', '$fases', '1')"; 
		$inserir = $wpdb->query($sql_inserir);
		$id_edital = $wpdb->insert_id;
		$ed = $wpdb->get_row("SELECT * FROM ava_edital WHERE id = '$id_edital'",ARRAY_A);
	}
	

	if(isset($_POST['atualizar'])){ //atualizar
		$id_atualizar = $_POST['atualizar'];
		$sql_atualizar = "UPDATE `ava_edital` SET
		`edital` = '$edital', 
		`id_mapas` = '$id_mapas', 
		`fases` = '$fases' 
		WHERE `id` = '$id_atualizar'";
		$atualizar = $wpdb->query($sql_atualizar);
		$ed = $wpdb->get_row("SELECT * FROM ava_edital WHERE id = '$id_atualizar'",ARRAY_A);
	}
	
	if(isset($_POST['edit_atualizar'])){
		$id_atualizar = $_POST['edit_atualizar'];
		$ed = $wpdb->get_row("SELECT * FROM ava_edital WHERE id = '$id_atualizar'",ARRAY_A);
		
		
	}
	
	?>

	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Atualizar Edital</h1>
		<h2><?php //var_dump($atualizar); echo $sql_atualizar; ?></h2>
		<div class="col-md-offset-1 col-md-10">	  
			<form class="form-horizontal" role="form" method="post" action="?p=editar_edital" >
				<div class="form-group">
					<label>Título do Edital</label>
					<input type="text" class="form-control" name="edital" value="<?php echo $ed['edital']; ?>" />
				</div>
				<div class="form-group">
					<label>ID do Projeto no Mapas Culturais</label>
					<input type="text" class="form-control" name="id_mapas" value="<?php echo $ed['id_mapas']; ?>"/>
				</div>
				<div class="form-group">
					<label>Número de fases</label>
					<input type="text" class="form-control" name="fases" value="<?php echo $ed['fases']; ?> "/>
				</div>
				<div class="form-group">

					<input type="hidden" name="atualizar" value="<?php echo $ed['id']; ?> "/>
					<input type="submit" value="Atualizar Edital" class="btn btn-theme btn-lg btn-block">
				</div>
			</form>
			
			<div class="form-group">
				<form class="form-horizontal" role="form" method="post" action="?p=avaliadores" >
					<input type="hidden" name="id_edital" value="<?php echo $ed['id']; ?> "/>
					<input type="submit" value="Avaliadores" class="btn btn-theme btn-lg btn-block">
				</form>
			</div>
			<div class="form-group">
				<input type="hidden" name="atualizar" value="<?php echo $ed['id']; ?> "/>
				<input type="submit" value="Subir Planilha de Inscrições " class="btn btn-theme btn-lg btn-block">
			</div>

			
		</div>
		
	</main>		
	<?php 
	break;
	case "listar_edital":
	?>
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Listar Editais</h1>

		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>ID MAPAS</th>
						<th>Título</th>
						<th>Período de Avaliação</th>
						<th></th>	
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$edit = editais($user->ID);				

					for($i = 0; $i < count($edit); $i++){ 
						?>	
						<tr>
							<td><?php //echo $i; ?></td>
							<td><?php echo $edit[$i]['mapas']; ?></td>
							<td><?php echo $edit[$i]['titulo']; ?></td>
							<td><?php echo $edit[$i]['periodo']; ?></td>
							<td>
								<form class="form-horizontal" role="form" method="post" action="?p=editar_edital" >
									<input type="hidden" name="edit_atualizar" value="<?php echo $edit[$i]['id']; ?> "/>
									<input type="submit" value="Editar" class="btn btn-theme btn-lg btn-block">
								</form>
								<?php //echo $edital[0]['periodo']; ?>
							</td>
							<td>
								<input type="hidden" name="atualizar" value="<?php echo $ed['id']; ?> "/>
								<input type="submit" value="Apagar" class="btn btn-theme btn-lg btn-block">
								<?php //echo $edital[0]['periodo']; ?>

							</td>
						</tr>
						<?php 
					} ?>	


				</tbody>
			</table>
		</div>
	</main>

	<?php 
	break;
	case "avaliadores":
	if(isset($_POST['id_edital'])){
		$id_atualizar = $_POST['id_edital'];
		$edit = editais("",$_POST['id_edital']);
	}
	?>
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Avaliadores - <?php echo $edit[0]['titulo']; ?></h1>
		<h2></h2>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Nome Completo</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$args = array('role' => 'administrator,avaliador');
					$users = get_users($args);
					var_dump($users);				

					for($i = 0; $i < count($edit); $i++){ 
						?>	
						<tr>
							<td><?php //echo $i; ?></td>
							<td><?php echo $edit[$i]['mapas']; ?></td>
							<td><?php echo $edit[$i]['titulo']; ?></td>
							<td><?php echo $edit[$i]['periodo']; ?></td>
						</tr>
						<?php 
					} ?>	


				</tbody>
			</table>
		</div>
	</main>	

	<?php 
	break;
	case "usuario":

	?>
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Usuários</h1>
		<h2></h2>

		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Nome Completo</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$args = array();
					$users = get_users( array( 'fields' => array('ID') ) );
					foreach($users as $user_id){
						$user_meta = get_user_meta ( $user_id->ID);
						$user_data = get_userdata( $user_id->ID );
						?>	
						<tr>
							<td><?php echo $user_id->ID; ?></td>
							<td><?php echo $user_data->display_name; ?></td>

						</tr>
						<?php 
					} 
					?>	


				</tbody>
			</table>
		</div>
	</main>	

	<?php
	break;
}
?>

<?php } //fim da validação do usuário ?>


</div>
</div>

<?php 
include "footer.php";
?>