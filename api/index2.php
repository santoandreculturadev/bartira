<?php
//header ('Content-type: text/html; charset=utf-8');
/*
+ Acervo
+ Ações Continuadas
+ Biblioteca
+ Comunicação
+ Convocatórias
+ Eventos
+ Disciplinas, Cursos, Incentivo à Criação
+ Orçamento
+ Plataforma CulturAZ
+ Redes Sociais

*/







// carrega as funções do wordpress

require_once("../../wp-load.php");
require_once("../inc/function.php"); //o function.php dá algum pau para saída para os gráficos
set_time_limit(0);



switch($_GET['src']){




/*


	// Atendimentos
	/*
	Mensal
	Público Atendido
	No. Atividades / Com agentes locais
	No. Agentes locais envolvidos
	No. Bairros
	
	Atividades Eventuais
	Público Atendido
	No. Atividades / Com agentes locais
	No. Bairros

	Atividades Eventuais
	Público Atendido em exposições
	No. Atividades / Com agentes locais
	No. Bairros por exposições
	
	
	
	*/
	case "atendimentos":

	$json = "[";
	$ano_base = $_GET['ano_base'];


	$ind_evento = indicadores($ano_base,"evento");
	$ind_biblioteca = indicadores($ano_base,"biblioteca");
	$ind_incentivo = indicadores($ano_base,"incentivo");

	if(isset($_GET['mes'])){
		
		
			$m = $_GET['mes'];

			$conta_bairro = array();
			$conta_bairro = contaBairros($ind_evento['mes'][$m]['id_bairros'],$conta_bairro);
			$conta_bairro = contaBairros($ind_incentivo[$m]['bairros']['id_bairro'],$conta_bairro);
			
			$t = tipo(tipoId("Biblioteca"));
			$tipo = json_decode($t['descricao'],TRUE);
			$conta_bairro = contaBairros($tipo['bairros'],$conta_bairro);
			

			$json .=  '{
			"Período": "'.campoMes($m).'",
			"Público Geral" : "'.($ind_evento['mes'][$m]['publico'] + $ind_biblioteca['mes'][$m]['Público - Biblioteca Central'] + $ind_biblioteca['mes'][$m]['Público - Biblioteca Descentralizada'] + $ind_incentivo[$m]['total']['all']).'",
			"Nº Atividades" : "'.($ind_evento['mes'][$m]['n_atividades'] +  $ind_incentivo[$m]['atividades']).'",
			"Nº Atividades com Agentes Locais" : "'.($ind_evento['mes'][$m]['n_atividades_locais'] +  $ind_incentivo[$m]['atividades_agentes_locais']).'",
			"Nº Agentes Culturais Locais Envolvidos" : "'.($ind_evento['mes'][$m]['agentes_locais'] +  $ind_incentivo[$m]['agentes_locais']).'",
			"Nº Bairros da Cidade Atendidos" : "'. count($conta_bairro).'",
			"% Bairros da Cidade Atendidos (Ref. 112 bairros)" : "'. round((count($conta_bairro)/112)*100,2).'",
			"Nº Bairros Descentralizados" : "'.(count($conta_bairro) - 1).'"
			},';

	}else{
		
	for($m = 1; $m < 13; $m++){	
			$conta_bairro = array();
			$conta_bairro = contaBairros($ind_evento['mes'][$m]['id_bairros'],$conta_bairro);
			$conta_bairro = contaBairros($ind_incentivo[$m]['bairros']['id_bairro'],$conta_bairro);
			
			$t = tipo(tipoId("Biblioteca"));
			$tipo = json_decode($t['descricao'],TRUE);
			$conta_bairro = contaBairros($tipo['bairros'],$conta_bairro);
			

			$json .=  '{
			"Período": "'.campoMes($m).'",
			"Público Geral" : "'.($ind_evento['mes'][$m]['publico'] + $ind_biblioteca['mes'][$m]['Público - Biblioteca Central'] + $ind_biblioteca['mes'][$m]['Público - Biblioteca Descentralizada'] + $ind_incentivo[$m]['total']['all']).'",
			"Nº Atividades" : "'.($ind_evento['mes'][$m]['n_atividades'] +  $ind_incentivo[$m]['atividades']).'",
			"Nº Atividades com Agentes Locais" : "'.($ind_evento['mes'][$m]['n_atividades_locais'] +  $ind_incentivo[$m]['atividades_agentes_locais']).'",
			"Nº Agentes Culturais Locais Envolvidos" : "'.($ind_evento['mes'][$m]['agentes_locais'] +  $ind_incentivo[$m]['agentes_locais']).'",
			"Nº Bairros da Cidade Atendidos" : "'. count($conta_bairro).'",
			"% Bairros da Cidade Atendidos (Ref. 112 bairros)" : "'. round((count($conta_bairro)/112)*100,2).'",
			"Nº Bairros Descentralizados" : "'.(count($conta_bairro) - 1).'"
			},';
	}
		
	}
	$json = substr($json,0,-1);	
	$json .= "]";
	
	

	 ob_end_clean(); 	
	 echo $json;
	









	
	
	
	break;

	
	// Acervo
	case "acervo":
	
	break;
	
	// Ações Continuadas
	case "acoes":
	
	break;

	case "biblioteca": // por mês tb
	
	if(isset($_GET['ano'])){
		$ano_base = $_GET['ano'];
	}else{
		$ano_base = date('Y');
	}
	

	//echo $ano_base;

	//echo "<pre>";
	//var_dump($ind);
	//echo "</pre>";
	
	$json = "[";


	if($ano_base == "ano"){
		$anos = anoOrcamento();
		//echo "<pre>";
		//var_dump($anos);
		//echo "</pre>";
		for($i = 0; $i < count($anos); $i++){
			$ind = indicadores($anos[$i]['ano_base'],'biblioteca');
			
			$json .=  '{
			"periodo": "'.$ind['ano']['periodo'].'",
			"Público - Biblioteca Central" : "'.$ind['ano']['Público - Biblioteca Central'].'",
			"Público - Biblioteca Descentralizada" : "'.$ind['ano']['Público - Biblioteca Descentralizada'].'",
			"Empréstimos - Biblioteca Central" : "'. $ind['ano']['Empréstimos - Biblioteca Central'].'",
			"Empréstimos - Biblioteca Descentralizada" : "'.$ind['ano']['Empréstimos - Biblioteca Descentralizada'].'",
			"Sócios - Biblioteca Central" : "'. $ind['ano']['Sócios - Biblioteca Central'].'",
			"Sócios - Biblioteca Descentralizada" : "'. $ind['ano']['Sócios - Biblioteca Descentralizada'].'",
			"Itens Acervo - Biblioteca Central" : "'.$ind['ano']['Itens Acervo - Biblioteca Central'].'",
			"Itens Acervo - Biblioteca Descentralizada" : "'.$ind['ano']['Itens Acervo - Biblioteca Descentralizada'].'",
			"Itens Acervo - Biblioteca Digital" : "'.$ind['ano']['Itens Acervo - Biblioteca Digital'].'",
			"Novas Incorporações - Biblioteca Central" : "'.$ind['ano']['Novas Incorporações - Biblioteca Central'].'",
			"Novas Incorporações - Biblioteca Descentralizada" : "'.$ind['ano']['Novas Incorporações - Biblioteca Descentralizada'].'",
			"Novas Incorporações - Biblioteca Digital" : "'.$ind['ano']['Novas Incorporações - Biblioteca Digital'].'",
			"Downloads - Digital" : "'.$ind['ano']['Novas Incorporações - Biblioteca Digital'].'"
			}';
			
			
			
		}
		
		
		
	}else{
	$ind = indicadores($ano_base,'biblioteca');

		if(!isset($_GET['total'])){

		for($i = 1; $i <= count($ind['mes']); $i++){
		$json .=  '{
			"periodo": "'.$ind['mes'][$i]['periodo'].'",
			"Público - Biblioteca Central" : "'.$ind['mes'][$i]['Público - Biblioteca Central'].'",
			"Público - Biblioteca Descentralizada" : "'.$ind['mes'][$i]['Público - Biblioteca Descentralizada'].'",
			"Empréstimos - Biblioteca Central" : "'. $ind['mes'][$i]['Empréstimos - Biblioteca Central'].'",
			"Empréstimos - Biblioteca Descentralizada" : "'.$ind['mes'][$i]['Empréstimos - Biblioteca Descentralizada'].'",
			"Sócios - Biblioteca Central" : "'. $ind['mes'][$i]['Sócios - Biblioteca Central'].'",
			"Sócios - Biblioteca Descentralizada" : "'. $ind['mes'][$i]['Sócios - Biblioteca Descentralizada'].'",
			"Itens Acervo - Biblioteca Central" : "'.$ind['mes'][$i]['Itens Acervo - Biblioteca Central'].'",
			"Itens Acervo - Biblioteca Descentralizada" : "'.$ind['mes'][$i]['Itens Acervo - Biblioteca Descentralizada'].'",
			"Itens Acervo - Biblioteca Digital" : "'.$ind['mes'][$i]['Itens Acervo - Biblioteca Digital'].'",
			"Novas Incorporações - Biblioteca Central" : "'.$ind['mes'][$i]['Novas Incorporações - Biblioteca Central'].'",
			"Novas Incorporações - Biblioteca Descentralizada" : "'.$ind['mes'][$i]['Novas Incorporações - Biblioteca Descentralizada'].'",
			"Novas Incorporações - Biblioteca Digital" : "'.$ind['mes'][$i]['Novas Incorporações - Biblioteca Digital'].'",
			"Downloads - Digital" : "'.$ind['mes'][$i]['Novas Incorporações - Biblioteca Digital'].'"
			},';

		
		

	}
		}else{
	
			$json .=  '{
			"periodo": "'.$ind['ano']['periodo'].'",
			"Público - Biblioteca Central" : "'.$ind['ano']['Público - Biblioteca Central'].'",
			"Público - Biblioteca Descentralizada" : "'.$ind['ano']['Público - Biblioteca Descentralizada'].'",
			"Empréstimos - Biblioteca Central" : "'. $ind['ano']['Empréstimos - Biblioteca Central'].'",
			"Empréstimos - Biblioteca Descentralizada" : "'.$ind['ano']['Empréstimos - Biblioteca Descentralizada'].'",
			"Sócios - Biblioteca Central" : "'. $ind['ano']['Sócios - Biblioteca Central'].'",
			"Sócios - Biblioteca Descentralizada" : "'. $ind['ano']['Sócios - Biblioteca Descentralizada'].'",
			"Itens Acervo - Biblioteca Central" : "'.$ind['ano']['Itens Acervo - Biblioteca Central'].'",
			"Itens Acervo - Biblioteca Descentralizada" : "'.$ind['ano']['Itens Acervo - Biblioteca Descentralizada'].'",
			"Itens Acervo - Biblioteca Digital" : "'.$ind['ano']['Itens Acervo - Biblioteca Digital'].'",
			"Novas Incorporações - Biblioteca Central" : "'.$ind['ano']['Novas Incorporações - Biblioteca Central'].'",
			"Novas Incorporações - Biblioteca Descentralizada" : "'.$ind['ano']['Novas Incorporações - Biblioteca Descentralizada'].'",
			"Novas Incorporações - Biblioteca Digital" : "'.$ind['ano']['Novas Incorporações - Biblioteca Digital'].'",
			"Downloads - Digital" : "'.$ind['ano']['Novas Incorporações - Biblioteca Digital'].'"
			},';

		}
	}

	$json = substr($json,0,-1);	
	$json .= "]";
	
	
	
	
	
	
 ob_end_clean(); 	
	echo $json;

	

	
	break;
	
	// Comunicação
	case "comunicacao":
	
	break;

	// Eventos
	case "eventos":
	/*
	if(isset($_GET['ano']) AND $_GET['ano'] != ""){
		$ano =" AND YEAR(periodo_inicio) = ".$_GET['ano'];
	}else{
		$ano = "";
	}
	*/
	$primeiro_dia = $_GET['ano']."-".$_GET['mes']."-01";
	$ultimo_dia = $_GET['ano']."-".$_GET['mes']."-".ultimoDiaMes($_GET['ano'],$_GET['mes']);
	
	
	// eventos data única
	$sql_data_unica_locais = "SELECT DISTINCT local FROM sc_indrencia WHERE dataFinal <> '0000-00-00' AND dataInicio >= '$primeiro_dia' AND dataInicio <= '$ultimo_dia' AND publicado = '1'";  
	$locais = $wpdb->get_results($sql_data_unica_locais, ARRAY_A);


	

	$bairros_array = array();
	$centro = 0;

	for($i = 0; $i < count($locais); $i++){
		$tipo = tipo($locais[$i]['local']);
		var_dump($tipo);
		$desc = json_decode($tipo['descricao'],true);
		
		if($desc['bairro'] == 578){
			$centro = 1;
		}else{	
			if(!in_array($desc['bairro'],$bairros_array)){
				array_push($bairros_array,$locais[$i]['local']);
			}
		}
	}

// Publico
	echo "<h1>Publico Evento`Único</h1>";
	$sql_data_unica =  "SELECT SUM(valor) AS publico FROM sc_indicadores WHERE periodoFim <> '0000-00-00' AND periodoInicio >= '$primeiro_dia' AND periodoInicio <= '$ultimo_dia' AND publicado = '1'";		
	$result_data_unica = $wpdb->get_row($sql_data_unica,ARRAY_A);
	var_dump($result_data_unica);

	echo "<h1>Publico Evento`Único</h1>";	
	
	
	

	
	
	echo "<pre>";
	var_dump($bairros_array);
	echo "</pre>";
	
	
	break;
	// Disciplinas, Cursos, Incentivo à Criação
	case "incentivo":
	
	
	
	
	
	
	break;
	
	// Orçamento
	/*
	Mensal
	Pizza: Disponível e Comprometido
	Barra horizontal: Comprometido, Disponibilizado, Orçado 
	
	*/
	
	
	case "orcamento":
	
	
	
	$sql_orcado = "SELECT SUM(valor) AS 'total' FROM sc_orcamento WHERE ano_base = '".$_GET['ano']."' AND publicado = '1' AND planejamento = '0' AND idPai = '0'";
	$query_orcado = $wpdb->get_row($sql_orcado,ARRAY_A);

	$sql_ids = "SELECT id FROM sc_orcamento WHERE ano_base = '".$_GET['ano']."' AND publicado = '1' AND planejamento = '0' AND idPai = '0'";
	$query_ids = $wpdb->get_results($sql_ids,ARRAY_A);



if(isset($_GET['mes'])){
	$json = "[";
	$primeiro_dia = $_GET['ano']."-01-01";
	$ultimo_dia = $_GET['ano']."-".$_GET['mes']."-".ultimoDiaMes($_GET['ano'],$_GET['mes']);
		$comprometido = 0;
		$revisado = 0;
		for($i = 0; $i < count($query_ids); $i++){
			$orc = orcamento($query_ids[$i]['id'],$ultimo_dia,$primeiro_dia);
			//echo "<pre>";
			//var_dump($orc);
			//echo "</pre>";
			$comprometido = $comprometido + $orc['total_liberado_data'];
			$revisado = $revisado + $orc['revisado'];
	}
	$liberado = $revisado - $comprometido;
	
		$json .= '{"orcado":"'.$query_orcado["total"].'","comprometido":"'.$comprometido.'","liberado":"'.$liberado.'"}]';
	
}else{

	$json = "";
}
	for($j = 1; $j <= 12; $j++){

	$primeiro_dia = $_GET['ano']."-01-01";
	$ultimo_dia = $_GET['ano']."-".$j."-".ultimoDiaMes($_GET['ano'],$j);
		$comprometido = 0;
		$revisado = 0;
		for($i = 0; $i < count($query_ids); $i++){
			$orc = orcamento($query_ids[$i]['id'],$ultimo_dia,$primeiro_dia);
			//echo "<pre>";
			//var_dump($orc);
			//echo "</pre>";
			$comprometido = $comprometido + $orc['total_liberado_data'];
			$revisado = $revisado + $orc['revisado'];
		}		
		$liberado = $revisado - $comprometido;
		$retorno[$j] = array(
		'mes' => sprintf("%02d", $j)."/".$_GET['ano'],
		'orcado' => dinheiroParaBr($query_orcado['total']),
		'comprometido' => dinheiroParaBr($comprometido),
		'liberado' => dinheiroParaBr($liberado)
		);
	
		
	
	}
		var_dump($retorno);
		$json = json_encode($retorno);
	
	
	//var_dump($query_ids);

//echo $primeiro_dia ." / ". $ultimo_dia;



	
	
	//echo "<pre>";
	//var_dump($retorno);
	//echo "</pre>";

 ob_end_clean(); 
 echo $json;
	
	
	

	
	
	
	
	
	
	break;


	// Plataforma CulturAZ
	case "culturaz":
	
	break;	

	// Redes Sociais
	case "redes":
	
	break;	
	
	
}


