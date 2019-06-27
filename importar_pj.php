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


$sql = "SELECT * FROM ava_inscricao WHERE id_mapas = '286'";
$ver = $wpdb->get_results($sql,ARRAY_A);

for($i = 0; $i < count($ver); $i++){
	$ins_json = json_decode($ver[$i]['descricao'],ARRAY_A);
	
	//var_dump($ins_json);
	
	$veri = strripos($ins_json['Instituição responsável - CPF ou CNPJ'], ".");
	
	if($veri === false){
		$cnpj = retornaMascara($ins_json['Instituição responsável - CPF ou CNPJ'],'##.###.###/####-##');
	}else{
		$cnpj = $ins_json['Instituição responsável - CPF ou CNPJ'];
	}
	$hoje = date('Y-m-d');
	$razaosocial = $ins_json['Instituição responsável - Nome completo ou Razão Social'];
	$cep = $ins_json['Instituição responsável - CEP'];
	$numero = $ins_json['Instituição responsável - Número'];
	$telefone01 = $ins_json['Instituição responsável - Telefone 1'];
	$email = $ins_json['Instituição responsável - Email Privado']; 
	$complemento = $ins_json["Instituição responsável - Complemento"];
	
	$sql_ver = "SELECT Id_PessoaJuridica FROM sc_pj WHERE CNPJ LIKE '$cnpj'";
	$query_ver = $wpdb->get_results($sql_ver,ARRAY_A);
	echo count($query_ver);
	echo "<pre>";
	var_dump($query_ver);
	echo "</pre>";

	if(count($query_ver) == 0){
		$sql_insert = "INSERT INTO `sc_pj` (`RazaoSocial`, `CNPJ`, `CEP`, `Numero`,  `Complemento`, `Telefone1` , `Email`, `DataAtualizacao` ) VALUES ('$razaosocial','$cnpj','$cep','$numero','$complemento','$telefone01','$email','$hoje')";		
		$query_insert = $wpdb->query($sql_insert);
		var_dump($query_insert);
	}

}


echo "<pre>";
var_dump($ver);
echo "</pre>";
