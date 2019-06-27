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

global $wpdb;

// Lista de Aprovados
$x = array("on-585853776","on-871045798");

// Cria uma string para verificação
$y = "";
foreach($x as $value){
	$y .= $value.",";
}
$y = substr($y,0,-1);


for($i = 0; $i < count($x); $i++){
	// verifica se já o evento na base;
	$sql_verifica = "SELECT idEvento FROM sc_evento WHERE mapas IN($y)";
	$ver = $wpdb->get_results($sql_verifica);
	
	// não existe, insere
	if(count($ver) == 0){ 
		$ins = retornaInscricao($x[$i]);
		//var_dump($ins);
		$n_inscricao = $x[$i];
		$cat = $ins['filtro'];
		$ins_json = json_decode($ins['descricao'],ARRAY_A);
		//echo "<pre>";
		//var_dump();
		//echo "</pre>";
		$nome_evento = $ins_json['3.1 - Título'];
		$programa = 25;
		$projeto = 322;
		$responsavel = ""; //id do moretto
		$suplente = ""; //id do kedley
		$autor = "";
		$ficha_tecnica = $ins_json['1.2 - Discriminar os integrantes do grupo'];
		$sinopse = $ins_json['3.6 - Sinopse do evento'];
		$links = $ins_json['3.14 - Referências']."".$ins_json['1.4 - Referências'];
		$release = $ins_json['1.4 - Resumo Currículo Grupo / Coletivo / Agente Cultural']." /n ".$ins_json['3.5 – Release e objetivo principal:']."".$ins_json['3.12 – Justificativa para a existência de sua proposta/ Resultados esperados com a execução / Relação com o local:'];
		
		echo $nome_evento;
		echo "<br />";
		echo $programa;
		echo "<br />";
		echo $projeto;
		echo "<br />";
		echo $ficha_tecnica;
		echo "<br />";
		echo $sinopse;
		echo "<br />";
		echo $links;
		echo "<br />";
		echo "<br />";
		
		$sql_ins = "INSERT INTO `sc_evento` (`idPrograma`, `idProjeto`, `nomeEvento`, `idResponsavel`, `idSuplente`, `fichaTecnica`, `sinopse`, `releaseCom`, `publicado`, `idUsuario`, `linksCom`, `inscricao`, `categoria`) VALUES ('$programa', '$projeto', '$nome_evento', '$responsavel', '$suplente', '$ficha_tecnica', '$sinopse', '$release', '1', '1', '$links', '$n_inscricao', '$cat')";
		$query_ins = $wpdb->query($sql_ins);
		if($query_ins == 1){
			echo "inserido com sucesso.<br />";
		}else{
			echo $sql_ins."<br / >"; 
		}
		
	}










}

