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
					<section id="contact" class="home-section bg-white">
						<div class="container">
							<div class="table-responsive">
								<p>Escolha no Menu ao lado o tipo de indicador que deseja inserir.</p>
							</div>
						</div>
					</section>

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
							<h3>Biblioteca - Visualizar Relatórios</h3>
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
						$sel = "SELECT * FROM sc_ind_biblioteca WHERE publicado = '1' $ano_base ORDER BY periodo_inicio DESC";
						$ocor = $wpdb->get_results($sel,ARRAY_A);
						if(count($ocor) > 0){
							?>

							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Período/Data</th>
											<th>Público - Biblioteca Central</th>
											<th>Público - Biblioteca Descentralizada</th>
											<th>Empréstimos - Biblioteca Central</th>
											<th>Empréstimos - Biblioteca Descentralizada</th>
											<th>Sócios - Biblioteca Central</th>
											<th>Sócios - Biblioteca Descentralizada</th>
											<th>Itens Acervo - Biblioteca Central</th>
											<th>Itens Acervo - Biblioteca Descentralizada</th>
											<th>Itens Acervo - Biblioteca Digital</th>
											<th>Novas Incorporações - Biblioteca Central</th>
											<th>Novas Incorporações - Biblioteca Descentralizada</th>
											<th>Novas Incorporações - Biblioteca Digital</th>
											<th>Downloads - Digital</th>
										</tr>
									</thead>
									<tbody>
										<?php
										for($i = 0; $i < count($ocor); $i++){
											?>
											<tr>
												<td><?php echo exibirDataBr($ocor[$i]['periodo_inicio']); ?><?php if($ocor[$i]['periodo_fim'] != '0000-00-00'){ echo " a ".exibirDataBr($ocor[$i]['periodo_fim']);} ?></td>
												<td><?php echo $ocor[$i]['pub_central'] ?></td>	 
												<td><?php echo $ocor[$i]['pub_ramais'] ?></td>	  
												<td><?php echo $ocor[$i]['emp_central'] ?></td>	 
												<td><?php echo $ocor[$i]['emp_ramais'] ?></td>	 
												<td><?php echo $ocor[$i]['soc_central'] ?></td>	 
												<td><?php echo $ocor[$i]['soc_ramais'] ?></td>	
												<td><?php echo $ocor[$i]['acervo_central'] ?></td>	 
												<td><?php echo $ocor[$i]['acervo_ramais'] ?></td>	 
												<td><?php echo $ocor[$i]['acervo_digital'] ?></td>
												<td><?php echo $ocor[$i]['incorporacoes_central'] ?></td>	 
												<td><?php echo $ocor[$i]['incorporacoes_ramais'] ?></td>	 
												<td><?php echo $ocor[$i]['incorporacoes_digital'] ?></td>		   					
												<td><?php echo $ocor[$i]['downloads'] ?></td>
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