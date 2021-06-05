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
	switch ($m) {
        case "01":    $mes = 'Jan';     break;
        case "02":    $mes = 'Fev';   break;
        case "03":    $mes = 'Mar';       break;
        case "04":    $mes = 'Abr';       break;
        case "05":    $mes = 'Mai';        break;
        case "06":    $mes = 'Jun';       break;
        case "07":    $mes = 'Jul';       break;
        case "08":    $mes = 'Ago';      break;
        case "09":    $mes = 'Set';    break;
        case "10":    $mes = 'Out';     break;
        case "11":    $mes = 'Nov';    break;
        case "12":    $mes = 'Dez';    break; 
 }
 
 return $mes;
	
}



// carrega as funções do wordpress

require_once("../../wp-load.php");
//require_once("../inc/function.php"); //o function.php dá algum pau para saída para os gráficos

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

	case "biblioteca":
	
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
	echo '[{ "periodo": "01/01/2020", "Público - Biblioteca Central" : "4597", "Público - Biblioteca Descentralizada" : "1617", "Empréstimos - Biblioteca Central" : "1634", "Empréstimos - Biblioteca Descentralizada" : "101", "Sócios - Biblioteca Central" : "45568", "Sócios - Biblioteca Descentralizada" : "80263", "Itens Acervo - Biblioteca Central" : "80263", "Itens Acervo - Biblioteca Descentralizada" : "104404", "Itens Acervo - Biblioteca Digital" : "26759", "Novas Incorporações - Biblioteca Central" : "123", "Novas Incorporações - Biblioteca Descentralizada" : "103", "Novas Incorporações - Biblioteca Digital" : "35", "Downloads - Digital" : "12732" },{ "periodo": "01/12/2019", "Público - Biblioteca Central" : "3358", "Público - Biblioteca Descentralizada" : "1792", "Empréstimos - Biblioteca Central" : "938", "Empréstimos - Biblioteca Descentralizada" : "626", "Sócios - Biblioteca Central" : "45506", "Sócios - Biblioteca Descentralizada" : "80038", "Itens Acervo - Biblioteca Central" : "80038", "Itens Acervo - Biblioteca Descentralizada" : "104322", "Itens Acervo - Biblioteca Digital" : "26724", "Novas Incorporações - Biblioteca Central" : "1", "Novas Incorporações - Biblioteca Descentralizada" : "301", "Novas Incorporações - Biblioteca Digital" : "103", "Downloads - Digital" : "12694" },{ "periodo": "01/11/2019", "Público - Biblioteca Central" : "5872", "Público - Biblioteca Descentralizada" : "5761", "Empréstimos - Biblioteca Central" : "1480", "Empréstimos - Biblioteca Descentralizada" : "1699", "Sócios - Biblioteca Central" : "45477", "Sócios - Biblioteca Descentralizada" : "80037", "Itens Acervo - Biblioteca Central" : "80037", "Itens Acervo - Biblioteca Descentralizada" : "104085", "Itens Acervo - Biblioteca Digital" : "26621", "Novas Incorporações - Biblioteca Central" : "22", "Novas Incorporações - Biblioteca Descentralizada" : "300", "Novas Incorporações - Biblioteca Digital" : "139", "Downloads - Digital" : "7355" },{ "periodo": "01/10/2019", "Público - Biblioteca Central" : "6337", "Público - Biblioteca Descentralizada" : "9688", "Empréstimos - Biblioteca Central" : "1692", "Empréstimos - Biblioteca Descentralizada" : "2675", "Sócios - Biblioteca Central" : "45411", "Sócios - Biblioteca Descentralizada" : "80037", "Itens Acervo - Biblioteca Central" : "80037", "Itens Acervo - Biblioteca Descentralizada" : "104156", "Itens Acervo - Biblioteca Digital" : "26482", "Novas Incorporações - Biblioteca Central" : "6", "Novas Incorporações - Biblioteca Descentralizada" : "83", "Novas Incorporações - Biblioteca Digital" : "214", "Downloads - Digital" : "11685" },{ "periodo": "01/09/2019", "Público - Biblioteca Central" : "7626", "Público - Biblioteca Descentralizada" : "9727", "Empréstimos - Biblioteca Central" : "1913", "Empréstimos - Biblioteca Descentralizada" : "2913", "Sócios - Biblioteca Central" : "45304", "Sócios - Biblioteca Descentralizada" : "80058", "Itens Acervo - Biblioteca Central" : "80058", "Itens Acervo - Biblioteca Descentralizada" : "104263", "Itens Acervo - Biblioteca Digital" : "26268", "Novas Incorporações - Biblioteca Central" : "30", "Novas Incorporações - Biblioteca Descentralizada" : "642", "Novas Incorporações - Biblioteca Digital" : "225", "Downloads - Digital" : "15350" },{ "periodo": "01/08/2019", "Público - Biblioteca Central" : "6839", "Público - Biblioteca Descentralizada" : "2842", "Empréstimos - Biblioteca Central" : "2046", "Empréstimos - Biblioteca Descentralizada" : "5861", "Sócios - Biblioteca Central" : "45211", "Sócios - Biblioteca Descentralizada" : "80054", "Itens Acervo - Biblioteca Central" : "80054", "Itens Acervo - Biblioteca Descentralizada" : "103851", "Itens Acervo - Biblioteca Digital" : "26043", "Novas Incorporações - Biblioteca Central" : "148", "Novas Incorporações - Biblioteca Descentralizada" : "4711", "Novas Incorporações - Biblioteca Digital" : "399", "Downloads - Digital" : "12612" },{ "periodo": "01/07/2019", "Público - Biblioteca Central" : "5585", "Público - Biblioteca Descentralizada" : "11559", "Empréstimos - Biblioteca Central" : "1903", "Empréstimos - Biblioteca Descentralizada" : "1400", "Sócios - Biblioteca Central" : "45095", "Sócios - Biblioteca Descentralizada" : "79940", "Itens Acervo - Biblioteca Central" : "79940", "Itens Acervo - Biblioteca Descentralizada" : "103400", "Itens Acervo - Biblioteca Digital" : "25644", "Novas Incorporações - Biblioteca Central" : "125", "Novas Incorporações - Biblioteca Descentralizada" : "221", "Novas Incorporações - Biblioteca Digital" : "50", "Downloads - Digital" : "10077" },{ "periodo": "01/06/2019", "Público - Biblioteca Central" : "6159", "Público - Biblioteca Descentralizada" : "9224", "Empréstimos - Biblioteca Central" : "1771", "Empréstimos - Biblioteca Descentralizada" : "3148", "Sócios - Biblioteca Central" : "44983", "Sócios - Biblioteca Descentralizada" : "79779", "Itens Acervo - Biblioteca Central" : "79779", "Itens Acervo - Biblioteca Descentralizada" : "99848", "Itens Acervo - Biblioteca Digital" : "25594", "Novas Incorporações - Biblioteca Central" : "456", "Novas Incorporações - Biblioteca Descentralizada" : "653", "Novas Incorporações - Biblioteca Digital" : "108", "Downloads - Digital" : "14298" },{ "periodo": "01/05/2019", "Público - Biblioteca Central" : "9815", "Público - Biblioteca Descentralizada" : "11782", "Empréstimos - Biblioteca Central" : "2197", "Empréstimos - Biblioteca Descentralizada" : "3752", "Sócios - Biblioteca Central" : "44889", "Sócios - Biblioteca Descentralizada" : "78865", "Itens Acervo - Biblioteca Central" : "78865", "Itens Acervo - Biblioteca Descentralizada" : "99219", "Itens Acervo - Biblioteca Digital" : "25486", "Novas Incorporações - Biblioteca Central" : "90", "Novas Incorporações - Biblioteca Descentralizada" : "549", "Novas Incorporações - Biblioteca Digital" : "142", "Downloads - Digital" : "11448" },{ "periodo": "01/04/2019", "Público - Biblioteca Central" : "9066", "Público - Biblioteca Descentralizada" : "10109", "Empréstimos - Biblioteca Central" : "2075", "Empréstimos - Biblioteca Descentralizada" : "3691", "Sócios - Biblioteca Central" : "44725", "Sócios - Biblioteca Descentralizada" : "78785", "Itens Acervo - Biblioteca Central" : "78785", "Itens Acervo - Biblioteca Descentralizada" : "95349", "Itens Acervo - Biblioteca Digital" : "25344", "Novas Incorporações - Biblioteca Central" : "150", "Novas Incorporações - Biblioteca Descentralizada" : "485", "Novas Incorporações - Biblioteca Digital" : "138", "Downloads - Digital" : "8202" },{ "periodo": "01/03/2019", "Público - Biblioteca Central" : "7289", "Público - Biblioteca Descentralizada" : "7132", "Empréstimos - Biblioteca Central" : "1993", "Empréstimos - Biblioteca Descentralizada" : "2831", "Sócios - Biblioteca Central" : "44771", "Sócios - Biblioteca Descentralizada" : "78622", "Itens Acervo - Biblioteca Central" : "78622", "Itens Acervo - Biblioteca Descentralizada" : "94792", "Itens Acervo - Biblioteca Digital" : "25206", "Novas Incorporações - Biblioteca Central" : "4", "Novas Incorporações - Biblioteca Descentralizada" : "577", "Novas Incorporações - Biblioteca Digital" : "98", "Downloads - Digital" : "7538" },{ "periodo": "01/02/2019", "Público - Biblioteca Central" : "8011", "Público - Biblioteca Descentralizada" : "5688", "Empréstimos - Biblioteca Central" : "1727", "Empréstimos - Biblioteca Descentralizada" : "1309", "Sócios - Biblioteca Central" : "44438", "Sócios - Biblioteca Descentralizada" : "78810", "Itens Acervo - Biblioteca Central" : "78810", "Itens Acervo - Biblioteca Descentralizada" : "94793", "Itens Acervo - Biblioteca Digital" : "25108", "Novas Incorporações - Biblioteca Central" : "21", "Novas Incorporações - Biblioteca Descentralizada" : "90", "Novas Incorporações - Biblioteca Digital" : "123", "Downloads - Digital" : "6400" },{ "periodo": "01/01/2019", "Público - Biblioteca Central" : "8112", "Público - Biblioteca Descentralizada" : "2840", "Empréstimos - Biblioteca Central" : "1823", "Empréstimos - Biblioteca Descentralizada" : "755", "Sócios - Biblioteca Central" : "44335", "Sócios - Biblioteca Descentralizada" : "78767", "Itens Acervo - Biblioteca Central" : "78767", "Itens Acervo - Biblioteca Descentralizada" : "95040", "Itens Acervo - Biblioteca Digital" : "24985", "Novas Incorporações - Biblioteca Central" : "43", "Novas Incorporações - Biblioteca Descentralizada" : "128", "Novas Incorporações - Biblioteca Digital" : "1", "Downloads - Digital" : "10313" },{ "periodo": "01/12/2018", "Público - Biblioteca Central" : "10356", "Público - Biblioteca Descentralizada" : "2906", "Empréstimos - Biblioteca Central" : "517", "Empréstimos - Biblioteca Descentralizada" : "1163", "Sócios - Biblioteca Central" : "44304", "Sócios - Biblioteca Descentralizada" : "78655", "Itens Acervo - Biblioteca Central" : "78655", "Itens Acervo - Biblioteca Descentralizada" : "95038", "Itens Acervo - Biblioteca Digital" : "24984", "Novas Incorporações - Biblioteca Central" : "87", "Novas Incorporações - Biblioteca Descentralizada" : "599", "Novas Incorporações - Biblioteca Digital" : "109", "Downloads - Digital" : "7146" },{ "periodo": "01/11/2018", "Público - Biblioteca Central" : "8078", "Público - Biblioteca Descentralizada" : "9569", "Empréstimos - Biblioteca Central" : "1883", "Empréstimos - Biblioteca Descentralizada" : "3249", "Sócios - Biblioteca Central" : "44266", "Sócios - Biblioteca Descentralizada" : "78513", "Itens Acervo - Biblioteca Central" : "78513", "Itens Acervo - Biblioteca Descentralizada" : "94455", "Itens Acervo - Biblioteca Digital" : "24875", "Novas Incorporações - Biblioteca Central" : "200", "Novas Incorporações - Biblioteca Descentralizada" : "525", "Novas Incorporações - Biblioteca Digital" : "123", "Downloads - Digital" : "11043" },{ "periodo": "01/10/2018", "Público - Biblioteca Central" : "10142", "Público - Biblioteca Descentralizada" : "14464", "Empréstimos - Biblioteca Central" : "2324", "Empréstimos - Biblioteca Descentralizada" : "5172", "Sócios - Biblioteca Central" : "44184", "Sócios - Biblioteca Descentralizada" : "48513", "Itens Acervo - Biblioteca Central" : "48513", "Itens Acervo - Biblioteca Descentralizada" : "93930", "Itens Acervo - Biblioteca Digital" : "24752", "Novas Incorporações - Biblioteca Central" : "85", "Novas Incorporações - Biblioteca Descentralizada" : "639", "Novas Incorporações - Biblioteca Digital" : "126", "Downloads - Digital" : "9358" },{ "periodo": "01/09/2018", "Público - Biblioteca Central" : "8684", "Público - Biblioteca Descentralizada" : "12464", "Empréstimos - Biblioteca Central" : "2161", "Empréstimos - Biblioteca Descentralizada" : "4850", "Sócios - Biblioteca Central" : "43717", "Sócios - Biblioteca Descentralizada" : "78340", "Itens Acervo - Biblioteca Central" : "78340", "Itens Acervo - Biblioteca Descentralizada" : "93431", "Itens Acervo - Biblioteca Digital" : "24626", "Novas Incorporações - Biblioteca Central" : "75", "Novas Incorporações - Biblioteca Descentralizada" : "324", "Novas Incorporações - Biblioteca Digital" : "18", "Downloads - Digital" : "25494" },{ "periodo": "01/08/2018", "Público - Biblioteca Central" : "10514", "Público - Biblioteca Descentralizada" : "14414", "Empréstimos - Biblioteca Central" : "2836", "Empréstimos - Biblioteca Descentralizada" : "4874", "Sócios - Biblioteca Central" : "43257", "Sócios - Biblioteca Descentralizada" : "77446", "Itens Acervo - Biblioteca Central" : "77446", "Itens Acervo - Biblioteca Descentralizada" : "93796", "Itens Acervo - Biblioteca Digital" : "24608", "Novas Incorporações - Biblioteca Central" : "198", "Novas Incorporações - Biblioteca Descentralizada" : "1539", "Novas Incorporações - Biblioteca Digital" : "103", "Downloads - Digital" : "8209" },{ "periodo": "01/07/2018", "Público - Biblioteca Central" : "10160", "Público - Biblioteca Descentralizada" : "8038", "Empréstimos - Biblioteca Central" : "2571", "Empréstimos - Biblioteca Descentralizada" : "1397", "Sócios - Biblioteca Central" : "42708", "Sócios - Biblioteca Descentralizada" : "77040", "Itens Acervo - Biblioteca Central" : "77040", "Itens Acervo - Biblioteca Descentralizada" : "93470", "Itens Acervo - Biblioteca Digital" : "24505", "Novas Incorporações - Biblioteca Central" : "185", "Novas Incorporações - Biblioteca Descentralizada" : "1168", "Novas Incorporações - Biblioteca Digital" : "14", "Downloads - Digital" : "5151" },{ "periodo": "01/06/2018", "Público - Biblioteca Central" : "7227", "Público - Biblioteca Descentralizada" : "8637", "Empréstimos - Biblioteca Central" : "2953", "Empréstimos - Biblioteca Descentralizada" : "4038", "Sócios - Biblioteca Central" : "42649", "Sócios - Biblioteca Descentralizada" : "77785", "Itens Acervo - Biblioteca Central" : "77785", "Itens Acervo - Biblioteca Descentralizada" : "94945", "Itens Acervo - Biblioteca Digital" : "24491", "Novas Incorporações - Biblioteca Central" : "146", "Novas Incorporações - Biblioteca Descentralizada" : "391", "Novas Incorporações - Biblioteca Digital" : "37", "Downloads - Digital" : "4481" },{ "periodo": "01/05/2018", "Público - Biblioteca Central" : "8120", "Público - Biblioteca Descentralizada" : "12318", "Empréstimos - Biblioteca Central" : "2617", "Empréstimos - Biblioteca Descentralizada" : "5524", "Sócios - Biblioteca Central" : "42520", "Sócios - Biblioteca Descentralizada" : "77639", "Itens Acervo - Biblioteca Central" : "77639", "Itens Acervo - Biblioteca Descentralizada" : "94554", "Itens Acervo - Biblioteca Digital" : "24454", "Novas Incorporações - Biblioteca Central" : "51", "Novas Incorporações - Biblioteca Descentralizada" : "389", "Novas Incorporações - Biblioteca Digital" : "74", "Downloads - Digital" : "6987" },{ "periodo": "01/04/2018", "Público - Biblioteca Central" : "8044", "Público - Biblioteca Descentralizada" : "21176", "Empréstimos - Biblioteca Central" : "2507", "Empréstimos - Biblioteca Descentralizada" : "5046", "Sócios - Biblioteca Central" : "42383", "Sócios - Biblioteca Descentralizada" : "77588", "Itens Acervo - Biblioteca Central" : "77588", "Itens Acervo - Biblioteca Descentralizada" : "94165", "Itens Acervo - Biblioteca Digital" : "24380", "Novas Incorporações - Biblioteca Central" : "129", "Novas Incorporações - Biblioteca Descentralizada" : "937", "Novas Incorporações - Biblioteca Digital" : "16", "Downloads - Digital" : "11127" },{ "periodo": "01/03/2018", "Público - Biblioteca Central" : "9577", "Público - Biblioteca Descentralizada" : "11654", "Empréstimos - Biblioteca Central" : "2448", "Empréstimos - Biblioteca Descentralizada" : "5066", "Sócios - Biblioteca Central" : "42120", "Sócios - Biblioteca Descentralizada" : "77459", "Itens Acervo - Biblioteca Central" : "77459", "Itens Acervo - Biblioteca Descentralizada" : "93228", "Itens Acervo - Biblioteca Digital" : "24364", "Novas Incorporações - Biblioteca Central" : "124", "Novas Incorporações - Biblioteca Descentralizada" : "750", "Novas Incorporações - Biblioteca Digital" : "64", "Downloads - Digital" : "16537" },{ "periodo": "01/02/2018", "Público - Biblioteca Central" : "5763", "Público - Biblioteca Descentralizada" : "5075", "Empréstimos - Biblioteca Central" : "1816", "Empréstimos - Biblioteca Descentralizada" : "1513", "Sócios - Biblioteca Central" : "41905", "Sócios - Biblioteca Descentralizada" : "77335", "Itens Acervo - Biblioteca Central" : "77335", "Itens Acervo - Biblioteca Descentralizada" : "92478", "Itens Acervo - Biblioteca Digital" : "23426", "Novas Incorporações - Biblioteca Central" : "48", "Novas Incorporações - Biblioteca Descentralizada" : "463", "Novas Incorporações - Biblioteca Digital" : "47", "Downloads - Digital" : "4789" },{ "periodo": "01/01/2018", "Público - Biblioteca Central" : "5959", "Público - Biblioteca Descentralizada" : "1811", "Empréstimos - Biblioteca Central" : "1939", "Empréstimos - Biblioteca Descentralizada" : "919", "Sócios - Biblioteca Central" : "41664", "Sócios - Biblioteca Descentralizada" : "75456", "Itens Acervo - Biblioteca Central" : "75456", "Itens Acervo - Biblioteca Descentralizada" : "91659", "Itens Acervo - Biblioteca Digital" : "22868", "Novas Incorporações - Biblioteca Central" : "160", "Novas Incorporações - Biblioteca Descentralizada" : "140", "Novas Incorporações - Biblioteca Digital" : "0", "Downloads - Digital" : "3671" },{ "periodo": "01/12/2017", "Público - Biblioteca Central" : "4593", "Público - Biblioteca Descentralizada" : "2775", "Empréstimos - Biblioteca Central" : "1333", "Empréstimos - Biblioteca Descentralizada" : "676", "Sócios - Biblioteca Central" : "41617", "Sócios - Biblioteca Descentralizada" : "71684", "Itens Acervo - Biblioteca Central" : "71684", "Itens Acervo - Biblioteca Descentralizada" : "97057", "Itens Acervo - Biblioteca Digital" : "22870", "Novas Incorporações - Biblioteca Central" : "326", "Novas Incorporações - Biblioteca Descentralizada" : "529", "Novas Incorporações - Biblioteca Digital" : "8", "Downloads - Digital" : "2521" },{ "periodo": "01/11/2017", "Público - Biblioteca Central" : "4057", "Público - Biblioteca Descentralizada" : "9466", "Empréstimos - Biblioteca Central" : "2075", "Empréstimos - Biblioteca Descentralizada" : "3257", "Sócios - Biblioteca Central" : "41592", "Sócios - Biblioteca Descentralizada" : "71358", "Itens Acervo - Biblioteca Central" : "71358", "Itens Acervo - Biblioteca Descentralizada" : "96941", "Itens Acervo - Biblioteca Digital" : "22862", "Novas Incorporações - Biblioteca Central" : "129", "Novas Incorporações - Biblioteca Descentralizada" : "704", "Novas Incorporações - Biblioteca Digital" : "41", "Downloads - Digital" : "8915" },{ "periodo": "01/10/2017", "Público - Biblioteca Central" : "4509", "Público - Biblioteca Descentralizada" : "11678", "Empréstimos - Biblioteca Central" : "2174", "Empréstimos - Biblioteca Descentralizada" : "6113", "Sócios - Biblioteca Central" : "40897", "Sócios - Biblioteca Descentralizada" : "71220", "Itens Acervo - Biblioteca Central" : "71220", "Itens Acervo - Biblioteca Descentralizada" : "96244", "Itens Acervo - Biblioteca Digital" : "22843", "Novas Incorporações - Biblioteca Central" : "174", "Novas Incorporações - Biblioteca Descentralizada" : "951", "Novas Incorporações - Biblioteca Digital" : "27", "Downloads - Digital" : "11655" },{ "periodo": "01/09/2017", "Público - Biblioteca Central" : "5384", "Público - Biblioteca Descentralizada" : "10117", "Empréstimos - Biblioteca Central" : "2246", "Empréstimos - Biblioteca Descentralizada" : "4834", "Sócios - Biblioteca Central" : "40830", "Sócios - Biblioteca Descentralizada" : "69186", "Itens Acervo - Biblioteca Central" : "69186", "Itens Acervo - Biblioteca Descentralizada" : "95476", "Itens Acervo - Biblioteca Digital" : "20399", "Novas Incorporações - Biblioteca Central" : "362", "Novas Incorporações - Biblioteca Descentralizada" : "233", "Novas Incorporações - Biblioteca Digital" : "55", "Downloads - Digital" : "6932" },{ "periodo": "01/08/2017", "Público - Biblioteca Central" : "6915", "Público - Biblioteca Descentralizada" : "10353", "Empréstimos - Biblioteca Central" : "2592", "Empréstimos - Biblioteca Descentralizada" : "5292", "Sócios - Biblioteca Central" : "40820", "Sócios - Biblioteca Descentralizada" : "69059", "Itens Acervo - Biblioteca Central" : "69059", "Itens Acervo - Biblioteca Descentralizada" : "92982", "Itens Acervo - Biblioteca Digital" : "22639", "Novas Incorporações - Biblioteca Central" : "440", "Novas Incorporações - Biblioteca Descentralizada" : "153", "Novas Incorporações - Biblioteca Digital" : "82", "Downloads - Digital" : "4736" },{ "periodo": "01/07/2017", "Público - Biblioteca Central" : "5379", "Público - Biblioteca Descentralizada" : "5154", "Empréstimos - Biblioteca Central" : "1983", "Empréstimos - Biblioteca Descentralizada" : "1899", "Sócios - Biblioteca Central" : "40776", "Sócios - Biblioteca Descentralizada" : "71417", "Itens Acervo - Biblioteca Central" : "71417", "Itens Acervo - Biblioteca Descentralizada" : "89222", "Itens Acervo - Biblioteca Digital" : "22000", "Novas Incorporações - Biblioteca Central" : "130", "Novas Incorporações - Biblioteca Descentralizada" : "81", "Novas Incorporações - Biblioteca Digital" : "78", "Downloads - Digital" : "2833" },{ "periodo": "01/06/2017", "Público - Biblioteca Central" : "5400", "Público - Biblioteca Descentralizada" : "9197", "Empréstimos - Biblioteca Central" : "1850", "Empréstimos - Biblioteca Descentralizada" : "3916", "Sócios - Biblioteca Central" : "40677", "Sócios - Biblioteca Descentralizada" : "71433", "Itens Acervo - Biblioteca Central" : "71433", "Itens Acervo - Biblioteca Descentralizada" : "24308", "Itens Acervo - Biblioteca Digital" : "22000", "Novas Incorporações - Biblioteca Central" : "66", "Novas Incorporações - Biblioteca Descentralizada" : "129", "Novas Incorporações - Biblioteca Digital" : "13", "Downloads - Digital" : "6806" },{ "periodo": "01/05/2017", "Público - Biblioteca Central" : "7054", "Público - Biblioteca Descentralizada" : "11596", "Empréstimos - Biblioteca Central" : "2771", "Empréstimos - Biblioteca Descentralizada" : "6494", "Sócios - Biblioteca Central" : "40548", "Sócios - Biblioteca Descentralizada" : "71205", "Itens Acervo - Biblioteca Central" : "71205", "Itens Acervo - Biblioteca Descentralizada" : "24154", "Itens Acervo - Biblioteca Digital" : "22000", "Novas Incorporações - Biblioteca Central" : "154", "Novas Incorporações - Biblioteca Descentralizada" : "189", "Novas Incorporações - Biblioteca Digital" : "77", "Downloads - Digital" : "6265" },{ "periodo": "01/04/2017", "Público - Biblioteca Central" : "5151", "Público - Biblioteca Descentralizada" : "11802", "Empréstimos - Biblioteca Central" : "2380", "Empréstimos - Biblioteca Descentralizada" : "5436", "Sócios - Biblioteca Central" : "40359", "Sócios - Biblioteca Descentralizada" : "71131", "Itens Acervo - Biblioteca Central" : "71131", "Itens Acervo - Biblioteca Descentralizada" : "23988", "Itens Acervo - Biblioteca Digital" : "22000", "Novas Incorporações - Biblioteca Central" : "116", "Novas Incorporações - Biblioteca Descentralizada" : "259", "Novas Incorporações - Biblioteca Digital" : "14", "Downloads - Digital" : "5054" },{ "periodo": "01/03/2017", "Público - Biblioteca Central" : "5862", "Público - Biblioteca Descentralizada" : "9638", "Empréstimos - Biblioteca Central" : "2851", "Empréstimos - Biblioteca Descentralizada" : "5873", "Sócios - Biblioteca Central" : "40220", "Sócios - Biblioteca Descentralizada" : "71015", "Itens Acervo - Biblioteca Central" : "71015", "Itens Acervo - Biblioteca Descentralizada" : "23729", "Itens Acervo - Biblioteca Digital" : "22000", "Novas Incorporações - Biblioteca Central" : "207", "Novas Incorporações - Biblioteca Descentralizada" : "219", "Novas Incorporações - Biblioteca Digital" : "0", "Downloads - Digital" : "5092" },{ "periodo": "01/02/2017", "Público - Biblioteca Central" : "2825", "Público - Biblioteca Descentralizada" : "6475", "Empréstimos - Biblioteca Central" : "1948", "Empréstimos - Biblioteca Descentralizada" : "1624", "Sócios - Biblioteca Central" : "40081", "Sócios - Biblioteca Descentralizada" : "70808", "Itens Acervo - Biblioteca Central" : "70808", "Itens Acervo - Biblioteca Descentralizada" : "23510", "Itens Acervo - Biblioteca Digital" : "22000", "Novas Incorporações - Biblioteca Central" : "191", "Novas Incorporações - Biblioteca Descentralizada" : "498", "Novas Incorporações - Biblioteca Digital" : "0", "Downloads - Digital" : "3007" },{ "periodo": "01/01/2017", "Público - Biblioteca Central" : "3380", "Público - Biblioteca Descentralizada" : "3240", "Empréstimos - Biblioteca Central" : "2449", "Empréstimos - Biblioteca Descentralizada" : "1160", "Sócios - Biblioteca Central" : "39947", "Sócios - Biblioteca Descentralizada" : "70617", "Itens Acervo - Biblioteca Central" : "70617", "Itens Acervo - Biblioteca Descentralizada" : "23012", "Itens Acervo - Biblioteca Digital" : "22000", "Novas Incorporações - Biblioteca Central" : "123", "Novas Incorporações - Biblioteca Descentralizada" : "112", "Novas Incorporações - Biblioteca Digital" : "0", "Downloads - Digital" : "2927" }]';
	
	
	break;


	// Plataforma CulturAZ
	case "culturaz":
	
	break;	

	// Redes Sociais
	case "redes":
	
	break;	
	
	
}


