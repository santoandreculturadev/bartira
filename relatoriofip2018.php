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
$orcamento = orcamentoTotal(2018);
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
	<h1>CONVOCATÓRIA NO. 005/2017</h1>
	<h2>Aniversário da Cidade 2018</h2>
	
	
	<h3>Relação de intervenções selecionadas</h3>
	
	<p>Após efetuarem, no período de 05/01 a 17/01/18, a avaliação individual das intervenções culturais inscritas na presente convocatória, os membros da Comissão de Seleção, reuniram-se na Secretaria de Cultura nos dias 18 e 19 de janeiro de 2018, das 10h00 às 19h00 para análise coletiva das propostas, participando desta avaliação coletiva os seguintes membros: Kleber Fernando de Albuquerque, Sergio Luis Zanchetta, Tales Andre Loro Jaloretto, Luciana Zorzato, Kedley Correa de Moraes, Miguel Gondim de Castro, Milton Toller Correia. Em consenso, e partindo dos critérios de análise constantes da Convocatória, os membros da Comissão de Seleção também deram relevância aos seguintes aspectos no conjunto das propostas: representatividade do proponente em relação à linguagem/ segmento ao qual pertence, priorização de grupos e artistas locais e da região, diversidade de linguagens/ segmentos na composição da seleção, não repetição, na medida do possível, da seleção de proponentes que participaram de projetos da Secretaria de Cultura no último exercício. </p>

	<p>Durante a análise coletiva todas as propostas culturais foram debatidas e pontuadas e de comum acordo os membros acharam por bem estabelecer uma linha de corte para cada categoria, levando-se em consideração as médias das notas finais, que foram as seguintes: categoria A: 41,5; categoria C: 36,5; categoria D: 49; categoria E: 25; categoria F: 40; categoria G: 46; categoria H: 50. Não houve linha de corte nas categorias B e I em função das poucas inscrições recebidas. </p>

	<p>Também de comum acordo os membros convencionaram que as demais propostas situadas abaixo da linha de corte fossem pontuadas com nota zero por uma questão de agilizar e otimizar o tempo de trabalho da Comissão. A Comissão esclarece que o “zero” não tem nenhuma relação com a análise de qualidade estética das propostas ou mérito do proponente, que essa nota é apenas uma questão sistêmica.</p>

	<p>Esta seleção contou com 226 propostas de intervenções culturais inscritas, cujas inscrições ocorreram entre 06/11 a 22/12/17. Foram selecionados 58 propostas sendo 6 delas duplicadas totalizando 64 intervenções a serem contratadas.</p>

	<p>A somatória dos valores propostos pelas intervenções selecionadas totaliza <strong>R$144.000,00</strong> (cento e quarenta e quatro mil reais).
	Informamos ainda que todos os inscritos integrarão um banco de dados específico que terá validade até 31/dezembro/2018.</p>

	<p>A Comissão de seleção foi composta pelos seguintes membros:</p>

	<ul>-04 representantes da sociedade civil indicados pelo Conselho Municipal de Políticas Culturais Comissão:
		<li>• Kleber Fernando de Albuquerque</li>
		<li>• Rosana Banharoli</li>
		<li>• Sergio Luis Zanchetta</li>
		<li>• Tales Andre Loro Jaloretto</li>
	</ul>
	<ul>
		- 04 representantes do poder público indicados pela Secretaria de Cultura.
		<li>• Luciana Zorzato</li>
		<li>• Kedley Correa de Moraes</li>
		<li>• Miguel Gondim de Castro</li>
		<li>• Milton Toller Correia</li>
	</ul>

	<div>


		<?php 
			// Seleciona as categorias
		$sql_cat = "SELECT DISTINCT filtro FROM ava_ranking WHERE edital = '349' ORDER BY filtro ASC";
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
					$sql_ins = "SELECT inscricao,nota FROM ava_ranking WHERE filtro = '$filtro' AND edital =  '349' ORDER BY nota DESC";
					$res_ins = $wpdb->get_results($sql_ins,ARRAY_A);

					for($k = 0; $k < count($res_ins); $k++){		
						$inscricao = $res_ins[$k]['inscricao'];
						$sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$inscricao'";	
						$json = $wpdb->get_row($sel,ARRAY_A);	
						$res_json = converterObjParaArray(json_decode(($json['descricao'])));
						$nota = nota($inscricao,349);						
						?>
						
						<tr>
							<td><?php echo $res_json['3.1 - Título']; ?></td>
							<td><?php echo $inscricao; ?></td>
							<td><?php echo $res_json['Agente responsável pela inscrição']; ?></td>
							<td><?php if(isset($nota['pareceristas'][0])){echo $nota['pareceristas'][0]['nota'];}?></td>
							<td><?php if(isset($nota['pareceristas'][1])){echo $nota['pareceristas'][1]['nota'];}?></td>
							<td><?php if(isset($nota['media'])){echo substr($nota['media'], 0, 4);}?></td>
							<td><?php echo retornaNota2Fase($inscricao,'350'); ?></td>
							<td><?php echo $res_ins[$k]['nota']; ?></td>
							<td><?php echo retornaAnotacao($inscricao,53,'350'); ?></td>
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
	Kleber Fernando de Albuquerque</p><br /><br />
	<p>-------------------------------------------------------------- <br />
	Rosana Banharoli</p><br /><br />
	<p>-------------------------------------------------------------- <br />
	Sergio Luis Zanchetta</p><br /><br />
	<p>-------------------------------------------------------------- <br />
	Tales Andre Loro Jaloretto</p><br /><br />
	<p>-------------------------------------------------------------- <br />
	Luciana Zorzato</p><br /><br />
	<p>-------------------------------------------------------------- <br />
	Kedley Correa de Moraes</p><br /><br />
	<p>-------------------------------------------------------------- <br />
	Miguel Gondim de Castro</p><br /><br />
	<p>-------------------------------------------------------------- <br />
	Milton Toller Correia</p><br /><br />

</div>