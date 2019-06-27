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
				<h3>Incentivo à Criação - Visualizar Disciplinas</h3>
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
						</select>
					</div>
				</div>		

			</div>		
		</div>

		<?php 
		$sel = "SELECT * FROM sc_ind_incentivo WHERE publicado = '1' $ano_base ORDER BY ocor_inicio DESC";
		$ocor = $wpdb->get_results($sel,ARRAY_A);
		if(count($ocor) > 0){
			?>

			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Período</th>
							<th>Local</th>
							<th>Outros Locais</th>
							<th>Bairro</th>
							<th>Projeto</th>
							<th>Tipo da ação</th>
							<th>Título da ação</th>
							<th>Disciplinas</th>
							<th>Segmento/Linguagem</th>
							<th>Carga Horária Total</th>
							<th>Concluintes</th>
							<th>Evasão</th>
							<th>Nome do(s) Profissional(is)</th>
							<th>O profissional é de Santo André?</th>
							<th>Custo da hora/aula do profissional</th>
							<th>Carga horária total do profissional para esta ação</th>
							<th>Custo total de contratação do profissional para esta ação</th>
							<th>Gastos com materiais de consumo</th>
							<th>Houve uma parceria para esta ação?</th>
							<th>Qual o parceiro?</th>
							<th>Vagas oferecidas</th>
							<th>Rematriculados</th>
							<th>Inscritos</th>
							<th>Lista de Espera</th>
							<th>Janeiro - Número total de atendidos ao longo da ação (número de frequentadores reais da ação no mês + número de atendidos da lista de espera)</th>
							<th>Janeiro - Número total de atendidos que são moradores de Santo André</th>
							<th>Fevereiro - Número total de atendidos ao longo da ação (número de frequentadores reais da ação no mês + número de atendidos da lista de espera)</th>
							<th>Fevereiro - Número total de atendidos que são moradores de Santo André</th>
							<th>Março - Número total de atendidos ao longo da ação (número de frequentadores reais da ação no mês + número de atendidos da lista de espera)</th>
							<th>Março - Número total de atendidos que são moradores de Santo André</th>
							<th>Abril - Número total de atendidos ao longo da ação (número de frequentadores reais da ação no mês + número de atendidos da lista de espera)</th>
							<th>Abril - Número total de atendidos que são moradores de Santo André</th>
							<th>Maio - Número total de atendidos ao longo da ação (número de frequentadores reais da ação no mês + número de atendidos da lista de espera)</th>
							<th>Maio - Número total de atendidos que são moradores de Santo André</th>
							<th>Junho - Número total de atendidos ao longo da ação (número de frequentadores reais da ação no mês + número de atendidos da lista de espera)</th>
							<th>Junho - Número total de atendidos que são moradores de Santo André</th>
							<th>Julho - Número total de atendidos ao longo da ação (número de frequentadores reais da ação no mês + número de atendidos da lista de espera)</th>
							<th>Julho - Número total de atendidos que são moradores de Santo André</th>
							<th>Agosto - Número total de atendidos ao longo da ação (número de frequentadores reais da ação no mês + número de atendidos da lista de espera)</th>
							<th>Agosto - Número total de atendidos que são moradores de Santo André</th>
							<th>Setembro - Número total de atendidos ao longo da ação (número de frequentadores reais da ação no mês + número de atendidos da lista de espera)</th>
							<th>Setembro - Número total de atendidos que são moradores de Santo André</th>
							<th>Outubro - Número total de atendidos ao longo da ação (número de frequentadores reais da ação no mês + número de atendidos da lista de espera)</th>
							<th>Outubro - Número total de atendidos que são moradores de Santo André</th>
							<th>Novembro - Número total de atendidos ao longo da ação (número de frequentadores reais da ação no mês + número de atendidos da lista de espera)</th>
							<th>Novembro - Número total de atendidos que são moradores de Santo André</th>
							<th>Dezembro - Número total de atendidos ao longo da ação (número de frequentadores reais da ação no mês + número de atendidos da lista de espera)</th>
							<th>Dezembro - Número total de atendidos que são moradores de Santo André</th>
							<th width="10%"></th>

						</tr>
					</thead>
					<tbody>
						<?php
						for($i = 0; $i < count($ocor); $i++){

							?>
							<tr>
								<td><?php echo exibirDataBr($ocor[$i]['ocor_inicio']) ?> a <?php echo exibirDataBr($ocor[$i]['ocor_fim']) ?> </td>
								<?php $equipamento = retornaTipo($ocor[$i]['equipamento']); ?>
								<td><?php echo $equipamento['tipo']; ?></td>
								<td><?php echo $ocor[$i]['outros']; ?></td>
								<?php $bairro = retornaTipo($ocor[$i]['bairro']); ?>
								<td><?php echo $bairro['tipo']; ?></td>
								<?php $projeto = retornaTipo($ocor[$i]['projeto']); ?>
								<td><?php echo $projeto['tipo']; ?></td>
								<?php $tipo_acao = retornaTipo($ocor[$i]['tipo_acao']); ?>
								<td><?php echo $tipo_acao['tipo']; ?></td>
								<td><?php echo $ocor[$i]['titulo_acao'];  ?></td>
								<td><?php echo $ocor[$i]['disciplinas'];  ?></td>
								<?php $linguagem = retornaTipo($ocor[$i]['linguagem']); ?>
								<td><?php echo $linguagem['tipo'];  ?></td>	
								<td><?php echo $ocor[$i]['carga_horaria'];  ?></td>
								<td><?php echo $ocor[$i]['n_concluintes'];  ?></td>
								<td><?php echo $ocor[$i]['n_evasao'];  ?></td>
								<td><?php echo $ocor[$i]['nome_profissional']; ?></td>
								<?php 
								if ($ocor[$i]['santo_andre']) {
									?>
									<td><?php echo "SIM "?></td>
								<?php } else { ?>
									<td><?php echo "NÃO"?></td>
								<?php } ?>		   						
								<td><?php echo dinheiroParaBr($ocor[$i]['custo_hora_aula']); ?></td>
								<td><?php echo $ocor[$i]['carga_horaria_prof']; ?></td>
								<td><?php echo "R$". dinheiroParaBr($ocor[$i]['custo_total']); ?></td>
								<td><?php echo dinheiroParaBr($ocor[$i]['material_consumo']); ?></td>
								<?php 
								if ($ocor[$i]['parceria']) {
									?>
									<td><?php echo "SIM "?></td>
								<?php } else { ?>
									<td><?php echo "NÃO"?></td>
								<?php } ?>
								<td><?php echo $ocor[$i]['parceiro']; ?></td>
								<td><?php echo $ocor[$i]['vagas']; ?></td>
								<td><?php echo $ocor[$i]['rematriculas']; ?></td>
								<td><?php echo $ocor[$i]['inscritos']; ?></td>
								<td><?php echo $ocor[$i]['espera']; ?></td>
								<td><?php echo $ocor[$i]['janeiro']; ?></td>
								<td><?php echo $ocor[$i]['janeiro_sa']; ?></td>
								<td><?php echo $ocor[$i]['fevereiro']; ?></td>
								<td><?php echo $ocor[$i]['fevereiro_sa']; ?></td>
								<td><?php echo $ocor[$i]['marco']; ?></td>
								<td><?php echo $ocor[$i]['marco_sa']; ?></td>
								<td><?php echo $ocor[$i]['abril']; ?></td>
								<td><?php echo $ocor[$i]['abril_sa']; ?></td>
								<td><?php echo $ocor[$i]['maio']; ?></td>
								<td><?php echo $ocor[$i]['maio_sa']; ?></td>
								<td><?php echo $ocor[$i]['junho']; ?></td>
								<td><?php echo $ocor[$i]['junho_sa']; ?></td>
								<td><?php echo $ocor[$i]['julho']; ?></td>
								<td><?php echo $ocor[$i]['julho_sa']; ?></td>
								<td><?php echo $ocor[$i]['agosto']; ?></td>
								<td><?php echo $ocor[$i]['agosto_sa']; ?></td>
								<td><?php echo $ocor[$i]['setembro']; ?></td>
								<td><?php echo $ocor[$i]['setembro_sa']; ?></td>
								<td><?php echo $ocor[$i]['outubro']; ?></td>
								<td><?php echo $ocor[$i]['outubro_sa']; ?></td>
								<td><?php echo $ocor[$i]['novembro']; ?></td>
								<td><?php echo $ocor[$i]['novembro_sa']; ?></td>
								<td><?php echo $ocor[$i]['dezembro']; ?></td>  
								<td><?php echo $ocor[$i]['dezembro_sa']; ?></td> 									  
							</tr>
						<?php } ?>

					</tbody>
				</table>



			</div>

		</div>

	<?php } else { ?>
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<p> Não há disciplinas/cursos cadastrados. </p>
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
