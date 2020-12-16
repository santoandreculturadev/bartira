<?php 		   
		?>
		<?php include "header.php"; ?>
		<?php 
		if(isset($_GET['p'])){
			$p = $_GET['p'];
		}else{
			$p = 'inicio';	
		}
		//session_start(); // carrega a sessão

		?>

		<?php

		error_reporting(0);
		ini_set(“display_errors”, 0 );

		?>


	<body>
			<?php include "menu/me_indicadores.php"; ?>
			
			<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
				<?php 
				switch($p){
					case "inicio": ?>

					<?php

					if(isset($_GET['ano_base']) AND $_GET['ano_base'] != 0 ){

						$ano_base = " AND ano_base ='".$_GET['ano_base']."' ";

						$anobase_option = $_GET['ano_base'];	
					}else{
						$ano_base = "";
						$anobase_option = 0; 	

					}
					?>


					<div class="row">    
						<div class="col-md-offset-2 col-md-8">
							<h3>Redes Sociais - Visualizar Relatórios</h3>
							<p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
							<div class="col-md-offset-1 col-md-10">

								<form method="GET" action="?" class="form-horizontal" role="form">
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Ano Base *</label>
											<select class="form-control" name="ano_base" id="inputSubject" >
												<option value='0'>Escolha uma opção</option>
												<option <?php echo select(1,$anobase_option) ?> >2017</option>
												<option <?php echo select(2,$anobase_option) ?> >2018</option>
												<option <?php echo select(3,$anobase_option) ?> >2019</option>
											</select>
										</div>
									</div>		
									<div class="form-group">
										<div class="col-md-offset-2">
											<input type="submit" class="btn btn-theme btn-sm btn-block" value="Aplicar">
										</form>
									</div>
								</div>		

							</div>		
						</div>


<?php 
$sel = "SELECT * FROM sc_ind_redes WHERE publicado = '1' $ano_base ORDER BY periodo_inicio DESC";	
$ocor = $wpdb->get_results($sel,ARRAY_A);
if(count($ocor) > 0){
	?>

	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Período/Data</th>
					<th>Nº de Postagens - Casa da Palavra</th>
					<th>Nº Membros - Casa da Palavra</th>
					<th>Nº de Postagens - ELCV</th>
					<th>Nº Membros - ELCV</th>
					<th>Nº de Postagens - EMIA</th>
					<th>Nº Membros - EMIA </th>
					<th>Nº de Postagens - Museu de Santo André</th>
					<th>Nº Membros - Museu de Santo André</th>
					<th>Nº de Postagens - CEU Ana Maria</th>
					<th>Nº Membros - CEU Ana Maria</th>
					<th>Nº de Postagens - CEU Marek</th>
					<th>Nº Membros - CEU Marek</th>					
					<th>Nº de Postagens - REBISA</th>
					<th>Nº Membros - REBISA</th>	
					<th>Nº de Postagens - Biblioteca Vila Floresta</th>
					<th>Nº Membros - Biblioteca Vila Floresta</th>	
					<th>Nº de Postagens - ELD (Página)</th>
					<th>Nº Membros - ELD (Página) </th>	
					<th>Nº de Postagens - OSSA</th>
					<th>Nº Membros - OSSA</th>
					<th>Nº de Postagens - Casa do Olhar</th>
					<th>Nº Membros - Casa do Olhar</th>
					<th>Nº de Postagens - ELD (Grupo)</th>
					<th>Nº Membros - ELD (Grupo)</th>	
					<th>Nº de Postagens - ELT</th>
					<th>Nº Membros - ELT</th>
					<th>Nº de Postagens - COMDEPHAAPASA</th>
					<th>Nº Membros - COMDEPHAAPASA</th>
					<th width="10%"></th>

				</tr>
			</thead>
			<tbody>
				<?php
				for($i = 0; $i < count($ocor); $i++){
					?>
					<tr>
						<td><?php echo exibirDataBr($ocor[$i]['periodo_inicio']); ?><?php if($ocor[$i]['periodo_fim'] != '0000-00-00'){ echo " a ".exibirDataBr($ocor[$i]['periodo_fim']);} ?></td>
						<td><?php echo $ocor[$i]['posts_casapalavra'] ?></td>
						<td><?php echo $ocor[$i]['membros_casapalavra'] ?></td>
						<td><?php echo $ocor[$i]['posts_elcv'] ?></td>
						<td><?php echo $ocor[$i]['membros_elcv'] ?></td>
						<td><?php echo $ocor[$i]['posts_emiaaf'] ?></td>
						<td><?php echo $ocor[$i]['membros_emiaaf'] ?></td>
						<td><?php echo $ocor[$i]['posts_museu'] ?></td>
						<td><?php echo $ocor[$i]['membros_museu'] ?></td>
						<td><?php echo $ocor[$i]['posts_ceuana'] ?></td>
						<td><?php echo $ocor[$i]['membros_ceuana'] ?></td>
						<td><?php echo $ocor[$i]['posts_ceumarek'] ?></td>
						<td><?php echo $ocor[$i]['membros_ceumarek'] ?></td>
						<td><?php echo $ocor[$i]['posts_rebisa'] ?></td>
						<td><?php echo $ocor[$i]['membros_rebisa'] ?></td>
						<td><?php echo $ocor[$i]['posts_bibliovf'] ?></td>
						<td><?php echo $ocor[$i]['membros_bibliovf'] ?></td>
						<td><?php echo $ocor[$i]['posts_eld'] ?></td>
						<td><?php echo $ocor[$i]['membros_eld'] ?></td>
						<td><?php echo $ocor[$i]['posts_orquestra'] ?></td>
						<td><?php echo $ocor[$i]['membros_orquestra'] ?></td>
						<td><?php echo $ocor[$i]['posts_casaolhar'] ?></td>
						<td><?php echo $ocor[$i]['membros_casaolhar'] ?></td>
						<td><?php echo $ocor[$i]['posts_grupoeld'] ?></td>
						<td><?php echo $ocor[$i]['membros_grupoeld'] ?></td>
						<td><?php echo $ocor[$i]['posts_elt'] ?></td>
						<td><?php echo $ocor[$i]['membros_elt'] ?></td>
						<td><?php echo $ocor[$i]['posts_comde'] ?></td>	  
						<td><?php echo $ocor[$i]['membros_comde'] ?></td>	 
					</tr>
				<?php } ?>

			</tbody>
		</table>



	</div>

</div>

<?php } else { ?>
	<div class="row">    
		<div class="col-md-offset-2 col-md-8">
			<p> Não há relatórios cadastrados. </p>
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

