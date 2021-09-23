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

						$ano_base = $_GET['ano_base'];
						$sql_ano_base = " AND ano_base = '$ano_base' ";
						
					}else{
						$ano_base = NULL;
						$sql_ano_base = "";

					}
					?>

					<div class="row">    
						<div class="col-md-offset-2 col-md-8">
							<h3>Acervos - Visualizar Relatórios</h3>
							<p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
							<div class="col-md-offset-1 col-md-10">

								<form method="GET" action="?" class="form-horizontal" role="form">
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Ano Base *</label>
											<select class="form-control" name="ano_base" id="inputSubject" >
												<option value='0'>Escolha uma opção</option>
																								<?php 
													anoBaseIndicadores("sc_ind_acervos",$ano_base);

												?>
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
$sel = "SELECT * FROM sc_ind_acervos WHERE publicado = '1' $sql_ano_base ORDER BY periodo_inicio DESC";
$ocor = $wpdb->get_results($sel,ARRAY_A);
if(count($ocor) > 0){
	?>

	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Período</th>
					<th>Museu - Total Itens no Acervo</th>
					<th>Museu - Acervos/Produtos Digitalizados</th>
					<th>Museu - Acervos/Produtos Disponibilizados</th>
					<th>Arte Contemporânea - Total Itens no Acervo</th>
					<th>Arte Contemporânea - Acervos/Produtos Digitalizados</th>
					<th>Arte Contemporânea - Acervos/Produtos Disponibilizados</th>
					<th width="10%"></th>
					<th width="10%"></th>

				</tr>
			</thead>
			<tbody>
				<?php
				for($i = 0; $i < count($ocor); $i++){

					?>
					<tr>
						<td><?php echo exibirDataBr($ocor[$i]['periodo_inicio']) ?> a <?php echo exibirDataBr($ocor[$i]['periodo_fim']) ?> </td>
						<td><?php echo $ocor[$i]['museu_total']?></td>
						<td><?php echo$ocor[$i]['museu_digitalizados'] ?></td>	
						<td><?php echo$ocor[$i]['museu_disponiveis'] ?></td>	
						<td><?php echo$ocor[$i]['artec_total'] ?></td>	
						<td><?php echo$ocor[$i]['artec_digitalizados'] ?></td>	
						<td><?php echo$ocor[$i]['artec_disponiveis'] ?></td>	
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
