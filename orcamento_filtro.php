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
							<h3>Orçamento - Visualizar Relatórios</h3>
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
												<option <?php echo select(3,$anobase_option) ?> >2020</option>
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
$sel = "SELECT * FROM sc_ind_orcamento WHERE publicado = '1' $ano_base ORDER BY periodo_inicio DESC";
$ocor = $wpdb->get_results($sel,ARRAY_A);
if(count($ocor) > 0){
	?>

	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="18%">Período/Data</th>
					<th>Orçado</th>
					<th>Contigenciado</th>
					<th>Supl/Liberado</th>
					<th>Disponibilizado</th>
					<th>Empenhado</th>
					<th>Reservado</th>
					<th>Comprometido</th>
					<th>Disponível</th>
					<th>% comprometido em relação ao disponível</th>

					<th width="10%"></th>

				</tr>
			</thead>
			<tbody>
				<?php
				for($i = 0; $i < count($ocor); $i++){
					?>
					<tr>
						<td><?php echo exibirDataBr($ocor[$i]['periodo_inicio']); ?><?php if($ocor[$i]['periodo_fim'] != '0000-00-00'){ echo " a ".exibirDataBr($ocor[$i]['periodo_fim']);} ?></td>
						<td><?php echo dinheiroParaBr($ocor[$i]['orcado']) ?></td>	  
						<td><?php echo dinheiroParaBr($ocor[$i]['contigenciado']) ?></td>	  
						<td><?php echo dinheiroParaBr($ocor[$i]['sup_liberado']) ?></td>
						<td><?php echo dinheiroParaBr($ocor[$i]['orcado']-$ocor[$i]['contigenciado']+$ocor[$i]['sup_liberado']) ?></td>
						<td><?php echo dinheiroParaBr($ocor[$i]['empenhado']) ?></td>	  
						<td><?php echo dinheiroParaBr($ocor[$i]['reservado']) ?></td>	  
						<td><?php echo dinheiroParaBr($ocor[$i]['empenhado']+$ocor[$i]['reservado']) ?></td>
						<td><?php echo dinheiroParaBr($ocor[$i]['disponivel']) ?></td>	
						<td><?php echo dinheiroParaBr(($ocor[$i]['empenhado']+$ocor[$i]['reservado']) / ($ocor[$i]['orcado']-$ocor[$i]['contigenciado']+$ocor[$i]['sup_liberado'])*100) ?></td>	
						
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