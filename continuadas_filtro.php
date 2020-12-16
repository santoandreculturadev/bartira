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
							<h3>Ações Continuadas - Visualizar Relatórios</h3>
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
$sel = "SELECT * FROM sc_ind_continuadas WHERE publicado = '1' $ano_base ORDER BY periodoInicio DESC";

$ocor = $wpdb->get_results($sel,ARRAY_A);
if(count($ocor) > 0){
	?>

	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th></th>
					<th>Data da Abertura</th>
					<th>Horário da Abertura</th>
					<th>Período de Visitação</th>
					<th>Equipamentos Culturais ou de Lazer</th>
					<th>Outros Locais</th>
					<th>Bairro</th>
					<th>Projeto</th>
					<th>Nome da Ação</th>
					<th>Nome da Atração Principal</th>
					<th>Segmento/Linguagem</th>
					<th>Tipo</th>
					<th>Nº de Agentes Culturais e/ou de lazer protagonistas da ação</th>
					<th>Selecionados por convocatória/edital?</th>
					<th>Se sim, qual?</th>
					<th>A ação contou com artistas/profissionais da cidade?</th>
					<th>Se sim, quantos?</th>
					<th>Ação realizada em parceria?</th>
					<th>Parceiro</th>
					<th>Gastos com Contratação de Pessoal</th>
					<th>Gastos com Estrutura para Ação Específica</th>
					<th>Público da Abertura</th>
					<th>Público Janeiro</th>
					<th>Público Fevereiro</th>
					<th>Público Março</th>
					<th>Público Abril</th>
					<th>Público Maio</th>
					<th>Público Junho</th>
					<th>Público Julho</th>
					<th>Público Agosto</th>
					<th>Público Setembro</th>
					<th>Público Outubro</th>
					<th>Público Novembro</th>
					<th>Público Dezembro</th>
					<th>Somatória</th>
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
						<?php if ($ocor[$i]['abertura_acao'] != '0000-00-00')
						{
							?> 
							<td><?php echo exibirDataBr($ocor[$i]['abertura_acao']); ?>	
							<?php
						}else{
							?>
							<td><?php echo "" ?>
						<?php } ?>
						<?php if ($ocor[$i]['hora'] != '00:00:00')
						{
							?>
							<td><?php echo ($ocor[$i]['hora']); ?>
						<?php }else{ ?>
							<td><?php echo "" ?>	
						<?php } ?>
						<?php if ($ocor[$i]['periodoInicio'] != '0000-00-00')
						{
							?> 
							<td><?php echo exibirDataBr($ocor[$i]['periodoInicio']); ?><?php if($ocor[$i]['periodoFim'] != '0000-00-00'){ echo " a ".exibirDataBr($ocor[$i]['periodoFim']);} ?></td>
							<?php
						}else{
							?>
							<td><?php echo "LONGA DURAÇÃO" ?>
							<?php
						}
						?>
						<td><?php echo $local;  ?></td>
						<td><?php echo ($ocor[$i]['outros_locais']); ?>
						<?php $bairro = retornaTipo($ocor[$i]['bairro']); ?>
						<td><?php echo ($bairro['tipo']); ?>
						<?php $projeto = retornaTipo($ocor[$i]['projeto']); ?>	
						<td><?php echo ($projeto['tipo']); ?>	
						<td><?php echo $evento['titulo'];  ?></td>
						<td><?php echo ($ocor[$i]['atracao_principal']); ?>
						<?php $linguagem = retornaTipo($ocor[$i]['linguagem']); ?>
						<td><?php echo ($linguagem['tipo']); ?>	
						<?php $tipo_evento = retornaTipo($ocor[$i]['tipo_evento']); ?>
						<td><?php echo ($tipo_evento['tipo']); ?>
						<td><?php echo ($ocor[$i]['numero_agentes']); ?>
						<?php
						if ($ocor[$i]['convocatoria_edital'] == '1') {
							?>
							<td><?php echo "SIM" ?>
							<?php 	
						} else { 
							?>	
							<td><?php echo "NÃO" ?>
						<?php } ?>
						<?php $nome_convocatoria = retornaTipo($ocor[$i]['nome_convocatoria']); ?>
						<td><?php echo ($nome_convocatoria['tipo']); ?>	
						<?php
						if ($ocor[$i]['prof_sa'] == '1') {
							?>
							<td><?php echo "SIM" ?>
							<?php 	
						} else { 
							?>	
							<td><?php echo "NÃO" ?>
						<?php } ?>
						<td><?php echo ($ocor[$i]['quantidade_prof_sa']); ?>
						<?php
						if ($ocor[$i]['acao_parceria'] == '1') {
							?>
							<td><?php echo "SIM" ?>
							<?php 	
						} else { 
							?>	
							<td><?php echo "NÃO" ?>
						<?php } ?>							
						<td><?php echo ($ocor[$i]['nome_parceiro']); ?>	
						<td><?php echo dinheiroParaBr($ocor[$i]['gastos_pessoal']); ?>	
						<td><?php echo dinheiroParaBr($ocor[$i]['gastos_estrutura']); ?>	
						<td><?php echo ($ocor[$i]['valor']); ?>	
						<td><?php echo ($ocor[$i]['pub_jan']); ?>	
						<td><?php echo ($ocor[$i]['pub_fev']); ?>	
						<td><?php echo ($ocor[$i]['pub_mar']); ?>	
						<td><?php echo ($ocor[$i]['pub_abr']); ?>	
						<td><?php echo ($ocor[$i]['pub_mai']); ?>	
						<td><?php echo ($ocor[$i]['pub_jun']); ?>	
						<td><?php echo ($ocor[$i]['pub_jul']); ?>	
						<td><?php echo ($ocor[$i]['pub_ago']); ?>	
						<td><?php echo ($ocor[$i]['pub_set']); ?>	
						<td><?php echo ($ocor[$i]['pub_out']); ?>	
						<td><?php echo ($ocor[$i]['pub_nov']); ?>	
						<td><?php echo ($ocor[$i]['pub_dez']); ?>	


						<td><?php echo $ocor[$i]['valor']+$ocor[$i]['pub_jan']+$ocor[$i]['pub_fev']+$ocor[$i]['pub_mar']+$ocor[$i]['pub_abr']+$ocor[$i]['pub_mai']+$ocor[$i]['pub_jun']+$ocor[$i]['pub_jul']+$ocor[$i]['pub_ago']+$ocor[$i]['pub_set']+$ocor[$i]['pub_out']+$ocor[$i]['pub_nov']+$ocor[$i]['pub_dez']; if($ocor[$i]['contagem'] == 1){echo " (total)";}else{echo " (média/dia)";}  
						$total = $total + ($ocor[$i]['valor']+$ocor[$i]['pub_jan']+$ocor[$i]['pub_fev']+$ocor[$i]['pub_mar']+$ocor[$i]['pub_abr']+$ocor[$i]['pub_mai']+$ocor[$i]['pub_jun']+$ocor[$i]['pub_jul']+$ocor[$i]['pub_ago']+$ocor[$i]['pub_set']+$ocor[$i]['pub_out']+$ocor[$i]['pub_nov']+$ocor[$i]['pub_dez']);

						?></td>				  
						<td>

						</td>
					</tr>

				<?php } 

				$sql = "SELECT idEvento,nomeEvento FROM sc_evento WHERE idEvento NOT IN(SELECT DISTINCT idEvento FROM sc_indicadores) AND (ano_base = '2019') AND dataEnvio IS NOT NULL";
				$evento = $wpdb->get_results($sql,ARRAY_A);


				?>
				<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><strong>Total</strong></td><td><?php echo $total; ?></td><td></td></tr>
			</tbody>
		</table>



	</div>

</div>

<?php } else { ?>
	<div class="row">    
		<div class="col-md-offset-2 col-md-8">
			<p> Não há ações cadastradas. </p>
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
