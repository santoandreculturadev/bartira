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

// Funções
function retornaMes($data){
	
	$m = date("m", strtotime($data));
	switch ($data) {
        case "01":    $mes = 'Jan';   break;
        case "02":    $mes = 'Fev';   break;
        case "03":    $mes = 'Mar';   break;
        case "04":    $mes = 'Abr';   break;
        case "05":    $mes = 'Mai';   break;
        case "06":    $mes = 'Jun';   break;
        case "07":    $mes = 'Jul';   break;
        case "08":    $mes = 'Ago';   break;
        case "09":    $mes = 'Set';   break;
        case "10":    $mes = 'Out';   break;
        case "11":    $mes = 'Nov';   break;
        case "12":    $mes = 'Dez';   break; 
 }
 
 return $mes;
	
}



// carrega as funções do wordpress

require_once("../../wp-load.php");
require_once("../inc/function.php"); //o function.php dá algum pau para saída para os gráficos

switch($_GET['src']){


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
	
	break;

	
	// Acervo
	case "acervo":
	
	break;
	
	// Ações Continuadas
	case "acoes":
	
	break;

	case "biblioteca": // por mês tb
	
	if(isset($_GET['ano']) AND $_GET['ano'] != ""){
		$ano =" AND YEAR(periodo_inicio) = ".$_GET['ano'];
	}else{
		$ano = "";
	}
	
	
	$json = "[";
	$json_array = array();
	$sel = "SELECT * FROM sc_ind_biblioteca WHERE publicado = '1' $ano ORDER BY periodo_inicio ASC";
	$ocor = $wpdb->get_results($sel,ARRAY_A);
	if(count($ocor) > 0){
		for($i = 0; $i < count($ocor); $i++){
		$json .=  '{
			"periodo": "'.date("m/Y", strtotime($ocor[$i]['periodo_inicio'])).'",
			"Público - Biblioteca Central" : "'.$ocor[$i]['pub_central'].'",
			"Público - Biblioteca Descentralizada" : "'.$ocor[$i]['pub_ramais'].'",
			"Empréstimos - Biblioteca Central" : "'. $ocor[$i]['emp_central'].'",
			"Empréstimos - Biblioteca Descentralizada" : "'.$ocor[$i]['emp_ramais'].'",
			"Sócios - Biblioteca Central" : "'. $ocor[$i]['soc_ramais'].'",
			"Sócios - Biblioteca Descentralizada" : "'. $ocor[$i]['acervo_central'].'",
			"Itens Acervo - Biblioteca Central" : "'.$ocor[$i]['acervo_central'].'",
			"Itens Acervo - Biblioteca Descentralizada" : "'.$ocor[$i]['acervo_ramais'].'",
			"Itens Acervo - Biblioteca Digital" : "'.$ocor[$i]['acervo_digital'].'",
			"Novas Incorporações - Biblioteca Central" : "'.$ocor[$i]['incorporacoes_central'].'",
			"Novas Incorporações - Biblioteca Descentralizada" : "'.$ocor[$i]['incorporacoes_ramais'].'",
			"Novas Incorporações - Biblioteca Digital" : "'.$ocor[$i]['incorporacoes_digital'].'",
			"Downloads - Digital" : "'.$ocor[$i]['downloads'].'"
			},';
		
		$json_array[$i] = array(
			"periodo" => $ocor[$i]['periodo_inicio'],
			"Público - Biblioteca Central"  => $ocor[$i]['pub_central'],
			"Público - Biblioteca Descentralizada" => $ocor[$i]['pub_ramais'],
			"Empréstimos - Biblioteca Central" =>  $ocor[$i]['emp_central'],
			"Empréstimos - Biblioteca Descentralizada" => $ocor[$i]['emp_ramais'],
			"Sócios - Biblioteca Central" =>  $ocor[$i]['soc_ramais'],
			"Sócios - Biblioteca Descentralizada" =>  $ocor[$i]['acervo_central'],
			"Itens Acervo - Biblioteca Central" => $ocor[$i]['acervo_central'],
			"Itens Acervo - Biblioteca Descentralizada" => $ocor[$i]['acervo_ramais'],
			"Itens Acervo - Biblioteca Digital" => $ocor[$i]['acervo_digital'],
			"Novas Incorporações - Biblioteca Central" => $ocor[$i]['incorporacoes_central'],
			"Novas Incorporações - Biblioteca Descentralizada" => $ocor[$i]['incorporacoes_ramais'],
			"Novas Incorporações - Biblioteca Digital" => $ocor[$i]['incorporacoes_digital'],
			"Downloads - Digital" => $ocor[$i]['downloads']
		);
	}
}
	$json = substr($json,0,-1);	
	$json .= "]";
	
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
	$sql_data_unica_locais = "SELECT DISTINCT local FROM sc_ocorrencia WHERE dataFinal <> '0000-00-00' AND dataInicio >= '$primeiro_dia' AND dataInicio <= '$ultimo_dia' AND publicado = '1'";  
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


