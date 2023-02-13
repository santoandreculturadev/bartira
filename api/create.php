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



	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando os registros...</h1><br />";
	$hoje = date('Y-m-d H:i:s');

$wpdb->query("TRUNCATE TABLE `sc_api`");




$ano = anoOrcamento(true);





for($i = 0; $i < count($ano); $i++){
	$ano_base = $ano[$i]['ano_base'];




	$json_ano = "[";
	$json_total = array();

	// atendimento

	$ind_evento = indicadores($ano_base,"evento");
	$ind_biblioteca = indicadores($ano_base,"biblioteca");
	$ind_incentivo = indicadores($ano_base,"incentivo");

	$json_ano .=  '{
		"Período": "'.$ano_base.'",
		"Público Geral" : "0",
		"Nº Atividades" : "0",
		"Nº Agentes Culturais Locais Envolvidos" : "0",
		"Nº Bairros da Cidade Atendidos" : "0",
		"% Bairros da Cidade Atendidos (Ref. 112 bairros)" : "0",
		"Nº Bairros Descentralizados" : "0"
		},';	
		
	$conta_bairro_total = array();	

	for($m = 1; $m < 13; $m++){	
		$json_mes = "[";
			$conta_bairro = array();
			$conta_bairro = contaBairros($ind_evento['mes'][$m]['id_bairros'],$conta_bairro);
			$conta_bairro = contaBairros($ind_incentivo[$m]['bairros']['id_bairros'],$conta_bairro);
			
			$t = tipo(tipoId("Biblioteca"));
			$tipo = json_decode($t['descricao'],TRUE);
			$conta_bairro = contaBairros($tipo['bairros'],$conta_bairro);
			

			$json_ano .=  '{
			"Período": "'.fillZero($m,2).'",
			"Público Geral" : "'.($ind_evento['mes'][$m]['publico'] + $ind_biblioteca['mes'][$m]['Público - Biblioteca Central'] + $ind_biblioteca['mes'][$m]['Público - Biblioteca Descentralizada'] + $ind_incentivo[$m]['total']['all']).'",
			"Nº Atividades" : "'.($ind_evento['mes'][$m]['n_atividades'] +  $ind_incentivo[$m]['atividades']).'",
			"Nº Atividades com Agentes Locais" : "'.($ind_evento['mes'][$m]['n_atividades_locais'] +  $ind_incentivo[$m]['atividades_agentes_locais']).'",
			"Nº Agentes Culturais Locais Envolvidos" : "'.($ind_evento['mes'][$m]['agentes_locais'] +  $ind_incentivo[$m]['agentes_locais']).'",
			"Nº Bairros da Cidade Atendidos" : "'. count($conta_bairro).'",
			"% Bairros da Cidade Atendidos (Ref. 112 bairros)" : "'. round((count($conta_bairro)/112)*100,2).'",
			"Nº Bairros Descentralizados" : "'.(count($conta_bairro) - 1).'"
			},';

			$json_mes .=  '{
			"Período": "'.fillZero($m,2).'",
			"Público Geral" : "'.($ind_evento['mes'][$m]['publico'] + $ind_biblioteca['mes'][$m]['Público - Biblioteca Central'] + $ind_biblioteca['mes'][$m]['Público - Biblioteca Descentralizada'] + $ind_incentivo[$m]['total']['all']).'",
			"Nº Atividades" : "'.($ind_evento['mes'][$m]['n_atividades'] +  $ind_incentivo[$m]['atividades']).'",
			"Nº Atividades com Agentes Locais" : "'.($ind_evento['mes'][$m]['n_atividades_locais'] +  $ind_incentivo[$m]['atividades_agentes_locais']).'",
			"Nº Agentes Culturais Locais Envolvidos" : "'.($ind_evento['mes'][$m]['agentes_locais'] +  $ind_incentivo[$m]['agentes_locais']).'",
			"Nº Bairros da Cidade Atendidos" : "'. count($conta_bairro).'",
			"% Bairros da Cidade Atendidos (Ref. 112 bairros)" : "'. round((count($conta_bairro)/112)*100,2).'",
			"Nº Bairros Descentralizados" : "'.(count($conta_bairro) - 1).'"
			},';

			// total
			$json_total['Público Geral'] = $json_total['Público Geral'] + ($ind_evento['mes'][$m]['publico'] + $ind_biblioteca['mes'][$m]['Público - Biblioteca Central'] + $ind_biblioteca['mes'][$m]['Público - Biblioteca Descentralizada'] + $ind_incentivo[$m]['total']['all']);
			$json_total['Nº Atividades'] = $json_total['Nº Atividades'] + ($ind_evento['mes'][$m]['n_atividades'] +  $ind_incentivo[$m]['atividades']);
			$json_total['Nº Atividades com Agentes Locais'] = $json_total['Nº Atividades com Agentes Locais'] + ($ind_evento['mes'][$m]['n_atividades_locais'] +  $ind_incentivo[$m]['atividades_agentes_locais']);
			$json_total['Nº Agentes Culturais Locais Envolvidos'] = $json_total['Nº Agentes Culturais Locais Envolvidos'] + ($ind_evento['mes'][$m]['agentes_locais'] +  $ind_incentivo[$m]['agentes_locais']);
			$conta_bairro_total = contaBairros($conta_bairro,$conta_bairro_total);
			echo "contaBairroTotal:";
			var_dump($conta_bairro_total);

		//echo $json_mes."<br />";
		$json_mes = substr($json_mes,0,-1);	
		$json_mes .= "]";

	$sql_insert = "INSERT INTO `sc_api` (`id`, `src`, `ano`, `mes`, `json`) VALUES (NULL, 'atendimentos', '$ano_base', '".$m."', '$json_mes')";
	$wpdb->query($sql_insert);

	} // fim do loop mês
		

	$json_ano = substr($json_ano,0,-1);	
	$json_ano .= "]";
	
	$json_total['Nº Bairros da Cidade Atendidos'] = count($conta_bairro_total);
	$json_total['% Bairros da Cidade Atendidos (Ref. 112 bairros)'] =  round((count($conta_bairro_total)/112)*100,2);
	$json_total['Nº Bairros Descentralizados'] = count($conta_bairro_total)-1;

	$json_total_json = json_encode($json_total,JSON_UNESCAPED_UNICODE);
	$json_total_retorno = "[".$json_total_json."]";


	$sql_insert = "INSERT INTO `sc_api` (`id`, `src`, `ano`, `mes`, `json`) VALUES (NULL, 'atendimentos', '$ano_base', '0', '$json_ano')";
	$wpdb->query($sql_insert);

	$sql_insert = "INSERT INTO `sc_api` (`id`, `src`, `ano`, `mes`, `total`,`json`) VALUES (NULL, 'atendimentos', '$ano_base', '0', '1','$json_total_retorno')";
	$wpdb->query($sql_insert);


	// biblioteca


	$json_ano = "[";

	$ind = indicadores($ano_base,'biblioteca');
	
	

	$json_ano .=  '{
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
			
	$json_ano = substr($json_ano,0,-1);	
	$json_ano .= "]";		

	$sql_insert = "INSERT INTO `sc_api` (`id`, `src`, `ano`, `mes`, `total`, `json`) VALUES (NULL, 'biblioteca', '$ano_base', '0','1', '$json_ano')";
	$x = $wpdb->query($sql_insert);
	var_dump($x);		
	
	$json_total = "[";

		for($n = 1; $n < 13; $n++){
		$json_mes = "[";	
		$json_mes .=  '{
			"periodo": "'.$ind['mes'][$n]['periodo'].'",
			"Público - Biblioteca Central" : "'.$ind['mes'][$n]['Público - Biblioteca Central'].'",
			"Público - Biblioteca Descentralizada" : "'.$ind['mes'][$n]['Público - Biblioteca Descentralizada'].'",
			"Empréstimos - Biblioteca Central" : "'. $ind['mes'][$n]['Empréstimos - Biblioteca Central'].'",
			"Empréstimos - Biblioteca Descentralizada" : "'.$ind['mes'][$n]['Empréstimos - Biblioteca Descentralizada'].'",
			"Sócios - Biblioteca Central" : "'. $ind['mes'][$n]['Sócios - Biblioteca Central'].'",
			"Sócios - Biblioteca Descentralizada" : "'. $ind['mes'][$n]['Sócios - Biblioteca Descentralizada'].'",
			"Itens Acervo - Biblioteca Central" : "'.$ind['mes'][$n]['Itens Acervo - Biblioteca Central'].'",
			"Itens Acervo - Biblioteca Descentralizada" : "'.$ind['mes'][$n]['Itens Acervo - Biblioteca Descentralizada'].'",
			"Itens Acervo - Biblioteca Digital" : "'.$ind['mes'][$n]['Itens Acervo - Biblioteca Digital'].'",
			"Novas Incorporações - Biblioteca Central" : "'.$ind['mes'][$n]['Novas Incorporações - Biblioteca Central'].'",
			"Novas Incorporações - Biblioteca Descentralizada" : "'.$ind['mes'][$n]['Novas Incorporações - Biblioteca Descentralizada'].'",
			"Novas Incorporações - Biblioteca Digital" : "'.$ind['mes'][$n]['Novas Incorporações - Biblioteca Digital'].'",
			"Downloads - Digital" : "'.$ind['mes'][$n]['Novas Incorporações - Biblioteca Digital'].'"
			},';

			$json_total .=  '{
				"periodo": "'.$ind['mes'][$n]['periodo'].'",
				"Público - Biblioteca Central" : "'.$ind['mes'][$n]['Público - Biblioteca Central'].'",
				"Público - Biblioteca Descentralizada" : "'.$ind['mes'][$n]['Público - Biblioteca Descentralizada'].'",
				"Empréstimos - Biblioteca Central" : "'. $ind['mes'][$n]['Empréstimos - Biblioteca Central'].'",
				"Empréstimos - Biblioteca Descentralizada" : "'.$ind['mes'][$n]['Empréstimos - Biblioteca Descentralizada'].'",
				"Sócios - Biblioteca Central" : "'. $ind['mes'][$n]['Sócios - Biblioteca Central'].'",
				"Sócios - Biblioteca Descentralizada" : "'. $ind['mes'][$n]['Sócios - Biblioteca Descentralizada'].'",
				"Itens Acervo - Biblioteca Central" : "'.$ind['mes'][$n]['Itens Acervo - Biblioteca Central'].'",
				"Itens Acervo - Biblioteca Descentralizada" : "'.$ind['mes'][$n]['Itens Acervo - Biblioteca Descentralizada'].'",
				"Itens Acervo - Biblioteca Digital" : "'.$ind['mes'][$n]['Itens Acervo - Biblioteca Digital'].'",
				"Novas Incorporações - Biblioteca Central" : "'.$ind['mes'][$n]['Novas Incorporações - Biblioteca Central'].'",
				"Novas Incorporações - Biblioteca Descentralizada" : "'.$ind['mes'][$n]['Novas Incorporações - Biblioteca Descentralizada'].'",
				"Novas Incorporações - Biblioteca Digital" : "'.$ind['mes'][$n]['Novas Incorporações - Biblioteca Digital'].'",
				"Downloads - Digital" : "'.$ind['mes'][$n]['Novas Incorporações - Biblioteca Digital'].'"
				},';
	
	
			
		$json_mes = substr($json_mes,0,-1);	
	$json_mes .= "]";
	$sql_insert = "INSERT INTO `sc_api` (`id`, `src`, `ano`, `mes`, `json`) VALUES (NULL, 'biblioteca', '$ano_base', '$n', '$json_mes')";
	$wpdb->query($sql_insert);		
	


	}

	$json_total = substr($json_total,0,-1);	
	$json_total .= "]";
	$sql_insert_total = "INSERT INTO `sc_api` (`id`, `src`, `ano`, `total`,`mes`, `json`) VALUES (NULL, 'biblioteca', '$ano_base','0', '0', '$json_total')";
	$wpdb->query($sql_insert_total);	

	
// evento



	$json_ano = "[";
	for($m = 1; $m < 13; $m++){	
		$json_mes = "[";
			$conta_bairro = array();
			$conta_bairro = contaBairros($ind_evento['mes'][$m]['id_bairros'],$conta_bairro);
			//$conta_bairro = contaBairros($ind_incentivo[$m]['bairros']['id_bairro'],$conta_bairro);
			
			//$t = tipo(tipoId("Biblioteca"));
			//$tipo = json_decode($t['descricao'],TRUE);
			//$conta_bairro = contaBairros($tipo['bairros'],$conta_bairro);
			

			$json_ano .=  '{
			"Período": "'.fillZero($m,2).'",
			"Público Geral" : "'.($ind_evento['mes'][$m]['publico']).'",
			"Nº Atividades" : "'.($ind_evento['mes'][$m]['n_atividades']).'",
			"Nº Atividades com Agentes Locais" : "'.($ind_evento['mes'][$m]['n_atividades_locais']).'",
			"Nº Agentes Culturais Locais Envolvidos" : "'.($ind_evento['mes'][$m]['agentes_locais']).'",
			"Nº Bairros da Cidade Atendidos" : "'. count($conta_bairro).'",
			"% Bairros da Cidade Atendidos (Ref. 112 bairros)" : "'. round((count($conta_bairro)/112)*100,2).'",
			"Nº Bairros Descentralizados" : "'.(count($conta_bairro) - 1).'"
			},';

			$json_mes .=  '{
			"Período": "'.fillZero($m,2).'",
			"Público Geral" : "'.($ind_evento['mes'][$m]['publico']).'",
			"Nº Atividades" : "'.($ind_evento['mes'][$m]['n_atividades']).'",
			"Nº Atividades com Agentes Locais" : "'.($ind_evento['mes'][$m]['n_atividades_locais']).'",
			"Nº Agentes Culturais Locais Envolvidos" : "'.($ind_evento['mes'][$m]['agentes_locais']).'",
			"Nº Bairros da Cidade Atendidos" : "'. count($conta_bairro).'",
			"% Bairros da Cidade Atendidos (Ref. 112 bairros)" : "'. round((count($conta_bairro)/112)*100,2).'",
			"Nº Bairros Descentralizados" : "'.(count($conta_bairro) - 1).'"
			},';
		//echo $json_mes."<br />";
		$json_mes = substr($json_mes,0,-1);	
		$json_mes .= "]";

	$sql_insert = "INSERT INTO `sc_api` (`id`, `src`, `ano`, `mes`, `json`) VALUES (NULL, 'eventos', '$ano_base', '".$m."', '$json_mes')";
	$wpdb->query($sql_insert);

	} // fim do loop mês
		

	$json_ano = substr($json_ano,0,-1);	
	$json_ano .= "]";

	$sql_insert = "INSERT INTO `sc_api` (`id`, `src`, `ano`, `mes`, `json`) VALUES (NULL, 'eventos', '$ano_base', '0', '$json_ano')";
	$wpdb->query($sql_insert);

	//total
		$json_total = "[";
				$json_total .=  '{
			"Período": "'.$ano_base.'",
			"Público Geral" : "'.($ind_evento['ano']['publico']).'",
			"Nº Atividades" : "'.($ind_evento['ano']['n_atividades']).'",
			"Nº Atividades com Agentes Locais" : "'.($ind_evento['ano']['n_atividades_locais']).'",
			"Nº Agentes Culturais Locais Envolvidos" : "'.($ind_evento['ano']['agentes_locais']).'",
			"Nº Bairros da Cidade Atendidos" : "'. $ind_evento['ano']['n_bairros'].'",
			"% Bairros da Cidade Atendidos (Ref. 112 bairros)" : "'. round((($ind_evento['ano']['n_bairros'])/112)*100,2).'",
			"Nº Bairros Descentralizados" : "'.(($ind_evento['ano']['n_bairros']) - 1).'"
			},';
		//echo $json_mes."<br />";
		$json_total = substr($json_total,0,-1);	
		$json_total .= "]";
		$sql_insert = "INSERT INTO `sc_api` (`id`, `src`, `ano`, `total`, `mes`, `json`) VALUES (NULL, 'eventos', '$ano_base', '1', '0', '$json_total')";
		$wpdb->query($sql_insert);	
		echo $sql_insert;
		

	
// incentivo



	$json_ano = "[";
	for($m = 1; $m < 13; $m++){	
		$json_mes = "[";
			$conta_bairro = array();
			//$conta_bairro = contaBairros($ind_evento['mes'][$m]['id_bairros'],$conta_bairro);
			$conta_bairro = contaBairros($ind_incentivo[$m]['bairros']['id_bairros'],$conta_bairro);
			
			//$t = tipo(tipoId("Bibliotecas"));
			//$tipo = json_decode($t['descricao'],TRUE);
			//$conta_bairro = contaBairros($tipo['bairros'],$conta_bairro);
			

			$json_ano .=  '{
			"Período": "'.fillZero($m,2).'",
			"Público Geral" : "'.($ind_incentivo[$m]['total']['all']).'",
			"Nº Atividades" : "'.($ind_incentivo[$m]['atividades']).'",
			"Nº Atividades com Agentes Locais" : "'.($ind_incentivo[$m]['atividades_agentes_locais']).'",
			"Nº Agentes Culturais Locais Envolvidos" : "'.($ind_incentivo[$m]['agentes_locais']).'",
			"Nº Bairros da Cidade Atendidos" : "'. count($conta_bairro).'",
			"% Bairros da Cidade Atendidos (Ref. 112 bairros)" : "'. round((count($conta_bairro)/112)*100,2).'",
			"Nº Bairros Descentralizados" : "'.(count($conta_bairro) - 1).'"
			},';

			$json_mes .=  '{
			"Período": "'.fillZero($m,2).'",
			"Público Geral" : "'.($ind_incentivo[$m]['total']['all']).'",
			"Nº Atividades" : "'.($ind_incentivo[$m]['atividades']).'",
			"Nº Atividades com Agentes Locais" : "'.($ind_incentivo[$m]['atividades_agentes_locais']).'",
			"Nº Agentes Culturais Locais Envolvidos" : "'.($ind_incentivo[$m]['agentes_locais']).'",
			"Nº Bairros da Cidade Atendidos" : "'. count($conta_bairro).'",
			"% Bairros da Cidade Atendidos (Ref. 112 bairros)" : "'. round((count($conta_bairro)/112)*100,2).'",
			"Nº Bairros Descentralizados" : "'.(count($conta_bairro) - 1).'"
			},';
		//echo $json_mes."<br />";
		$json_mes = substr($json_mes,0,-1);	
		$json_mes .= "]";

	$sql_insert = "INSERT INTO `sc_api` (`id`, `src`, `ano`, `mes`, `json`) VALUES (NULL, 'incentivo', '$ano_base', '".$m."', '$json_mes')";
	$wpdb->query($sql_insert);

	} // fim do loop mês
		

	$json_ano = substr($json_ano,0,-1);	
	$json_ano .= "]";
	
	



	$sql_insert = "INSERT INTO `sc_api` (`id`, `src`, `ano`, `mes`, `json`) VALUES (NULL, 'incentivo', '$ano_base', '0', '$json_ano')";
	$wpdb->query($sql_insert);
	
	//total
		$json_total = "[";
				$json_total .=  '{
			"Período": "'.$ano_base.'",
			"Público Geral" : "'.($ind_incentivo['total']['all']).'",
			"Nº Atividades" : "'.($ind_incentivo['atividades']).'",
			"Nº Atividades com Agentes Locais" : "'.($ind_incentivo['atividades_agentes_locais']).'",
			"Nº Agentes Culturais Locais Envolvidos" : "'.($ind_incentivo['agentes_locais']).'",
			"Nº Bairros da Cidade Atendidos" : "'. $ind_incentivo['bairros']['n_bairros'].'",
			"% Bairros da Cidade Atendidos (Ref. 112 bairros)" : "'. round((($ind_incentivo['bairros']['n_bairros'])/112)*100,2).'",
			"Nº Bairros Descentralizados" : "'.(($ind_incentivo['bairros']['n_bairros']) - 1).'"
			},';
		//echo $json_mes."<br />";
		$json_total = substr($json_total,0,-1);	
		$json_total .= "]";
		$sql_insert = "INSERT INTO `sc_api` (`id`, `src`, `ano`, `total`, `mes`, `json`) VALUES (NULL, 'incentivo', '$ano_base', '1', '0', '$json_total')";
		$wpdb->query($sql_insert);	
		echo $sql_insert;
	
	

	
	
	// orcamento (id, src, ano, total, mes, json)
	

	// Quais os projetos do ano base
	
	// anos que não sejam o atual buscar no contabil

	// total no ano

		$json_total = "[";	
	
		for($n = 1; $n < 13; $n++){

			$json = "[";
	
				$res = orcamentoDataTotal($ano_base,$n);
				$res['periodo'] = fillZero($n,2);
				$json .= json_encode($res);


			$json_total .= json_encode($res).",";
				//$json = substr($json,0,-1);	
			$json .= "]";


			$sql_insert = "INSERT INTO `sc_api` (`id`, `src`, `ano`, `total`, `mes`, `json`) VALUES (NULL, 'orcamento', '$ano_base', '0', $n, '$json')";
			$wpdb->query($sql_insert);	
			
		
		}
		$json_total = substr($json_total,0,-1);	
		$json_total .= "]";
		$sql_insert = "INSERT INTO `sc_api` (`id`, `src`, `ano`, `total`, `mes`, `json`) VALUES (NULL, 'orcamento', '$ano_base', '1', '0', '$json_total')";
		$wpdb->query($sql_insert);	


	} // fim do loop do ano
	





	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";