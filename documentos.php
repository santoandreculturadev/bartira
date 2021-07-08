<?php 

//Carrega WP como FW
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

if(!isset($_GET['id']) OR !isset($_GET['modelo'])){
	echo "<h1>Erro.</h1>";
	
}else{
	$pedido = retornaPedido($_GET['id']);
	//var_dump($pedido);
	
	switch ($_GET['modelo']){
	case 303: // Folha de Rosto	Inexigibilidade
	
	$file_name='folha_abertura_processo_inexigibilidade.doc';
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Content-Type: application/force-download');
	header('Content-type: application/vnd.ms-word');
	header('Content-Type: application/download');
	header('Content-Disposition: attachment;filename='.$file_name);
	header('Content-Transfer-Encoding: binary ');

	?>
	<html>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
	<body>
		<style type='text/css'>
		.style_01 {
			font-size: 16px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}
	</style>
	<br /><br /><br /> 
	<p class="style_01">À <br />
		Encarregatura de Protocolo <br />
	Sr. Encarregado(a)</p>
	<br />
	<br />
	<br />
	
	<p class="paragrafo">Solicitamos a abertura de processo administrativo com os seguintes dados:</p>

	<br /><br />
	<p>Interessado: <font color="#FF0000">(Nome do Setor Gerencia ou Encarregatura) - CR (do setor)</font></p>

	<br />
	<br />
	<br />
	<p>Assunto: Inexigibilidade - contratação da empresa <b><?php echo $pedido['nome_razaosocial']  ?> </b> para representar o(a) <font color="#FF0000">(artista/cia/banda/grupo/dupla)</font> <?php echo $pedido['titulo'] ?> para programação da Secretaria de Cultura.</p>

	<br />
	<br />
	<br />

	<p>Atenciosamente,</p>
	<br />
	<br />
	<br />
	<center>
		<p>Santo André, <?php 
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		echo strftime('%A, %d de %B de %Y', strtotime('today'));
		
		?>. </center></p>
		
		<br /><br />
		
		<br /><br />
		
		<p><center><?php echo $pedido['usuario']; ?><br />
		<p>IF-______________</p>	
		</p></center>
		
		<br /><br />
		
		<br /><br />
		
		<p class="rodape">Secretaria de Cultura<br />
			Praça IV Centenário, 02 - Centro - Paço Municipal - Prédio da Biblioteca - Santo André - SP, CEP:09015-080 <br /> 
		Telefone (11) 4433-0421</p>

		<?php
		break;

		case 310: // Folha de Rosto	Dispensa de Licitação
	
	$file_name='folha_abertura_processo_dispensa.doc';
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Content-Type: application/force-download');
	header('Content-type: application/vnd.ms-word');
	header('Content-Type: application/download');
	header('Content-Disposition: attachment;filename='.$file_name);
	header('Content-Transfer-Encoding: binary ');

	?>
	<html>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
	<body>
		<style type='text/css'>
		.style_01 {
			font-size: 16px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}
	</style>
	<br /><br /><br /> 
	<p class="style_01">À <br />
		Encarregatura de Protocolo <br />
	Sr. Encarregado(a)</p>
	<br />
	<br />
	<br />
	
	<p class="paragrafo">Solicitamos a abertura de processo administrativo com os seguintes dados:</p>

	<br /><br />
	<p>Interessado: <font color="#FF0000">(Nome do Setor Gerencia ou Encarregatura) - CR (do setor)</font></p>

	<br />
	<br />
	<br />
	<br />

	<p>Atenciosamente,</p>
	<br />
	<br />
	<br />
	<center>
		<p>Santo André, <?php 
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		date_default_timezone_set('America/Sao_Paulo');
		echo strftime('%A, %d de %B de %Y', strtotime('today'));
		
		?>. </center></p>
		
		<br /><br />
		
		<br /><br />
		
		<p><center><?php echo $pedido['usuario']; ?><br />
		<p>IF-______________</p>	
		</p></center>
		
		<br /><br />
		
		<br /><br />
		
		<p class="rodape">Secretaria de Cultura<br />
			Praça IV Centenário, 02 - Centro - Paço Municipal - Prédio da Biblioteca - Santo André - SP, CEP:09015-080 <br /> 
		Telefone (11) 4433-0421</p>

		<?php 
	break;	
	
	case 101: //Justificativa FIP

	$file_name='justificativa_aniver_20.doc';
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Content-Type: application/force-download');
	header('Content-type: application/vnd.ms-word');
	header('Content-Type: application/download');
	header('Content-Disposition: attachment;filename='.$file_name);
	header('Content-Transfer-Encoding: binary ');

	?>
	<html>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
	<body>
		<style type='text/css'>
		.style_01 {
			font-size: 12px;
		}	

		.style_02 {
			font-size: 18px;
			text-align: center;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}
	</style>
	<br />

		<p class="style_02"><br />
		Secretaria de Cultura <br />
		Departamento de Planejamento e Projetos Especiais</p>


		<br />
		<br />

			<p><center><strong>JUSTIFICATIVA</strong></center></p>

		<br />
		
		<p>Santo André, <?php echo exibeHoje(); ?>.

		<p>Senhora Secretária:</p>	
	
		<br />

        <p><justify>Trata-se de contratação da empresa <?php echo $pedido['nome'] ?>, representando o(a) <font color="#FF0000">(artista/cia/banda/grupo/dupla)</font> <?php echo $pedido['titulo'] ?>, em artes <font color="#FF0000">(inserir o nome artístico)</font>, para apresentação artística no(s) dia(s) 31/07/2021 e 01/08/2021 inserida na programação do 20° Festival de Inverno de Paranapiacaba – Edição Digital. Para isso o(a) <font color="#FF0000">(artista/cia/banda/grupo/dupla)</font> <?php echo $pedido['titulo'] ?> produzirá vídeo autoral inédito de <font color="#FF0000">(minutos)</font> no formato FULL HD, com medidas 1902x1080 PIXELS, de sua atividade artística.</p>
<p>O Festival de Inverno de Paranapiacaba se consagrou ao longo dos últimos anos com uma data extremamente importante no município mobilizando todo o governo municipal e contemplando um conjunto de programações diferenciadas. Em virtude da pandemia – Covid-19, a Secretaria de Cultura, especialmente, dedica grande parte de seus esforços à construção de uma grade de programação digital atendendo diversos gostos artísticos e que contemple este público com um momento de entretenimento e aprimoramento cultural.</p>
<p>Tal contratação justifica-se por tratar-se de um(a) <font color="#FF0000">(artista/cia/banda/grupo/dupla)</font> que desenvolve um trabalho de qualidade, e se enquadra na proposta da Secretaria, que visa realizar ações, proporcionando ao público o contato com diversos estilos culturais.</p>
<p>Ressaltamos que a referida contratação atende às necessidades públicas de acesso à cultura popular e à política governamental de difusão e fomento às diferentes manifestações culturais.</p>
<p>A Prefeitura pretende proporcionar à população o contato com os mais variados movimentos e correntes artísticas, não se limitando a determinada manifestação cultural ou artística.</p>
<p>Desta forma, pretende estimular a fruição e diversidade, a fim de que a população possa usufruir de estilos variados de cultura, lazer e entretenimento, o que proporciona o desenvolvimento humano pleno no que diz respeito à dignidade e à consciência humana e, ao mesmo tempo, aproxima o público das manifestações e linguagens.</p>
 
<p>Quando for Grupo/Banda/Cia:</p>
<p>Para essa apresentação o(a) <font color="#FF0000">(artista/cia/banda/grupo/dupla)</font> <?php echo $pedido['titulo'] ?> será formado por: <?php echo $pedido['ficha_tecnica'] ?>.</p>
<p>Breve release: <?php echo $pedido['release'] ?></p>
        
<p><font color="#FF0000">O(A) (artista/cia/banda/grupo/dupla)</font> <?php echo $pedido['titulo'] ?> atende às expectativas da Secretaria, neste momento.</p>

<p>Atesto que o(a) <font color="#FF0000">(artista/cia/banda/grupo/dupla)</font> <?php echo $pedido['titulo'] ?> é consagrado(a) pela crítica especializada e pela opinião pública. Não existem parâmetros nem tabelas que comprovem os valores solicitados pelos artistas, estando avaliado em consonância com a economicidade.  Atesto ainda que é inviável a competição pela singularidade da atração. A futura contratação atingirá os fins e objetivos públicos.</justify></p>
 
       <P></center></p>

		
		<br /><br />
		
		<br /><br />
		
		<p><strong>Marco Moretto Neto</strong></p>
		<p>Diretor do Departamento de Planejamento e Projetos Especiais</p>

		<br /><br />
		
		<br /><br />

		<p>Ratifico:</p>

		<br /><br />
		
		<br /><br />

		<p><strong>Simone Zárate</strong><br />
		<p>Secretária de Cultura</p>
			
		
		<?php 
		break;	

	case 563: // Folha de Rosto	FIP
	
	$file_name='folha_abertura_processo_aniver_20.doc';
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Content-Type: application/force-download');
	header('Content-type: application/vnd.ms-word');
	header('Content-Type: application/download');
	header('Content-Disposition: attachment;filename='.$file_name);
	header('Content-Transfer-Encoding: binary ');

	?>
	<html>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
	<body>
		<style type='text/css'>
		.style_01 {
			font-size: 16px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}
	</style>
	<br /><br /><br /> 
	<p class="style_01">À <br />
		Encarregatura de Protocolo <br />
	Sr. Encarregado(a)</p>
	<br />
	<br />
	<br />
	
	<p class="paragrafo">Solicitamos a abertura de processo administrativo com os seguintes dados:</p>

	<br /><br />
	<p>Interessado: (Nome do Setor Gerencia ou Encarregatura) -  CR <?php echo $pedido['cr']; ?></p>

		<br />
		<br />
		<br />
		<p>Assunto: Inexigibilidade - contratação da empresa <b><?php echo $pedido['nome_razaosocial']  ?> </b> para
            representar o(a) <?php echo $pedido['titulo'] ?> <!--<font color="#FF0000">(artista/cia/banda/grupo/dupla)</font>-->
            para programação do Aniversário da Cidade 2020.
			<br />
			<br />
			<br />

			<p>Atenciosamente,</p>
			<br />
			<br />
			<br />
			<center>
				<p>Santo André, <?php echo exibeHoje(); ?>.

					
				</center></p>
				
				<br /><br />
				
				<br /><br />
				
				<p><center>_______________________________________<br />
				<p><center><?php echo $pedido['usuario']; ?><br />
					IF-_______________________
				</p></center>
				
				<br /><br />
				
				<br /><br />
				
				<p class="rodape">Secretaria de Cultura<br />
					Praça IV Centenário, S/N - Centro - Paço Municipal - Prédio da Biblioteca - Santo André - SP, CEP:09015-080<br /> 
				Telefone 4433-0421</p>
				
				<?php 
				break;	


	case 304: // OS	

	/*$file_name='folha_os.doc';
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Content-Type: application/force-download');
	header('Content-type: application/vnd.ms-word');
	header('Content-Type: application/download');
	header('Content-Disposition: attachment;filename='.$file_name);
	header('Content-Transfer-Encoding: binary ');*/
	
	?>
	<!-- CSS para impressão -->

	<html>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
	<body>
		<style type='text/css'>
		.style_01 {
			font-size: 12px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 12px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}
	</style>
	
	<table width="100%" border="1">
		<tr>
			<td rowspan="5" width="15%"><center><img src="images/logo.png" /></center></td>
		</tr>

		<tr>
			<td colspan="3"><center><b>Prefeitura Municipal de Santo André</b></center></td>
		</tr>

		<tr>
			<td colspan="3"><center><b>Solicitação de Serviços</b></center></td>
		</tr>	

		<tr>
			<td><center>Data da Emissão<br /><b><?php echo date("d/m/Y")?></b></center></td>
			<td><center>CR Requisitante<br /><b><font color="#FF0000">INSIRA SEU CR AQUI</font></b></center></td>
		</tr>

		<tr>
			<td colspan="3"><center><b>Nome da área requisitante: <font color="#FF0000">INSIRA O NOME DO SEU DEPARTAMENTO</font></b></center></td>
			<tr/>

		</table>
		<table width="100%" border="1">
			<tr>
				<td colspan="4"><center><b>Dotação orçamentária</b></center></td>

			</tr>

			<tr>
				<td>Cód. Dotação:<br /><b><?php echo resumoDotacao($pedido['cod_dotacao']); ?></b></td>
				<td>Projeto:<br /><b><?php echo $pedido['projeto']; ?><b/></td>
					<td>Ficha: <br /> <b><?php echo $pedido['ficha']; ?></b></td>
					<td>Sub-elemento despesa: <br /><center>22</center></td>	
				</tr>
			</tr>

			<tr>
				<td colspan="3">Cód. Vinculação de Despesa<br /><center>110.000</center></td>
				<td>Fonte de Recursos: <br /><center>  <?php echo $pedido['fonte']; ?></center></td>
			</tr>

			<tr>
				<td colspan="3">Nome do Contato <br /><?php echo $pedido['usuario']; ?></td>
				<td>Telefone Contato<br /><font color="#FF0000">(Insira seu telefone aqui)</font></td>
			</tr>

			<tr><td colspan="4">Conta corrente (cód.Reduzido)/DB<br /><center>252</center></td></tr>	

			<tr>
				<td colspan="4">Data Período do evento: <br /><?php echo $pedido['periodo']; ?></td>
			</tr>

			<tr>
				<td colspan="4">Local de aplicação do serviço ou evento:<br /><?php echo $pedido['local']; ?></td>
			</tr>

			<tr>
				<td colspan="4">Especificação:</td>
			</tr>

			<tr>
				<td colspan="4">	<p>Contratação da empresa <b><?php echo $pedido['nome_razaosocial']  ?></b>, representando a(s) apresentação(ões) do(s) seguinte(s) artista(s) <b><?php  echo $pedido['integrantes'] ?></b> para  realização de <?php echo $pedido['objeto']; ?> em <?php echo $pedido['local']; ?> no(s) dia(s)  <?php echo $pedido['periodo']; ?> </b></p>
					<p>Empresa: <?php echo $pedido['nome_razaosocial']  ?><br />
						CNPJ: <?php echo $pedido['cpf_cnpj']  ?><br />
						Endereço: <?php echo $pedido['end']  ?><br />
						Email: <?php echo $pedido['email'];?> - Telefone: <?php echo $pedido['telefone'];?>  <br />
						<p>Valor total: R$<?php echo $pedido['valor'];?> (<?php echo $pedido['valor_extenso']; ?>)</p>
						
						<p><b>Forma de pagamento:</b> <?php echo $pedido['forma_pagamento'];?> </p>
						<p><?php echo $pedido['banco'];?> </p>		

					</td>
				</tr>

				<tr>
					<td colspan="4"><center><b>Aprovação (assinatura sobre carimbo e data)</b></center></td>
				</tr>

				<tr>

				<td colspan="2" width='33%' height="100px" style="vertical-align:top; text-align: center;">Responsável pela Área<br />C.R. Requisitante<br /><br /><br /><br /><br /></td>
				<td width='33%' height="100px" style="vertical-align:top; text-align: center;">Diretor(a) da Área <br />C.R. Requisitante</td>
				<td height="100px" style="vertical-align:top; text-align: center;">Secretário(a) da Área <br />C.R. Requisitante</td>

				<tr>
					<td colspan="4"><center><b>A Cargo da Área de Materiais</b></center></td>
				</tr>
				<tr>

					<td colspan="2" width='33%' height="35px" style="vertical-align:top; text-align: center;">Código Serviço/Material<br /><br /></td>
					<td width='33%' height="35px" style="vertical-align:top; text-align: center;">Almoxarifado</td>
					<td height="35px" style="vertical-align:top; text-align: center;">Nº SC/OS(SICOM)</td>


					<tr>
						<td colspan="4"><center><b>1ª via - Processo          2ª via - Requisitante</b></center></td>
					</tr>
						
						<?php 
						break;

	case 001: // OS	
	$file_name='teste.doc';
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Content-Type: application/force-download');
	header('Content-type: application/vnd.ms-word');
	header('Content-Type: application/download');
	header('Content-Disposition: attachment;filename='.$file_name);
	header('Content-Transfer-Encoding: binary ');
	
	?>
	<!-- CSS para impressão -->
	
	
	
	<link rel="stylesheet" type="text/css" href="print.css" media="print" />

	<table  width="100%" border="1">
		<tr>
			<td rowspan="5" width="15%"><center><img src="images/logo.png" /></center></td>
			
		</tr>
		<tr>
			<td colspan="2"><center><b>Prefeitura Municipal de Santo André</b></center></td>
		</tr>
		<tr>
			<td colspan="2"><center><b>Solicitação de Serviços</b></center></td>
		</tr>	
		<tr>
			<td><center>Data da Emissão<br /><b><?php echo date("d/m/Y")?></b></center></td>
			<td><center>CR Requisitante<br /></center><b><?php echo $pedido['cr']; ?></b></td>

		</tr>
		<tr>
			<td colspan="3"><center><b>Nome da área requisitante: Secretaria de Cultura - <?php echo $pedido['periodo'] ?></b></center></td>
			<tr/>	
		</table>
		<table border="1">
			<tr>
				<td colspan="4"><center><b>Dotação orçamentária</b></center></td>

			</tr>

			<tr>
				<td>Cód. Dotação:<br /><b><?php echo resumoDotacao($pedido['cod_dotacao']); ?></b></td>
				<td>Projeto:<br /><b><?php echo $pedido['projeto']; ?><b/></td>
					<td>Ficha: <br /> <b><?php echo $pedido['ficha']; ?></b></td>
					<td>Sub-elemente Despesa: <br /><center>22</center></td>	
				</tr>
			</tr>
			<tr>
				<td colspan="3">Cód. Vinculação de Despesa<br /><center>110.000</center></td>
				<td>Fonte de Recursos: <br /><center>  <?php echo $pedido['fonte']; ?></center></td>
			</tr>
			<tr>
				<td colspan="3">Nome do Contato <br /><?php echo $pedido['usuario']; ?></td>
				<td>Telefone Contato<br /><?php echo $pedido['telefone']; ?></td>
			</tr>
			<tr><td colspan="4">Conta corrente codReduzido/DB<br /><center>252</center></td></tr>	
			<tr>
				<td colspan="4">Data Período do evento: <br /><?php echo $pedido['periodo']; ?></td>
			</tr>	
			<tr>
				<td colspan="4">Local de aplicação do serviço ou evento:<br /><?php echo $pedido['local']; ?></td>
			</tr>
			<tr>
				<td colspan="4">Especificação (a maior quantidade necessária de informações para a correta contratação)</td>
			</tr>
			<tr>
				<td colspan="4">	<p>Contratação de <?php echo $pedido['tipoPessoa']; ?> <b><?php echo $pedido['nome_razaosocial']  ?></b>, representando a(s) apresentação(ões) do(s) seguinte(s) artista(s) <b><?php  echo $pedido['integrantes'] ?></b> para  realização de <?php echo $pedido['objeto']; ?> em <?php echo $pedido['local']; ?> no(s) dia(s)  <?php echo $pedido['periodo']; ?> </b></p>
					<p>Empresa: <?php echo $pedido['nome_razaosocial']  ?><br />
						CNPJ: <?php echo $pedido['cpf_cnpj']  ?><br />
						Endereço: <?php echo $pedido['end']  ?><br />
						Email: <?php echo $pedido['email'];?> <br />
						<p>Valor total: R$<?php echo $pedido['valor'];?> (<?php echo $pedido['valor_extenso']; ?>)</p>
						
						<p><b>Forma de pagamento:</b> <?php echo $pedido['forma_pagamento'];?> </p>
						<p><?php echo $pedido['banco'];?> </p>		

					</td>
				</tr>
				<tr>
					<td colspan="4"><center><b>Aprovação (assinatura sobre carimbo e data)</b></center></td>
				</tr>
				<tr>

					<td colspan="2" width='33%' height="100px" style="vertical-align:top; text-align: center;">Responsável pela Área<br />C.R. Requisitante</td>
					<td width='33%' height="100px" style="vertical-align:top; text-align: center;">Diretor(a) da Área<br />C.R. Requisitante</td>
					<td height="100px" style="vertical-align:top; text-align: center;">Secretário(a) da Área <br />C.R. Requisitante</td>


					<tr>
						<td colspan="4"><center><b>A Cargo da Área de Materiais</b></center></td>
					</tr>
					<tr>

						<td colspan="2" width='33%' height="35px" style="vertical-align:top; text-align: center;">Código Serviço/Material</td>
						<td width='33%' height="35px" style="vertical-align:top; text-align: center;">Almoxarifado</td>
						<td height="35px" style="vertical-align:top; text-align: center;">Nº SC/OS(SICOM)</td>



						<tr>
							<td colspan="4"><center><b>1ª via - Processo          2ª via - Requisitante</b></center></td>
						</tr>
						<tr>	
						</table>
						
						<?php 
						break;



case 549: // OS para FIP

/*$file_name='folha_os_fip.doc';
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Content-Type: application/force-download');
	header('Content-type: application/vnd.ms-word');
	header('Content-Type: application/download');
	header('Content-Disposition: attachment;filename='.$file_name);
	header('Content-Transfer-Encoding: binary ');*/

?>

<html>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
	<body>
		<style type='text/css'>
		.style_01 {
			font-size: 12px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 12px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}
	</style>

<table  width="100%" border="1">
	<tr>
		<td rowspan="5" width="12%"><center><img src="images/logo.png" /></center></td>
	</tr>
	<tr>
		<td colspan="3"><center><b>Prefeitura Municipal de Santo André</b></center></td>
	</tr>
	<tr>
		<td colspan="3"><center><b>Solicitação de Serviços</b></center></td>
	</tr>	
	<tr>
		<td><center>Data da Emissão<br /><b><?php echo date("d/m/Y")?></b></center></td>
		<td><center>CR Requisitante<br /><b><?php echo $pedido['cr']; ?></b></center></td>

	</tr>
	<tr>
		<td colspan="3"><center><b>Nome da área requisitante: Departamento de Planejamento e Projetos Especiais</b></center></td>
		</tr>	

	</table>
	<table  width="100%" border="1">
		<tr>
			<td colspan="4"><center><b>Dotação orçamentária</b></center></td>

		</tr>

		<tr>
			<td>Cód. Dotação:<br /><b><?php echo resumoDotacao($pedido['cod_dotacao']); ?></b></td>
			<td>Projeto:<br /><b><?php echo $pedido['projeto']; ?></b></td>
				<td>Ficha: <br /> <b><?php echo $pedido['ficha']; ?></b></td>
				<td>Sub-elemento despesa: <br /><center>22</center></td>	
			</tr>
		</tr>
		<tr>
			<td colspan="3">Cód. Vinculação de Despesa<br /><center>110.000</center></td>
			<td>Fonte de Recursos: <br /><center>  <?php echo $pedido['fonte']; ?></center></td>
		</tr>
		<tr>
		<td colspan="3">Nome do Contato <br /><b><?php echo $pedido['usuario']; ?></b></td>
        <td>Telefone Contato<br /><b><?php echo $pedido['telefone']; ?></b></td>

			<!--<td colspan="3">Nome do Contato <br />Rodrigo Fernando da Silva</td>
			<td>Telefone Contato<br />(11) 4433-0711</td> -->
		</tr>
		<tr><td colspan="4">Conta corrente (cód.Reduzido)/DB<br /><center>252</center></td></tr>	
		<tr>
			<td colspan="4">Data Período do evento: <br /><?php echo $pedido['periodo']; ?></td>
		</tr>	
		<tr>
			<td colspan="4">Local de aplicação do serviço ou evento:<br /><?php echo $pedido['local']; ?></td>
		</tr>
		<tr>
			<td colspan="4">	<p>Contratação da empresa <b><?php echo $pedido['nome_razaosocial']  ?></b>, representando
			<!--<font color="#FF0000">(artista/cia/banda/grupo/dupla)</font> --><?php echo $pedido['titulo'] ?> para
                    realização de apresentação artística,  inserida na programação do 20º Festival de Inverno de Paranapiacaba - Edição Digital Santo André 2021.</p>
				<p>Empresa: <?php echo $pedido['nome_razaosocial']  ?><br />
					CNPJ: <?php echo $pedido['cpf_cnpj']  ?><br />
					Endereço: <?php echo $pedido['end']  ?>
					Telefone: <?php echo $pedido['telefone']; ?> 
					Email: <?php echo $pedido['email'];?>   <br />
					<p><strong>Valor total:</strong> R$<?php echo $pedido['valor'];?> (<?php echo $pedido['valor_extenso']; ?>)</p>
					
					<p>
                        <b>Forma de pagamento:</b>
                        Forma de Pagamento: O pagamento será feito pela Prefeitura Municipal de Santo André, em parcela única,
                        desembolsada 30 dias após a execução do serviço, obedecendo o cronograma de pagamentos da Secretaria de
                        Finanças.
                    </p>
                <p><?php echo $pedido['banco'];?> </p>

				</td>
			</tr>
			<tr>
				<td colspan="4"><center><b>Aprovação (assinatura sobre carimbo e data)</b></center></td>
			</tr>
			<tr>

				<td colspan="2" width='33%' height="100px" style="vertical-align:top; text-align: center;">Responsável pela Área<br />C.R. Requisitante<br /><br /><br /></td>
				<td width='33%' height="100px" style="vertical-align:top; text-align: center;">Diretor(a) da Área <br />C.R. Requisitante</td>
				<td height="100px" style="vertical-align:top; text-align: center;">Secretário(a) da Área <br />C.R. Requisitante</td>

				<tr>
					<td colspan="4"><center><b>A Cargo da Área de Materiais</b></center></td>
				</tr>
				<tr>

					<td colspan="2" width='33%' height="35px" style="vertical-align:top; text-align: center;">Código Serviço/Material<br /><br /></td>
					<td width='33%' height="35px" style="vertical-align:top; text-align: center;">Almoxarifado</td>
					<td height="35px" style="vertical-align:top; text-align: center;">Nº SC/OS(SICOM)</td>
				</tr>	


					<tr>
						<td colspan="4"><center><b>1ª via - Processo          2ª via - Requisitante</b></center></td>
					</tr>

					
	<?php /*
	echo '<pre>';
	var_dump($pedido);
	echo '</pre>';
	
		echo '<pre>';
	$metausuario = opcaoDados("usuario",1);
	var_dump($metausuario);
	echo '</pre>';
	*/
	?>
	
	
	<?php 
	break;	
	case 305: //Justificativa	
	?>

	<?php 
	break;	
	case 306: //CAPUT

	$file_name='caput.doc';
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Content-Type: application/force-download');
	header('Content-type: application/vnd.ms-word');
	header('Content-Type: application/download');
	header('Content-Disposition: attachment;filename='.$file_name);
	header('Content-Transfer-Encoding: binary ');

	?>
	<html>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
	<body>
		<style type='text/css'>
		.style_01 {
			font-size: 16px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}

		.direita{
			text-align: right;
			
		}
	</style>
	<br /><br /><br /> 
	<p class="direita">Número do Processo:<?php echo $pedido['nProcesso'] ?></p>
	<p class="paragrafo">À <br />
		Gerência de Compras e Licitações I <br />
	Senhor(a) Gerente</p>
	<br />

	
	<p class="paragrafo">Com base nas informações e justificativas, retro que adoto, peço a continuidade da contratação nas bases da O.S. que o presente processo trata, com fulcro na Lei Federal n°8.666/93.</p>


	<br />
	<br />
	<p>Santo André, <?php echo exibeHoje(); ?>.</p>
	
	<br /><br />
	
	<br /><br />

	<br /><br />
	
	<p><left>Nome do Diretor da área correspondente<br />
		Cargo do Diretor da área correspondente
	</p></left>
	
	<br /><br />
	
	<br /><br />
	
	<p>De acordo,</p>

	<p>Santo André, <?php echo exibeHoje(); ?>. </p>
	<br /><br />
	
	<br /><br />
	<p>Simone Zárate<br />
	Secretária de Cultura</p>

	<br /><br />
	
	<br /><br />

	<br /><br />

		<p class="rodape">Secretaria de Cultura<br />
		Praça IV Centenário, 02 - Centro - Paço Municipal - Prédio da Biblioteca - Santo André - SP, CEP:09015-080 <br /> 
	Telefone (11) 4433-0730 / (11) 4433-0421</p>
	
	
	
	
	<?php 
	break;	
	case 561: //CAPUT FIP

	$file_name='caput_aniver_20.doc';
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Content-Type: application/force-download');
	header('Content-type: application/vnd.ms-word');
	header('Content-Type: application/download');
	header('Content-Disposition: attachment;filename='.$file_name);
	header('Content-Transfer-Encoding: binary ');

	?>
	<html>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
	<body>
		<style type='text/css'>
		.style_01 {
			font-size: 16px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}

		.direita{
			text-align: right;
			
		}
	</style>
	<br /><br /><br /> 
	<!--<p class="direita">Número do Processo:<?php //echo $pedido['nProcesso'] ?></p>-->
	<p class="paragrafo">À <br />
		Gerência de Compras e Licitações I <br />
	Senhor(a) Gerente</p>
	<br />


	<p class="paragrafo">Com base nas informações e justificativas, retro que adoto, peço a continuidade da contratação nas bases da O.S. que o presente processo trata, com fulcro na Lei Federal n°8.666/93.</p>


	<br />
	<br />
	<p>Santo André, <?php echo exibeHoje(); ?>.</p>
	
	<br /><br />
	
	<br /><br />

	<br /><br />

	
	<p><b>Marco Moretto Neto</b><br />
		Diretor do Departamento de Planejamento e Projetos Especiais
	</p></center>
	
	<br /><br />
	
	<br /><br />
	
	<p>De acordo,</p>

	<p>Santo André, <?php echo exibeHoje(); ?>. </p>

	<br /><br />
	
	<br /><br />

	<br /><br />
	<p><b>Simone Zárate</b><br />
	Secretaria de Cultura</p>

	<br /><br />
	
	<br /><br />
	
	<p class="rodape">Secretaria de Cultura<br />
		Praça IV Centenário, S/N - Centro - Paço Municipal - Prédio da Biblioteca - Santo André - SP, CEP: 09015-080 <br /> 
	Telefone (11) 4433-0730/ (11) 4433-0421</p>
	
	
	
	
	<?php 
	break;	
	
	case 562: //Declaração de Responsabilidade FIP

	$file_name='declaracao_responsabilidade_fip.doc';
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Content-Type: application/force-download');
	header('Content-type: application/vnd.ms-word');
	header('Content-Type: application/download');
	header('Content-Disposition: attachment;filename='.$file_name);
	header('Content-Transfer-Encoding: binary ');

	?>
	<html>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
	<body>
		<style type='text/css'>
		.style_01 {
			font-size: 16px;

		}
		.paragrafo{
			text-indent:4em
		}
		p{
			font-size: 18px;
		}
		
		.rodape{
			text-align: center;
			font-size: 12px;
			padding: -10px;
			
		}
	</style>
	<br />

	
	<p>Referente à contratação da empresa <?php echo $pedido['nome_razaosocial']?> incrita no CNPJ <?php echo $pedido['cpf_cnpj']?>
        representando <!--<font color="#FF0000">(artista/cia/banda/grupo/dupla)</font>--> <?php echo $pedido['titulo'] ?>.</p>
		<br />
		<p><strong>Dotação: <?php echo resumoDotacao($pedido['cod_dotacao'])?> - Projeto: <?php echo $pedido['projeto']?>
                - Ficha: <?php echo $pedido['ficha']?> </strong></p>
		<br /><br />
		<p>Valor: R$ <?php echo $pedido['valor'] ?> ( <?php echo $pedido['valor_extenso'] ?>)		
			
			<br /><br />
			<br /><br />
			<p><center><strong>Declaração</strong></center></p>
			<p></p>
			<p><justify>
			Declaro que a despesa pretendida tem a correspondente adequação orçamentária e financeira de acordo com a lei orçamentária anual e possui dotação específica e suficiente, ou seja, está abrangida por crédito genérico, de forma que somadas todas as despesas da mesma espécie, realizadas e a realizar, previstas no programa de trabalho da unidade, não serão ultrapassados os limites estabelecidos para o exercício, estando adequada também com a Lei de Diretrizes Orçamentárias e o Plano Plurianual vigentes.</justify></p>
		</p>
					<br /><br />

					<br /><br />

					<br /><br />

		<p>Santo André, <?php echo exibeHoje(); ?>.

			
		</center></p>
		
			<br /><br />

			<br /><br />
			
			<br /><br />
		<center><p>Simone Zárate<br />
			Secretaria de Cultura<br />
			CPF : 161.410.008-00<br />
			E-mail profissional: szarate@santoandre.sp.gov.br<br />
			E-mail particular: simonezarate@terra.com.br
		</center></p>

			<br /><br />


			<br /><br />

			

		
		<?php 
		break;

		case 307: //Declaração de Responsabilidade	

		$file_name='declaracao_responsabilidade.doc';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: application/force-download');
		header('Content-type: application/vnd.ms-word');
		header('Content-Type: application/download');
		header('Content-Disposition: attachment;filename='.$file_name);
		header('Content-Transfer-Encoding: binary ');

		?>
		<html>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
		<body>
			<style type='text/css'>
			.style_01 {
				font-size: 16px;

			}
			.paragrafo{
				text-indent:4em
			}
			p{
				font-size: 18px;
			}
			
			.rodape{
				text-align: center;
				font-size: 12px;
				padding: -10px;
				
			}
		</style>
		<br />

		
		<p>Referente à contratação da empresa <?php echo $pedido['nome_razaosocial']?> inscrita no CNPJ <?php echo $pedido['cpf_cnpj']?>
            representando <!--<font color="#FF0000">(artista/cia/banda/grupo/dupla)</font>--> <?php echo $pedido['titulo'] ?>. </p>

			<br />
			<p><strong>Dotação: <?php echo resumoDotacao($pedido['cod_dotacao'])?> - Projeto: <?php echo $pedido['projeto']?> - Ficha: <?php echo $pedido['ficha']?> </strong></p>
			<br /><br />
			<p>Valor: R$ <?php echo $pedido['valor'] ?> ( <?php echo $pedido['valor_extenso'] ?>)		
				<br /><br />
				<br /><br />
				<p><center><strong>Declaração</strong></center></p>
				<p><center>
				Declaro que a despesa pretendida tem a correspondente adequação orçamentária e financeira de acordo com a lei orçamentária anual e possui dotação específica e suficiente, ou seja, está abrangida por crédito genérico, de forma que somadas todas as despesas da mesma espécie, realizadas e a realizar, previstas no programa de trabalho da unidade, não serão ultrapassados os limites estabelecidos para o exercício, estando adequada também com a Lei de Diretrizes Orçamentárias e o Plano Plurianual vigentes.</center></p>
			</p>
			<p><center>Santo André, <?php echo exibeHoje(); ?>. </center></p>
			
			<br /><br />
			
			<br /><br />
			

			<br /><br />
			
			<br /><br />

	
			<p><center>Simone Zárate<br />
				Secretaria de Cultura<br />
				CPF : 161.410.008-00<br />
				E-mail profissional: szarate@santoandre.sp.gov.br<br />
				E-mail particular: simonezarate@terra.com.br
			</center></p>
			
			<br /><br />


			<br /><br />

			<br /><br />


			<br /><br />

			<p class="rodape">Secretaria de Cultura <br />
				Praça IV Centenário, 02 - Centro - Paço Municipal - Prédio da Biblioteca - Santo André - SP, CEP:09015-080 <br /> 
			Telefone (11) 4433-0730 / (11) 4433-0421</p>
			<?php 
			break;



			case 396:
			$justificativa = "";
			if($pedido['evento_atividade'] == 'atividade'){
				$justificativa .= "Valor a ser reservado para empenho  ".$pedido['obs']." ".$pedido['objeto'] ;	
			}else{
				$justificativa .= "
				Valor a ser reservado para empenho de contratação para ".$pedido['objeto']; 
			}
			
			$justificativa .= " a ser realizado por ".$pedido['nome_razaosocial']."(".$pedido['cpf_cnpj'].") representando ".$pedido['integrantes']." em data/período ".$pedido['periodo']  ;

			if($pedido['local'] != ""){
				$justificativa .= " em ".$pedido['local'];
				
			}
			
			

			$file_name='liberacaodeverba.doc';
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Content-Type: application/force-download');
			header('Content-type: application/vnd.ms-word');
			header('Content-Type: application/download');
			header('Content-Disposition: attachment;filename='.$file_name);
			header('Content-Transfer-Encoding: binary ');

			?>
			<html>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
			<body>
				<style type='text/css'>
				.style_01 {
					font-size: 16px;

				}
				.paragrafo{
					text-indent:4em
				}
				p{
					font-size: 18px;
				}
				
				.rodape{
					text-align: center;
					font-size: 12px;
					padding: -10px;
					
				}
			</style>

			<table border='1'>
				<tr>
					<th>Liberação Nº</th>
					<th>Data</th>
					<th>Justificativa</th>
					<th>Projeto/Ficha</th>
					<th>Dotação</th>
					<th>Fonte</th>
					<th>Valor</th>
				</tr>
				<tr>
					<td><?php echo $pedido['nLiberacao'] ?></td>	
					<td><?php echo exibirDataBr($pedido['liberado']); ?></td>	
					<td><?php echo $justificativa ?></td>	
					<td><?php echo $pedido['projeto']." / ".$pedido['ficha']; ?></td>	
					<td><?php echo resumoDotacao($pedido['cod_dotacao']); ?></td>	
					<td><?php echo $pedido['fonte'] ?></td>	
					<td><?php echo $pedido['valor'] ?>	

				</tr>
				
			</table>

			<?php 
			break;
			case "320":
			
			
			$justificativa = "";

			if($pedido['evento_atividade'] == 'atividade'){
				$justificativa .= "Valor a ser reservado para empenho  ".$pedido['obs']." ".$pedido['objeto'] ;	
			}else{
				$justificativa .= "
				Valor a ser reservado para empenho de contratação para ".$pedido['objeto']; 
			}
			
			$justificativa .= " a ser realizado por ".$pedido['nome_razaosocial']." (".$pedido['cpf_cnpj'].") em data/período ".$pedido['periodo']  ;

			if($pedido['local'] != ""){
				$justificativa .= " em ".$pedido['local'];
				
			}
			
			$sql_mult = "SELECT idPedidoContratacao FROM sc_contratacao WHERE nLiberacao = '".$pedido['nLiberacao']."'";
			$res_mult = $wpdb->get_results($sql_mult,ARRAY_A);
		//var_dump($res_mult); $sql_mult;		
			
			$file_name='liberacaodeverbamultipla.doc';
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Content-Type: application/force-download');
			header('Content-type: application/vnd.ms-word');
			header('Content-Type: application/download');
			header('Content-Disposition: attachment;filename='.$file_name);
			header('Content-Transfer-Encoding: binary ');

			?>

			<html>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8">
			<body>
				<style type='text/css'>

				.style_01 {
					font-size: 16px;

				}
				.paragrafo{
					text-indent:4em
				}
				p{
					font-size: 18px;
				}
				
				.rodape{
					text-align: center;
					font-size: 12px;
					padding: -10px;
					
				}

			</style>

			<table border='1'>
				<tr>
					<th>Liberação Nº</th>
					<th>Data</th>
					<th>Justificativa</th>
					<th>Projeto/Ficha</th>
					<th>Dotação</th>
					<th>Fonte</th>
					<th>Valor</th>
				</tr>
				<tr>
					<td rowspan='<?php echo count($ped); ?>'><?php echo $pedido['nLiberacao'] ?></td>
					<td rowspan='<?php echo count($ped); ?>'><?php echo date('d/m/Y'); ?></td>
					<td rowspan='<?php echo count($ped); ?>'><?php echo $justificativa; ?></td>

				</tr>
				<?php $total = 0; ?>
				<?php for ($i = 0; $i < count($res_mult); $i++){ 
					$ped = retornaPedido($res_mult[$i]['idPedidoContratacao']);
					
					?>
					<tr>

						<td><?php echo $ped['projeto']." / ".$ped['ficha']; ?></td>	
						<td><?php echo resumoDotacao($ped['cod_dotacao']); ?></td>	
						<td><?php echo $ped['fonte'] ?></td>	
						<td><?php echo $ped['valor'];
						$total = $total + dinheiroDeBr($ped['valor']);
						?>	
					</tr>

				<?php } ?>
				<tr>
					
					<td colspan="5"></td>
					<td>Total</td>
					<td><?php echo dinheiroParaBr($total); ?></td>
				</tr>
				
				
				
			</table>
			
			<?php 
			break;
			case "salao2018":
			//http://www3.santoandre.sp.gov.br/bartira/scpsa/documentos.php?id=0&modelo=salao2018

			$sql = "SELECT descricao FROM ava_inscricao WHERE id_mapas = '277'";
			$res = $wpdb->get_results($sql,ARRAY_A);

			?>
			
			<style>
			.break { page-break-before: always; }
			.esquerda{
				margin-left: 100px;
			}

		</style>
		<?php 
		for($i = 1;$i < count($res); $i++){
			$x = json_decode($res[$i]['descricao'],true);
			
	//echo "<pre>";
	//var_dump($x);
	//echo "</pre>";
			?>
			
			
			
			
			
			
			<h1 class="break"></h1>
			
			<p><center><font size="2">46° Salão de Arte Contemporânea Luiz Sacilotto - 2018 - Santo André<br />
				Caderno dos Artistas - 1 fase
			</font></center></p>
			<br />
			<div class="esquerda">
				<h3>Cadastro : ___________</h3>
				<p>Nome artístico: <?php echo $x['Nome artístico']?> / <?php echo $x['Número']?> </p>	
				<p>Técnica:<?php echo $x['Informar técnica']; ?> </p>
				<br />
				
				<h3>Obra A</h3>	
				<p>Título: <?php echo $x['Título da Obra (a)']; ?><br />
					Dimensões:  <?php echo $x['Dimensões (a)']; ?><br />
					Valor:  <?php echo $x['Valor (a)']; ?><br />
				</p>
				<br />

				<h3>Obra B</h3>	
				<p>Título: <?php echo $x['Título da Obra (b)']; ?><br />
					Dimensões:  <?php echo $x['Dimensões (b)']; ?><br />
					Valor:  <?php echo $x['Valor (b)']; ?><br />
				</p>
				<br />

				<h3>Obra C</h3>	
				<p>Título: <?php echo $x['Título da Obra (c)']; ?><br />
					Dimensões:  <?php echo $x['Dimensões (c)']; ?><br />
					Valor:  <?php echo $x['Valor (c)']; ?><br />
				</p>
				<br />

				<h3>Obra D</h3>	
				<p>Título: <?php echo $x['Título da Obra (d)']; ?><br />
					Dimensões:  <?php echo $x['Dimensões (d)']; ?><br />
					Valor:  <?php echo $x['Valor (d)']; ?><br />
				</p>
				<br />

				<h3>Obra E</h3>	
				<p>Título: <?php echo $x['Título da Obra (e)']; ?><br />
					Dimensões:  <?php echo $x['Dimensões (e)']; ?><br />
					Valor:  <?php echo $x['Valor (e)']; ?><br />
				</p>
				<br />
			</div>
			
			<?php
			
		}

		?>

		
		
		<?php 
		break;
		default:
		?>


		<?php 
		break;	
	}
	
	
}

