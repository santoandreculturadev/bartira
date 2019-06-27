<?php include "header.php"; ?>
<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';
}

?>
<body>
	
	<?php include "menu/me_inicio.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Manutenção</h1>		
		<?php 
		switch($p){
			case 'inicio':
			?>
			<ul>
				<li><a href="?p=atualiza_categoria_ranking">Atualiza a categoria das inscrições</a> : é preciso definir o id_mapas </li>
				<li><a href="?p=atualiza_agenda">Atualiza a agenda</a> : todos os eventos do Bartira. </li>
				<li><a href="?p=atualiza_hora_final">Atualiza as ocorrências com hora final</a> : todos os eventos do Bartira. </li>
				<li><a href="">Atualiza a categoria das inscrições</a> </li>
				<li><a href="?p=importa_contatos">Importa contatos das inscrições</a> </li>
				<li><a href="?p=atualiza_status">Atualiza Status</a> </li>
				<li><a href="?p=orcamento2019">Importa o orçamento de 2019</a> </li>

			</ul>

			<?php
			break;
			case "orcamento2019":
			
			echo "<h1>Importar Orçamento 2019</h1>";
			// Seleciona todos os registro da tabela temp_orcamento2019
			$sql_sel = "SELECT * FROM temp_orcamento2019";
			$res = $wpdb->get_results($sql_sel, ARRAY_A);
			//var_dump($res);
			for($i = 0; $i < count($res); $i++){
				if($res[$i]['id'] != 1){
					
					
					switch($res[$i]['COL 3']){
						case "01 - GABINETE DA SECRETARIA DE CULTURA";
						$unidade = 289;
						break;
						case "10 - DEPARTAMENTO DE CULTURA";
						$unidade = 290;
						break;
						case "80 - DEPARTAMENTO DE LAZER";
						$unidade = 291;
						break;
						default:
						$unidade = 1;		
					}
					
					
					$projeto = $res[$i]['COL 5'];
					$descricao = $res[$i]['COL 6'];
					$ficha = $res[$i]['COL 7'];
					$dotacao = $res[$i]['COL 8'];
					$fonte  = $res[$i]['COL 9'];
					$natureza = $res[$i]['COL 10'];
					$des_nat = "";
					$funcao = $res[$i]['COL 13'];
					$des_funcao  = "";
					$programa  = $res[$i]['COL 11'];
					$des_programa  = "";
					$acao = $res[$i]['COL 12'];
					$des_acao  = "";
					$valor = dinheiroDeBr(trim($res[$i]['COL 48']));
					$obs = "";
					$publicado = 1;
					$idUsuario = 1;
					$ano_base = '2019';
					
					
					
					$sql_insert = "INSERT INTO `sc_orcamento` (`unidade`, `projeto`, `descricao`, `ficha`, `dotacao`, `fonte`, `natureza`, `des_nat`, `funcao`, `des_funcao`, `programa`, `des_programa`, `acao`, `des_acao`, `valor`, `obs`, `publicado`, `idUsuario`, `ano_base`) VALUES ( '$unidade', '$projeto', '$descricao', '$ficha', '$dotacao', '$fonte', '$natureza', '$des_nat', '$funcao', '$des_funcao', '$programa', '$des_programa', '$acao', '$des_acao', '$valor', '$obs', '$publicado', '$idUsuario', '$ano_base')";
					$q = $wpdb->query($sql_insert);
					var_dump($q);
					echo " - ".$wpdb->insert_id;
					echo "<br />";				
				}
				
			}
			
			?>
			
			<?php 
			break;
			case 'atualiza_categoria_ranking':  
			if(isset($_GET['id_mapas'])){
				$id_mapas = $_GET['id_mapas'];
				?>		  
				<?php 
				$sql_sel_ins = "SELECT inscricao FROM ava_inscricao WHERE id_mapas = '$id_mapas'";
				$res = $wpdb->get_results($sql_sel_ins,ARRAY_A);
				
				
				for($i = 0; $i < count($res); $i++){
					$id_insc = $res[$i]['inscricao'];
					$sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$id_insc'";	
					$json = $wpdb->get_row($sel,ARRAY_A);	
					$res_json = converterObjParaArray(json_decode(($json['descricao'])));
					$filtro = $res_json['3.2 - Categoria'];
					$sql_atualiza = "UPDATE ava_ranking SET filtro = '$filtro' WHERE inscricao = '$id_insc'";
					if($wpdb->query($sql_atualiza)){
						echo "$id_insc - Filtro atualizado.<br />";
					}else{
						echo "$id_insc - $sql_atualiza.<br />";
						
					}
				}
				
			}else{
				?>
				<div class="container">
					<div class="row">    
						<div class="col-md-offset-2 col-md-8">
							<h1>Não há Edital indicado</h1>
						</div>
					</div>
				</div>
			<?php 	}

			
			?>

			<?php 
			break;
			case 'relatorio_edital':  

			if(isset($_GET['edital'])){
				$edital = $_GET['edital'];
			}else{
				echo "Não há edital selecionado.<br />";
			}

			if(isset($_GET['user'])){
				$user = $_GET['user'];
			}else{
				echo "Não há usuário selecionado.<br />";
			}

			if(isset($user) AND isset($edital)){
				
				
			}else{ ?>

				<form method="POST" action="?" class="form-horizontal" role="form">
					<div class="container">
						<div class="row">    
							<div class="col-md-offset-2 col-md-8">
								<label>Edital</label>
								<input type="text" name="nomeEvento" class="form-control" id="inputSubject" value=""/>
							</div>
						</div>
					</div>
				</form>

				<?php 
			}
			?>  
			<?php 
			break;
			case 'atualiza_banco':
			$sql_sel = "SELECT * FROM igsis_bancos ORDER BY codigo";
			$res = $wpdb->get_results($sql_sel,ARRAY_A);
			for($i = 0; $i < count($res); $i++){
				$descricao = json_encode(array(
					"codBanco" => $res[$i]['codigo']
				)
			);
				$tipo = $res[$i]['banco'];
				$sql_ins = "INSERT INTO sc_tipo (tipo,descricao,abreviatura,publicado) VALUES('$tipo','$descricao','banco','1')";
				$ins = $wpdb->query($sql_ins);
				
				if($ins == 1){
					echo "$tipo migrado<br />";
				}else{
					echo $sql_ins."<br />";
					
				}
				
			}
			
			?>	
			<?php 
			break;
			case 'subelemento':

			$sub = array(

				"319004" => [
					"3" => "Férias - CPTD",
					"21" =>	"13º Salário - CPTD",
					"151" => "Obrigação Patronal - Inss Temporário",
					"152" => "Obrigação Patronal - Inss Temporário -Férias",
					"153" => "Obrigação Patronal - Fgts Temporário",
					"154" => "Obrigação Patronal - Fgts Temporário -Férias",
					"991" => "Outras Contratações por Tempo Determinado - Demais", 
					"992" => "Outras Contratações por Tempo Determinado - Demais Férias",
					"998" => "Serviços Extraordinários Diurnos - Temporário"
				],

				"335043" => [
					"0" => "Subvenções Sociais" 
				],

				"339030" => [
					"4" => "Gás Engarrafado",
					"7" => "Gêneros de Alimentação",
					"24" => "Material para manutenção de bens imóveis",
					"26" => "Material elétrico e eletrônico	",
					"99" => "Outros materiais de consumo ",
				],	

				"339031" => [
					"0" => "Premiações Culturais, Artísticas, Científicas e Outras",

				],	
				
				"339033" => [
					"2" => "Passagens para o Exterior",
				],
				
				"339036" => [
					"7" => "Estagiários",
					"28" => "Serviço de Seleção e Treinamento",
					"99" => "Outros Serviços",

				],	

				"339039" => [
					"1" => "Assinaturas De Periódicos E Anuidades",
					"2" => "Condomínios",
					"4" => "Direitos Autorais",
					"5" => "Serviços Técnicos Profissionais ",
					"12" => "Locação de Máquinas e Equipamentos ",
					"16" => "Manutenção e Conservação De Bens Imóveis", 
					"17" => "Manutenção e Conservação de Máquinas e Equipamentos ",
					"22" => "Exposições, Congressos e Conferências",
					"39" => "Encargos Financeiros Indedutíveis - Empresas ",
					"47" => "Serviços de Comunicação em Geral", 
					"48" => "Serviço de Seleção e Treinamento",
					"57" => "Serviços de Processamento de Dados ",
					"58" => "Serviços de Telecomunicação",
					"63" => "Serviços Gráficos ",
					"99" => "Outros Serviços de Terceiros- Pessoa Jurídica ",

				],	
				
				"449052" => [
					"12	Aparelhos e Utensílios Domésticos ",
					"33	Equipamentos Para Áudio Vídeo e Foto",
					"42	Mobiliário em Geral ",
					"99	outros Materiais Permanente",
				],	
			);


			echo "<pre>";
			var_dump($sub);
			echo "</pre>";

			var_dump(json_encode($sub));



			?>	

			<?php 
			break;
			case 'atualiza_agenda':  
			set_time_limit(0);

			$sql_evento = "SELECT idEvento FROM sc_evento WHERE publicado = '1'";
			$evento = $wpdb->get_results($sql_evento,ARRAY_A);
			for($i = 0; $i < count($evento); $i++){
				atualizarAgenda($evento[$i]['idEvento'],true);
			}
			
			

			?>		  
			<div class="container">
				<div class="row">    
					<div class="col-md-offset-2 col-md-8">
						
					</div>
				</div>
			</div>
			<?php 
			break;
			case 'importa_contatos':  
			set_time_limit(0);

			$x =array("on-58078286","on-2101871521","on-2135100180","on-1302100216","on-316231794","on-688002562","on-1954495637","on-1776752054","on-779107560","on-1800557621","on-1865705822","on-260727837","on-1539060598","on-1517359845","on-83570770","on-1973229016","on-1866929251","on-1024162598","on-650254741","on-250367787","on-1310481067","on-1403335167","on-22818438","on-101546906","on-1054155689","on-1601848067","on-2022854575","on-445536142","on-221062963","on-509705695","on-783504660","on-1860378557","on-646718992","on-307571087","on-465126408","on-643633308","on-1443264217","on-259882278","on-1878208231","on-921197314","on-442527509","on-1134166409");


//$x = array("on-58078286");

// Cria uma string para verificação
			$y = "";
			foreach($x as $value){
				$y .= $value.",";
			}
			$y = substr($y,0,-1);


			for($i = 0; $i < count($x); $i++){

				$ins = retornaInscricao($x[$i]);
				$insc = json_decode($ins['descricao'],true);

				$nome = $insc["Agente responsável pela inscrição - Nome completo ou Razão Social"];
				$sql_ver = "SELECT id FROM sc_contatos WHERE nome LIKE '%$nome%'";
				$ver = $wpdb->get_results($sql_ver,ARRAY_A);
		if(count($ver) == 0){ //insere
			
			
			$nomeartistico   =  $insc["Agente responsável pela inscrição"];
			$localnascimento   = "";
			$datanascimento   = "";
			$cep   = $insc["Agente responsável pela inscrição - CEP"];
			$numero   = $insc["Agente responsável pela inscrição - Número"];
			$complemento   = $insc["Agente responsável pela inscrição - Complemento"];
			$telefone1   =  $insc["Agente responsável pela inscrição - Telefone 1"];
			$telefone2   =  $insc["Agente responsável pela inscrição - Telefone 2"];
			$telefone3   = $insc["Agente responsável pela inscrição - Telefone Público"];
			$email   = $insc["Agente responsável pela inscrição - Email Privado"];
			$biografia   = addslashes("Participou da programação de Aniversário 2018 com o projeto '".$insc["3.1 - Título"]."'");
			$area_atuacao   = $insc["Agente responsável pela inscrição - Área de Atuação"];
			$local_atuacao   = $insc["Agente responsável pela inscrição - Área de Atuação"];
			$acervo   = "";
			$links   = $insc["Agente responsável pela inscrição - Site"];
			$culturaz   = $insc["Agente responsável pela inscrição - Id"];
			$usuario = $user->ID;
			$hoje = date('Y-m-d');

			
			$sql_inserir = "INSERT INTO `sc_contatos` (`nome`, `nome_artistico`, `telefone1`, `nascimento`, `area`, `local`, `bio`, `email`, `acervo`, `culturaz`, `atualizacao`, `publicado`, `telefone2`, `telefone3`, `cep`, `numero`, `complemento`,`local_atuacao`,`links`,`idUsuario`) VALUES ('$nome', '$nomeartistico', '$telefone1', '$datanascimento', '$area_atuacao', '$localnascimento', '$biografia', '$email','$acervo', '$culturaz', '$hoje', '1', '$telefone2', '$telefone3', '$cep', '$numero', '$complemento', '$local_atuacao','$links','$usuario')";

			$ins = $wpdb->query($sql_inserir);
			if($ins){
				$mensagem = alerta("Contato inserido com sucesso.","success");
			}else{
				$mensagem = alerta("Erro. Tente novamente.","warning");
			}
			
		}
		
		

		echo "<pre>";
		var_dump($insc);
		echo "</pre>";
		
		
	}
	
	

	?>		  
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				
			</div>
		</div>
	</div>
	<?php 
	break;
	case 'atualiza_hora_final': 

// Gera os horários finais das ocorrências
	$sql_oc = "SELECT idOcorrencia, horaInicio, duracao FROM sc_ocorrencia";
	$ocor = $wpdb->get_results($sql_oc,ARRAY_A);
	for($i = 0; $i < count($ocor); $i++){
		$idOcorrencia = $ocor[$i]['idOcorrencia'];
		$horaInicio = $ocor[$i]['horaInicio'];
		$duracao = $ocor[$i]['duracao'];
		$horaFinal = somaMinutos($horaInicio,$duracao).":00";
		if($duracao != 0){
			$upd = "UPDATE sc_ocorrencia SET horaFinal = '$horaFinal' WHERE idOcorrencia = '$idOcorrencia'";
			$x = $wpdb->query($upd);
			if($x == 1){
				echo $i." - ".$horaInicio." + ".$duracao." minutos = ".$horaFinal."<br />";
			}
		}
	}
	
	?>		  
	<?php 
	break;
	case 'atualiza_status':  

// seleciona todos os eventos publicados
	$sql_evento = "SELECT * FROM sc_evento WHERE publicado = 1";
	$evento = $wpdb->get_results($sql_evento,ARRAY_A);

	for($i = 0; $i < count($evento); $i++){
		
	if($evento[$i]['dataEnvio'] == NULL){ // enviado
		$sql_atualiza = "UPDATE sc_evento SET status = '1' WHERE idEvento = '".$evento[$i]['idEvento']."'";
		$wpdb->query($sql_atualiza);
	}

	if($evento[$i]['dataEnvio'] != NULL){ // enviado
		$sql_atualiza = "UPDATE sc_evento SET status = '2' WHERE idEvento = '".$evento[$i]['idEvento']."'";
		$wpdb->query($sql_atualiza);
	}

	if($evento[$i]['mapas'] != NULL AND $evento[$i]['mapas'] != 0 ){ // enviado
		$sql_atualiza = "UPDATE sc_evento SET status = '4' WHERE idEvento = '".$evento[$i]['idEvento']."'";;
		$wpdb->query($sql_atualiza);
	}

}

?>	


<?php 
break;
}//fim da switch
?>		  

</main>
</div>
</div>

<?php 
include "footer.php";
?>