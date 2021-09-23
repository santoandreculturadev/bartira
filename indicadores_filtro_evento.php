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
                     
					}

					if(isset($_GET['ano_base'])){
						$ano_base = $_GET['ano_base'];
					}else{
						$ano_base = date('Y');

					}	
						$sql_ano_base = " AND ano_base = '$ano_base' ";
				
					
					?>

					<div class="row">    
						<div class="col-md-offset-2 col-md-8">
							<h3>Eventos - Visualizar Relatórios</h3>
							<p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
							<div class="col-md-offset-1 col-md-10">

								<form method="GET" action="?" class="form-horizontal" role="form">
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Ano Base *</label>
											<select class="form-control" name='ano_base' id="inputSubject" >
																								<?php 
													anoBaseIndicadores("sc_indicadores",$ano_base);

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
$sel = "SELECT * FROM sc_indicadores WHERE publicado = '1' $ano_base ORDER BY periodoInicio DESC";
$ocor = $wpdb->get_results($sel,ARRAY_A);
if(count($ocor) > 0){
	?>

	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th></th>
					<th>Período/Data</th>
					<th>Hora</th>
					<th>Local</th>
					<th>Outros Locais</th>
					<th>Bairro</th>
					<th>Projeto</th>
					<th>Nome do Evento</th>
					<th>Nome da Atração Principal</th>							
					<th>Linguagem</th>
					<th>Segmento/Tipo</th>
					<th>Grupos/Agentes Culturais e de Lazer</th>
					<th>Selecionados por convocatória/edital?</th>
					<th>Se sim, qual?</th>
					<th>A ação contou com artistas/profissionais da cidade?</th>
					<th>Se sim, quantos?</th>
					<th>Houve parceria?</th>
					<th>Parceiro</th>
					<th>Público</th>
					<th>Gastos com contratação de pessoal para esta ação específica</th>
					<th>Gastos com estrutura para esta ação específica</th>										
					<th width="10%"></th>
					<th width="10%"></th>

				</tr>
			</thead>
			<tbody>
				<?php
				for($i = 0; $i < count($ocor); $i++){
					$evento = evento($ocor[$i]['idEvento']);
					if($ocor[$i]['idOcorrencia'] != 0){
						$ocorrencia = ocorrencia($ocor[$i]['idOcorrencia']);
						$local = " (".$ocorrencia['local'].")";
					}else{
						$local = "";
					}
					?>
					<tr>
						<td><?php echo $k; $k++; ?></td>
						<td><?php echo exibirDataBr($ocor[$i]['periodoInicio']); ?><?php if($ocor[$i]['periodoFim'] != '0000-00-00'){ echo " a ".exibirDataBr($ocor[$i]['periodoFim']);} ?></td>
						<?php if ($ocor[$i]['hora'] != '00:00:00') { ?>
							<td><?php echo $ocor[$i]['hora']; ?>
						<?php } else { ?>
							<td><?php echo "" ?>
						<?php } ?>
						<td><?php echo $local; ?></td>	
						<td><?php echo $ocor[$i]['outros_locais']; ?></td>
						<?php $bairro = retornaTipo($ocor[$i]['bairro']); ?>	
						<td><?php echo $bairro['tipo']; ?></td>	
						<?php $projeto = retornaTipo($ocor[$i]['projeto']); ?>
						<td><?php echo $projeto['tipo']; ?></td>	
						<td><?php echo $evento['titulo']?></td>
						<td><?php echo $ocor[$i]['atracao_principal']?></td>
						<?php $linguagem = retornaTipo($ocor[$i]['linguagem']); ?>
						<td><?php echo $linguagem['tipo']?></td>
						<?php $tipo_evento = retornaTipo($ocor[$i]['tipo_evento']); ?>
						<td><?php echo $tipo_evento['tipo']?></td>
						<td><?php echo $ocor[$i]['numero_agentes']?></td>
						<?php
						if ($ocor[$i]['convocatoria_edital'] == '1') {
							?></td>
							<td><?php echo "SIM" ?>
						<?php } else { ?>
							<td><?php echo "NÃO" ?>	
						<?php } ?>
						<?php $nome_convocatoria = retornaTipo($ocor[$i]['nome_convocatoria']); ?>
						<td><?php echo $nome_convocatoria['tipo']; ?></td>	
						<?php
						if ($ocor[$i]['prof_sa'] == '1') {
							?></td>
							<td><?php echo "SIM" ?>
						<?php } else { ?>
							<td><?php echo "NÃO" ?>	
						<?php } ?>
						<td><?php echo $ocor[$i]['quantidade_prof_sa']?></td>
						<?php
						if ($ocor[$i]['acao_parceria'] == '1') {
							?></td>
							<td><?php echo "SIM" ?>
						<?php } else { ?>
							<td><?php echo "NÃO" ?>	
						<?php } ?>
						<td><?php echo $ocor[$i]['nome_parceiro']?></td>
						<td><?php echo $ocor[$i]['valor']; if($ocor[$i]['contagem'] == 1){echo " (total)";}else{echo " (média/dia)";}  
						$total = $total + $ocor[$i]['valor']; ?></td>									
						<td><?php echo dinheiroParaBr($ocor[$i]['gastos_pessoal']) ?></td>
						<td><?php echo dinheiroParaBr($ocor[$i]['gastos_estrutura']) ?></td>
					</tr>

				<?php } 

				$sql = "SELECT idEvento,nomeEvento FROM sc_evento WHERE idEvento NOT IN(SELECT DISTINCT idEvento FROM sc_indicadores) AND (ano_base = '2019') AND dataEnvio IS NOT NULL";
				$evento = $wpdb->get_results($sql,ARRAY_A);


				?>
				<tr><td></td><td>Total:</td><td><?php echo count($evento); ?> eventos sem indicação de público </td><td><?php echo $total; ?></td><td></td></tr>
			</tbody>
		</table>



	</div>

</div>

<?php } else { ?>
	<div class="row">    
		<div class="col-md-offset-2 col-md-8">
			<p> Não há eventos cadastrados. </p>
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


