<?php
// funcoes sistema avaliacao sc.psa
/* 
status dos eventos:
1 > Rascunho
2 > Planejado
3 > Aprovado
4 > Publicado Comunicação / Mapas
5 > Cancelado

*/		


ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include "globals.php";

function converterObjParaArray($data) { //função que transforma objeto vindo do json em array
	if(is_object($data)) {
		$data = get_object_vars($data);
	}
	if(is_array($data)) {
		return array_map(__FUNCTION__, $data);
	}else{
		return $data;
	}
}

function nocache(){
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Last Modified: '. gmdate('D, d M Y H:i:s') .' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	header('Pragma: no-cache');
	header('Expires: 0');

	
}

function checar($id){
	if($id == 1){
		echo " checked ";		
	}
}

function fillZero($string,$caracteres){
	return str_pad($string,$caracteres , '0', STR_PAD_LEFT);
}


function float2($number){
	if($number == NULL){
		return number_format(0, 2, '.', '');
	}else{	
		return number_format($number, 2, '.', '');
	}	
}

function exibeHoje(){
	$dia = date('d');
	$ano = date('Y');
	
	switch(date('m')){
		case '1':
		$mes = "Janeiro";
		break;
		case '2':
		$mes = "Fevereiro";
		
		break;
		case '3':
		$mes = "Março";
		
		break;
		case '4':
		$mes = "Abril";
		
		break;
		case '5':
		$mes = "Maio";
		
		break;
		case '6':
		$mes = "Junho";
		
		break;
		case '7':
		$mes = "Julho";
		
		break;
		case '8':
		$mes = "Agosto";
		
		break;
		case '9':
		$mes = "Setembro";
		
		break;
		case '10':
		$mes = "Outubro";
		
		break;
		case '11':
		$mes = "Novembro";
		
		break;
		case '12':
		$mes = "Dezembro";
		
		break;


		
	}
	
	return "$dia de $mes de $ano";
	
}

function retornaMes($m){

	switch($m){
		case '1':
		$mes = "Janeiro";
		break;
		case '2':
		$mes = "Fevereiro";
		
		break;
		case '3':
		$mes = "Março";
		
		break;
		case '4':
		$mes = "Abril";
		
		break;
		case '5':
		$mes = "Maio";
		
		break;
		case '6':
		$mes = "Junho";
		
		break;
		case '7':
		$mes = "Julho";
		
		break;
		case '8':
		$mes = "Agosto";
		
		break;
		case '9':
		$mes = "Setembro";
		
		break;
		case '10':
		$mes = "Outubro";
		
		break;
		case '11':
		$mes = "Novembro";
		
		break;
		case '12':
		$mes = "Dezembro";
		
		break;
	}
	return $mes;
		

}

function nuloZero($n){
	if($n == NULL){
		return 0;
	}else{
		return $n;
	}
}


function stringMesAno($data){
	
	$timestamp = strtotime($data); 
	return date('m/Y', $timestamp);

}


function saudacao(){ 
	$hora = date('H');
	if(($hora > 12) AND ($hora <= 18)){
		return "Boa tarde";	
	}else if(($hora > 18) AND ($hora <= 23)){
		return "Boa noite";	
	}else if(($hora >= 0) AND ($hora <= 4)){
		return "Boa noite";	
	}else if(($hora > 4) AND ($hora <=12)){
		return "Bom dia";
	}
}

function numeroSemana($date){
	return date("W", strtotime($date)); 
}

function nSemana($date){
	return date("w", strtotime($date)); 
}

//retira menu wp-admin
	
remove_action('init', 'wp_admin_bar_init');
add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
if (!current_user_can('administrator') AND !is_admin()) {
show_admin_bar(false);
}
  }


//soma(+) ou substrai(-) dias de um date(a-m-d)
function somarDatas($data,$dias){ 
	$data_final = date('Y-m-d', strtotime("$dias days",strtotime($data)));	
	return $data_final;
}

// só devolve o dia sem ano e mês
function ultimoDiaMes($ano,$mes){
	return date("t", mktime(0,0,0,$mes,'01',$ano));
}

function recuperaDados($tabela,$idEvento,$campo){ //retorna uma array com os dados de qualquer tabela. serve apenas para 1 registro.
	global $wpdb;
	$sql = "SELECT * FROM $tabela WHERE $campo = '$idEvento' LIMIT 0,1";
	$result = $wpdb->get_row($sql,ARRAY_A);
	if($result){
		return $result;
	}else{
		return $sql;
	}
}

// Retira acentos das strings
function semAcento($string){
	$newstring = preg_replace("/[^a-zA-Z0-9_.]/", "", strtr($string, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
	return $newstring;
}
function tirarAcentos($string){
	return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}


//retorna data d/m/y de mysql/date(a-m-d)
function exibirDataBr($data){ 
	$timestamp = strtotime($data); 
	return date('d/m/Y', $timestamp);
}

//retorna data mysql/date (a-m-d) de data/br (d/m/a)
function exibirDataMysql($data){ 
	list ($dia, $mes, $ano) = explode ('/', $data);
	$data_mysql = $ano.'-'.$mes.'-'.$dia;
	return $data_mysql;
}



function checado($x,$array){
	if (in_array($x,$array)){
		return "checked='checked'";		
	}
}

function valorPorExtenso($valor=0)
{
		//retorna um valor por extenso
	$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
	$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
	$c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
	$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
	$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
	$u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
	$z=0;
	$valor = number_format($valor, 2, ".", ".");
	$inteiro = explode(".", $valor);
	for($i=0;$i<count($inteiro);$i++)
		for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
			$inteiro[$i] = "0".$inteiro[$i];
		$rt = "";
		// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;) 
		$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
		for ($i=0;$i<count($inteiro);$i++)
		{
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
			$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
			$t = count($inteiro)-1-$i;
			$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($valor == "000")$z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t]; 
			if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}
		return($rt ? $rt : "zero");
	}


	function select($id,$sel){
		if($id == $sel){
			return "selected";			
		}	
	}
//retorna valor xxx,xx para xxx.xx
	function dinheiroDeBr($valor)
	{
		if($valor == NULL){
			return 0;	
		}else{
			$valor = str_ireplace(".","",$valor);
			$valor = str_ireplace(",",".",$valor);
			return $valor;
		}

	}
//retorna valor xxx.xx para xxx,xx
	function dinheiroParaBr($valor)
	{ 
		if($valor == NULL){
			return 0;	
		}else{
			$valor = number_format($valor, 2, ',', '.');
			return $valor;
		}
	}

// retorna datatime sem hora
	function retornaDataSemHora($data){
		$semhora = substr($data, 0, 10);
		return $semhora;
	}
	
//retorna data d/m/y de mysql/datetime(a-m-d H:i:s)	
	function exibirDataHoraBr($data){ 
		$timestamp = strtotime($data); 
		return date('d/m/y - H:i:s', $timestamp);	
	}
//retorna hora H:i de um datetime
	function exibirHora($data){
		$timestamp = strtotime($data); 
		return date('H:i', $timestamp);	
	}

//soma minutos

	function somaMinutos($hora,$minutos){
		return date("H:i",strtotime($hora." ".$minutos." minutes"));	
	}

//retorna o endereço da página atual
	function urlAtual(){ 
		$dominio= $_SERVER['HTTP_HOST'];
		$url = "http://" . $dominio. $_SERVER['REQUEST_URI'];
		return $url;
	}

	function retornaMascara($val, $mask)
	{
		$maskared = '';
		$k = 0;
		for($i = 0; $i<=strlen($mask)-1; $i++)
		{
			if($mask[$i] == '#')
			{
				if(isset($val[$k]))
					$maskared .= $val[$k++];
			}
			else
			{
				if(isset($mask[$i]))
					$maskared .= $mask[$i];
			} 
		}
		return $maskared;
	}

function gravarLog($log, $idUsuario){ //grava na tabela ig_log os inserts e updates
	global $wpdb;
	$logTratado = addslashes($log);
		//$idUsuario = $user->ID;
	
	if(isset($_SERVER['REMOTE_ADDR'])){ 
		$ip = $_SERVER["REMOTE_ADDR"];
	}else{
		$ip = "1.1.1.1";
	}
	
		//$ip = $_SERVER['REMOTE_ADDR'];
	
	
	$data = date('Y-m-d H:i:s');
	$sql = "INSERT INTO `sc_log` (`idUsuario`, `ip`, `data`, `query`) VALUES ('$idUsuario', '$ip', '$data', '$logTratado')";
	$wpdb->query($sql);
}
/*
	function diasemana($data)
	{
		$ano =  substr("$data", 0, 4);
		$mes =  substr("$data", 5, -3);
		$dia =  substr("$data", 8, 9);
		$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		switch($diasemana)
		{
			case"0": $diasemana = "Domingo";       break;
			case"1": $diasemana = "Segunda-Feira"; break;
			case"2": $diasemana = "Terça-Feira";   break;
			case"3": $diasemana = "Quarta-Feira";  break;
			case"4": $diasemana = "Quinta-Feira";  break;
			case"5": $diasemana = "Sexta-Feira";   break;
			case"6": $diasemana = "Sábado";        break;
		}
		return "$diasemana";
	}

function diasemanaint($data)
	{
		$ano =  substr("$data", 0, 4);
		$mes =  substr("$data", 5, -3);
		$dia =  substr("$data", 8, 9);
		$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		
		return $diasemana;
	}
*/	
	function noResend(){
		$p1 = $_SERVER["HTTP_REFERER"];
		$p2 = $_SERVER["QUERY_STRING"];
		echo $p1;
		header('Location:'.$p1, true, 301);
	}
	function mask($val, $tipo){
		
	//verifica se é só número
		if(is_float($val) == true){	
			$val = (string)$val;
		// prepara o tipo de mascara
			switch($tipo){
				case "cnpj": 
				$mask ='##.###.###/####-##';
				break;
				case "cpf":
				$mask = '###.###.###-##';
				break;
				case "cep":
				$mask ='#####-###';
				break;
				case "data":
				$mask ='##/##/####';
				break;
			}
			$maskared = '';
			$k = 0;
			for($i = 0; $i<=strlen($mask)-1; $i++)
			{
				if($mask[$i] == '#')
				{
					if(isset($val[$k]))
						$maskared .= $val[$k++];
				}
				else
				{
					if(isset($mask[$i]))
						$maskared .= $mask[$i];
				}
			}
		}else{
			$maskared = $val;
		}
		return $maskared;
	}

	function mesBr($m){
		switch ($m) {
			case "01":    $mes = 'Janeiro';     break;
			case "02":    $mes = 'Fevereiro';   break;
			case "03":    $mes = 'Março';       break;
			case "04":    $mes = 'Abril';       break;
			case "05":    $mes = 'Maio';        break;
			case "06":    $mes = 'Junho';       break;
			case "07":    $mes = 'Julho';       break;
			case "08":    $mes = 'Agosto';      break;
			case "09":    $mes = 'Setembro';    break;
			case "10":    $mes = 'Outubro';     break;
			case "11":    $mes = 'Novembro';    break;
			case "12":    $mes = 'Dezembro';    break; 
		}

		return $mes;
		
	}

	function vGlobais(){
		if(isset($_POST)){
			echo "POST";
			echo "<pre>";
			var_dump($_POST);
			echo "</pre>";
		}

		if(isset($_GET)){
			echo "GET";
			echo "<pre>";
			var_dump($_GET);
			echo "</pre>";	
		}
		if(isset($_SESSION)){
			echo "SESSION";
			echo "<pre>";
			var_dump($_SESSION);
			echo "</pre>";	
		}

		if(isset($_FILES)){
			echo "FILES";
			echo "<pre>";
			var_dump($_FILES);
			echo "</pre>";	
			
			
		}
		
		echo "SERVER";
		echo "<pre>";
		var_dump($_SERVER);
		echo "</pre>";

	}


	function buscaCep($cep){
		$url = "https://viacep.com.br/ws/".$cep."/json/";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$page = curl_exec($ch);
		$evento = json_decode($page);
		$ccsp = converterObjParaArray($evento);
		return $ccsp;
		
	}


	function retornaModulo($descricao){
		global $wpdb;
		$descricao = trim($descricao);	

		$sql = "SELECT * FROM sc_tipo WHERE descricao LIKE '$descricao' AND abreviatura = 'modulo'  AND publicado = '1' LIMIT 0,1";
		$res = $wpdb->get_row($sql,ARRAY_A);
		if($res == NULL){
			return NULL;
		}else{
			return $res;
		}
	}




	function geraTipoOpcao($abreviatura,$select = 0){
		global $wpdb;
		$sql = "SELECT * FROM sc_tipo WHERE abreviatura = '$abreviatura' AND publicado = 1 ORDER BY tipo ASC";
		$query = $wpdb->get_results($sql,ARRAY_A);
		for($i = 0; $i < count($query); $i++){
			if($select == $query[$i]['id_tipo']){
				if($query[$i]['ano_base'] != NULL){
					$ano_base = " (".$query[$i]['ano_base'].")";
				}else{
					$ano_base = "";
				}
				
				
				echo "<option value='".$query[$i]['id_tipo']."' selected >".$query[$i]['tipo'].$ano_base."</option>";
			}else{
				echo "<option value='".$query[$i]['id_tipo']."' >".$query[$i]['tipo'].$ano_base."</option>";
			}
		}		

	}

	function geraTipoOpcaoAno($abreviatura,$select = 0){
		global $wpdb;
		$sql = "SELECT * FROM sc_tipo WHERE abreviatura = '$abreviatura' AND publicado = 1 AND ano_base = '2019' ORDER BY tipo ASC";
		$query = $wpdb->get_results($sql,ARRAY_A);
		for($i = 0; $i < count($query); $i++){
			if($select == $query[$i]['id_tipo']){
				echo "<option value='".$query[$i]['id_tipo']."' selected >".$query[$i]['tipo']."</option>";
			}else{
				echo "<option value='".$query[$i]['id_tipo']."' >".$query[$i]['tipo']."</option>";
			}
		}		

	}
	

	function tipo($id){
		global $wpdb;
		$sql = "SELECT * FROM sc_tipo WHERE id_tipo = '$id'";
		$res = $wpdb->get_row($sql,ARRAY_A);
		if($res == NULL){
			$res['tipo'] = "";
			$res['descricao'] = "";
			return $res;
		}else{	
			return $res;
		}
	}

	function tipoId($string){
		global $wpdb;
		$sql = "SELECT id_tipo FROM sc_tipo WHERE tipo LIKE '$string'";
		//echo $sql;
		$res = $wpdb->get_row($sql,ARRAY_A);
		return $res['id_tipo'];
	}

	function retornaDot($id){
		
		global $wpdb;
		
		$sql = "SELECT * FROM sc_orcamento WHERE id = '$id'";
		
		$res = $wpdb->get_row($sql,ARRAY_A);
		
		return $res;

	
	}

/*
function proxQuinta($data){ // em Y-m-d
	$data = diasemanaint($data_se);
	if($data_se == 4{
		return $data;
	}else{
		while($data_se != 4){
			$data = somarDatas($data,"4");
		}

	
	}
	
	
}
*/	





function evento($id){

	global $wpdb;

	$sql =  "SELECT * FROM sc_evento WHERE idEvento = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	/*
	echo "<pre>";
	var_dump($programa);
	echo "</pre>";

	*/
	$programa = tipo($res['idPrograma']);
	if(!is_array($programa)){
		$programa['tipo'] = "";
	}
	
	$projeto = tipo($res['idProjeto']);
	if(!is_array($projeto)){
		$projeto['tipo'] = "";
	}
	$linguagem = tipo($res['idLinguagem']);
	if(!is_array($linguagem)){
		$linguagem['tipo'] = "";
	}

	$tipo_evento = tipo($res["idTipo"]);
	if(!is_array($tipo_evento)){
		$tipo_evento['tipo'] = "";
	}

	$usuario = get_userdata($res['idResponsavel']);
	if($usuario != NULL){
		$usercon = $usuario->first_name." ".$usuario->last_name;
	}else{
		$usercon = "";
	}
	$aprovacao = get_userdata($res['idRespAprovacao']);
	if($aprovacao != NULL){
		$user_aprovacao = $aprovacao->first_name." ".$aprovacao->last_name;
	}else{
		$user_aprovacao = "";
	}
	
	
	$etaria = tipo($res['faixaEtaria']);
	$periodo = periodo($res['idEvento']);
	
	$nomeEvento = $res['nomeEvento'];
	
	switch($res['status']){
		case 1:
		$status = "Rascunho";
		break;

		case 2:
		$status = "Planejado";
		break;

		case 3:
		$status = "Aprovado";
		break;

		case 4:
		$status = "Publicado Comunicação/Mapas";
		break;
		
		case 5:
		$status = "Cancelado";
		$nomeEvento = "[Cancelado] ".$nomeEvento;
		break;

		default:
		$status = "Não definido. Comunicar ao administrador do sistema.";	
		break;
	}
	
	//$status = retornaStatus($res['idEvento']);
	
	
	
	$local = retornaLocais($id);
	
	
	
	$evento = array(
		'titulo' => $nomeEvento,
		'idTipo' => $res['idTipo'],
		'programa' => $programa['tipo'],
		'projeto' => $projeto['tipo'],
		'linguagem' => $linguagem['tipo'],
		'responsavel' => $usercon,
		'autor' => $res['autor'],
		'grupo' => $res['nomeGrupo'],
		'ficha_tecnica' => $res['fichaTecnica'],
		'sinopse' => $res['sinopse'],
		'release' => $res['releaseCom'],
		'status' => $status,
		'usuario' => '',
		'responsavel' => $usercon,
		'idMapas' =>  $res['mapas'],
		'envio' => '',
		'periodo' => $periodo,
		'local' => $local,
		'faixa_etaria' => $etaria['tipo'],
		'valor_entrada' => '',
		'imagem' => '',
		'planejamento' => $res['planejamento'],
		'objeto' => $tipo_evento['tipo']." - ".$res['nomeEvento'],
		'tipo' => $tipo_evento['tipo'],
		'aprovacao' => $user_aprovacao,
		'revisado' => $res['revisado'],
		'dataEnvio' => $res['dataEnvio'],
		'previsto' => $res['previsto'],
		'artista_local' => $res['artista_local'],
		'cidade' => $res['cidade'],
		'n_agentes' => $res['n_agentes'],
		'n_agentes_abc' => $res['n_agentes_abc'],
		'descricao' => $res['descricao'],
		'url' => $res['url'],
		'online' => $res['online'],
		'convocatoria_edital' => $res['convocatoria_edital'],
		'ano_base' => $res['ano_base']

	);

	
	
	$evento['mapas'] = array(
		'id' => $res['mapas'],
		'name' => $res['nomeEvento'],
		'shortDescription' => substr($res['sinopse'],0,390)."...",
		'longDescription' => $res['descricao'],
		'classificaoEtaria' => $etaria['tipo'],
	);
	
	//ocorrências
	$sql_oc = "SELECT * FROM sc_ocorrencia WHERE idEvento = '$id' AND publicado = '1'";
	$res_oc = $wpdb->get_results($sql_oc,ARRAY_A);
	for($i = 0;$i < count($res_oc); $i++){
		$id_local = tipo($res_oc[$i]['local']);
		$x = json_decode($id_local['descricao'],ARRAY_A);
		$mapas_local = $x['mapas'];
		$evento['mapas']['ocorrencia'][$i]['spaceId'] = $mapas_local;
		$oc_legivel = ocorrencia($res_oc[$i]['idOcorrencia']);
		if($res_oc[$i]['dataFinal'] == '0000-00-00'){ // evento de data úntica

			$evento['mapas']['ocorrencia'][$i]['frequency'] = "once";			
			$evento['mapas']['ocorrencia'][$i]['startsOn'] = $res_oc[$i]['dataInicio'];
			$evento['mapas']['ocorrencia'][$i]['startsAt'] = substr($res_oc[$i]['horaInicio'],0,5);
			$evento['mapas']['ocorrencia'][$i]['duration'] = $res_oc[$i]['duracao'];
			$evento['mapas']['ocorrencia'][$i]['until'] = '';
			if($oc_legivel['descricao'] == ''){
				$evento['mapas']['ocorrencia'][$i]['description'] = $oc_legivel['data'];
			}else{
				$evento['mapas']['ocorrencia'][$i]['description'] = $oc_legivel['descricao'];
				
			}
			if($res_oc[$i]['valorIngresso'] == 0){
				$evento['mapas']['ocorrencia'][$i]['price'] = "Grátis";
			}else{
				$evento['mapas']['ocorrencia'][$i]['price'] = dinheiroParaBr($res_oc[$i]['valorIngresso']);
			}
		}else{

			$evento['mapas']['ocorrencia'][$i]['frequency'] = "weekly";			
			$evento['mapas']['ocorrencia'][$i]['startsOn'] = $res_oc[$i]['dataInicio'];
			$evento['mapas']['ocorrencia'][$i]['startsAt'] = substr($res_oc[$i]['horaInicio'],0,5);
			$evento['mapas']['ocorrencia'][$i]['duration'] = $res_oc[$i]['duracao'];
			$evento['mapas']['ocorrencia'][$i]['until'] = $res_oc[$i]['dataFinal'];
			if($oc_legivel['descricao'] == ''){
				$evento['mapas']['ocorrencia'][$i]['description'] = $oc_legivel['data'];
			}else{
				$evento['mapas']['ocorrencia'][$i]['description'] = $oc_legivel['descricao'];
				
			}
			if($res_oc[$i]['valorIngresso'] == 0){
				$evento['mapas']['ocorrencia'][$i]['price'] = "Grátis";
			}else{
				$evento['mapas']['ocorrencia'][$i]['price'] = dinheiroParaBr($res_oc[$i]['valorIngresso']);
			}
			
			$evento['mapas']['ocorrencia'][$i]['day'] = array();
			
			if($res_oc[$i]['domingo'] == 1){
				$evento['mapas']['ocorrencia'][$i]['day'][0] = 'on';
			}		
			if($res_oc[$i]['segunda'] == 1){
				$evento['mapas']['ocorrencia'][$i]['day'][1] = 'on';
			}		
			if($res_oc[$i]['terca'] == 1){
				$evento['mapas']['ocorrencia'][$i]['day'][2] = 'on';
			}		
			if($res_oc[$i]['quarta'] == 1){
				$evento['mapas']['ocorrencia'][$i]['day'][3] = 'on';
			}		
			if($res_oc[$i]['quinta'] == 1){
				$evento['mapas']['ocorrencia'][$i]['day'][4] = 'on';
			}		
			if($res_oc[$i]['sexta'] == 1){
				$evento['mapas']['ocorrencia'][$i]['day'][5] = 'on';
			}		
			if($res_oc[$i]['sabado'] == 1){
				$evento['mapas']['ocorrencia'][$i]['day'][6] = 'on';
			}		

			
			
		}
	}
	
	
	return $evento;
}


function metausuario($id){
	global $wpdb;
	$sql = "SELECT opcao FROM sc_opcoes WHERE entidade = 'usuario' AND id_entidade = '$id'";
	//echo $sql;
	$res = $wpdb->get_row($sql,ARRAY_A);
	return json_decode($res['opcao'],true);
}

function atividade($id){

	global $wpdb;

	$sql =  "SELECT * FROM sc_atividade WHERE id = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	/*
	echo "<pre>";
	var_dump($programa);
	echo "</pre>";

	*/
	$programa = tipo($res['idPrograma']);
	$projeto = tipo($res['idProjeto']);
	$usuario = get_userdata($res['idRes']);
	if($usuario){
		$u = $usuario->first_name." ".$usuario->last_name;
	}else{
		$u = "";
	}
	//$status = retornaStatus($res['idEvento']);
	
	$evento = array(
		'titulo' => $res['titulo'],
		'nome' => $res['titulo'],
		'objeto' => $res['titulo'],
		'periodo' => exibirDataBr($res['periodo_inicio'])." a ".exibirDataBr($res['periodo_fim']), 
		'tipoPessoa' => 'Pessoa jurídica',
		'programa' => $programa['tipo'],
		'projeto' => $projeto['tipo'],
		'responsavel' => $u,
		//'status' => $status['status'],
		'usuario' => ''
	);

	return $evento;
}



function ocorrencia($id){
	global $wpdb;
	
	
	$oc = $wpdb->get_row("SELECT * FROM sc_ocorrencia WHERE idOcorrencia = '$id'",ARRAY_A);
	
	
	if(($oc['dataInicio'] == $oc['dataFinal']) OR
		$oc['dataFinal'] == '' OR
		$oc['dataFinal'] == NULL OR
		$oc['dataFinal'] == '0000-00-00' 
	){
		$tipo = "Evento de Data Única";	
	$data =  exibirDataBr($oc['dataInicio'])." às ".substr($oc['horaInicio'],0,-3)." (".$oc['duracao']." minutos)";
	
}else if($oc['dataInicio'] != $oc['dataFinal'] ){
	$tipo = "Evento de temporada";
	$s = " ";
	if($oc['segunda'] == 1){
		$s .= "segunda, ";		
	}
	if($oc['terca'] == 1){
		$s .= "terca, ";		
	}
	if($oc['quarta'] == 1){
		$s .= "quarta, ";		
	}
	if($oc['quinta'] == 1){
		$s .= "quinta, ";		
	}
	if($oc['sexta'] == 1){
		$s .= "sexta, ";		
	}
	if($oc['domingo'] == 1){
		$s .= "sabado, ";		
	}
	if($oc['domingo'] == 1){
		$s .= "domingo, ";		
	}

	
	if($s != " "){
		$sem = "( ".substr($s,0,-2)." )";
	}else{
		$sem = "";
	}

	$data = "De ".exibirDataBr($oc['dataInicio'])." a ".exibirDataBr($oc['dataFinal'])." às ".substr($oc['horaInicio'],0,-3)." (".$oc['duracao']." minutos)".$sem;	
	
	
}

$local = tipo($oc['local']);

$ocorrencia = array(
	'tipo' => $tipo,
	'data' =>  $data,
	'local' => $local['tipo'],
	'descricao' => $oc['descricao']
);

return $ocorrencia;

}	

function geraOpcaoUsuario($select = NULL, $role = NULL){
	if($role == NULL){
		$x = '';
	}else{
		$x = "'role=$role'";
	}
	$blogusers = get_users( $x );
	// Array of WP_User objects.
	foreach ( $blogusers as $user ) {
		if($user->ID == $select){
			echo '<option value="'.esc_html( $user->ID ).'" selected>' . esc_html( $user->display_name ) . '</option>';
		}else{	
			echo '<option value="'.esc_html( $user->ID ).'">' . esc_html( $user->display_name ) . '</option>';
			
		}
	}	
	
}

function geraOpcaoDotacao($ano_base,$id = NULL){
	global $wpdb;
	$sql_orc = "SELECT * FROM sc_orcamento WHERE ano_base = '$ano_base' AND descricao IS NOT NULL AND publicado = '1' AND idPai = '0' ORDER BY projeto ASC, ficha ASC ";
	echo $sql_orc;
	$res = $wpdb->get_results($sql_orc,ARRAY_A);

	for($i = 0; $i < count($res) ; $i++){
		if($res[$i]['id'] == $id){
			echo "<option value = '".$res[$i]['id']."' selected > ".$res[$i]['projeto']."/".$res[$i]['ficha']." - ".$res[$i]['descricao']." </option>";
			//echo "<option>selected</option>";
		}else{
			echo "<option value = '".$res[$i]['id']."' > ".$res[$i]['projeto']."/".$res[$i]['ficha']." - ".$res[$i]['descricao']." </option>";
			//echo "<option>non-selected</option>";
		}	
		
	}
	
}

function verificaDataAgenda($data,$id,$hora,$local){
	global $wpdb;
	$sel = "SELECT idAgenda FROM sc_agenda WHERE data = '$data' AND hora = '$hora' AND idLocal = '$local' AND idEvento = '$id'";
	$res = $wpdb->get_results($sel,ARRAY_A);
	$num = $wpdb->num_rows;
	//echo $sel."<br />";

	return $num;
}

function insereAgenda($data,$id,$hora,$local,$log = false){
	global $wpdb;
	
		// limpa a ocorrencia na agenda
	$sql_ins = "INSERT INTO `sc_agenda` (`idEvento`, `data`, `hora`, `idLocal`) 
	VALUES ('$id', '$data', '$hora', '$local')"; 			
	$insere = $wpdb->query($sql_ins);
	if($log == true){var_dump($sql_ins)."<br />";};
	return $wpdb->insert_id;

}

function atualizarAgenda($id,$log = false){ //01
	global $wpdb;
	$sql_limpa =  "DELETE FROM `sc_agenda` WHERE idEvento = '$id'";
	$limpa = $wpdb->query($sql_limpa);
	$sql = "SELECT * FROM sc_ocorrencia WHERE idEvento = '$id' AND publicado = '1'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	if(count($res) > 0){ //02
		for($i = 0; $i < count($res); $i++){ //03
			if($res[$i]['dataFinal'] != '0000-00-00'){ // temporada //04
				$di = $res[$i]['dataInicio'];
				while(strtotime($di) < strtotime($res[$i]['dataFinal'])){
					if($log == true){ echo strtotime($di)." / ".strtotime($res[$i]['dataFinal'])."<br />"; }
					$n = nSemana($di);
					//echo $di."<br />";
					if($n == 0 AND $res[$i]['domingo'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
						if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$di." <br />";}
					}
					
					if($n == 1 AND $res[$i]['segunda'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
						if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$di." <br />";}
						
					}					
					if($n == 2 AND $res[$i]['terca'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
						if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$di." <br />";}
						
					}					
					if($n == 3 AND $res[$i]['quarta'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
						if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$di." <br />";}
						
					}					
					if($n == 4 AND $res[$i]['quinta'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
						if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$di." <br />";}
						
					}					
					if($n == 5 AND $res[$i]['sexta'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
						if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$di." <br />";}
						
					}					
					if($n == 6 AND $res[$i]['sabado'] == 1){
						$x = insereAgenda($di,$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
						if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$di." <br />";}
					}					
					$di = somarDatas($di,"+1");
				}	
			}else{ // data única //04
				$x = insereAgenda($res[$i]['dataInicio'],$res[$i]['idEvento'],$res[$i]['horaInicio'],$res[$i]['local'],$log);
				if($log == true){var_dump($x); echo " - idEvento: ".$id." / ".$res[$i]['dataInicio']." <br />";}

			}
			
		}//03
	}	
} //01 

function diasEfetivos($id){ //01
	global $wpdb;
	$sql = "SELECT * FROM sc_ocorrencia WHERE idEvento = '$id' AND publicado = '1'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	$ndias = 0;
	$minutos = 0;
	if(count($res) > 0){ //02
		for($i = 0; $i < count($res); $i++){ //03
			if($res[$i]['dataFinal'] != '0000-00-00'){ // temporada //04
				$di = $res[$i]['dataInicio'];

				while(strtotime($di) <= strtotime($res[$i]['dataFinal'])){
					$n = nSemana($di);
					//echo strtotime($di)." <= ".strtotime($res[$i]['dataFinal'])."($n)<br /> ";
					if($n == 0 AND $res[$i]['domingo'] == 1){
						$ndias++;
						$minutos = $minutos + $res[$i]['duracao'];
						//echo "domingo";
					}
					
					if($n == 1 AND $res[$i]['segunda'] == 1){
						$ndias++;
						$minutos = $minutos + $res[$i]['duracao'];

						
					}					
					if($n == 2 AND $res[$i]['terca'] == 1){
						$ndias++;
						$minutos = $minutos + $res[$i]['duracao'];


					}					
					if($n == 3 AND $res[$i]['quarta'] == 1){
						$ndias++;
						$minutos = $minutos + $res[$i]['duracao'];
					}					
					if($n == 4 AND $res[$i]['quinta'] == 1){
						$ndias++;
						$minutos = $minutos + $res[$i]['duracao'];

					}					
					if($n == 5 AND $res[$i]['sexta'] == 1){
						$ndias++;
						$minutos = $minutos + $res[$i]['duracao'];

					}					
					if($n == 6 AND $res[$i]['sabado'] == 1){
						$ndias++;
						$minutos = $minutos + $res[$i]['duracao'];
					}					
					$di = somarDatas($di,"+1");
				}	
			}else{ // data única //04
				$ndias++;
				$minutos = $minutos + $res[$i]['duracao'];
				
			}
			
		}//03
	}
	$tempo = array('dias' => $ndias, 'minutos' => $minutos);
	return $tempo;
} //01 

function orcamento($id,$fim = NULL,$inicio = NULL){

	global $wpdb;
	$sel = "SELECT valor,dotacao,descricao, projeto, ficha, natureza, fonte, ano_base FROM sc_orcamento WHERE id = '$id' AND publicado = '1'";
	$val = $wpdb->get_row($sel,ARRAY_A);
	if($fim == NULL){
		$fim = $val['ano_base']."-12-31";
	}
	if($inicio == NULL){
		$inicio = $val['ano_base']."-01-01";
	}

	
	// Contigenciado (286)
	$sel_cont	= "SELECT valor FROM sc_mov_orc WHERE tipo = '286' AND dotacao = '$id' AND data between '$inicio'  AND '$fim' AND publicado = '1'" ;
	$cont = $wpdb->get_results($sel_cont,ARRAY_A);
	$valor_cont = 0;
	for($i = 0; $i < count($cont); $i++){
		$valor_cont = $valor_cont + $cont[$i]['valor'];	
	}
	//echo $sel_cont;
	
	// Anulado (394)
	$sel_cont	= "SELECT valor FROM sc_mov_orc WHERE tipo = '394' AND dotacao = '$id' AND data between '$inicio'  AND '$fim' AND publicado = '1'" ;
	$cont = $wpdb->get_results($sel_cont,ARRAY_A);
	$valor_anul = 0;
	for($i = 0; $i < count($cont); $i++){
		$valor_anul = $valor_anul + $cont[$i]['valor'];	
	}
	
	
	// Descontigenciado (287)
	$sel_cont	= "SELECT valor FROM sc_mov_orc WHERE tipo = '287' AND dotacao = '$id' AND data between '$inicio'  AND '$fim' AND publicado = '1'" ;
	$cont = $wpdb->get_results($sel_cont,ARRAY_A);
	$valor_desc = 0;
	for($i = 0; $i < count($cont); $i++){
		$valor_desc = $valor_desc + $cont[$i]['valor'];	
	}
	

	// Suplemento (288)
	$sel_cont	= "SELECT valor FROM sc_mov_orc WHERE tipo = '288' AND dotacao = '$id' AND data between '$inicio'  AND '$fim' AND publicado = '1'" ;
	$cont = $wpdb->get_results($sel_cont,ARRAY_A);
	$valor_supl = 0;
	for($i = 0; $i < count($cont); $i++){
		$valor_supl = $valor_supl + $cont[$i]['valor'];	
	}
	
	// Histórico
	$sel_hist = "SELECT id, titulo,valor, descricao, tipo, idUsuario,data,idPedidoContratacao FROM sc_mov_orc WHERE dotacao = '$id' AND publicado = '1' ORDER BY id ASC ";
	$hist = $wpdb->get_results($sel_hist,ARRAY_A);
	
	// Histórico de Contratação com Data
	$sel_hist_data = "SELECT id, titulo,valor, descricao, tipo, idUsuario,data,idPedidoContratacao FROM sc_mov_orc WHERE dotacao = '$id' AND publicado = '1' AND data BETWEEN '$inicio' AND '$fim' AND tipo = '311' ORDER BY id ASC ";
	$hist_data = $wpdb->get_results($sel_hist_data,ARRAY_A);
	$total_liberado_data = 0;
	for($t = 0; $t < count($hist_data); $t++){
		$total_liberado_data = $total_liberado_data + $hist_data[$t]['valor'];
	}
	
	
	
	//evento e atividades - liberado (início)
	$valor_lib = 0;	
	$sql_lib = "SELECT valor FROM sc_contratacao WHERE dotacao = '$id' AND liberado <> '0000-00-00' AND nLiberacao <> '' AND publicado = '1' AND idEvento IN(SELECT idEvento FROM sc_evento WHERE cancelamento = 0 AND publicado = '1')";
	$lib = $wpdb->get_results($sql_lib,ARRAY_A);

	for($i = 0; $i < count($lib); $i++){
		$valor_lib = $valor_lib + $lib[$i]['valor'];	
	}

	$sql_lib2 = "SELECT valor FROM sc_contratacao WHERE dotacao = '$id' AND liberado <> '0000-00-00' AND nLiberacao <> '' AND publicado = '1' AND idAtividade IN(SELECT id FROM sc_atividade WHERE publicado = '1')";
	$lib2 = $wpdb->get_results($sql_lib2,ARRAY_A);
	for($k = 0; $k < count($lib2); $k++){
		$valor_lib = $valor_lib + $lib2[$k]['valor'];	
	}
		//evento e atividades - liberado (início)

	
	
	//planejado 
	
	$valor_pla_pf = 0;
	$valor_pla_pj = 0;
	$valor_pla = 0;
	/*
	$sql_pla_pf = "SELECT valor FROM sc_contratacao WHERE dotacao = '$id' AND tipoPessoa =  '1' AND idPessoa IN (SELECT DISTINCT Id_PessoaFisica FROM sc_pf WHERE CPF = '000.000.000-00') AND publicado = '1'";
	$pla_pf = $wpdb->get_results($sql_pla_pf,ARRAY_A);
	if(count($pla_pf) > 0){
		for($i = 0; $i < count($pla_pf); $i++){
			$valor_pla_pf = $valor_pla_pf + $pla_pf[$i]['valor'];	
		}
	}

	$sql_pla_pj = "SELECT valor FROM sc_contratacao WHERE dotacao = '$id' AND tipoPessoa =  '2' AND idPessoa IN (SELECT DISTINCT Id_PessoaJuridica FROM sc_pj WHERE CNPJ = '00.000.000/0000-00') AND publicado = '1'";
	$pla_pj = $wpdb->get_results($sql_pla_pj,ARRAY_A);
	if(count($pla_pj) > 0){
		for($k = 0; $k < count($pla_pj); $k++){
			$valor_pla_pj = $valor_pla_pj + $pla_pj[$k]['valor'];	
		}
	}

	
	*/
	
	//$sql_pla = "SELECT valor FROM sc_orcamento WHERE idPai = '$id' AND publicado = '1'";
	$sql_pla = "SELECT * FROM sc_orcamento, sc_tipo  WHERE idPai = '$id' AND sc_orcamento.publicado = '1' AND sc_tipo.publicado ='1' AND sc_tipo.id_tipo = sc_orcamento.planejamento";
	$pla = $wpdb->get_results($sql_pla,ARRAY_A);
	if(count($pla) > 0){
		for($i = 0; $i < count($pla); $i++){
			$valor_pla = $valor_pla + $pla[$i]['valor'];	
		}
	}
	

	
	$dotacao = array(
		'descricao' => $val['descricao'],
		'dotacao' => $val['dotacao'],
		'total' => 	$val['valor'],
		'contigenciado' => $valor_cont,
		'descontigenciado' => $valor_desc,
		'suplementado' => $valor_supl,
		'historico' => $hist,
		'historico_contratacao' => $hist_data,
		'total_liberado_data' => $total_liberado_data,
		'sql_data' => $sel_hist_data,
	'visualizacao' => $val['projeto']."/".$val['ficha'], //colocar natureza (importar de novo)
	'natureza' => $val['natureza']."/".$val['fonte'],	
	'liberado' => $valor_lib,
	'planejado' => $valor_pla,
	'anulado' => $valor_anul,
	'revisado' => ($val['valor']  - $valor_cont + $valor_desc + $valor_supl - $valor_anul), 
	'projeto' =>  $val['projeto'],
	'ficha' => $val['ficha'],
	'ano_base' => $val['ano_base']


);
	
	
	return $dotacao;
	
}

function historicoOrcamento($id){
	global $wpdb;
	$sel_hist = "SELECT id, titulo,valor, descricao, tipo, idUsuario,data FROM sc_mov_orc WHERE dotacao = '$id' AND '$inicio' <= data AND '$fim' >= data AND publicado = '1' ORDER BY data ASC ";
	$hist = $wpdb->get_results($sel_hist,ARRAY_A);
	
	$sel_con = "SELECT idPedidoContratacao,idEvento,idAtividade, valor, liberado, observacao FROM sc_contratacao WHERE dotacao = '$i' AND liberado <> '0000-00-00'";
	$con = $wpdb->get_results($sel_con,ARRAY_A);
	$k = count($hist);
	for($i = 0; $i < count($con) ; $i++){
		$x = retornaPedido($con[$i]['idPedidoContratacao']);
		
		$hist[$k]['id'] = $con[$i]['idPedidoContratacao'];
		$hist[$k]['titulo'] = $x['objeto']." - ".$x['obs'];
		$hist[$k]['valor'] = $con[$i]['valor'];
		$hist[$k]['descricao'] = "Contratação da Empresa/Pessoa: ".$x['nome']." para ".$x['objeto']." no período ". $x['periodo']." em ".$x['local'];
		$hist[$k]['tipo'] = "Liberação";
		$hist[$k]['idUsuario'] = "";
		$hist[$k]['data'] = $con[$i]['liberado'];
		$k++;
	}
	//asort($hist,)
	
	return $hist;
	
	
	
}


function atualizaHistorico($idPedidoContratacao){
	// Liberação = 311, Empenho = 395
	// liberado, empenhado
	$user = wp_get_current_user();
	global $wpdb;
	$x = retornaPedido($idPedidoContratacao);
	$sql_ver_mov = "SELECT * FROM sc_mov_orc WHERE idPedidoContratacao = '$idPedidoContratacao'";
	$res_ver_mov = $wpdb->get_row($sql_ver_mov,ARRAY_A);
	if($res_ver_mov == NULL){ //insere
		if($x['liberado'] != '0000-00-00'){
			$titulo = $x['objeto'];
			$idOrc = $x['idDot'];
			$data = $x['liberado'];
			$valor = dinheiroDeBr($x['valor']);
			$descricao = "Contratação de ".$x['nome_razaosocial']."( ".$x['cpf_cnpj']. ") para ".$x['objeto']." no período ".$x['periodo'];
			if($x['local'] != ''){
				$descricao .= " em ".$x['local'];
			}

			$id_user = $user->ID;
			
			$sql = "INSERT INTO `sc_mov_orc` (`titulo`, `tipo`,  `dotacao`, `data`, `valor`, `descricao`, `idUsuario`, `publicado`, `idPedidoContratacao`) VALUES ('$titulo', '311',  '$idOrc', '$data', '$valor', '$descricao', '$id_user', '1', '$idPedidoContratacao')";	
			$q = $wpdb->query($sql);
			if($q == 0){
				$q = $sql;
			}
		}
		
	}else{ // atualiza
		$id = $res_ver_mov['id'];
		$valor = dinheiroDeBr($x['valor']);
		$data = $x['liberado'];
		$idOrc = $x['idDot'];
		$descricao = "Contratação de ".$x['nome_razaosocial']."( ".$x['cpf_cnpj']. ") para ".$x['objeto']." no período ".$x['periodo'];
		if($x['local'] != ''){
			$descricao .= " em ".$x['local'];
		}
		if($x['liberado'] != '0000-00-00'){
			$sql = "UPDATE sc_mov_orc SET 
			valor = '$valor',
			data = '$data',
			dotacao = '$idOrc',
			descricao = '$descricao',
			publicado = '1'
			WHERE id = '$id'";
			$q = $wpdb->query($sql);
			if($q == 0){
				$q = $sql;
			}			
		}else{
			$sql = "UPDATE sc_mov_orc SET 
			publicado = '0'
			WHERE id = '$id'";
			$q = $wpdb->query($sql);
			if($q == 0){
				$q = $sql;
			}
		}
		
	}
	
	return $q;
}


/* Funções para Pedidos de Contratação */


function retornaPessoa($id,$tipo){
	global $wpdb;
	$x = array();
	if($tipo == 1){
		$sql = "SELECT * FROM sc_pf WHERE Id_PessoaFisica = '$id'";
		$res = $wpdb->get_row($sql,ARRAY_A);	
		$b = tipo($res['codBanco']);
		$codBanco = json_decode($b['descricao'],true);

		$x['nome'] = $res['Nome'];
		$x['cpf_cnpj'] = $res['CPF'];
		$x['tipoPessoa'] = "Pessoa Física";
		$x['email'] = $res['Email'];
		if($b['tipo'] != ""){
			$x['banco'] = "Banco: ".$b['tipo']." (".$codBanco['codBanco'].") / Agência: ".$res['agencia']." / Conta Corrente: ".$res['conta'];
		}else{
			$x['banco'] = "";
		}

		$x['telefone'] = $res['Telefone1'];
		//var_dump($res);
	}elseif($tipo == 2){
		$sql = "SELECT * FROM sc_pj WHERE Id_PessoaJuridica = '$id'";
		$res = $wpdb->get_row($sql,ARRAY_A);	
		$b = tipo($res['codBanco']);
		$codBanco = json_decode($b['descricao'],true);
		$x['nome'] = $res['RazaoSocial'];
		$x['cpf_cnpj'] = $res['CNPJ'];
		$x['tipoPessoa'] = "Pessoa Jurídica";
		$x['email'] = $res['Email'];
		if($b['tipo'] != ""){
		$x['banco'] = "Banco: ".$b['tipo']." (".$codBanco['codBanco'].") / Agência: ".$res['agencia']." / Conta Corrente: ".$res['conta'];
		}else{
			$x['banco'] = "";
		}
		
		$x['telefone'] = $res['Telefone1'];
	//var_dump($res);
	}
	else{
	}
	return $x;

}


function listaPedidos($id,$tipo){ //lista os pedidos de contratação de determinado pedido

	global $wpdb;

	switch($tipo){
		case 'evento':
		default:
		$sql = "SELECT idPedidoContratacao, tipoPessoa, idPessoa, valor, dotacao,nProcesso FROM sc_contratacao WHERE idEvento = '$id' AND publicado = '1'";
		break;
		case 'atividade' :
		$sql = "SELECT idPedidoContratacao, tipoPessoa, idPessoa, valor, dotacao,nProcesso FROM sc_contratacao WHERE idAtividade = '$id' AND publicado = '1'";
		break;		
	}
	
	
	$res = $wpdb->get_results($sql,ARRAY_A);
	$pedido = array();
	for($i = 0; $i < count($res); $i++){
		if($res[$i]['tipoPessoa'] == 1){
			$tipo = "Pessoa Física";
			$pessoa = retornaPessoa($res[$i]['idPessoa'],1);
			
			
		}elseif($res[$i]['tipoPessoa'] == 2){
			$tipo = "Pessoa Jurídica";
			$pessoa = retornaPessoa($res[$i]['idPessoa'],2);
		}
		else{
			$tipo = "Reserva de Valor (OUTROS)";
			$pessoa = retornaPessoa($res[$i]['idPessoa'],3);
		}

		$pedido[$i] = array(
			'idPedidoContratacao' => $res[$i]['idPedidoContratacao'],
			'tipo' => $tipo,
			'nome' => $pessoa['nome'],
			'valor' => $res[$i]['valor'],
			'idPessoa' => $res[$i]['idPessoa'],
			'cpf_cnpj' => $pessoa['cpf_cnpj'],
			'dotacao' => $res[$i]['dotacao'],
			'nProcesso' => $res[$i]['nProcesso']
		);
		
	}


	return $pedido;	
	
}

function periodo($id){ //retorna o período
	global $wpdb;
	$sql = "SELECT dataInicio, dataFinal, horaInicio FROM sc_ocorrencia WHERE publicado = '1' AND idEvento = '$id' ORDER BY dataInicio ASC";
	$res = $wpdb->get_results($sql,ARRAY_A);

	$x = array();
	if(count($res) == 0){ // não há ocorrências registradas
		$x['bool'] = FALSE;
		$x['legivel'] = "Não há ocorrências cadastradas.";
	}
	else if(count($res) == 1 AND $res[0]['dataFinal'] == '0000-00-00'){ // Evento de data única
		$x['bool'] = TRUE;
		$x['inicio'] = $res[0]['dataInicio'];
		$x['final'] = $res[0]['dataInicio'];
		$x['legivel'] = exibirDataBr($res[0]['dataInicio']);
		$x['horario'] = $res[0]['horaInicio'];
	}else{ // temporadas ou multiplas ocorrencias
		if(count($res) == 1){ // se for apenas uma ocorrência
			$x['bool'] = TRUE;
			$x['inicio'] = $res[0]['dataInicio'];
			$x['final'] = $res[0]['dataFinal'];
			$x['legivel'] = exibirDataBr($res[0]['dataInicio'])." a ".exibirDataBr($res[0]['dataFinal']) ;
		}else{ // comparar datas
			$x['bool'] = TRUE;
			$x['inicio'] = $res[0]['dataInicio'];
			
			$data = $res[0]['dataInicio'];
			for($i = 0; $i < count($res); $i++){
				if(strtotime($data) <= strtotime($res[$i]['dataInicio'])){
					$data = $res[$i]['dataInicio'];
				}
				if(strtotime($data) <= strtotime($res[$i]['dataFinal'])){
					$data = $res[$i]['dataFinal'];
				}
				
			}
			$x['final'] = $data;
			$x['legivel'] = exibirDataBr($res[0]['dataInicio'])." a ".exibirDataBr($data) ;	
			
			
			
			
			
			
			
		}
		
		
	}
	
	
	
	return $x;

}


function opcaoDados($tipo,$id){
	global $wpdb;
	$sql = "SELECT opcao FROM sc_opcoes WHERE entidade = '$tipo' AND id_entidade = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	if(is_array($res)){
		return json_decode($res['opcao'],true);
	}else{
		return NULL;
	}
	
}


function retornaPedido($id){
	global $wpdb;
	$sql_tipo = "SELECT idEvento, idAtividade FROM sc_contratacao WHERE idPedidoContratacao = '$id'";
	$res_tipo = $wpdb->get_row($sql_tipo,ARRAY_A);
	
	if($res_tipo['idEvento'] != 0){
		
		
		$sql = "SELECT valor, tipoPessoa, idPessoa, sc_evento.idEvento, idResponsavel, dotacao, valor, formaPagamento, empenhado, liberado, parcelas, observacao, nLiberacao, nProcesso,  sc_evento.dataEnvio, sc_evento.descricao  FROM sc_contratacao, sc_evento WHERE idPedidoContratacao = '$id' AND sc_evento.idEvento = sc_contratacao.idEvento ";
		$res = $wpdb->get_row($sql,ARRAY_A);
		$pessoa = retornaPessoa($res['idPessoa'],$res['tipoPessoa']);
		$objeto = evento($res['idEvento']);
		$periodo = periodo($res['idEvento']);
		$userwp = get_userdata($res['idResponsavel']);
		$metausuario = opcaoDados("usuario",$res['idResponsavel']);
		if(!isset($metausuario['cr'])){
			$metausuario['cr'] = "";
		}
		if(!isset($metausuario['telefone'])){
			$metausuario['telefone'] = "";
		}
		if(!isset($metausuario['funcao'])){
			$metausuario['funcao'] = "";
		}
		if(!isset($metausuario['departamento'])){
			$metausuario['departamento'] = "";
		}
		$dotac = recuperaDados("sc_orcamento",$res['dotacao'],"id");
		if(!is_array($dotac)){
			$dotac = array(
				'dotacao' => '',
				'ficha' => '',
				'projeto' => '',
				'fonte' => ''
			);
		}
		
		$local = retornaLocais($res['idEvento']);
		$end = retornaEndereco($res['tipoPessoa'],$res['idPessoa']);
		$status = "Em análise";
		if('0000-00-00' != $res['empenhado']){
			$status = 'Empenhado';
		}else if('0000-00-00' != $res['liberado']){
			$status = 'Liberado';
		}
		if($pessoa['tipoPessoa'] == 1){
			$pes = "Física";
		}else{
			$pes = "Jurídica";
		}
		
		if($userwp == NULL){
			$usuario = "";
		}else{
			$usuario = $userwp->display_name;
		}
		
		$x = array();
		$x['evento_atividade'] = 'evento';
		$x['id'] = $res['idEvento'];
		$x['nome'] = $pessoa['nome'];
		$x['objeto'] = $objeto['objeto'];	
		$x['autor'] = $objeto['autor'];
		$x['periodo'] = $periodo['legivel'];
		$x['usuario'] = $usuario;
		$x['area'] = $metausuario['departamento'];
		$x['cargo'] = $metausuario['funcao'];
		$x['tipoPessoa'] = $pessoa['tipoPessoa'];
		$x['pessoa'] = $pes;
		$x['nome_razaosocial'] = $pessoa['nome'];
		$x['cpf_cnpj'] = $pessoa['cpf_cnpj'];
		$x['cr'] = $metausuario['cr'];
		$x['idDot'] = $res['dotacao'];
		$x['cod_dotacao'] = $dotac['dotacao'];
		$x['ficha'] = $dotac['ficha'];
		$x['projeto'] = $dotac['projeto'];
		$x['despesa'] = "";
		$x['fonte'] = $dotac['fonte'];
		$x['telefone'] = $pessoa['telefone'];
		$x['conta_corrente'] = "";
		$x['contato_telefone'] = $metausuario['telefone'];
		$x['local'] = $local;
		$x['tipo'] = $objeto['tipo'];
		$x['end'] = $end;
		$x['email'] = $pessoa['email'];
		$x['valor'] = dinheiroParaBr($res['valor']);
		$x['valor_extenso'] = valorPorExtenso($res['valor']);
		$x['forma_pagamento'] = $res['formaPagamento'];
		$x['banco'] = $pessoa['banco'];
		$x['liberado'] = $res['liberado'];
		$x['empenhado'] = $res['empenhado'];
		$x['status'] = $status;
		$x['parcelas'] = $res['parcelas'];
		$x['obs'] = $res['observacao'];
		$x['nLiberacao'] = $res['nLiberacao'];
		$x['nProcesso'] = $res['nProcesso'];
		$x['dataEnvio'] = $res['dataEnvio'];
		$x['descricao'] = $res['descricao'];
		$x['titulo'] = $objeto['titulo'];	
		$x['ficha_tecnica'] = $objeto['ficha_tecnica'];
		$x['release'] = $objeto['release'];	
		return $x;
	}
	
	if($res_tipo['idAtividade'] != 0){
		$sql = "SELECT valor, tipoPessoa, idPessoa, sc_atividade.id, idRes, dotacao, valor, formaPagamento, empenhado, liberado, parcelas, observacao, nLiberacao, nProcesso, sc_contratacao.dataEnvio FROM sc_contratacao, sc_atividade WHERE idPedidoContratacao = '$id' AND sc_atividade.id = sc_contratacao.idAtividade";
		$res = $wpdb->get_row($sql,ARRAY_A);
		$pessoa = retornaPessoa($res['idPessoa'],$res['tipoPessoa']);
		$objeto = atividade($res['id']);
		$userwp = get_userdata($res['idRes']);
		if($userwp == NULL){
			$usuario = "";
		}else{
			$usuario = $userwp->first_name." ".$userwp->last_name;
		}
		$metausuario = opcaoDados("usuario",$res['idRes']);
		if(!isset($metausuario['cr'])){
			$metausuario['cr'] = "";
		}
		if(!isset($metausuario['telefone'])){
			$metausuario['telefone'] = "";
		}
		if(!isset($metausuario['funcao'])){
			$metausuario['funcao'] = "";
		}
		if(!isset($metausuario['departamento'])){
			$metausuario['departamento'] = "";
		}
		
		if($res['dotacao'] != NULL){
			$dotac = recuperaDados("sc_orcamento",$res['dotacao'],"id");
			if($dotac == NULL){
				$dotac['dotacao'] = "";
				$dotac['ficha'] = "";
				$dotac['projeto'] = "";
				$dotac['fonte'] = "";
			}	

		}else{
			$dotac['dotacao'] = "";
			$dotac['ficha'] = "";
			$dotac['projeto'] = "";
			$dotac['fonte'] = "";
		}
		
		$local = "";
		$end = retornaEndereco($res['tipoPessoa'],$res['idPessoa']);
		$status = "Em análise";
		
		$x = array();
		$x['evento_atividade'] = 'atividade';
		$x['id'] = $res['id'];
		$x['nome'] = $pessoa['nome'];
		$x['objeto'] = $objeto['objeto'];	
		$x['autor'] = "";
		$x['periodo'] = $objeto['periodo'];
		$x['usuario'] = $usuario;
		$x['area'] = $metausuario['departamento'];
		$x['cargo'] = $metausuario['funcao'];
		$x['tipoPessoa'] = $pessoa['tipoPessoa'];
		$x['pessoa'] = "Pessoa Jurídica";
		$x['nome_razaosocial'] = $pessoa['nome'];
		$x['cpf_cnpj'] = $pessoa['cpf_cnpj'];
		$x['cr'] = "";
		$x['idDot'] = $res['dotacao'];
		$x['cod_dotacao'] = $dotac['dotacao'];
		$x['ficha'] = $dotac['ficha'];
		$x['projeto'] = $dotac['projeto'];
		$x['despesa'] = "";
		$x['fonte'] = $dotac['fonte'];
		$x['telefone'] = $pessoa['telefone'];
		$x['conta_corrente'] = "";
		$x['contato_telefone'] = $pessoa['telefone'];
		$x['local'] = $local;
		$x['tipo'] = "";
		$x['end'] = $end;
		$x['email'] = $pessoa['email'];
		$x['valor'] = dinheiroParaBr($res['valor']);
		$x['valor_extenso'] = valorPorExtenso($res['valor']);
		$x['forma_pagamento'] = $res['formaPagamento'];
		$x['banco'] = $pessoa['banco'];
		$x['liberado'] = $res['liberado'];
		$x['empenhado'] = $res['empenhado'];
		$x['status'] = $status;
		$x['parcelas'] = $res['parcelas'];
		$x['obs'] = $res['observacao'];
		$x['integrantes'] = "";
		$x['nLiberacao'] = $res['nLiberacao'];
		$x['nProcesso'] = $res['nProcesso'];
		$x['dataEnvio'] = $res['dataEnvio'];
		return $x;	
	}
	
	
	
	
	
}

function opcoes($id,$entidade){
	global $wpdb;
	$sql = "SELECT * FROM sc_opcoes WHERE entidade = '$entidade' AND id_entidade = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	if(is_array($res)){
		$json = json_decode($res['opcao'],true);
	}else{
		$json = NULL;	
	}
	return $json;
}

function editaOpcoes($id_entidade,$entidade,$descricao){
	global $wpdb;
	$ex = opcoes($id_entidade,$entidade);

	if($ex != NULL){
		$desc_json = json_encode($descricao);
		$sql = "UPDATE sc_opcoes SET opcao = '$descricao' WHERE entidade = '$entidade' AND id_entidade = '$id_entidade'";
	}else{
		$desc_json = json_encode($descricao);
		$sql = "INSERT INTO `sc_opcoes` (`id`, `entidade`, `id_entidade`, `opcao`) VALUES (NULL, '$entidade', '$id_entidade', '$desc_json')";
	}
	$wpdb->query($sql);
	
}

function retornaUsuario($idUsuario){
	global $wpdb;
	$sql = "SELECT * FROM wordpress_users WHERE id = '$idUsuario'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	return $res;
}

function retornaTipo($id){
	global $wpdb;
	$sql = "SELECT * FROM sc_tipo WHERE id_tipo = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	return $res;
}

function retornaLocais($idEvento){
	global $wpdb;
	$sql = "SELECT DISTINCT local FROM sc_ocorrencia WHERE publicado = '1' AND idEvento = '$idEvento'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	$x = "";
	for($i = 0; $i < count($res) ; $i++){
		$t = tipo($res[$i]['local']);
		$x .= $t['tipo'].",";
		
	}
	return  substr($x, 0, -1);
	
}

function retornaCEP($cep){
	global $wpdb;
	$dados = array(
		'sucesso' => 0,
		'rua' => '',
		'bairro' => '',
		'cidade' => '',
		'estado' => '' 
	);
	$cep_index = substr($cep, 0, 5);
	$dados['sucesso'] = 0;
	$sql01 = "SELECT * FROM igsis_cep_cep_log_index WHERE cep5 = '$cep_index' LIMIT 0,1";
	$campo01 = $wpdb->get_row($sql01,ARRAY_A);
	if($campo01 != NULL){
		$uf = "igsis_cep_".$campo01['uf'];
		$sql02 = "SELECT * FROM $uf WHERE cep = '$cep'";
		$campo02 = $wpdb->get_row($sql02,ARRAY_A);
		if($campo02 != NULL){
		$n_inscritos = (is_array($campo02) ? count($campo02) : 0);
		if($n_inscritos > 0){
			$dados['sucesso'] = 1;
		}else{
			$dados['sucesso'] = 0;
		}
		$dados['rua']     = $campo02['tp_logradouro']." ".$campo02['logradouro'];
		$dados['bairro']  = $campo02['bairro'];
		$dados['cidade']  = $campo02['cidade'];
		$dados['estado']  = strtoupper($campo01['uf']);
	}
	}
	return $dados;
}


function retornaEndereco($tipo,$pessoa){
	global $wpdb;
	switch ($tipo){
		case 1:
		$sql = "SELECT CEP, Numero, Complemento FROM sc_pf WHERE Id_PessoaFisica = '$pessoa' ";
		$res = $wpdb->get_row($sql,ARRAY_A);
		$dados = retornaCEP($res['CEP']);
		
		$end = $dados['rua'].", ".$res['Numero']." - ".$res['Complemento']. " ".$dados['bairro']. " " .$dados['cidade']. " / ".$dados['estado']."<br />CEP:".$res['CEP'];
		
		return $end;
		
		break;		

		case 2:
		$sql = "SELECT CEP, Numero, Complemento FROM sc_pj WHERE Id_PessoaJuridica = '$pessoa' ";
		$res = $wpdb->get_row($sql,ARRAY_A);
		$dados = retornaCEP($res['CEP']);
		
		$end = $dados['rua'].", ".$res['Numero']." - ".$res['Complemento']. " ".$dados['bairro']. " " .$dados['cidade']. " / ".$dados['estado']."<br />CEP:".$res['CEP'];
		
		return $end;
		
		break;
		
	}
	
}

function resumoDotacao($dotacao){
	
	/*	[0]70
		[1]10
		[2].3
		[3].3
		[4].90
		[5].39
		[6].13
		[7].392
		[8].0072
		[9].2
		[10].189
		[11].01 

	*/
		global $wpdb;

	if(strlen($dotacao) > 5){ //veio inteiro
		$x = explode(".",$dotacao);
		$resumo = $x[0].$x[1].".".$x[2].$x[3].$x[4].$x[5].".".$x[10].".".$x[11];
		
	}else{ //veio o id
		$sql = "SELECT dotacao FROM sc_orcamento WHERE id = '$dotacao'";
		$res = $wpdb->get_row($sql,ARRAY_A);
		$x = explode(".",$res['dotacao']);
		$resumo = $x[0].$x[1].".".$x[2].$x[3].$x[4].$x[5].".".$x[10].".".$x[11];
	}
	return $resumo;
	
}

function parcela($id){
	global $wpdb;
	$sel = "SELECT * FROM sc_parcela WHERE idPedidoContratacao = '$id'";
	$res = $wpdb->get_results($sel,ARRAY_A);
	if(count($res) == 0){
		return NULL;
	}else{
		for($i = 0; $i < count($res); $i++){
			$x[$i+1] = $res[$i];
		}
		
		return $x;
	}
	
}




function verificaEvento($idEvento){
	/*
	Evento 
	Campos obrigatórios sc_evento:
		Nome do Evento
		Programa
		Projeto
		Linguagem
		Tipo de Evento
		Responsável
		Aprovação
		Autor
		Classificação
		Sinopse
		Cidade
		Número de Agentes envolvidos
		Número de Agentes envolvidos de Santo André e Região
		
	
	
	
	Ocorrência
	Campos obrigatórios sc_ocorrencia:
		Data 
		Se data final
			Dias da semana
		horário
		local
		
	
	Se existir contratação
		Campos obrigatórios
		Valor
		Dotação
		Justificativa
		Parecer Artístico
	*/
		
		global $wpdb;
		
		$relatorio = "";
		$r = 0;
		$evento = evento($idEvento);
		
		
		if($evento['titulo'] == "" OR $evento['titulo'] == NULL){
			$relatorio .= "O evento não possui título.<br />";
			$r++;	
		}

		if($evento['programa'] == "" OR $evento['programa'] == NULL){
			$relatorio .= "Não foi determinado um programa.<br />";
			$r++;	
		}

		if($evento['projeto'] == "" OR $evento['projeto'] == NULL){
			$relatorio .= "Não foi determinado um projeto.<br />";
			$r++;	
		}

		if($evento['linguagem'] == "" OR $evento['linguagem'] == ""){
			$relatorio .= "Não foi determinado uma linguagem.<br />";
			$r++;	
		}

		if($evento['responsavel'] == "" OR $evento['responsavel'] == ""){
			$relatorio .= "O evento não possui responsável.<br />";
			$r++;	
		}

		if($evento['aprovacao'] == "" OR $evento['aprovacao'] == ""){
			$relatorio .= "O evento não possui indicação de pessoa responsável pela aprovação.<br />";
			$r++;	
		}
		
			
		if($evento['faixa_etaria'] == "" OR $evento['faixa_etaria'] == "Escolha uma "){
			$relatorio .= "O evento não possui uma classificação etária.<br />";
			$r++;	
		}

		if($evento['sinopse'] == "" OR $evento['sinopse'] == ""){
			$relatorio .= "O evento não possui uma sinopse.<br />";
			$r++;	
		}

		if($evento['release'] == "" OR $evento['release'] == ""){
			$relatorio .= "O evento não possui um release.<br />";
			$r++;	
		}

		if($evento['ficha_tecnica'] == "" OR $evento['ficha_tecnica'] == ""){
			$relatorio .= "O evento não possui uma ficha técnica.<br />";
			$r++;	
		}



	// Trava de data
		/*$periodo = periodo($idEvento);
		$dias = opcaoDados("sistema",0);
		$hoje45 = somarDatas(date('Y-m-d'),$dias['dias']);*/
		


		
		
		
	/*
	if($evento['artista_local'] == 0){
		$relatorio .= "É preciso informar a origem do artista (local).<br />";
		$r++;	
	}	
	
	if($evento['n_agentes'] == 0){
		$relatorio .= "É preciso informar o número de agentes culturais envolvidos. Informe também o número de agentes culturais de Santo André e região<br />";
	}	
	*/
	
	//Ocorrencias
	$ocorrencias = periodo($idEvento);
	if($ocorrencias['bool'] == FALSE){
		$relatorio .= "O evento não possui ocorrências.<br />";
		$r++;
	}else{
		$sql_ocor = "SELECT * FROM sc_ocorrencia WHERE idEvento = '$idEvento' AND publicado = '1'";
		$res = $wpdb->get_results($sql_ocor,ARRAY_A);
		for ($i = 0; $i < count($res); $i++){
			if($res[$i]['local'] == 0){
				$relatorio .= "Há ocorrências sem locais.<br />";
				$r++;
			} 
			if($res[$i]['horaInicio'] == '00:00:00'){
				$relatorio .= "Há ocorrências sem hora de início.<br />";
				$r++;
			} 

			if($res[$i]['duracao'] == '0'){
				$relatorio .= "Há ocorrências sem duração.<br />";
				$r++;
			} 
		}
			//echo $hoje45." - ".$periodo['inicio'];
		/*$tipo = opcaoDados("sistema",0);
		if((strtotime($hoje45) > strtotime($periodo['inicio'])) AND !in_array($evento['idTipo'],$dias['tipo'])){ //700 reunião fechada, 57 reunião, 710 okupa cultura
			$relatorio .= "O início do evento está a menos de ".$dias['dias']." dias de hoje. Atualize a data do evento para que o sistema permita a mudança de status ou peça para o diretor de sua divisão para fazê-lo.<br />";
			$r++;	
		} */
	}

	$pedidos = listaPedidos($idEvento,'evento');	
	if(count($pedidos) > 0){
		//$relatorio .= "O evento possui pedidos de contratação.<br />";
		//$ped = retornaPedido($pedidos[$i]['idPedidoContratacao']);
		for($k = 0; $k < count($pedidos); $k++){
			if($pedidos[$k]['dotacao'] == NULL){
				$relatorio .= "Há pedidos de contratação sem dotação definida.<br />";
				$r++;
			}
			if($pedidos[$k]['valor'] == 0){
				$relatorio .= "Há pedidos de contratação sem valores definidos.<br />";
				$r++;
			}
			if($pedidos[$k]['nProcesso'] == NULL){
				$relatorio .= "Há pedidos de contratação sem número de processo definido.<br />";
				$r++;
			}

		}		
		
		

		
		
		
		
	}else{
		//$relatorio .= "O evento não possui pedidos de contratação.<br />";
		
	}
	
	
	$x['relatorio'] = $relatorio;
	$x['erros'] = $r;
	return $x;
	
	
	
}

function listaArquivos($entidade,$id){
	global $wpdb;
	$sql = "SELECT arquivo FROM sc_arquivo WHERE entidade ='$entidade' AND id = '$id' AND publicado = '1'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	return $res;
}

function retornaStatus($idEvento){
	global $wpdb;
	$sql = "SELECT dataEnvio FROM sc_evento WHERE idEvento = '$idEvento' AND planejamento = '0'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	$x = array(
		'status' => ''
	);
	if($res['dataEnvio'] == NULL){ // evento em elaboração
		$x['status'] = 'Em elaboração';
	}else{ // enviado
		$x['status'] = 'Publicado';		
	}
	return $x;
	
	
}





/* Fim das Funções para Pedidos de Contratação */


/* Editais */

function editais($usuario,$id = NULL){
	global $wpdb;
	$editais = array();
	
	if($id != NULL){
		$filtro = " AND id = '$id' ";		
	}else{
		$filtro =  "";	
	}
	$sql = "SELECT id, edital, id_mapas, avaliadores, fases FROM ava_edital WHERE publicado = '1' AND edital <> '' $filtro ";
	$res = $wpdb->get_results($sql);
	for($i = 0; $i < count($res); $i++){
		$editais[$i]['id'] = $res[$i]->id;
		$editais[$i]['titulo'] = $res[$i]->edital;	
		$editais[$i]['mapas'] = $res[$i]->id_mapas;
		$editais[$i]['fases']['quantidade'] = $res[$i]->fases;
		
		// lista as fases
		$sql_fase = "SELECT edital, fase, peso, inicio, fim FROM ava_fase WHERE edital = '".$editais[$i]['id']."'";
		$res_fase = $wpdb->get_results($sql_fase);
		
		
		for($k = 0; $k < count($res_fase); $k++){
			$editais[$i]['fases'][$k]['fase'] ['numero']= $res_fase[$k]->fase;
			$editais[$i]['fases'][$k]['fase']['peso'] = $res_fase[$k]->peso;
			$editais[$i]['fases'][$k]['fase']['inicio'] = $res_fase[$k]->inicio;
			$editais[$i]['fases'][$k]['fase']['fim'] = $res_fase[$k]->fim;
			$fim =  $res_fase[$k]->fim;
		}
		
		
		if(count($res_fase) == 0){
			$editais[$i]['periodo'] = "Não há fases cadastradas.";
		}else{
			$editais[$i]['periodo'] = "De ".exibirDataBr($editais[$i]['fases'][0]['fase']['inicio'])." a ".exibirDataBr($editais[$i]['fases'][count($res_fase) -1]['fase']['fim']);
			
		}
		
		
		// lista criterios
		
		
		
		
		
		
		
		
		
		
		
		
	}
	
	
	return $editais;
	
	

}


function retornaNota($inscricao,$criterio,$usuario){
	global $wpdb;
	$sql = "SELECT nota FROM ava_nota WHERE usuario = '$usuario' AND criterio = '$criterio' AND inscricao = '$inscricao'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	if(count($res) > 0){
		return $res['nota'];
	}else{
		return 0;
	}
	
}

function somaNotas($inscricao,$usuario,$edital){
	global $wpdb;
	$sql_soma = "SELECT nota FROM `ava_nota` WHERE inscricao = '$inscricao' AND usuario ='$usuario' AND edital = '$edital' ";
    $peso = "SELECT peso FROM `ava_criterios` WHERE edital ='$edital'";

	$res = $wpdb->get_results($sql_soma,ARRAY_A);
	$res2 = $wpdb->get_results($peso,ARRAY_A);

	$total = 0;
	if(count($res) > 0){
		for($i = 0; $i < count($res); $i++){
			$total = $total + ($res[$i]['nota']* $res2[$i]['peso']);
		} 
	}
	return $total;
}

function somaNotas2($inscricao,$usuario,$edital){
    global $wpdb;
    $sql_soma = "SELECT nota FROM `ava_nota` WHERE inscricao = '$inscricao' AND usuario ='$usuario' AND edital = '$edital' ";
    $peso = "SELECT peso FROM `ava_criterios` WHERE edital = '$edital' ";

    $res = $wpdb->get_results($sql_soma,ARRAY_A);
    $total = 0;
    if(count($res) > 0){
        for($i = 0; $i < count($res); $i++){
            $total = $total + $res[$i]['nota'];
        }
    }
    return $total;
}



function retornaAnotacao($inscricao,$usuario,$edital = NULL){
	global $wpdb;
	$sql_sel_obs = "SELECT anotacao FROM ava_anotacao WHERE usuario = '".$usuario."' AND inscricao = '".$inscricao."' AND edital = '$edital'";
	$res_obs = $wpdb->get_row($sql_sel_obs,ARRAY_A);
	return $res_obs['anotacao'];
}

function atualizaNota($inscricao,$edital){
	global $wpdb;
	$nota_total = 0;	
	
	// seleciona os pareceridas
	$sql_pareceristas = "SELECT DISTINCT usuario FROM ava_nota WHERE inscricao = '$inscricao'";
	$query_pareceristas = $wpdb->get_results($sql_pareceristas,ARRAY_A);
	$numero = count($query_pareceristas);
	
	if($numero != 0){
		
		for($k = 0; $k < $numero; $k++){
			$nota[$k] = somaNotas($inscricao,$query_pareceristas[$k]['usuario'],$edital);		
			$nota_total = $nota_total + $nota[$k];
		}
		
		$nota_total = $nota_total/$numero;
		$discrepancia = 0;
		if($numero == 2){
			$discrepancia = moduloAritimetica($nota[0] - $nota[1]);
		}
		
		
		
	//atualiza ranking
		$ver_ranking = "SELECT nota FROM ava_ranking WHERE inscricao = '$inscricao'";
		$query_ranking = $wpdb->get_results($ver_ranking,ARRAY_A);
		if(count($query_ranking) > 0){
			$update_ranking = "UPDATE ava_ranking SET nota = '$nota_total', discrepancia = '$discrepancia' WHERE inscricao = '$inscricao'";
			$wpdb->query($update_ranking);
			
		}else{
			$insert_ranking = "INSERT INTO `ava_ranking` (`id`, `inscricao`, `nota`, `edital`, `discrepancia`, `filtro`, `revisao`) VALUES (NULL, '$inscricao', '$nota_total', '$edital', '', '', '');";
			$wpdb->query($insert_ranking);
		}
		
	}
}

function atualizaNota2Fase($inscricao,$fase1,$fase2){
	global $wpdb;
	$nota_total = 0;	
	
	// seleciona os pareceridas
	$sql_pareceristas = "SELECT DISTINCT usuario FROM ava_nota WHERE inscricao = '$inscricao' AND edital = '$fase1'";
	$query_pareceristas = $wpdb->get_results($sql_pareceristas,ARRAY_A);
	$numero = count($query_pareceristas);
	if($numero != 0){
		
		$sql_soma = "SELECT nota FROM ava_nota WHERE inscricao ='$inscricao' AND edital='$fase1'";
		$soma = $wpdb->get_results($sql_soma,ARRAY_A);
		$total_nota = 0;
		for($i = 0; $i < count($soma); $i++){
			$total_nota = $total_nota + $soma[$i]['nota'];
		}	
		
		
		$nota_total = $total_nota/$numero;
		$discrepancia = 0;
		if($numero == 2){
		//$discrepancia = moduloAritimetica($nota[0] - $nota[1]);
		}
		
		$sql_2fase = "SELECT nota FROM ava_nota WHERE inscricao = '$inscricao' AND edital = '$fase2'";
		$res_2fase = $wpdb->get_row($sql_2fase,ARRAY_A);
		
		if(count($res_2fase) > 0){
			$nota_total = $nota_total + $res_2fase['nota'];
			var_dump($nota_total);
		}
		

		
	//atualiza ranking
		$update_ranking = "UPDATE ava_ranking SET nota = '$nota_total' WHERE inscricao = '$inscricao'";
		$x = $wpdb->query($update_ranking);
		if($x){
			return "Ranking atualizado.";
		}else{
			return "Erro ao atualizar ranking";
		}
		
	}
}

function moduloAritimetica($numero){
	if($numero < 0){
		return $numero*(-1);
	}else{
		return $numero;
	}
}

function retornaCriterio($id){
	global $wpdb;
	$sql = "SELECT * FROM ava_criterios WHERE id = '$id'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	return $res;
}

function valorNotaMax($inscricao,$usuario){
	global $wpdb;
	$sql = "SELECT nota,criterio FROM ava_nota WHERE inscricao = '$inscricao' AND usuario = '$usuario'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	for($i = 0;$i < count($res); $i++){
		$nota = $res[$i]['nota'];
		$x = retornaCriterio($res[$i]['criterio']);
		$corte = $x['nota_maxima'];
		if($nota > $corte){
			$sql_update = "UPDATE ava_nota SET nota = '$corte' WHERE inscricao = '$inscricao' AND usuario = '$usuario' AND criterio = '".$res[$i]['criterio']."'";
			$wpdb->query($sql_update);
		}
	}
}


function anotacao($inscricao,$edital){
	global $wpdb;
	$x = array();
	
	$sql_pareceristas = "SELECT DISTINCT usuario FROM ava_anotacao WHERE inscricao = '$inscricao' AND edital = '$edital'";
	$query_pareceristas = $wpdb->get_results($sql_pareceristas,ARRAY_A);
	$numero = count($query_pareceristas);
	
	if($numero != 0){
		
		for($k = 0; $k < $numero; $k++){
			$anotacao[$k] = retornaAnotacao($inscricao,$query_pareceristas[$k]['usuario'],$edital);		
			$x['pareceristas'][$k]['usuario'] = $query_pareceristas[$k]['usuario'];
			$x['pareceristas'][$k]['anotacao'] = $anotacao[$k];
		}
		

		return $x;
		
	}
}



function nota($inscricao,$edital){
	global $wpdb;
	$nota_total = 0;	
	$x = array();
	
	$sql_pareceristas = "SELECT DISTINCT usuario FROM ava_nota WHERE inscricao = '$inscricao' AND edital = '$edital'";
	$query_pareceristas = $wpdb->get_results($sql_pareceristas,ARRAY_A);
	$numero = count($query_pareceristas);
	
	if($numero != 0){
		
		for($k = 0; $k < $numero; $k++){
			$nota[$k] = somaNotas($inscricao,$query_pareceristas[$k]['usuario'],$edital);		
			$nota_total = $nota_total + $nota[$k];
			$x['pareceristas'][$k]['usuario'] = $query_pareceristas[$k]['usuario'];
			$x['pareceristas'][$k]['nota'] = $nota[$k];
		}
		
		$nota_total = $nota_total/$numero;
		$discrepancia = 0;

		if($numero == 2){
			$discrepancia = moduloAritimetica($nota[0] - $nota[1]);
			
		}

		$x['media'] = $nota_total;

		return $x;
		
	}
}

function retornaNotaTotal($inscricao,$usuario,$edital){
	global $wpdb;
	$nota = 0;
	$sql = "SELECT nota FROM ava_nota WHERE usuario = '$usuario' AND inscricao ='$inscricao' AND edital = '$edital'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	for($i = 0; $i < count($res); $i++){
		$nota = $nota + $res[$i]['nota'];
		
	}
	return $nota;
	
	
}

function retornaNota2Fase($inscricao,$fase2){
	global $wpdb;
	$sql = "SELECT nota FROM ava_nota WHERE inscricao = '$inscricao' AND edital = '$fase2'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	return $res['nota'];
}

function listarAvaliadores($inscricao){
	global $wpdb;
	$nota = "";
//	$sql = "SELECT DISTINCT usuario FROM ava_nota WHERE inscricao = '$inscricao'";
	$sql = "SELECT usuario  FROM `ava_nota` WHERE `inscricao` LIKE '$inscricao' AND `edital` = 273 ORDER BY `usuario` DESC";

	//$res = $wpdb->get_results($sql,ARRAY_A);
	$res_ava = $wpdb->get_results($sql,ARRAY_A);
	$x = "";	
	for($i = 0; $i < count($res_ava); $i++){
		if($x != $res_ava[$i]['usuario']){
			$wpuser = get_userdata($res_ava[$i]['usuario']);
			$nota = $nota . $wpuser->first_name." / ";
			$x = $res_ava[$i]['usuario'];
		}
	}
	return $nota;
}

function verificaAvaliacao($usuario,$edital){
	global $wpdb;
	$anotacao = 0;
	$zeradas = 0;
	$matriz = array();
	
	$tipo = 'usuario';
	$id = $usuario;
	$x = opcaoDados($tipo,$id);
	$g = $x['edital'][1];
	$sql_sel_ins = "SELECT avaliadores FROM ava_edital WHERE id_mapas = '$edital'";
	$sel = $wpdb->get_row($sql_sel_ins,ARRAY_A);
	$res = json_decode($sel['avaliadores'],true);
	

	
	$n_inscritos = (is_array($res[$g]) ? count($res[$g]) : 0);

	echo "<pre>";
	var_dump($g);
	echo "</pre>";

	for($i = 0; $i < $n_inscritos; $i++){ //roda as notas das inscrições
		$id_insc = $res[$g][$i];
		$y = retornaAnotacao($id_insc,$usuario,$edital);
		if($y == NULL OR $y == ""){
			$anotacao++;
		}
		$k = retornaNotaTotal($id_insc,$usuario,$edital);
		if($k == 0){
			$zeradas = $zeradas + 1;
		}
	}

	$matriz['zeradas'] = $zeradas;
	$matriz['anotacao'] = $anotacao;
	
	return $matriz;
	
}


function retornaInscricao($inscricao){
	global $wpdb;
	$sql = "SELECT filtro, descricao FROM ava_inscricao, ava_ranking WHERE ava_inscricao.inscricao = '$inscricao' AND ava_inscricao.inscricao = ava_ranking.inscricao";
	$res = $wpdb->get_row($sql,ARRAY_A);
	return $res;
	
}



/* Planejamento */

function anoOrcamento($ordem = NULL){
	
	global $wpdb;
	if($ordem != NULL){
		$ordem = " ORDER BY ano_base DESC";
	}else{
		$ordem = " ORDER BY ano_base ASC";
	}
	
	$sql = "SELECT DISTINCT ano_base FROM sc_orcamento WHERE ano_base <> '0' $ordem ";
	$res_ava = $wpdb->get_results($sql,ARRAY_A);
	return $res_ava;
}

function retornaPlanejamento($idPlan,$anobase){
    global $wpdb;
    $x = array();
    $x['bool'] = FALSE;
    $x['dotacao'] = 0;
    $x['valor'] = 0;
    $x['obs'] = "";
    $sql_ver = "SELECT id, valor, idPai, obs FROM sc_orcamento WHERE planejamento = '$idPlan' AND ano_base = '$anobase'";
    //echo $sql_ver;
    $res_ver = $wpdb->get_results($sql_ver,ARRAY_A);
    if(count($res_ver) > 0){
        $x['bool'] = TRUE;
        $x['dotacao'] = $res_ver[0]['idPai'];
        $x['valor'] = $res_ver[0]['valor'];
        $x['obs'] = $res_ver[0]['obs'];
    }

    return $x;

}



function orcamentoTotal($ano){
	global $wpdb;
	$sql_list =  "SELECT id FROM sc_orcamento WHERE publicado = '1' AND planejamento = '0' AND ano_base = '$ano' ORDER BY projeto ASC, ficha ASC";
	$res = $wpdb->get_results($sql_list,ARRAY_A);
	$total_orc = 0;
	$total_con = 0;
	$total_des = 0;
	$total_sup = 0;
	$total_anu = 0;
	$total_rev = 0;
	$total_tot = 0;
	$total_pla = 0;
	$total_lib = 0;
	$total_anul = 0;
	for($i = 0; $i < count($res); $i++){
		$orc = orcamento($res[$i]['id']);
		$total = $orc['total'] - $orc['contigenciado'] + $orc['descontigenciado'] + $orc['suplementado'] - $orc['liberado'] - $orc['anulado'];
		
		$total_orc = $total_orc + $orc['total'];
		$total_con = $total_con + $orc['contigenciado'];
		$total_des = $total_des + $orc['descontigenciado'];
		$total_sup = $total_sup + $orc['suplementado'];
		$total_anu = $total_anu + $orc['anulado'];
		$total_lib = $total_lib + $orc['liberado'];
		$total_rev = $total_rev + $orc['revisado'];
		$total_pla = $total_pla + $orc['planejado'];
		$total_anul = $total_anul + $orc['anulado'];	
				//$total_res = $total_res;
		$total_tot = $total_tot + $total;					
		
		
		
		
			} // fim do for	
			
			$sal_pla = $total_tot - $total_pla;
			
			$total_rev = $total_rev - projeto600($ano);

			$total_pla = $total_pla - projeto600planejamento($ano);		
			
			
			$x = array(
				'orcamento' => $total_orc,
				'contigenciado' => $total_con,
				'descontigenciado' => $total_des,
				'suplementado' => $total_sup,
				'anulado' => $total_anu,
				'liberado' => $total_lib,
				'revisado' => $total_rev,
				'planejado' => $total_pla,
				'total' => $total_tot
				
			);
			return $x;
			
		}

		function retornaCheck($inscricao){
			global $wpdb;
			$sql = "SELECT revisao FROM ava_ranking WHERE inscricao = '$inscricao'";
			$res = $wpdb->get_row($sql,ARRAY_A);
			return $res['revisao'];
			
		}

		/* funções css */

		function alerta($string,$tipo){ 
	// success, info, warning, danger
			return '<div class="alert alert-'.$tipo.'">'.$string.'</div>';
		}

//infraestrutura

		function insereAta($idEvento,$idAta,$qte){
			global $wpdb;
			$sql = "SELECT id,quantidade FROM sc_producao WHERE id_ata = '$idAta' AND id_evento = '$idEvento'";
			$x = $wpdb->get_results($sql,ARRAY_A);

	if(count($x) > 0){ //atualiza
		$sql_upd = "UPDATE sc_producao SET quantidade = '$qte' WHERE id = '".$x[0]['id']."'";	
		$wpdb->query($sql_upd);	
	}else{ //insere
		$sql_ins = "INSERT INTO sc_producao (id_ata,id_evento,quantidade) VALUES ('$idAta','$idEvento','$qte')";
		$wpdb->query($sql_ins);
	}
}

function recAta($idEvento,$idAta){
	global $wpdb;
	$sql = "SELECT id,quantidade FROM sc_producao WHERE id_ata = '$idAta' AND id_evento = '$idEvento'";
	$x = $wpdb->get_results($sql,ARRAY_A);
	if(count($x) > 0){
		return $x[0]['quantidade'];
	}else{
		return 0;
	}
}

function infraAta($idEvento){
	global $wpdb;
	$x = array();
	$geral = 0;	
	// distinct das empresas ()
	$sql_empresa = "SELECT DISTINCT pj FROM sc_ata";
	$emp = $wpdb->get_results($sql_empresa,ARRAY_A);
	for($i = 0; $i < count($emp); $i++){
		$empresa = retornaPessoa($emp[$i]['pj'],2);
		$x[$i]['id'] = $emp[$i]['pj'];
		$x[$i]['razao_social'] = $empresa['nome'];
		$x[$i]['cnpj'] = $empresa['cpf_cnpj'];	
		// soma valor
		$sql_soma = "SELECT * FROM sc_producao WHERE id_ata IN (SELECT id FROM sc_ata WHERE pj = '".$emp[$i]['pj']."') AND id_evento = '$idEvento'";
		$soma = $wpdb->get_results($sql_soma,ARRAY_A);
		$total = 0;
		for($k = 0; $k < count($soma); $k++){
			$sql_valor = "SELECT valor_diaria FROM sc_ata WHERE id = '".$soma[$k]['id_ata']."'";
			$valor = $wpdb->get_results($sql_valor,ARRAY_A);
			$total = $total + ($soma[$k]['quantidade'] * $valor[0]['valor_diaria']);
		}
		$x[$i]['total'] = $total;
		$geral = $geral + $total;



		
	}

	$x['total'] = $geral;
	return $x;
}

function retornaItemInfra($id){
	global $wpdb;
	$sql = "SELECT nome FROM sc_infra WHERE id = '$id'";
	$x = $wpdb->get_results($sql,ARRAY_A);
	return $x[0]['nome'];
	
}

function retornaInfra($idEvento){
	global $wpdb;
	$sql = "SELECT * FROM sc_producao WHERE id_evento = '$idEvento' AND quantidade <> '0'";
	$x = $wpdb->get_results($sql,ARRAY_A);
	$string = "";
	if(count($x) == 0){
		return NULL;
	}else{
		for($i = 0; $i < count($x); $i++){
			$string .= "+ ".retornaItemInfra($x[$i]['id_ata'])."(".$x[$i]['quantidade'].")<br />";
		}
		return $string;
	}
}

function retornaContabil($nProcesso){
	global $wpdb;
	$sql = "SELECT * FROM sc_contabil WHERE nProcesso LIKE '$nProcesso'";
	$x = $wpdb->get_results($sql,ARRAY_A);
	return $x;
	
	
	
}


function geraCampo($tipo,$nome,$titulo,$valor = ""){

	switch($tipo){
		case "text":
		echo "<label>".$titulo."</label>";
		echo "<input type='text' name='".$nome."' class='form-control' maxlength='120' id='inputSubject' placeholder='' value='".$valor."'/>";	
		echo "<br /><br />";
		break;

		case "textarea":
		echo "<label>".$titulo."</label>";
		echo '<textarea name="'.$nome.'" class="form-control" rows="10" placeholder="">'.$valor.'</textarea>';
		echo "<br /><br />";
		break;

		case "check":
		if($valor == 'on'){
			$check = ' checked ';
		}else{
			$check = '';
		}	
		
		echo '<input type="checkbox" name="'.$nome.'" '.$check.' /> '.$titulo;
		echo "<br /><br />";
		break;
	}
}

function insereProducao($campo,$valor,$idEvento){
	// verifica se existe 
	global $wpdb;
	$sql_ver = "SELECT id FROM sc_producao_ext WHERE id_lista_producao = '$campo' AND id_evento = '$idEvento'";
	$x = $wpdb->get_results($sql_ver,ARRAY_A);
	
	if(count($x) > 0){ //se existe, atualiza
		$sql_upd = "UPDATE sc_producao_ext SET valor = '$valor' WHERE id = '".$x[0]['id']."'";
		$wpdb->query($sql_upd);	
	}else{ // se não, insere
		$sql_ins = "INSERT INTO `sc_producao_ext` (`id`, `id_lista_producao`, `id_evento`, `valor`) VALUES (NULL, '$campo', '$idEvento', '$valor')";
		$wpdb->query($sql_ins);
	}
}

function recuperaProducao($campo,$idEvento){
	global $wpdb;
	$sql = "SELECT valor FROM sc_producao_ext WHERE id_lista_producao = '$campo' AND id_evento = '$idEvento'";
	$x = $wpdb->get_results($sql,ARRAY_A);
	if(count($x) > 0){
		return $x[0]['valor'];
	}else{
		return "";	
	}
	
}

function chamaAPI($url,$data){
	$get_addr = $url.'?'.http_build_query($data);
	$ch = curl_init($get_addr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$page = curl_exec($ch);
	$evento = json_decode($page,true);
	return $evento;
	echo $get_addr;
}

function retornaProducao($id){
	global $wpdb;
	$sql = "SELECT * FROM sc_lista_producao WHERE id = '$id'";
	$x = $wpdb->get_results($sql,ARRAY_A);

	
	
	if(count($x) == 1){
		$j = json_decode($x[0]['descricao'],true);
		$y = array(
			"tipo" => $x[0]['tipo'],
			"titulo" => $x[0]['titulo'],
			"descricao" => $j['descricao'],
			"type" => $j['tipo'],
			"name" => $j['nome']
		);
		return $y;
	}else{
		return false;
	}	
}

function producao($idEvento){
	global $wpdb;
	$producao = array();
	
	// producao
	$sql = "SELECT * FROM sc_producao_ext WHERE id_evento = '$idEvento'";
	$x = $wpdb->get_results($sql,ARRAY_A);
	return $x;
	
	
	
	// comunicacao
	
	// apoio
	
	
	
	
}



function somaPrograma($id,$ano){
	global $wpdb;
	$total = 0;
	$idPed = array();
	$sql_evento = "SELECT valor,idPedidoContratacao FROM sc_contratacao WHERE idEvento IN(SELECT idEvento FROM sc_evento WHERE idPrograma = '$id' AND publicado = '1' AND dataEnvio IS NOT NULL AND cancelamento = 0) AND nLiberacao <> '' AND ano_base = '$ano' AND liberado <> '0000-00-00' AND publicado ='1'";
	$evento = $wpdb->get_results($sql_evento,ARRAY_A);

	for($i = 0; $i < count($evento); $i++){
		$total = $total + $evento[$i]['valor'];
		
	}

	$sql_atividade = "SELECT valor,idPedidoContratacao FROM sc_contratacao WHERE idAtividade IN(SELECT id FROM sc_atividade WHERE idPrograma = '$id' AND publicado = '1') AND nLiberacao <> ''  AND liberado <> '0000-00-00' AND ano_base = '$ano' AND publicado ='1' ";
	$atividade = $wpdb->get_results($sql_atividade,ARRAY_A);

	for($k = 0; $k < count($atividade); $k++){
		$total = $total + $atividade[$k]['valor'];
	}
	
	if($id == 383){
		
		$total = $total + projeto600($ano);
		
	}
	
	$x['total'] = $total;
	$x['contador'] = count($evento) + count($atividade);

	return $x;
}

function somaProjeto($id,$ano){
	global $wpdb;
	$total = 0;
	$sql_evento = "SELECT valor FROM sc_contratacao WHERE idEvento IN(SELECT idEvento FROM sc_evento WHERE idProjeto = '$id' AND publicado = '1' AND cancelamento = 0 AND dataEnvio IS NOT NULL) AND ano_base = '$ano' AND nLiberacao <> ''";
	$evento = $wpdb->get_results($sql_evento,ARRAY_A);

	for($i = 0; $i < count($evento); $i++){
		$total = $total + $evento[$i]['valor'];
	}

	$sql_evento = "SELECT valor FROM sc_contratacao WHERE idAtividade IN(SELECT id FROM sc_atividade WHERE idProjeto = '$id' AND publicado = '1') AND ano_base = '$ano' AND nLiberacao <> ''";
	$evento = $wpdb->get_results($sql_evento,ARRAY_A);

	for($i = 0; $i < count($evento); $i++){
		$total = $total + $evento[$i]['valor'];
	}
	
	
	return $total;
}

function somaExecutado($projeto,$ficha,$ano){
	global $wpdb;
	$total = 0;
	$sql_executado = "SELECT v_empenho FROM sc_contabil WHERE projeto = '$projeto' AND ficha = '$ficha' AND ano = '$ano'";
	$executado = $wpdb->get_results($sql_executado,ARRAY_A);

	for($i = 0; $i < count($executado); $i++){
		$total = $total + $executado[$i]['v_empenho'];
	}
		
	return $total;
}

function giap($projeto,$ficha,$ano,$folha = FALSE){
	if($projeto == 600 AND $folha == TRUE AND $ano = 2018){
		$f = " AND nProcesso == '43313' ";		
	}elseif ($projeto == 600 AND $folha == TRUE AND $ano = 2019) {
		$f = " AND nProcesso == '24/2019' ";	
	}else{
		$f = "";
	}



	global $wpdb;
	$sql = "SELECT * FROM sc_contabil WHERE ficha = '$ficha' AND projeto = '$projeto' AND ano = '$ano' $f";
	$c = $wpdb->get_results($sql,ARRAY_A);
	$a = array(
		'v_empenho' => 0,
		'v_estorno' => 0,
		'v_anulado' => 0,
		'v_n_processado' => 0,
		'v_processado' => 0,
		'v_op' => 0,
		'v_op_baixado' => 0,
		'v_saldo' => 0
	);
	
	for($i = 0; $i < count($c); $i++){
		$a['v_empenho'] = $a['v_empenho'] + $c[$i]['v_empenho'];
		$a['v_estorno'] = $a['v_estorno'] + $c[$i]['v_estorno'];
		$a['v_anulado'] = $a['v_anulado'] + $c[$i]['v_anulado'];
		$a['v_n_processado'] = $a['v_n_processado'] + $c[$i]['v_n_processado'];
		$a['v_processado'] = $a['v_processado'] + $c[$i]['v_processado'];
		$a['v_op'] = $a['v_op'] + $c[$i]['v_op'];
		$a['v_op_baixado'] =  $a['v_op_baixado'] + $c[$i]['v_op_baixado'];
		$a['v_saldo'] = $a['v_saldo'] + $c[$i]['v_saldo'];
	}
	
	return $a;
	
}

function projeto600($ano){
	/*$_600_1116 = giap(600,1116,$ano); 
	$_600_1117 = giap(600,1117,$ano); 
	$_600_1118 = giap(600,1118,$ano); 
	$_600_1119 = giap(600,1119,$ano); 
	$pessoal = $_600_1116['v_op_baixado'] + $_600_1117['v_op_baixado'] + $_600_1118['v_op_baixado'] + $_600_1119['v_op_baixado'];*/
	global $wpdb;
	$sql = "SELECT SUM(valor) AS valor_total FROM sc_orcamento WHERE projeto = '600' AND publicado = '1' AND ano_base = '$ano'";
	$res = $wpdb->get_row($sql,ARRAY_A);
	

	return $res['valor_total'];
}


function projeto600planejamento($ano){
	global $wpdb;
	$sql = "SELECT valor FROM sc_orcamento WHERE  publicado = '1' AND idPai IN (SELECT id FROM sc_orcamento WHERE ano_base = '$ano' AND publicado = '1' AND projeto = '600') ";
	$res = $wpdb->get_results($sql,ARRAY_A);
	$total = 0;
	for($i = 0; $i < count($res) ; $i++){
		$total = $total + $res[$i]['valor'];
	}

	return $total;

}

//indicadores


/*
retorna número dos indicadores inseridos
os tipos são: 
	acervos // sc_ind_acervos
                    <th>Período</th> ok
                    <th>Público</th> ok 
                    <th>Nº Atividades</th> ok 
                    <th>Nº Atividades com Agentes Locais</th> ok
                    <th>Nº Agentes Culturais Locais Envolvidos</th>
                    <th>Nº Bairros</th>
                    <th>% Bairros da Cidade Atendidos (Ref. 112 bairros)</th>
                    <th>Nº Bairros Descentralizados</th>


	continuadas // sc_ind_continuadas
	biblioteca // sc_ind_biblioteca
	comunicacao // sc_ind_comunicacao
	convocatorias // sc_ind_convocatorias
	eventos // sc_indicadores
	incentivo // sc_ind_incentivo
	lazer // 
	orcamento // sc_ind_orcamento
	culturaz // sc_ind_culturaz
	redes // sc_indi_redes
	geral
*/



function indResumo($tipo,$ano){   

	global $wpdb;
	switch($tipo){
		case "eventos":
			for($i = 1; $i <= 12; $i++){ //meses
				$data_inicio = $ano."-".$i."-01";
				$data_fim = $ano."-".$i."-".ultimoDiaMes($ano,$i);
				$sql = "SELECT * FROM sc_indicadores WHERE periodoInicio BETWEEN '$data_inicio' AND '$data_fim' AND publicado = '1'";		
				$c = $wpdb->get_results($sql,ARRAY_A);
				echo $data_inicio." / ".$data_fim."<br />";	
				echo "<pre>";
				var_dump($c);
				echo "</pre>";
		
			}
		break;

	}
	
	
}

function indicadores($ano_base,$tipo,$projeto = NULL, $in_projeto = NULL ,$programa = NULL, $in_programa = NULL){
// in_projeto = NULL => IN ; in_projeto = TRUE => NOT IN 


	global $wpdb;

	$x = array();
	switch($tipo){
		
		
		//$dados = [];
		
		case "evento":
		
			$publico_ano = 0;
			// por projeto
			$sql_concatena_projetos = "";

			if($projeto != NULL){
				$sql_projetos = "SELECT idEvento FROM sc_evento WHERE idProjeto IN('$projeto') AND ano_base = '$ano_base' AND publicado = '1'";
				$res_projetos = $wpdb->get_results($sql_projetos,ARRAY_A);
				$projetos_string = "";
				for($i = 0; $i < count($res_projetos); $i++){
					$projetos_string .= $res_projetos[$i]['idEvento'].",";
				}
				if(count($res_projetos) == 0){
					$sql_concatena_projetos = "";
				}else{
					$projetos_string = substr($projetos_string, 0, -1);
					$sql_concatena_projetos = " AND idEvento IN($projetos_string) ";
				}
			}
			$sql_concatena_programas = "";
			if($programa != NULL){
				$sql_programas = "SELECT idEvento FROM sc_evento WHERE idPrograma IN('$programa') AND ano_base = '$ano_base' AND publicado = '1'";
				$res_programas = $wpdb->get_results($sql_programas,ARRAY_A);
				$programas_string = "";
				for($i = 0; $i < count($res_programas); $i++){
					$programas_string .= $res_programas[$i]['idEvento'].",";
				}
				if(count($res_programas) == 0){
					$sql_concatena_programas = "";
				}else{
					$programas_string = substr($programas_string, 0, -1);
					$sql_concatena_programas = " AND idEvento IN($programas_string) ";
				}
			}
		

			$sql_lista = "SELECT idEvento, valor, contagem, ndias FROM sc_indicadores WHERE ano_base = '$ano_base' AND publicado = '1' $sql_concatena_projetos $sql_concatena_programas";
			$res = $wpdb->get_results($sql_lista);	

			// por mês

			for($m = 1; $m < 13; $m++){
			// Público
			$sql_lista = "SELECT idEvento, valor, contagem, ndias FROM sc_indicadores WHERE ano_base = '$ano_base' AND publicado = '1' $sql_concatena_projetos";
				$data_inicial = $ano_base."-".str_pad($m, 2, 0, STR_PAD_LEFT)."-01";
				$ultimo_dia = ultimoDiaMes($ano_base,$m);
				$data_final = $ano_base."-".str_pad($m, 2, 0, STR_PAD_LEFT)."-".$ultimo_dia;
				$sql_data = " AND periodoInicio BETWEEN '$data_inicial' AND '$data_final' ";	
				$sql_lista = $sql_lista.$sql_data;
				$res_mes = $wpdb->get_results($sql_lista,ARRAY_A);
				$publico = 0;
				for($j = 0; $j < count($res_mes); $j++){
					if($res_mes[$j]['contagem'] == '2'){
						$total_parcial = $res_mes[$j]['ndias']*$res_mes[$j]['ndias'];
						$publico = $publico + $total_parcial;
						$publico_ano = $publico_ano + $total_parcial;
					}else{
						$publico = $publico + $res_mes[$j]['valor'];
						$publico_ano = $publico_ano + $res_mes[$j]['valor'];
					}
				}

			$sql_ocorrencia = "SELECT idEvento, artista_local, n_agentes_abc FROM sc_evento WHERE idEvento IN (SELECT DISTINCT idEvento FROM sc_ocorrencia WHERE
			(dataInicio >= '$data_inicial' AND dataFinal = '0000-00-00' AND dataInicio <= '$data_final')
			OR
			(dataInicio <= '$data_inicial' AND dataFinal >= '$data_final') OR
			(dataInicio <=	'$data_inicial' AND dataFinal <= '$data_final' AND dataFinal > '$data_inicial' AND dataFinal <> '0000-00-00') OR
			(dataInicio >= '$data_inicial' AND dataFinal >= '$data_final' AND dataInicio < '$data_final' AND dataFinal <> '0000-00-00') OR
			(dataInicio >= '$data_inicial' AND dataFinal <= '$data_final'  AND dataInicio > '$data_final' AND dataFinal < '$data_inicial' AND dataFinal <> '0000-00-00')   AND publicado = '1' $sql_concatena_projetos) AND status IN(3,4)";
			$res_eventos = $wpdb->get_results($sql_ocorrencia,ARRAY_A);	
			$n_atividades = count($res_eventos);
			
			$evento_agentes_locais = 0;
			$agentes_culturais_locais = 0;
			
			
			for ($k = 0; $k < count($res_eventos); $k++){
				//agentes locais 
				if($res_eventos[$k]['artista_local'] != 0 OR $res_eventos[$k]['n_agentes_abc'] != 0 ){
					$evento_agentes_locais ++;
				}
			
				$agentes_culturais_locais = $agentes_culturais_locais + $res_eventos[$k]['n_agentes_abc'];	
			}
			
			$sql_bairros = "SELECT DISTINCT local FROM sc_ocorrencia WHERE
			(dataInicio >= '$data_inicial' AND dataFinal = '0000-00-00' AND dataInicio <= '$data_final')
			OR
			(dataInicio <= '$data_inicial' AND dataFinal >= '$data_final') OR
			(dataInicio <=	'$data_inicial' AND dataFinal <= '$data_final' AND dataFinal > '$data_inicial' AND dataFinal <> '0000-00-00') OR
			(dataInicio >= '$data_inicial' AND dataFinal >= '$data_final' AND dataInicio < '$data_final' AND dataFinal <> '0000-00-00') OR
			(dataInicio >= '$data_inicial' AND dataFinal <= '$data_final'  AND dataInicio > '$data_final' AND dataFinal < '$data_inicial' AND dataFinal <> '0000-00-00') AND publicado = '1' $sql_concatena_projetos";
			//echo $sql_bairros."<br />";

			$res_local = $wpdb->get_results($sql_bairros,ARRAY_A);
			
			$n_bairros = array();
			$n_bairros_descentralizados = 0;
			for($k = 0;$k < count($res_local); $k++){
				$tipo = tipo($res_local[$k]['local']);
				$local = json_decode($tipo['descricao'],true);
				if(isset($local['bairro'])){
					$bairro = $local['bairro'];
					if(!in_array($bairro,$n_bairros) AND $bairro != NULL){
						array_push($n_bairros,$bairro);
					}
				}

			}

			$numero_bairros = count($n_bairros);
			if(in_array(578,$n_bairros)){
				$numero_bairros_descentralizados = count($n_bairros) - 1;
			}
			
			$porcentagem = round(($numero_bairros/112)*100,2);
			
				/*	
			echo "Período : $m <br />
                  Público: $publico<br /> 
                  Nº Atividades: $n_atividades<br /> 
                  Nº Atividades com Agentes Locais: $evento_agentes_locais <br />
                  Nº Agentes Culturais Locais Envolvidos: $agentes_culturais_locais <br />
                  Nº Bairros: $numero_bairros <br />
                  Bairros da Cidade Atendidos (Ref. 112 bairros) :$porcentagem <br />
                  Nº Bairros Descentralizados: $numero_bairros_descentralizados
				<br />
				  <br />
			

			";
	*/

			$x['mes'][$m] = array(
				'publico' => $publico,
				'n_atividades' => $n_atividades,
				'n_atividades_locais' => $evento_agentes_locais,
				'agentes_locais' => $agentes_culturais_locais,
				'n_bairros' => $numero_bairros,
				'bairros_atendidos' => $porcentagem,
				'n_bairros_descentralizados' => $numero_bairros_descentralizados,
				'id_bairros' => $n_bairros
				
			
			
			);
			
			
			}// final do mês

		
			// por ano
			
	

			$data_inicial = $ano_base."-01-01";
			$data_final = $ano_base."-12-31";

			$sql_ocorrencia = "SELECT idEvento, artista_local, n_agentes_abc FROM sc_evento WHERE idEvento IN (SELECT DISTINCT idEvento FROM sc_ocorrencia WHERE
			(dataInicio >= '$data_inicial' AND dataFinal = '0000-00-00' AND dataInicio <= '$data_final')
			OR
			(dataInicio <= '$data_inicial' AND dataFinal >= '$data_final') OR
			(dataInicio <=	'$data_inicial' AND dataFinal <= '$data_final' AND dataFinal > '$data_inicial' AND dataFinal <> '0000-00-00') OR
			(dataInicio >= '$data_inicial' AND dataFinal >= '$data_final' AND dataInicio < '$data_final' AND dataFinal <> '0000-00-00') OR
			(dataInicio >= '$data_inicial' AND dataFinal <= '$data_final'  AND dataInicio > '$data_final' AND dataFinal < '$data_inicial' AND dataFinal <> '0000-00-00')   AND publicado = '1' $sql_concatena_projetos) AND status IN(3,4)";
			
			$res_total = $wpdb->get_results($sql_ocorrencia,ARRAY_A);
		
			$total_evento = array();
			$evento_agentes_locais = 0;
			$agentes_culturais_locais = 0;

			for($k = 0; $k < count($res_total); $k++){
				$idEvento = $res_total[$k]['idEvento'];
						
				if(!in_array($idEvento,$total_evento)){
						array_push($total_evento,$idEvento);
					}		

			if($res_total[$k]['artista_local'] != 0 OR $res_total[$k]['n_agentes_abc'] != 0 ){
					$evento_agentes_locais ++;
				}					
	
			$agentes_culturais_locais = $agentes_culturais_locais + $res_total[$k]['n_agentes_abc'];	
	
			}
			
			$n_atividades = count($total_evento);
			
			$sql_bairros = "SELECT DISTINCT local FROM sc_ocorrencia WHERE
			(dataInicio >= '$data_inicial' AND dataFinal = '0000-00-00' AND dataInicio <= '$data_final')
			OR
			(dataInicio <= '$data_inicial' AND dataFinal >= '$data_final') OR
			(dataInicio <=	'$data_inicial' AND dataFinal <= '$data_final' AND dataFinal > '$data_inicial' AND dataFinal <> '0000-00-00') OR
			(dataInicio >= '$data_inicial' AND dataFinal >= '$data_final' AND dataInicio < '$data_final' AND dataFinal <> '0000-00-00') OR
			(dataInicio >= '$data_inicial' AND dataFinal <= '$data_final'  AND dataInicio > '$data_final' AND dataFinal < '$data_inicial' AND dataFinal <> '0000-00-00') AND publicado = '1' $sql_concatena_projetos";
			//echo $sql_bairros."<br />";

			$res_local = $wpdb->get_results($sql_bairros,ARRAY_A);
			
			$n_bairros = array();
			$n_bairros_descentralizados = 0;
			for($k = 0;$k < count($res_local); $k++){
				$tipo = tipo($res_local[$k]['local']);
				$local = json_decode($tipo['descricao'],true);
				if(isset($local['bairro'])){
					$bairro = $local['bairro'];
					if(!in_array($bairro,$n_bairros) AND $bairro != NULL){
						array_push($n_bairros,$bairro);
					}
				}

			}

			$numero_bairros = count($n_bairros);
			if(in_array(578,$n_bairros)){
				$numero_bairros_descentralizados = count($n_bairros) - 1;
			}
			
			$porcentagem = round(($numero_bairros/112)*100,2);
			



	$x['ano'] = array(
				'publico' => $publico_ano,
				'n_atividades' => $n_atividades,
				'n_atividades_locais' => $evento_agentes_locais,
				'agentes_locais' => $agentes_culturais_locais,
				'n_bairros' => $numero_bairros,
				'bairros_atendidos' => $porcentagem,
				'n_bairros_descentralizados' => $numero_bairros_descentralizados,
				'id_bairros' => $n_bairros
				
			
			
			);
	
			

		break;
	
		case "biblioteca": //$ano_base,$tipo,$projeto = NULL, $programa = NULL

		$x = array();
			
		// bairros
		$bairros = tipo(tipoId("Bibliotecas"));	
		$id_bairros = json_decode($bairros['descricao'],TRUE);
		//$locais = $ids['bairros'];
		//var_dump($locais);
		if(count($id_bairros) > 0){
			$loc = explode(",",$id_bairros['bairros']);
		}else{
			$loc = array();
		}
		
		$total_publico_central = 0;
		$total_publico_descentral = 0;
		$total_emprestimo_central = 0;
		$total_emprestimo_descentral = 0;	
		$total_socios_central = 0;
		$total_socios_descentral = 0;
		$total_itens_central = 0;
		$total_itens_descentral = 0;
		$total_novas_central = 0;
		$total_novas_descentral = 0;
		$total_nova_digital = 0;
		$total_downloads = 0;	
		$total_itens_digital = 0;
		// mes 

		for($m = 1; $m < 13; $m++){
				$data_inicial = $ano_base."-".str_pad($m, 2, 0, STR_PAD_LEFT)."-01";
				$ultimo_dia = ultimoDiaMes($ano_base,$m);
				$data_final = $ano_base."-".str_pad($m, 2, 0, STR_PAD_LEFT)."-".$ultimo_dia;			
				$sql_biblio = "SELECT * FROM sc_ind_biblioteca WHERE ano_base = '$ano_base' AND publicado = '1' AND periodo_inicio BETWEEN '$data_inicial' AND '$data_final'";
				$res = $wpdb->get_row($sql_biblio,ARRAY_A);

				if($res != NULL){

				$x["mes"][$m] = array(
					"periodo" => $ano_base."-".str_pad($m, 2, 0, STR_PAD_LEFT),
					"Público - Biblioteca Central"  => $res['pub_central'],
					"Público - Biblioteca Descentralizada" => $res['pub_ramais'] ,
					"Empréstimos - Biblioteca Central" => $res['emp_central']  ,
					"Empréstimos - Biblioteca Descentralizada" => $res['emp_ramais'],
					"Sócios - Biblioteca Central" =>  $res['soc_central'] ,
					"Sócios - Biblioteca Descentralizada" =>  $res['soc_ramais'] ,
					"Itens Acervo - Biblioteca Central" => $res['acervo_central'] ,
					"Itens Acervo - Biblioteca Descentralizada" => $res['acervo_ramais'] ,
					"Itens Acervo - Biblioteca Digital" =>  $res['acervo_digital'],
					"Novas Incorporações - Biblioteca Central" =>  $res['incorporacoes_central'],
					"Novas Incorporações - Biblioteca Descentralizada" =>  $res['incorporacoes_ramais'],
					"Novas Incorporações - Biblioteca Digital" => $res['incorporacoes_digital'] ,
					"Downloads - Digital" =>  $res['downloads']	

		);
		$total_publico_central = $total_publico_central + $res['pub_central'];
		$total_publico_descentral = $total_publico_descentral + $res['pub_ramais'];
		$total_emprestimo_central = $total_emprestimo_central + $res['emp_central'];
		$total_emprestimo_descentral = $total_emprestimo_descentral + $res['emp_ramais'];	
		$total_socios_central = $res['soc_central'];
		$total_socios_descentral = $res['soc_ramais'];
		$total_itens_central = $res['acervo_central'];
		$total_itens_descentral = $res['acervo_ramais'];
		$total_itens_digital = $res['acervo_digital'];
		$total_novas_central = $total_novas_central + $res['incorporacoes_central'];
		$total_novas_descentral = $total_novas_descentral +$res['incorporacoes_ramais'];
		$total_nova_digital = $total_nova_digital + $res['incorporacoes_digital'];
		$total_downloads = $total_downloads + $res['downloads'];	
				}		
		} // for do mês

		$x['ano'] = array(
			"periodo" => $ano_base,
			"Público - Biblioteca Central"  => $total_publico_central,
			"Público - Biblioteca Descentralizada" => $total_publico_descentral ,
			"Empréstimos - Biblioteca Central" => $total_emprestimo_central  ,
			"Empréstimos - Biblioteca Descentralizada" => $total_emprestimo_descentral,
			"Sócios - Biblioteca Central" =>  $total_socios_central ,
			"Sócios - Biblioteca Descentralizada" =>  $total_socios_descentral ,
			"Itens Acervo - Biblioteca Central" => $total_itens_central ,
			"Itens Acervo - Biblioteca Descentralizada" => $total_itens_descentral ,
			"Itens Acervo - Biblioteca Digital" =>  $total_itens_digital,
			"Novas Incorporações - Biblioteca Central" =>  $total_novas_central ,
			"Novas Incorporações - Biblioteca Descentralizada" =>  $total_novas_descentral,
			"Novas Incorporações - Biblioteca Digital" => $total_nova_digital ,
			"Downloads - Digital" =>  $total_downloads,
			"bairros" => $loc

		
		
		);
		break;


		case "incentivo": //$ano_base,$tipo,$projeto = NULL, $programa = NULL
			
			if(isset($projeto) AND $in_projeto == NULL){
				$sql_projeto = ' AND projeto IN ('.$projeto.') ';
			}elseif(isset($projeto) AND $in_projeto != NULL){
				$sql_projeto = ' AND projeto NOT IN ('.$projeto.') ';

			}else{
				$projeto = '';
			}
			
			if(isset($programa)){
				$sql_programa = ' AND programa IN ('.$programa.') ';
			}else{
				$sql_programa = '';
			}
			
			$sql_lista = "SELECT * FROM sc_ind_incentivo WHERE ocor_inicio BETWEEN '$ano_base-01-01' AND '$ano_base-12-31' AND publicado = '1' ".$sql_projeto." ".$sql_programa;
			$res_lista = $wpdb->get_results($sql_lista,ARRAY_A);

								$x['total']['all'] = 0;
								$x['sa']['all'] = 0;
								$x['vagas'] = 0;
								$x['atendidos'] = 0;
								$x['atividades'] = count($res_lista);
								$x['atividades_agentes_locais'] = 0;
								$x['agentes_locais'] = 0;
								$x['local'] = array();
								
			for($i = 0; $i < count($res_lista); $i++){
				if(!isset($x['total'][$res_lista[$i]['equipamento']])){
					$t = tipo($res_lista[$i]['equipamento']);
					$x['total'][$res_lista[$i]['equipamento']] = array(
					'nome' => $t['tipo'],
					'valor' => 0
					);
				}
				
				if(!isset($x['sa'][$res_lista[$i]['equipamento']])){

					$u = tipo($res_lista[$i]['equipamento']);
					$x['sa'][$res_lista[$i]['equipamento']] = array(
					'nome' => $u['tipo'],
					'valor' => 0
					);
				}		

				for($m = 1 ; $m < 13; $m++){
					if(!isset($x[$m]['atividades_agentes_locais'])){$x[$m]['atividades_agentes_locais'] = 0;}						
					if(!isset($x[$m]['agentes_locais'])){$x[$m]['agentes_locais'] = 0;}	
					if(!isset($x[$m]['atividades'])){$x[$m]['atividades'] = 0;}					
					if(!isset($x[$m]['total']['all'])){$x[$m]['total']['all'] = 0;}
					if(!isset($x[$m]['sa']['all'])){$x[$m]['sa']['all'] = 0;}					
					if(!isset($x[$m]['locais'])){$x[$m]['locais'] = array();}	
					if(!isset($x[$m]['bairros'])){$x[$m]['bairros'] = array();}	
					if(!isset($x[$m]['total'][$res_lista[$i]['equipamento']])){
						
						$v = tipo($res_lista[$i]['equipamento']);
						$x[$m]['total'][$res_lista[$i]['equipamento']] = array(
						'nome' => $v['tipo'],
						'valor' => 0
						);
						
					}	
				

					if(!isset($x[$m]['sa'][$res_lista[$i]['equipamento']]['valor'])){
						$w = tipo($res_lista[$i]['equipamento']);
						$x[$m]['sa'][$res_lista[$i]['equipamento']]= array(
						'nome' => $w['tipo'],
						'valor' => 0
						);
						
						}
					
					$mes = campoMes($m);
					$x[$m]['total']['all'] = $x[$m]['total']['all'] + $res_lista[$i][$mes];	
					$x['total']['all'] += $res_lista[$i][$mes];		

					$x[$m]['sa']['all'] = $x[$m]['sa']['all'] + $res_lista[$i][$mes."_sa"];	
					$x['sa']['all'] += $res_lista[$i][$mes."_sa"];		

					$x[$m]['total'][$res_lista[$i]['equipamento']]['valor'] += $res_lista[$i][$mes];	
					$x['total'][$res_lista[$i]['equipamento']]['valor'] += $res_lista[$i][$mes];		

					$x[$m]['sa'][$res_lista[$i]['equipamento']]['valor'] += $res_lista[$i][$mes."_sa"];	
					$x['sa'][$res_lista[$i]['equipamento']]['valor'] += $res_lista[$i][$mes."_sa"];		
						
					if($res_lista[$i][$mes] != 0){
						$x[$m]['atividades'] = $x[$m]['atividades'] + 1;
						$x[$m]['agentes_locais'] = $x[$m]['agentes_locais'] + $res_lista[$i]['santo_andre'];						
						array_push($x[$m]['locais'],$res_lista[$i]['equipamento']);	
						$x[$m]['bairros'] = retornaBairros($x[$m]['locais']);
						
					}else{
						$x[$m]['bairros'] = array(
						'n_bairros' => 0,
						'n_bairros_descentralizados' => 0,
						'id_bairro' => 0
						);
					}
					
					if($res_lista[$i][$mes] != 0 AND $res_lista[$i]['santo_andre'] > 0){
						$x[$m]['atividades_agentes_locais'] = $x[$m]['atividades_agentes_locais'] + 1;		
					}
					
					
				} // fim for do mês
				$x['vagas'] += $res_lista[$i]['vagas'] + $res_lista[$i]['rematriculas'];
				$x['atendidos'] += $res_lista[$i]['atendidos'];
				$x['agentes_locais'] += $res_lista[$i]['santo_andre'];
				if($res_lista[$i]['santo_andre'] > 0){
					$x['atividades_agentes_locais']++;
				}
				
				array_push($x['local'],$res_lista[$i]['equipamento']);	
						$x['bairros'] = retornaBairros($x['local']);
			}

	

			// atividades
			
			


		$x['preenchimento_vagas'] = number_format((($x['atendidos']/$x['vagas'])*100),2,',','.')." %";

		break;
	}
		
		

	
	
		return $x;
	
	
} 

function sanitizeString($str)
{
    return preg_replace('{\W}', '', preg_replace('{ +}', '_', strtr(
        utf8_decode(html_entity_decode($str)),
        utf8_decode('ÀÁÃÂÉÊÍÓÕÔÚÜÇÑàáãâéêíóõôúüçñ'),
        'AAAAEEIOOOUUCNaaaaeeiooouucn')));
}

function campoMes($mes){ //$mes é um int

		setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
		date_default_timezone_set('America/Sao_Paulo');
		return sanitizeString(utf8_encode(strftime('%B', mktime(0, 0, 0, $mes, 10))));
	
	
}



function dotacao($id){
	
}

function anoBaseIndicadores($tabela,$ano_base = NULL){
	global $wpdb;
	$sql = "SELECT DISTINCT ano_base FROM $tabela ORDER BY ano_base DESC";
	$res = $wpdb->get_results($sql,ARRAY_A);
	
	for($i = 0; $i < count($res); $i++){
		if($ano_base != NULL AND $res[$i]['ano_base'] == $ano_base){
			echo "<option value='".$res[$i]['ano_base']."' selected>".$res[$i]['ano_base']."</option>";
		}else{
			echo "<option value='".$res[$i]['ano_base']."'>".$res[$i]['ano_base']."</option>";
			
		}

	}
	
	return $res;
	
}



function geraOpcaoMeta($meta = NULL){
	global $wpdb;
	$sql = "SELECT DISTINCT meta FROM sc_plano_municipal ORDER BY meta ASC";
	$res = $wpdb->get_results($sql,ARRAY_A);
	$metas_validas = array();	
	
	for($i = 0;$i < count($res); $i++){
		if($meta == $res[$i]['meta']){
			echo "<option value='".$res[$i]['meta']."' selected>Meta ".$res[$i]['meta']."</option>";		
		}else{
			echo "<option value='".$res[$i]['meta']."'>Meta ".$res[$i]['meta']."</option>";				
		}
	}
	
}

function opcaoAnoBase($ano_base = NULL){
	global $wpdb;
	$sql = "SELECT DISTINCT ano_base FROM sc_tipo ORDER BY ano_base DESC";
	$res = $wpdb->get_results($sql,ARRAY_A);
	for($i = 0; $i < count($res); $i++){
		if($ano_base == $res[$i]['ano_base']){
			echo "<option value='".$res[$i]['ano_base']."' selected>".$res[$i]['ano_base']."</option>";		
		}else{
			echo "<option value='".$res[$i]['ano_base']."'>".$res[$i]['ano_base']."</option>";				
		}
	

	
	}
	
	
}

function orderMeta(){
	global $wpdb;
	$meta_valida = "";
	$sql = "SELECT DISTINCT meta FROM sc_plano_municipal ORDER BY meta ASC";
	$res = $wpdb->get_results($sql,ARRAY_A);
	for($i = 0; $i < count($res); $i++){
		$meta = $res[$i]['meta'];
		$sql_meta = "SELECT * FROM sc_plano_municipal WHERE meta = '$meta'  ORDER BY id DESC LIMIT 0,1";
		$res_meta = $wpdb->get_results($sql_meta,ARRAY_A);
		$meta_valida .= $res_meta[0]['id'].",";
	}
	return substr($meta_valida,0,-1);
}

function statusPlano($meta){
	global $wpdb;
	$x = array();
	$sql = "SELECT * FROM sc_plano_municipal_progressao WHERE meta = '$meta' AND publicado = '1' ORDER BY id DESC LIMIT 0,1";
	$res = $wpdb->get_row($sql,ARRAY_A);

	if($res == NULL){
		$x['execucao'] = 0;
		$x['status'] = "S/N";
		$x['data'] = "S/N";
		$x['relatorio'] = "S/N";
		$x['forum'] = "S/N";
	}else{
		$x['execucao'] = $res['execucao'];
		$t = retornaTipo($res['status']);
		$x['status'] = $t['tipo'];
		$x['status'] = $t['tipo'];
		$x['data'] = exibirDataBr($res['insert_date']);
		$x['relatorio'] = nl2Br($res['relatorio']);
		$x['forum'] = nl2br($res['analise_foruns']);

	}
	
	return $x;
}

function metaOrcamento($meta,$exibir = NULL){
	
	global $wpdb;
	$sql = "SELECT * FROM sc_orcamento WHERE meta = '$meta' AND publicado = '1'"; //planejamentos
	$res = $wpdb->get_results($sql,ARRAY_A);
	$ano = anoOrcamento();		
	$r = array();

	if($exibir == NULL){
		
		
	

	for($i = 0; $i < count($res); $i++){
		if($ano[$i] != 0){
			if(isset($r[$res[$i]['ano_base']])){	
				$r[$res[$i]['ano_base']] = $r[$res[$i]['ano_base']] + $res[$i]['valor'];
			}else{
				$r[$res[$i]['ano_base']] = $res[$i]['valor'];
			}
		}
	}


	}else{
		
	for($i = 0; $i < count($res); $i++){
		if($ano[$i] != 0){
			$pai = orcamentoPai($res[$i]['idPai']);
			
			$r[$i] = array(
			'valor' => $res[$i]['valor'],
			'projeto' => $pai['projeto'],
			'ficha' => $pai['ficha'],
			'ano_base' => $pai['ano_base'],
			);
			
		}
	}	
		
		
		
		
	}

	

	return $r;


	
	
	
}

function orcamentoPai($idPai){
	return recuperaDados("sc_orcamento",$idPai,"id");
	
}


function atualizaMetaOrcamento(){
	global $wpdb;
	$sql = "SELECT * FROM sc_tipo WHERE abreviatura = 'projeto' AND publicado = '1'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	for($i = 0; $i < count($res); $i++){
		$json = json_decode($res[$i]['descricao'],true);
		if(isset($json['meta'])){
			$sql_atualiza = "UPDATE sc_orcamento SET meta = '".$json['meta']."' WHERE planejamento = '".$res[$i]['id_tipo']."'";
			$wpdb->query($sql_atualiza);
		}
		
	//echo 	$res[$i]['id_tipo']."<br />";
	//echo "<pre>";
	//var_dump($json);
	//echo "</pre>";
	}
	
}

function local($local,$id = NULL){
	global $wpdb;
	
	
	
	
}

function geraMesOcorrencia($idEvento){
	global $wpdb;
	
	$sql = "SELECT * FROM sc_ocorrencia WHERE idEvento = '$idEvento' AND dataFinal <> '0000-00-00' AND publicado = '1'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	for($i = 0; $i < count($res); $i++){
		$inicio = $res[$i]['dataInicio'];
		$fim = $res[$i]['dataFinal'];
		
		if(isset($dataInicio)){
			if(strtotime($dataInicio) > strtotime($inicio)){
				$dataInicio = $inicio;
			}
			
		}else{
			$dataInicio = $inicio;
			
		}

		if(isset($dataFinal)){
			if(strtotime($dataFinal) > strtotime($fim)){
				$dataFinal = $fim;
			}
			
		}else{
			$dataFinal = $fim;
			
		}


	}
	
	$dateStart 		=  exibirDataBr($dataInicio);
	$dateStart 		= implode('-', array_reverse(explode('/', substr($dateStart, 0, 10)))).substr($dateStart, 10);
	$dateStart 		= new DateTime($dateStart);

	//End date
	$dateEnd 		= exibirDataBr($dataFinal);
	$dateEnd 		= implode('-', array_reverse(explode('/', substr($dateEnd, 0, 10)))).substr($dateEnd, 10);
	$dateEnd 		= new DateTime($dateEnd);

	//Prints days according to the interval
	$dateRange = array();
	while($dateStart <= $dateEnd){
		$dateRange[] = $dateStart->format('Y-m-d');
		$dateStart = $dateStart->modify('+1day');
	}
	
	$string_mes = [];	

	for($i = 0; $i < count($dateRange); $i++){
		if(!in_array(stringMesAno($dateRange[$i]),$string_mes)){
			array_push($string_mes,stringMesAno($dateRange[$i]));
		}
		
	}
	
	return $string_mes;
	
	
	
}

function listaLocaisOcorrencia($idEvento){
	global $wpdb;
	$sql = 'SELECT *
		FROM sc_ocorrencia
		WHERE idEvento = "'.$cod.'" 
		AND publicado = "1"';

		$res = $wpdb->get_results($sql);
		//echo "<pre>";
		//var_dump($res);
		//echo "</pre>";
		//echo $sql;
	for($i = 0; $i < count($res); $i++){
		$data = ocorrencia($res[$i]->idOcorrencia);
		$k[] = array(	
			'idOcorrencia'	=> $res[$i]->idOcorrencia,
			'data'			=> $data['local'],
		);
	}
	return $k;
}


function retornaBairros($locais){ // $bairros = array
	
			$n_bairros = array();
			$n_bairros_descentralizados = 0;
			for($k = 0;$k < count($locais); $k++){
				$tipo = tipo($locais[$k]);
				$local = json_decode($tipo['descricao'],true);
				if(isset($local['bairro'])){
					$bairro = $local['bairro'];
					if(!in_array($bairro,$n_bairros) AND $bairro != NULL){
						array_push($n_bairros,$bairro);
					}
				}

			}
			
			$numero_bairros = count($n_bairros);
			if(in_array(578,$n_bairros)){
				$numero_bairros_descentralizados = count($n_bairros) - 1;
			}else{
				$numero_bairros_descentralizados = count($n_bairros);
			}
			 $x['n_bairros'] = count($n_bairros);
			 $x['n_bairros_descentralizados'] = $numero_bairros_descentralizados;
			$x['id_bairro'] = $n_bairros;
			return $x;
	
}

function contaBairros($bairro,$conta_bairro){ //bairro array
	
	
	
	foreach($bairro as $b){
		if(!in_array($b,$conta_bairro)){
			array_push($conta_bairro,$b);
		}
	}
	
	return $conta_bairro;	
	
}

function fixAnoBase($tabela,$c_id,$c_data,$c_ano_base){ // nome da tabela, nome do campo id, nome do campo onde tem a data, nome do campo ano base
	global $wpdb;
	
	$sql = "SELECT $c_data,$c_id FROM $tabela";
	$res = $wpdb->get_results($sql,ARRAY_A);
	
	
	for($i = 0; $i < count($res); $i++){
		$ano_base = date_format(date_create($res[$i][$c_data]), 'Y');
		$id = $res[$i][$c_id];
		$upd = "UPDATE $tabela SET $c_ano_base = '$ano_base' WHERE $c_id = '$id'";
		$wpdb->query($upd);
	}
}

function orcamentoDataTotal($ano_base,$mes){
/*

+ Orçado = valor que vem da câmara (anual) ok
+ Contingenciado = valor que a prefeitura retém (mes/ano) ok
+ Descontigenciado = valor que a prefeitura libera do retido (mes/ano) ok
+ Anulado = valor que a prefeitura anula para sempre forever (mes/ano) ok 
+ Suplementado = valor que a prefeitura dá a mais sem estar no orçamento inicial (mes/ano) ok
+ Planejado (ano) ok 
+ Orçamento Municipal (ano) ok 
+ Percentual do orçamento da SC / prefeitura (ano) ok

+ Revisado/Disponibilizado = valor disponível de fato para ações ( Orçado - Contigenciado + Descontigenciado - Anulado + Suplementado - Folha de Pagamento ) sendo que o (Contigenciado >= Descontigenciado) (mes/ano) ok
+ Liberado/Comprometido =  liberações/empenhado (mes/ano) ok
+ Saldo Liberado/Disponível = Revisado - Liberado (quanto sobrou depois da prefeitura revisar e depois que a secretaria gastou) (mes/ano) ok
+ Comprometido em relação ao disponibilizado = (Comprometido / Orçado) *100 (mes/ano) ok
+ Percentual de execução planejado = (Liberado/planejado)*100 (mes/ano)

	*/



	global $wpdb;
	$inicio = $ano_base."-01-01";
	$fim = $ano_base."-".fillZero($mes,2)."-".ultimoDiaMes($ano_base,$mes);

	$orcamento = array();	

	$tipos = array(
		'contingenciado' => 286,
		'descontingenciado' => 287,
		'anulado' => 394,
		'suplementado' => 288,
		'liberado' => 311

	);

	// sc_orcamento - orçado
	$sql = "SELECT SUM(valor) AS valor_total FROM sc_orcamento WHERE ano_base = '$ano_base' AND publicado = '1' AND idPai = '0' AND planejamento = '0'";

	$res = $wpdb->get_row($sql,ARRAY_A);
	
	$orcamento['periodo'] = $ano_base."/".fillZero($mes,2);
	$orcamento['orcado'] = number_format($res['valor_total'],2,'.', '');

	//movimentações
	foreach($tipos as $key =>$orca){
		//echo $key." / ".$orca;
		// contingenciado
		$sql = "SELECT SUM(valor) AS valor_total FROM sc_mov_orc WHERE 
		publicado = '1' 
		AND tipo = '$orca'
		AND data between '$inicio' AND '$fim' 
		AND dotacao IN (SELECT id FROM sc_orcamento WHERE ano_base = '$ano_base' AND publicado ='1' AND idPai = '0' AND planejamento = '0')";

		$res = $wpdb->get_row($sql,ARRAY_A);
		$orcamento[$key] = float2($res['valor_total']);
	}


	$orcamento['revisado'] = $orcamento['orcado'] - $orcamento['contingenciado'] + $orcamento['descontingenciado'] - $orcamento['anulado'] + $orcamento['suplementado'] - projeto600($ano_base);

	$orcamento['revisado'] = float2($orcamento['revisado']);


	$orcamento['disponivel'] = $orcamento['revisado'] - $orcamento['liberado'];


	// planejado

	$sql_plan = "SELECT SUM(valor) AS valor_total FROM sc_orcamento WHERE ano_base = '$ano_base' AND publicado ='1' AND idPai <> '0' AND planejamento <> '0'";
	$res = $wpdb->get_row($sql_plan,ARRAY_A);
	$orcamento['planejado'] = $res['valor_total'] - projeto600planejamento($ano_base);

	// orcamento municipal
	
	$sql_orc_mun = "SELECT descricao FROM sc_tipo WHERE abreviatura = 'orcamento_municipal' AND tipo LIKE '$ano_base'";
	$res = $wpdb->get_row($sql_orc_mun,ARRAY_A);
	$orcamento['municipal'] = $res['descricao'];

	// secretaria_prefeitura

	$orcamento['secretaria_prefeitura'] = round(($orcamento['orcado']/$orcamento['municipal'])*100,2);

	// liberado_revisado

	$orcamento['liberado_revisado'] = round(($orcamento['liberado']/$orcamento['revisado'])*100,2);

	// liberado_planejado

	$orcamento['liberado_planejado'] = round(($orcamento['liberado']/$orcamento['planejado'])*100,2);

	// orcado_s_folhadepagamento

	$orcamento['orcado_s_folhadepagamento'] = $orcamento['orcado'] - projeto600($ano_base);

	$orc_base = array(
		"periodo"=>$orcamento['periodo'],
		"orcado" =>dinheiroParaBr($orcamento['orcado']),
		"contingenciado"=>dinheiroParaBr($orcamento['contingenciado']),
		"descontingenciado"=>dinheiroParaBr($orcamento['descontingenciado']),
		"anulado"=>dinheiroParaBr($orcamento['anulado']),
		"suplementado"=>dinheiroParaBr($orcamento['suplementado']),
		"liberado"=>dinheiroParaBr($orcamento['liberado']),
		"revisado"=>dinheiroParaBr($orcamento['revisado']),
		"disponivel"=>dinheiroParaBr($orcamento['disponivel']),
		"planejado"=>dinheiroParaBr($orcamento['planejado']),
		"municipal"=>dinheiroParaBr($orcamento['municipal']),
		"secretaria_prefeitura"=>$orcamento['secretaria_prefeitura']."%",
		"liberado_revisado"=>$orcamento['liberado_revisado']."%",
		"liberado_planejado"=>$orcamento['liberado_planejado']."%",
		"orcado_s_folhadepagamento"=>dinheiroParaBr($orcamento['orcado_s_folhadepagamento']),
	



	);
	return $orc_base;


	//return $orcamento;





}

function comparaProcesso($nProcesso){
	global $wpdb;
	$sql = "SELECT idPedidoContratacao FROM sc_contratacao WHERE nProcesso LIKE '%$nProcesso%'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	//echo "<pre>";	
	//var_dump($res);
	//echo "</pre>";
}