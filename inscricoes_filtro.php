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
							<h3>Inscrições Convocatórias - Visualizar Relatórios</h3>
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

<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Período</th>
					<th>Nome</th>
					<th>Valor Total Disponibilizado</th>
					<th>Rascunhos</th>
					<th>Inscritos</th>
					<th>Selecionados</th>
					<th>Contratados</th>
					<th>Total (Rascunhos + Inscritos)</th>
					<th width="10%"></th>
					<th width="10%"></th>
				</tr>
			</thead>
			<tbody>
				<form method="POST" action="?" />

<?php 
global $wpdb;
$sel = "SELECT * FROM sc_ind_inscricoes WHERE publicado = '1' $ano_base ORDER BY id DESC";
$ocor = $wpdb->get_results($sel,ARRAY_A);

$valor_disponibilizado = array(2018 => 0, 2019 => 0);
$rascunhos = array(2018 => 0, 2019 => 0);
$inscritos = array(2018 => 0, 2019 => 0);
$selecionados = array(2018 => 0, 2019 => 0);
$contratados = array(2018 => 0, 2019 => 0);
$total = array(2018 => 0, 2019 => 0);


				for($i = 0; $i < count($ocor); $i++){
					$convocatoria = tipo($ocor[$i]['convocatoria']);
					if(count($ocor) > 0){
					?>

					<tr>
						<td><?php echo exibirDataBr($ocor[$i]['periodo_inicio']) ?> a <?php echo exibirDataBr($ocor[$i]['periodo_fim']) ?> </td>
						<td><?php echo $convocatoria['tipo'] ?></td>	
						<td><?php echo dinheiroParaBr($ocor[$i]['valor_disponibilizado']) ?></td>	
						<td><?php echo $ocor[$i]['rascunhos'] ?></td>	
						<td><?php echo $ocor[$i]['inscritos'] ?></td>	
						<td><?php echo $ocor[$i]['selecionados'] ?></td>	
						<td><?php echo $ocor[$i]['contratados'] ?></td>
						<td><?php echo ($ocor[$i]['rascunhos']+$ocor[$i]['inscritos']) ?></td>	
					</tr>
				<?php 
			}

					$valor_disponibilizado[$ocor[$i]['ano_base']] = $valor_disponibilizado[$ocor[$i]['ano_base']] + $ocor[$i]['valor_disponibilizado'];
					$rascunhos[$ocor[$i]['ano_base']] = $rascunhos[$ocor[$i]['ano_base']] + $ocor[$i]['rascunhos'];
					$inscritos[$ocor[$i]['ano_base']] = $inscritos[$ocor[$i]['ano_base']] + $ocor[$i]['inscritos'];
					$selecionados[$ocor[$i]['ano_base']] = $selecionados[$ocor[$i]['ano_base']] + $ocor[$i]['selecionados'];
					$contratados[$ocor[$i]['ano_base']] = $contratados[$ocor[$i]['ano_base']] + $ocor[$i]['contratados'];
					$total[$ocor[$i]['ano_base']] = $total[$ocor[$i]['ano_base']] + ($ocor[$i]['rascunhos']+$ocor[$i]['inscritos']);

			}		
			 ?>

			 <?php ?>

				<tr>
					<td>TOTAL 2018:</td>
					<td></td>
					<td><?php echo dinheiroParaBr($valor_disponibilizado['2018']); ?></td>
					<td><?php echo $rascunhos['2018']; ?></td>
					<td><?php echo $inscritos['2018']; ?></td>
					<td><?php echo $selecionados['2018']; ?></td>
					<td><?php echo $contratados['2018']; ?></td>
					<td><?php echo $total['2018']; ?></td>
				</tr>
				<tr>
					<td>TOTAL 2019:</td>
					<td></td>
					<td><?php echo dinheiroParaBr($valor_disponibilizado['2019']); ?></td>
					<td><?php echo $rascunhos['2019']; ?></td>
					<td><?php echo $inscritos['2019']; ?></td>
					<td><?php echo $selecionados['2019']; ?></td>
					<td><?php echo $contratados['2019']; ?></td>
					<td><?php echo $total['2019']; ?></td>
				</tr>

			</tbody>
		</table>
	</div>

<?php  /*} else { ?>
	<div class="row">    
		<div class="col-md-offset-2 col-md-8">
			<p> Não há relatórios cadastrados. </p>
		</div>		
	</div>


 } */?>

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
