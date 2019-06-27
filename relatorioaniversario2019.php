<?php 
require_once("../wp-load.php");
$user = wp_get_current_user();
if(!is_user_logged_in()): // Impede acesso de pessoas não autorizadas
/*** REMEMBER THE PAGE TO RETURN TO ONCE LOGGED IN ***/
$_SESSION["return_to"] = $_SERVER['REQUEST_URI'];
/*** REDIRECT TO LOGIN PAGE ***/
header("location: /");
endif;
//Carrega os arquivos de funções
require "inc/function.php";
$orcamento = orcamentoTotal(2019);
$projeto = array();
$w = 0;


?>
<style type="text/css" media="print">
@page {
	size: auto;   /* auto is the initial value */
	margin: 30;  /* this affects the margin in the printer settings */
}

</style>
<style>

.pieChart{
	float: right;
}
.margem {
	margin: 20px;
	
}	
}
</style>
<div class="margem">
	<h1>CONVOCATÓRIA NO. 012.11.2018 - SC</h1>
	<h2>Aniversário da Cidade 2019</h2>
	
	
	<h3>Relação de intervenções selecionadas</h3>
	
	<p>Após efetuarem, no período de 28/01 a 02/02/19, a avaliação individual das intervenções culturais inscritas na presente convocatória, os membros da Comissão de Seleção, reuniram-se na Secretaria de Cultura nos dias de 04 á 08 de fevereiro de 2019, das 08h30 às 17h00 para análise coletiva das propostas, participando desta avaliação coletiva os seguintes membros: Maria Cristina Pereira Sebastião, Vânia Ramalho de Oliveira, Miguel Gondim de Castro, Reinaldo Botelho e Rodrigo Fernando Da Silva. Uns dos membros da Comissão da sociedade civil, a senhora Luma Reis Ferreira abandonou e desistiu da Comissão no dia 27/01/2019, um dia antes do inicio dos trabalhos, não sobrando tempo hábil para contratação de outra profissional.</p>

	<p>Durante a análise coletiva todas as propostas culturais foram debatidas e pontuadas e de comum acordo os membros acharam por bem estabelecer uma linha de corte de 15 pontos. </p>

	<p>Também de comum acordo os membros convencionaram que as demais propostas situadas abaixo da linha de corte fossem pontuadas com nota 10 (dez) por uma questão de agilizar e otimizar o tempo de trabalho da Comissão. A Comissão esclarece que o 10 (dez) não tem nenhuma relação com a análise de qualidade estética das propostas ou mérito do proponente, que essa nota é apenas uma questão sistêmica.</p>

	<p>Esta seleção contou com 280 propostas de intervenções culturais inscritas, cujas inscrições ocorreram entre 15/11/2018 a 25/01/19. </p>

	<p>A somatória dos valores propostos pelas intervenções selecionadas totaliza <strong>R$101.500,00</strong> (cento e um mil e quinhentos reais).
	Informamos ainda que todos os inscritos integrarão um banco de dados específico que terá validade até 31/dezembro/2018.</p>

	<p>A Comissão de seleção foi composta pelos seguintes membros:</p>

	<ul>-02 representantes da sociedade civil indicados pelo Conselho Municipal de Políticas Culturais Comissão:
		<li>Maria Cristina Pereira Sebastião</li>
		<li>Vânia Ramalho de Oliveira</li>
	</ul>
	<ul>
		- 03 representantes do poder público indicados pela Secretaria de Cultura.
		<li>Miguel Gondim de Castro</li>
		<li>Reinaldo Botelho</li>
		<li>Rodrigo Fernando da Silva</li>
	</ul>

	<div>


		<?php 
			// Seleciona as categorias
		$sql_cat = "SELECT DISTINCT filtro FROM ava_ranking WHERE edital = '429' ORDER BY filtro ASC";
		$res_cat = $wpdb->get_results($sql_cat,ARRAY_A);

		for($i = 0; $i < count($res_cat); $i++){
			$filtro = $res_cat[$i]['filtro'];
			?>

			<h2><?php echo $filtro; ?></h2>
			<table border= "1" class="table table-striped">
				<thead>
					<tr>
						<th>Proposta</th>
						<th>Inscrição</th>
						<th>Proponente</th>
						<th>Nota01</th>
						<th>Nota02</th>
						<th>Média</th>
						<th>Coletiva</th>
						<th>Final</th>
						<th>Obs</th>	
					</tr>
				</thead>
				<tbody>
					
					<?php 
					$sql_ins = "SELECT inscricao,nota FROM ava_ranking WHERE filtro = '$filtro' AND edital = '429'  ORDER BY nota DESC";
					$res_ins = $wpdb->get_results($sql_ins,ARRAY_A);

					for($k = 0; $k < count($res_ins); $k++){		
						$inscricao = $res_ins[$k]['inscricao'];
						$sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$inscricao'";	
						$json = $wpdb->get_row($sel,ARRAY_A);	
						$res_json = converterObjParaArray(json_decode(($json['descricao'])));
						$nota = nota($inscricao,429);						
						?>
						
						<tr>
							<td><?php echo $res_json['Título']; ?></td>
							<td><?php echo $inscricao; ?></td>
							<td><?php echo $res_json['Agente responsável pela inscrição']; ?></td>
							<td><?php if(isset($nota['pareceristas'][0])){echo $nota['pareceristas'][0]['nota'];}?></td>
							<td><?php if(isset($nota['pareceristas'][1])){echo $nota['pareceristas'][1]['nota'];}?></td>
							<td><?php if(isset($nota['media'])){echo substr($nota['media'], 0, 2);}?></td>
							<td><?php echo retornaNota2Fase($inscricao,'430'); ?></td>
							<td><?php echo $res_ins[$k]['nota']; ?></td>
							<td><?php echo retornaAnotacao($inscricao,70,'430'); ?></td>
						</tr>			  

						<?php 
					}
					?>	
					
				</tbody>
			</table>			
			<?php			
			
		}
		
		
		
		?>
		
		

	</div>

	<div style="page-break-before: always;"> </div>
	<br /><br /><br />
	<p>-------------------------------------------------------------- <br />
	Maria Cristina Pereira Sebastião </p><br /><br />
	<p>-------------------------------------------------------------- <br />
	Miguel Gondim de Castro</p><br /><br />
	<p>-------------------------------------------------------------- <br />
	Reinaldo Botelho</p><br /><br />
	<p>-------------------------------------------------------------- <br />
	Rodrigo Fernando da Silva</p><br /><br />
	<p>-------------------------------------------------------------- <br />
	Vânia Ramalho de Oliveira</p><br /><br />

</div>