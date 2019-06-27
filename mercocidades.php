<?php include "header.php"; ?>

<body>
	
	<?php include "menu/me_mercocidades.php"; ?>
	
	<?php 
	
	if(isset($_GET['p'])){
		$p = $_GET['p'];
	}else{
		$p = 'inicio';
	}
	
	switch($p){
		case 'inicio':
		
		function retornaDataAvaliacao($id_mercocidades,$user){
			global $wpdb;
			$sql = "SELECT data01,jurado01 FROM sc_mercocidades_nota WHERE id_mercocidades = '$id_mercocidades' AND id_usuario = '$user'";
			$x = $wpdb->get_row($sql,ARRAY_A);
			if($x == NULL){
				$y['data01'] = "N/A";
				$y['jurado01'] = "N/A";
				return $x;
			}else{
				$x['data01'] = exibirDataBr($x['data01']);
				return $x;
			}
			
		}
		
		?>
		
		<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
			<h1>Mercocidades - Vídeo</h1>

			<h2>Obras inscritas</h2>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Título</th>
							<th>Categoria</th>
							<th>Inscrito</th>
							<th>Data</th>
							<th>Nota</th>
							<th></th>
						</tr>
					</thead>
					<tbody>

						<?php 
						$sql_filmes = "SELECT * FROM sc_mercocidades";
						$edital = $wpdb->get_results($sql_filmes,ARRAY_A);
						for($i = 0; $i < count($edital); $i++){
							$nota = (retornaDataAvaliacao($edital[$i]['id'],$user->ID)); 
							?>		
							
							<tr>
								<td><?php echo $edital[$i]['id']; ?></td>
								<td><?php echo $edital[$i]['COL27']; ?></td>
								<td><?php echo $edital[$i]['COL32']; ?></td>
								<td><?php echo $edital[$i]['COL2']; ?></td>
								<td><?php echo $nota['data01']; ?></td>
								<td><?php echo $nota['jurado01']; ?></td>
								<td>
									<form action="?p=view" method="POST" class="form-horizontal">
										<input type="hidden" name="p" value="view">
										<input type="hidden" name="id" value="<?php echo $edital[$i]['id']; ?>">
										<input type="hidden" name="id" value="<?php echo $edital[$i]['id']; ?>">
										<input type="submit" class="btn btn-theme btn-lg btn-block" name="detalhes" value="Detalhes" />
									</form>					  </td>

								</tr>
							<?php } ?>		


						</tbody>
					</table>
				</div>
				
				
				<?php 
				break;
				case 'view':


				$id = $_POST['id'];
				$id_usuario = $user->ID;
				$sql = "SELECT * FROM sc_mercocidades WHERE id= '$id'";

// verifica se existem as notas
				$sql_ver = "SELECT * FROM sc_mercocidades_nota WHERE id_mercocidades = '$id' AND id_usuario = '$id_usuario'";
				$ver = $wpdb->get_results($sql_ver,ARRAY_A);

if(count($ver) == 0){ // atualiza
	
 // insere
	$sql_ins = "INSERT INTO `sc_mercocidades_nota` (`id`, `id_usuario`, `id_mercocidades`, `um_video`, `quantos_videos`, `ano`, `classificado`, `categoria`, `minutagem`, `tema`, `legendagem`, `documentos`, `jurado01`, `data01`, `status`) VALUES (NULL, '$id_usuario', '$id', '', '', '', '', '', '', '', '', '', '', '', '')";
	$ins = $wpdb->query($sql_ins);
	$id = $wpdb->insert_id;
}

if(isset($_POST['salvar'])){
	$um_video = $_POST["um_video"];
	$quantos_videos = $_POST["quantos_videos"];
	$ano = $_POST["ano"];
	$categoria = $_POST["categoria"];
	$minutagem = $_POST["minutagem"];
	$tema = $_POST["tema"];
	$legendagem = $_POST["legendagem"];
	$jurado01 = $_POST["jurado01"];
	$id_mercocidades = $_POST["id"];
	$data01 = date('Y-m-d');
	
	$sql_upd = "UPDATE sc_mercocidades_nota SET
	`um_video` = '$um_video',
	`quantos_videos` = '$quantos_videos',
	`ano` = '$ano',
	`categoria` = '$categoria',
	`minutagem` = '$minutagem',
	`tema` = '$tema',
	`legendagem` = '$tema',
	`jurado01` = '$jurado01',
	`data01` = '$data01'
	WHERE id_mercocidades = '$id_mercocidades' AND id_usuario = '$id_usuario';
	
	
	";
	$e = $wpdb->query($sql_upd);
	if($e == 1){
		$mensagem = alerta("Avaliação atualizada","success");
	}else{
		$mensagem = alerta("Erro ao atualizar","warning");
	}
	
}


$filme = $wpdb->get_row($sql,ARRAY_A);

?>	


<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
	<h1><?php echo $filme['COL27']; ?></h1>		
	<p><?php if(isset($mensagem)){echo $mensagem; }?></p>
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<p>de : <?php echo $filme['COL2']; ?> ( <?php echo $filme['COL15']; ?> / <?php echo $filme['COL28']; ?>  )</p>
				<p>cidade : <?php echo $filme['COL8']; ?></p>
				<p>contato : <?php echo $filme['COL9']; ?></p>
				<p>categoria : <?php echo $filme['COL32']; ?></p>
				<p>sinopse : <?php echo $filme['COL35']; ?></p>
				
				
				<p><a href="<?php echo $filme['COL31'];  ?>" target=_blank ><?php echo $filme['COL31'];  ?> </a><?php if($filme['COL34'] != ""){ echo $filme['COL34'];} ?></p>
				
				<?php 

				
				?>

			</div>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<?php 
			  //recupera as notas
			$notas = $wpdb->get_row($sql_ver,ARRAY_A);
			//var_dump($notas);	
			
			?>
			
			
			<form method="POST" action="?p=view" class="form-horizontal" role="form">
				<tbody>
					<tr>
						<td>Enviou apenas um vídeo?</td>
						<td>
							<select class="form-control" name="um_video" id="programa" >
								<option value='1' <?php if($notas['um_video'] == 1){ echo " selected ";} ?> >Sim</option>
								<option value='0' <?php if($notas['um_video'] == 0){ echo " selected ";} ?>>Não</option>
							</select>
						</td>
					</tr>
					
					<tr>
						<td>Se não, quantos vídeos enviou?</td>
						<td>
							<input type="text" name="quantos_videos" class="form-control" id="inputSubject" value="<?php echo $notas['quantos_videos'];?>"/>
						</td>
					</tr>
					<tr>
						<td>O vídeo foi feito em:</td>
						<td>
							<select class="form-control" name="ano" id="programa" >
								<option value='2017' <?php if($notas['ano'] == '2017'){ echo " selected ";} ?>>2017</option>
								<option value='2018' <?php if($notas['ano'] == '2018'){ echo " selected ";} ?>>2018</option>
								<option value='2019' <?php if($notas['ano'] == '2019'){ echo " selected ";} ?>>2019</option>

							</select>
						</td>
					</tr>
					<tr>
						<td>Vídeo se enquadra na categoria inscrita?</td>
						<td>
							<select class="form-control" name="categoria" id="programa" >
								<option value='1'<?php if($notas['categoria'] == 1){ echo " selected ";} ?> >Sim</option>
								<option value='0' <?php if($notas['categoria'] == 0){ echo " selected ";} ?>>Não</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>O vídeo está dentro da minutagem exigida?</td>
						<td>
							<select class="form-control" name="minutagem" id="programa" >
								<option value='1'<?php if($notas['minutagem'] == 1){ echo " selected ";} ?> >Sim</option>
								<option value='0' <?php if($notas['minutagem'] == 0){ echo " selected ";} ?>>Não</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>O vídeo se adequa ao tema?</td>
						<td>
							<select class="form-control" name="tema" id="programa" >
								<option value='1'<?php if($notas['tema'] == 1){ echo " selected ";} ?> >Sim</option>
								<option value='0' <?php if($notas['tema'] == 0){ echo " selected ";} ?>>Não</option>					</select>
							</td>
						</tr>				
						<tr>
							<td>A legedagem está correta?</td>
							<td>
								<select class="form-control" name="legendagem" id="programa" >
									<option value='1'<?php if($notas['legendagem'] == 1){ echo " selected ";} ?> >Sim</option>
									<option value='0' <?php if($notas['legendagem'] == 0){ echo " selected ";} ?>>Não</option>					</select>
								</td>
							</tr>				
							<tr>
								<td>Nota</td>
								<td>
									<select class="form-control" name="jurado01" id="programa" >
										<option value='0' <?php if($notas['jurado01'] == 0){ echo " selected ";} ?>>0</option>
										<option value='4' <?php if($notas['jurado01'] == 4){ echo " selected ";} ?> >4</option>
										<option value='10' <?php if($notas['jurado01'] == 10){ echo " selected ";} ?>>10</option>

									</select>
								</td>
							</tr>	
							<tr>
								<td>
									<input type='hidden' name='id' value='<?php echo $notas['id_mercocidades'] ?>' >

									<input type="submit" class="btn btn-theme btn-lg btn-block" name = 'salvar' value="Salvar">
								</td>
								<td>
								</td>
							</tr>
							
						</tbody>
					</table>
				</div>
				
				<?php 
				break;
  } // fim da switch
  ?>
</main>
</div>
</div>

<?php 
include "footer.php";
?>