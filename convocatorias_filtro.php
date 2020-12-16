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
							<h3>Resumo Convocatórias - Visualizar Relatórios</h3>
							<p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
							<div class="col-md-offset-1 col-md-10">

								

							</div>		
						</div>


				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<label><h2>2019</h2></label>
							<tr>
								<th>Período</th>
								<th>Realizadas</th>
								<th>Inscritos</th>
								<th>Selecionados</th>
								<th>Contratados</th>
								<th>Valor Disponibilizado</th>
								<th width="10%"></th>
								<th width="10%"></th>
							</tr>
						</thead>
						
						
							<tbody>
								<tr>
									<td>01/12/2019 a 31/12/2019</td>
									<?php $sql_realizadas_dez = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND (rascunhos_dez != '0' OR inscritos_dez != '0' OR selecionados_dez != '0' OR contratados_dez != '0') AND publicado = '1'";
									$realizadas_dez = $wpdb->get_results($sql_realizadas_dez,ARRAY_A);
									?>
									<td><?php echo $realizadas_dez[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_dez = "SELECT SUM(inscritos_dez) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$inscritos_dez = $wpdb->get_results($sql_inscritos_dez,ARRAY_A);
									?>
									<td><?php echo $inscritos_dez[0]['SUM(inscritos_dez)'] ?></td>	

									<?php $sql_selecionados_dez = "	SELECT SUM(selecionados_dez) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$selecionados_dez = $wpdb->get_results($sql_selecionados_dez,ARRAY_A);
									?>
									<td><?php echo $selecionados_dez[0]['SUM(selecionados_dez)'] ?></td>

									<?php $sql_contratados_dez = "	SELECT SUM(contratados_dez) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$contratados_dez = $wpdb->get_results($sql_contratados_dez,ARRAY_A);
									?>
									<td><?php echo $contratados_dez[0]['SUM(contratados_dez)'] ?></td>

									<?php $sql_valor_disp = "SELECT SUM(valor_disponibilizado) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$valor_disp = $wpdb->get_results($sql_valor_disp,ARRAY_A);
									?>
									<td><?php echo dinheiroParaBr($valor_disp[0]['SUM(valor_disponibilizado)']) ?></td>		
								</tr>
						</tbody>
						<tbody>
								<tr>
									<td>01/11/2019 a 30/11/2019</td>
									<?php $sql_realizadas_nov = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND (rascunhos_nov != '0' OR inscritos_nov != '0' OR selecionados_nov != '0' OR contratados_nov != '0') AND publicado = '1'";
									$realizadas_nov = $wpdb->get_results($sql_realizadas_nov,ARRAY_A);
									?>
									<td><?php echo $realizadas_nov[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_nov = "SELECT SUM(inscritos_nov) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$inscritos_nov = $wpdb->get_results($sql_inscritos_nov,ARRAY_A);
									?>
									<td><?php echo $inscritos_nov[0]['SUM(inscritos_nov)'] ?></td>	

									<?php $sql_selecionados_nov = "	SELECT SUM(selecionados_nov) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$selecionados_nov = $wpdb->get_results($sql_selecionados_nov,ARRAY_A);
									?>
									<td><?php echo $selecionados_nov[0]['SUM(selecionados_nov)'] ?></td>

									<?php $sql_contratados_nov = "	SELECT SUM(contratados_nov) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$contratados_nov = $wpdb->get_results($sql_contratados_nov,ARRAY_A);
									?>
									<td><?php echo $contratados_nov[0]['SUM(contratados_nov)'] ?></td>	
								</tr>
						</tbody>
<tbody>
								<tr>
									<td>01/10/2019 a 31/10/2019</td>
									<?php $sql_realizadas_out = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND (rascunhos_out != '0' OR inscritos_out != '0' OR selecionados_out != '0' OR contratados_out != '0') AND publicado = '1'";
									$realizadas_out = $wpdb->get_results($sql_realizadas_out,ARRAY_A);
									?>
									<td><?php echo $realizadas_out[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_out = "SELECT SUM(inscritos_out) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$inscritos_out = $wpdb->get_results($sql_inscritos_out,ARRAY_A);
									?>
									<td><?php echo $inscritos_out[0]['SUM(inscritos_out)'] ?></td>	

									<?php $sql_selecionados_out = "	SELECT SUM(selecionados_out) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$selecionados_out = $wpdb->get_results($sql_selecionados_out,ARRAY_A);
									?>
									<td><?php echo $selecionados_out[0]['SUM(selecionados_out)'] ?></td>

									<?php $sql_contratados_out = "	SELECT SUM(contratados_out) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$contratados_out = $wpdb->get_results($sql_contratados_out,ARRAY_A);
									?>
									<td><?php echo $contratados_out[0]['SUM(contratados_out)'] ?></td>	
								</tr>
						</tbody>
<tbody>
								<tr>
									<td>01/09/2019 a 30/09/2019</td>
									<?php $sql_realizadas_set = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND (rascunhos_set != '0' OR inscritos_set != '0' OR selecionados_set != '0' OR contratados_set != '0') AND publicado = '1'";
									$realizadas_set = $wpdb->get_results($sql_realizadas_set,ARRAY_A);
									?>
									<td><?php echo $realizadas_set[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_set = "SELECT SUM(inscritos_set) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$inscritos_set = $wpdb->get_results($sql_inscritos_set,ARRAY_A);
									?>
									<td><?php echo $inscritos_set[0]['SUM(inscritos_set)'] ?></td>	

									<?php $sql_selecionados_set = "	SELECT SUM(selecionados_set) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$selecionados_set = $wpdb->get_results($sql_selecionados_set,ARRAY_A);
									?>
									<td><?php echo $selecionados_set[0]['SUM(selecionados_set)'] ?></td>

									<?php $sql_contratados_set = "	SELECT SUM(contratados_set) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$contratados_set = $wpdb->get_results($sql_contratados_set,ARRAY_A);
									?>
									<td><?php echo $contratados_set[0]['SUM(contratados_set)'] ?></td>	
								</tr>
						</tbody>
<tbody>
								<tr>
									<td>01/08/2019 a 31/08/2019</td>
									<?php $sql_realizadas_ago = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND (rascunhos_ago != '0' OR inscritos_ago != '0' OR selecionados_ago != '0' OR contratados_ago != '0') AND publicado = '1'";
									$realizadas_ago = $wpdb->get_results($sql_realizadas_ago,ARRAY_A);
									?>
									<td><?php echo $realizadas_ago[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_ago = "SELECT SUM(inscritos_ago) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$inscritos_ago = $wpdb->get_results($sql_inscritos_ago,ARRAY_A);
									?>
									<td><?php echo $inscritos_ago[0]['SUM(inscritos_ago)'] ?></td>	

									<?php $sql_selecionados_ago = "	SELECT SUM(selecionados_ago) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$selecionados_ago = $wpdb->get_results($sql_selecionados_ago,ARRAY_A);
									?>
									<td><?php echo $selecionados_ago[0]['SUM(selecionados_ago)'] ?></td>

									<?php $sql_contratados_ago = "	SELECT SUM(contratados_ago) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$contratados_ago = $wpdb->get_results($sql_contratados_ago,ARRAY_A);
									?>
									<td><?php echo $contratados_ago[0]['SUM(contratados_ago)'] ?></td>	
								</tr>
						</tbody>
<tbody>
								<tr>
									<td>01/07/2019 a 31/07/2019</td>
									<?php $sql_realizadas_jul = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND (rascunhos_jul != '0' OR inscritos_jul != '0' OR selecionados_jul != '0' OR contratados_jul != '0') AND publicado = '1'";
									$realizadas_jul = $wpdb->get_results($sql_realizadas_jul,ARRAY_A);
									?>
									<td><?php echo $realizadas_jul[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_jul = "SELECT SUM(inscritos_jul) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$inscritos_jul = $wpdb->get_results($sql_inscritos_jul,ARRAY_A);
									?>
									<td><?php echo $inscritos_jul[0]['SUM(inscritos_jul)'] ?></td>	

									<?php $sql_selecionados_jul = "	SELECT SUM(selecionados_jul) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$selecionados_jul = $wpdb->get_results($sql_selecionados_jul,ARRAY_A);
									?>
									<td><?php echo $selecionados_jul[0]['SUM(selecionados_jul)'] ?></td>

									<?php $sql_contratados_jul = "	SELECT SUM(contratados_jul) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$contratados_jul = $wpdb->get_results($sql_contratados_jul,ARRAY_A);
									?>
									<td><?php echo $contratados_jul[0]['SUM(contratados_jul)'] ?></td>	
								</tr>
						</tbody>
<tbody>
								<tr>
									<td>01/06/2019 a 30/06/2019</td>
									<?php $sql_realizadas_jun = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND (rascunhos_jun != '0' OR inscritos_jun != '0' OR selecionados_jun != '0' OR contratados_jun != '0') AND publicado = '1'";
									$realizadas_jun = $wpdb->get_results($sql_realizadas_jun,ARRAY_A);
									?>
									<td><?php echo $realizadas_jun[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_jun = "SELECT SUM(inscritos_jun) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$inscritos_jun = $wpdb->get_results($sql_inscritos_jun,ARRAY_A);
									?>
									<td><?php echo $inscritos_jun[0]['SUM(inscritos_jun)'] ?></td>	

									<?php $sql_selecionados_jun = "	SELECT SUM(selecionados_jun) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$selecionados_jun = $wpdb->get_results($sql_selecionados_jun,ARRAY_A);
									?>
									<td><?php echo $selecionados_jun[0]['SUM(selecionados_jun)'] ?></td>

									<?php $sql_contratados_jun = "	SELECT SUM(contratados_jun) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$contratados_jun = $wpdb->get_results($sql_contratados_jun,ARRAY_A);
									?>
									<td><?php echo $contratados_jun[0]['SUM(contratados_jun)'] ?></td>	
								</tr>
						</tbody>
<tbody>
								<tr>
									<td>01/05/2019 a 31/05/2019</td>
									<?php $sql_realizadas_mai = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND (rascunhos_mai != '0' OR inscritos_mai != '0' OR selecionados_mai != '0' OR contratados_mai != '0') AND publicado = '1'";
									$realizadas_mai = $wpdb->get_results($sql_realizadas_mai,ARRAY_A);
									?>
									<td><?php echo $realizadas_mai[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_mai = "SELECT SUM(inscritos_mai) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$inscritos_mai = $wpdb->get_results($sql_inscritos_mai,ARRAY_A);
									?>
									<td><?php echo $inscritos_mai[0]['SUM(inscritos_mai)'] ?></td>	

									<?php $sql_selecionados_mai = "	SELECT SUM(selecionados_mai) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$selecionados_mai = $wpdb->get_results($sql_selecionados_mai,ARRAY_A);
									?>
									<td><?php echo $selecionados_mai[0]['SUM(selecionados_mai)'] ?></td>

									<?php $sql_contratados_mai = "	SELECT SUM(contratados_mai) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$contratados_mai = $wpdb->get_results($sql_contratados_mai,ARRAY_A);
									?>
									<td><?php echo $contratados_mai[0]['SUM(contratados_mai)'] ?></td>	
								</tr>	
						</tbody>
<tbody>
								<tr>
									<td>01/04/2019 a 30/04/2019</td>
									<?php $sql_realizadas_abr = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND (rascunhos_abr != '0' OR inscritos_abr != '0' OR selecionados_abr != '0' OR contratados_abr != '0') AND publicado = '1'";
									$realizadas_abr = $wpdb->get_results($sql_realizadas_abr,ARRAY_A);
									?>
									<td><?php echo $realizadas_abr[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_abr = "SELECT SUM(inscritos_abr) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$inscritos_abr = $wpdb->get_results($sql_inscritos_abr,ARRAY_A);
									?>
									<td><?php echo $inscritos_abr[0]['SUM(inscritos_abr)'] ?></td>	

									<?php $sql_selecionados_abr = "	SELECT SUM(selecionados_abr) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$selecionados_abr = $wpdb->get_results($sql_selecionados_abr,ARRAY_A);
									?>
									<td><?php echo $selecionados_abr[0]['SUM(selecionados_abr)'] ?></td>

									<?php $sql_contratados_abr = "	SELECT SUM(contratados_abr) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$contratados_abr = $wpdb->get_results($sql_contratados_abr,ARRAY_A);
									?>
									<td><?php echo $contratados_abr[0]['SUM(contratados_abr)'] ?></td>	
								</tr>	
						</tbody>
<tbody>
								<tr>
									<td>01/03/2019 a 31/03/2019</td>
									<?php $sql_realizadas_mar = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND (rascunhos_mar != '0' OR inscritos_mar != '0' OR selecionados_mar != '0' OR contratados_mar != '0') AND publicado = '1'";
									$realizadas_mar = $wpdb->get_results($sql_realizadas_mar,ARRAY_A);
									?>
									<td><?php echo $realizadas_mar[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_mar = "SELECT SUM(inscritos_mar) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$inscritos_mar = $wpdb->get_results($sql_inscritos_mar,ARRAY_A);
									?>
									<td><?php echo $inscritos_mar[0]['SUM(inscritos_mar)'] ?></td>	

									<?php $sql_selecionados_mar = "	SELECT SUM(selecionados_mar) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$selecionados_mar = $wpdb->get_results($sql_selecionados_mar,ARRAY_A);
									?>
									<td><?php echo $selecionados_mar[0]['SUM(selecionados_mar)'] ?></td>

									<?php $sql_contratados_mar = "	SELECT SUM(contratados_mar) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$contratados_mar = $wpdb->get_results($sql_contratados_mar,ARRAY_A);
									?>
									<td><?php echo $contratados_mar[0]['SUM(contratados_mar)'] ?></td>	
								</tr>			

						</tbody>
<tbody>
								<tr>
									<td>01/02/2019 a 28/02/2019</td>
									<?php $sql_realizadas_fev = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND (rascunhos_fev != '0' OR inscritos_fev != '0' OR selecionados_fev != '0' OR contratados_fev != '0') AND publicado = '1'";
									$realizadas_fev = $wpdb->get_results($sql_realizadas_fev,ARRAY_A);
									?>
									<td><?php echo $realizadas_fev[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_fev = "SELECT SUM(inscritos_fev) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$inscritos_fev = $wpdb->get_results($sql_inscritos_fev,ARRAY_A);
									?>
									<td><?php echo $inscritos_fev[0]['SUM(inscritos_fev)'] ?></td>	

									<?php $sql_selecionados_fev = "	SELECT SUM(selecionados_fev) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$selecionados_fev = $wpdb->get_results($sql_selecionados_fev,ARRAY_A);
									?>
									<td><?php echo $selecionados_fev[0]['SUM(selecionados_fev)'] ?></td>

									<?php $sql_contratados_fev = "	SELECT SUM(contratados_fev) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$contratados_fev = $wpdb->get_results($sql_contratados_fev,ARRAY_A);
									?>
									<td><?php echo $contratados_fev[0]['SUM(contratados_fev)'] ?></td>	
								</tr>

						</tbody>
<tbody>
								<tr>
									<td>01/01/2019 a 31/01/2019</td>
									<?php $sql_realizadas_jan = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND (rascunhos_jan != '0' OR inscritos_jan != '0' OR selecionados_jan != '0' OR contratados_jan != '0') AND publicado = '1'";
									$realizadas_jan = $wpdb->get_results($sql_realizadas_jan,ARRAY_A);
									?>
									<td><?php echo $realizadas_jan[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_jan = "SELECT SUM(inscritos_jan) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$inscritos_jan = $wpdb->get_results($sql_inscritos_jan,ARRAY_A);
									?>
									<td><?php echo $inscritos_jan[0]['SUM(inscritos_jan)'] ?></td>	

									<?php $sql_selecionados_jan = "	SELECT SUM(selecionados_jan) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$selecionados_jan = $wpdb->get_results($sql_selecionados_jan,ARRAY_A);
									?>
									<td><?php echo $selecionados_jan[0]['SUM(selecionados_jan)'] ?></td>

									<?php $sql_contratados_jan = "	SELECT SUM(contratados_jan) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2019%' AND publicado = '1'";
									$contratados_jan = $wpdb->get_results($sql_contratados_jan,ARRAY_A);
									?>
									<td><?php echo $contratados_jan[0]['SUM(contratados_jan)'] ?></td>		
								</tr>
						</tbody>
					</table>	

						<!-- 2018 -->
					<div class="table-responsive">
						<table class="table table-striped">	
						<thead>
							<label><h2>2018</h2></label>
							<tr>
								<th>Período</th>
								<th>Realizadas</th>
								<th>Inscritos</th>
								<th>Selecionados</th>
								<th>Contratados</th>
								<th>Valor Disponibilizado</th>
								<th width="10%"></th>
								<th width="10%"></th>
							</tr>
						</thead>
						
						
							<tbody>
																<tr>

						<tbody>
																<tr>
									<td>01/12/2018 a 31/12/2018</td>
									<?php $sql_realizadas_dez = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND (rascunhos_dez != '0' OR inscritos_dez != '0' OR selecionados_dez != '0' OR contratados_dez != '0') AND publicado = '1'";
									$realizadas_dez = $wpdb->get_results($sql_realizadas_dez,ARRAY_A);
									?>
									<td><?php echo $realizadas_dez[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_dez = "SELECT SUM(inscritos_dez) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$inscritos_dez = $wpdb->get_results($sql_inscritos_dez,ARRAY_A);
									?>
									<td><?php echo $inscritos_dez[0]['SUM(inscritos_dez)'] ?></td>	

									<?php $sql_selecionados_dez = "	SELECT SUM(selecionados_dez) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$selecionados_dez = $wpdb->get_results($sql_selecionados_dez,ARRAY_A);
									?>
									<td><?php echo $selecionados_dez[0]['SUM(selecionados_dez)'] ?></td>

									<?php $sql_contratados_dez = "	SELECT SUM(contratados_dez) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$contratados_dez = $wpdb->get_results($sql_contratados_dez,ARRAY_A);
									?>
									<td><?php echo $contratados_dez[0]['SUM(contratados_dez)'] ?></td>

									<?php $sql_valor_disp = "SELECT SUM(valor_disponibilizado) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$valor_disp = $wpdb->get_results($sql_valor_disp,ARRAY_A);
									?>
									<td><?php echo dinheiroParaBr($valor_disp[0]['SUM(valor_disponibilizado)']) ?></td>		
								</tr>
						</tbody>
<tbody>
								<tr>
									<td>01/11/2018 a 30/11/2018</td>
									<?php $sql_realizadas_nov = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND (rascunhos_nov != '0' OR inscritos_nov != '0' OR selecionados_nov != '0' OR contratados_nov != '0') AND publicado = '1'";
									$realizadas_nov = $wpdb->get_results($sql_realizadas_nov,ARRAY_A);
									?>
									<td><?php echo $realizadas_nov[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_nov = "SELECT SUM(inscritos_nov) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$inscritos_nov = $wpdb->get_results($sql_inscritos_nov,ARRAY_A);
									?>
									<td><?php echo $inscritos_nov[0]['SUM(inscritos_nov)'] ?></td>	

									<?php $sql_selecionados_nov = "	SELECT SUM(selecionados_nov) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$selecionados_nov = $wpdb->get_results($sql_selecionados_nov,ARRAY_A);
									?>
									<td><?php echo $selecionados_nov[0]['SUM(selecionados_nov)'] ?></td>

									<?php $sql_contratados_nov = "	SELECT SUM(contratados_nov) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$contratados_nov = $wpdb->get_results($sql_contratados_nov,ARRAY_A);
									?>
									<td><?php echo $contratados_nov[0]['SUM(contratados_nov)'] ?></td>	
								</tr>
						</tbody>
<tbody>
								<tr>
									<td>01/10/2018 a 31/10/2018</td>
									<?php $sql_realizadas_out = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND (rascunhos_out != '0' OR inscritos_out != '0' OR selecionados_out != '0' OR contratados_out != '0') AND publicado = '1'";
									$realizadas_out = $wpdb->get_results($sql_realizadas_out,ARRAY_A);
									?>
									<td><?php echo $realizadas_out[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_out = "SELECT SUM(inscritos_out) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$inscritos_out = $wpdb->get_results($sql_inscritos_out,ARRAY_A);
									?>
									<td><?php echo $inscritos_out[0]['SUM(inscritos_out)'] ?></td>	

									<?php $sql_selecionados_out = "	SELECT SUM(selecionados_out) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$selecionados_out = $wpdb->get_results($sql_selecionados_out,ARRAY_A);
									?>
									<td><?php echo $selecionados_out[0]['SUM(selecionados_out)'] ?></td>

									<?php $sql_contratados_out = "	SELECT SUM(contratados_out) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$contratados_out = $wpdb->get_results($sql_contratados_out,ARRAY_A);
									?>
									<td><?php echo $contratados_out[0]['SUM(contratados_out)'] ?></td>	
								</tr>
						</tbody>
<tbody>
								<tr>
									<td>01/09/2018 a 30/09/2018</td>
									<?php $sql_realizadas_set = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND (rascunhos_set != '0' OR inscritos_set != '0' OR selecionados_set != '0' OR contratados_set != '0') AND publicado = '1'";
									$realizadas_set = $wpdb->get_results($sql_realizadas_set,ARRAY_A);
									?>
									<td><?php echo $realizadas_set[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_set = "SELECT SUM(inscritos_set) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$inscritos_set = $wpdb->get_results($sql_inscritos_set,ARRAY_A);
									?>
									<td><?php echo $inscritos_set[0]['SUM(inscritos_set)'] ?></td>	

									<?php $sql_selecionados_set = "	SELECT SUM(selecionados_set) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$selecionados_set = $wpdb->get_results($sql_selecionados_set,ARRAY_A);
									?>
									<td><?php echo $selecionados_set[0]['SUM(selecionados_set)'] ?></td>

									<?php $sql_contratados_set = "	SELECT SUM(contratados_set) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$contratados_set = $wpdb->get_results($sql_contratados_set,ARRAY_A);
									?>
									<td><?php echo $contratados_set[0]['SUM(contratados_set)'] ?></td>	
								</tr>
						</tbody>
<tbody>
								<tr>
									<td>01/08/2018 a 31/08/2018</td>
									<?php $sql_realizadas_ago = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND (rascunhos_ago != '0' OR inscritos_ago != '0' OR selecionados_ago != '0' OR contratados_ago != '0') AND publicado = '1'";
									$realizadas_ago = $wpdb->get_results($sql_realizadas_ago,ARRAY_A);
									?>
									<td><?php echo $realizadas_ago[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_ago = "SELECT SUM(inscritos_ago) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$inscritos_ago = $wpdb->get_results($sql_inscritos_ago,ARRAY_A);
									?>
									<td><?php echo $inscritos_ago[0]['SUM(inscritos_ago)'] ?></td>	

									<?php $sql_selecionados_ago = "	SELECT SUM(selecionados_ago) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$selecionados_ago = $wpdb->get_results($sql_selecionados_ago,ARRAY_A);
									?>
									<td><?php echo $selecionados_ago[0]['SUM(selecionados_ago)'] ?></td>

									<?php $sql_contratados_ago = "	SELECT SUM(contratados_ago) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$contratados_ago = $wpdb->get_results($sql_contratados_ago,ARRAY_A);
									?>
									<td><?php echo $contratados_ago[0]['SUM(contratados_ago)'] ?></td>	
								</tr>
						</tbody>
<tbody>
								<tr>
									<td>01/07/2018 a 31/07/2018</td>
									<?php $sql_realizadas_jul = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND (rascunhos_jul != '0' OR inscritos_jul != '0' OR selecionados_jul != '0' OR contratados_jul != '0') AND publicado = '1'";
									$realizadas_jul = $wpdb->get_results($sql_realizadas_jul,ARRAY_A);
									?>
									<td><?php echo $realizadas_jul[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_jul = "SELECT SUM(inscritos_jul) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$inscritos_jul = $wpdb->get_results($sql_inscritos_jul,ARRAY_A);
									?>
									<td><?php echo $inscritos_jul[0]['SUM(inscritos_jul)'] ?></td>	

									<?php $sql_selecionados_jul = "	SELECT SUM(selecionados_jul) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$selecionados_jul = $wpdb->get_results($sql_selecionados_jul,ARRAY_A);
									?>
									<td><?php echo $selecionados_jul[0]['SUM(selecionados_jul)'] ?></td>

									<?php $sql_contratados_jul = "	SELECT SUM(contratados_jul) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$contratados_jul = $wpdb->get_results($sql_contratados_jul,ARRAY_A);
									?>
									<td><?php echo $contratados_jul[0]['SUM(contratados_jul)'] ?></td>	
								</tr>
						</tbody>
<tbody>
								<tr>
									<td>01/06/2018 a 30/06/2018</td>
									<?php $sql_realizadas_jun = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND (rascunhos_jun != '0' OR inscritos_jun != '0' OR selecionados_jun != '0' OR contratados_jun != '0') AND publicado = '1'";
									$realizadas_jun = $wpdb->get_results($sql_realizadas_jun,ARRAY_A);
									?>
									<td><?php echo $realizadas_jun[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_jun = "SELECT SUM(inscritos_jun) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$inscritos_jun = $wpdb->get_results($sql_inscritos_jun,ARRAY_A);
									?>
									<td><?php echo $inscritos_jun[0]['SUM(inscritos_jun)'] ?></td>	

									<?php $sql_selecionados_jun = "	SELECT SUM(selecionados_jun) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$selecionados_jun = $wpdb->get_results($sql_selecionados_jun,ARRAY_A);
									?>
									<td><?php echo $selecionados_jun[0]['SUM(selecionados_jun)'] ?></td>

									<?php $sql_contratados_jun = "	SELECT SUM(contratados_jun) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$contratados_jun = $wpdb->get_results($sql_contratados_jun,ARRAY_A);
									?>
									<td><?php echo $contratados_jun[0]['SUM(contratados_jun)'] ?></td>	
								</tr>
						</tbody>
<tbody>
								<tr>
									<td>01/05/2018 a 31/05/2018</td>
									<?php $sql_realizadas_mai = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND (rascunhos_mai != '0' OR inscritos_mai != '0' OR selecionados_mai != '0' OR contratados_mai != '0') AND publicado = '1'";
									$realizadas_mai = $wpdb->get_results($sql_realizadas_mai,ARRAY_A);
									?>
									<td><?php echo $realizadas_mai[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_mai = "SELECT SUM(inscritos_mai) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$inscritos_mai = $wpdb->get_results($sql_inscritos_mai,ARRAY_A);
									?>
									<td><?php echo $inscritos_mai[0]['SUM(inscritos_mai)'] ?></td>	

									<?php $sql_selecionados_mai = "	SELECT SUM(selecionados_mai) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$selecionados_mai = $wpdb->get_results($sql_selecionados_mai,ARRAY_A);
									?>
									<td><?php echo $selecionados_mai[0]['SUM(selecionados_mai)'] ?></td>

									<?php $sql_contratados_mai = "	SELECT SUM(contratados_mai) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$contratados_mai = $wpdb->get_results($sql_contratados_mai,ARRAY_A);
									?>
									<td><?php echo $contratados_mai[0]['SUM(contratados_mai)'] ?></td>	
								</tr>	
						</tbody>
<tbody>
								<tr>
									<td>01/04/2018 a 30/04/2018</td>
									<?php $sql_realizadas_abr = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND (rascunhos_abr != '0' OR inscritos_abr != '0' OR selecionados_abr != '0' OR contratados_abr != '0') AND publicado = '1'";
									$realizadas_abr = $wpdb->get_results($sql_realizadas_abr,ARRAY_A);
									?>
									<td><?php echo $realizadas_abr[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_abr = "SELECT SUM(inscritos_abr) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$inscritos_abr = $wpdb->get_results($sql_inscritos_abr,ARRAY_A);
									?>
									<td><?php echo $inscritos_abr[0]['SUM(inscritos_abr)'] ?></td>	

									<?php $sql_selecionados_abr = "	SELECT SUM(selecionados_abr) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$selecionados_abr = $wpdb->get_results($sql_selecionados_abr,ARRAY_A);
									?>
									<td><?php echo $selecionados_abr[0]['SUM(selecionados_abr)'] ?></td>

									<?php $sql_contratados_abr = "	SELECT SUM(contratados_abr) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$contratados_abr = $wpdb->get_results($sql_contratados_abr,ARRAY_A);
									?>
									<td><?php echo $contratados_abr[0]['SUM(contratados_abr)'] ?></td>	
								</tr>	
						</tbody>
<tbody>
								<tr>
									<td>01/03/2018 a 31/03/2018</td>
									<?php $sql_realizadas_mar = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND (rascunhos_mar != '0' OR inscritos_mar != '0' OR selecionados_mar != '0' OR contratados_mar != '0') AND publicado = '1'";
									$realizadas_mar = $wpdb->get_results($sql_realizadas_mar,ARRAY_A);
									?>
									<td><?php echo $realizadas_mar[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_mar = "SELECT SUM(inscritos_mar) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$inscritos_mar = $wpdb->get_results($sql_inscritos_mar,ARRAY_A);
									?>
									<td><?php echo $inscritos_mar[0]['SUM(inscritos_mar)'] ?></td>	

									<?php $sql_selecionados_mar = "	SELECT SUM(selecionados_mar) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$selecionados_mar = $wpdb->get_results($sql_selecionados_mar,ARRAY_A);
									?>
									<td><?php echo $selecionados_mar[0]['SUM(selecionados_mar)'] ?></td>

									<?php $sql_contratados_mar = "	SELECT SUM(contratados_mar) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$contratados_mar = $wpdb->get_results($sql_contratados_mar,ARRAY_A);
									?>
									<td><?php echo $contratados_mar[0]['SUM(contratados_mar)'] ?></td>	
								</tr>			

						</tbody>
<tbody>
								<tr>
									<td>01/02/2018 a 28/02/2018</td>
									<?php $sql_realizadas_fev = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND (rascunhos_fev != '0' OR inscritos_fev != '0' OR selecionados_fev != '0' OR contratados_fev != '0') AND publicado = '1'";
									$realizadas_fev = $wpdb->get_results($sql_realizadas_fev,ARRAY_A);
									?>
									<td><?php echo $realizadas_fev[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_fev = "SELECT SUM(inscritos_fev) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$inscritos_fev = $wpdb->get_results($sql_inscritos_fev,ARRAY_A);
									?>
									<td><?php echo $inscritos_fev[0]['SUM(inscritos_fev)'] ?></td>	

									<?php $sql_selecionados_fev = "	SELECT SUM(selecionados_fev) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$selecionados_fev = $wpdb->get_results($sql_selecionados_fev,ARRAY_A);
									?>
									<td><?php echo $selecionados_fev[0]['SUM(selecionados_fev)'] ?></td>

									<?php $sql_contratados_fev = "	SELECT SUM(contratados_fev) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$contratados_fev = $wpdb->get_results($sql_contratados_fev,ARRAY_A);
									?>
									<td><?php echo $contratados_fev[0]['SUM(contratados_fev)'] ?></td>	
								</tr>

						</tbody>
<tbody>
								<tr>
									<td>01/01/2018 a 31/01/2018</td>
									<?php $sql_realizadas_jan = "SELECT DISTINCT COUNT(id) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND (rascunhos_jan != '0' OR inscritos_jan != '0' OR selecionados_jan != '0' OR contratados_jan != '0') AND publicado = '1'";
									$realizadas_jan = $wpdb->get_results($sql_realizadas_jan,ARRAY_A);
									?>
									<td><?php echo $realizadas_jan[0]['COUNT(id)'] ?></td>	

									<?php $sql_inscritos_jan = "SELECT SUM(inscritos_jan) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$inscritos_jan = $wpdb->get_results($sql_inscritos_jan,ARRAY_A);
									?>
									<td><?php echo $inscritos_jan[0]['SUM(inscritos_jan)'] ?></td>	

									<?php $sql_selecionados_jan = "	SELECT SUM(selecionados_jan) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$selecionados_jan = $wpdb->get_results($sql_selecionados_jan,ARRAY_A);
									?>
									<td><?php echo $selecionados_jan[0]['SUM(selecionados_jan)'] ?></td>

									<?php $sql_contratados_jan = "	SELECT SUM(contratados_jan) FROM sc_ind_inscricoes WHERE periodo_inicio LIKE '%2018%' AND publicado = '1'";
									$contratados_jan = $wpdb->get_results($sql_contratados_jan,ARRAY_A);
									?>
									<td><?php echo $contratados_jan[0]['SUM(contratados_jan)'] ?></td>		
								</tr>
						</tbody>


						
					</table>



				</div>

			</div>

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
