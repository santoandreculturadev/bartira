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
$x = array("on-1738877893","on-1453010115");


//$x = array("on-58078286");

// Cria uma string para verificação
$y = "";
foreach($x as $value){
	$y .= $value.",";
}
$y = substr($y,0,-1);


for($i = 0; $i < count($x); $i++){
	// verifica se já o evento na base;
	$sql_verifica = "SELECT idEvento FROM sc_evento WHERE inscricao = '".$x[$i]."'";
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
		$nome_evento = addslashes($ins_json['3.1 - Título']);
		$programa = 25;
		$projeto = 91;
		$responsavel = "70"; //id do rodrigo
		$suplente = "9"; //id do kedley
		$autor = "";
		$ficha_tecnica = addslashes($ins_json['1.2 - Discriminar os integrantes do grupo']);
		$sinopse = addslashes($ins_json['3.6 - Sinopse do evento']);
		$links = addslashes($ins_json['3.14 - Referências']."".$ins_json['1.4 - Referências']);
		$release = addslashes($ins_json['1.4 - Resumo Currículo Grupo / Coletivo / Agente Cultural']." /n ".$ins_json['3.5 – Release e objetivo principal:']."".$ins_json['3.12 – Justificativa para a existência de sua proposta/ Resultados esperados com a execução / Relação com o local:']);
		

		
		$sql_ins = "INSERT INTO `sc_evento` (`idPrograma`, `idProjeto`, `nomeEvento`, `idResponsavel`, `idSuplente`, `fichaTecnica`, `sinopse`, `releaseCom`, `publicado`, `idUsuario`, `linksCom`, `inscricao`, `categoria`) VALUES ('$programa', '$projeto', '$nome_evento', '$responsavel', '$suplente', '$ficha_tecnica', '$sinopse', '$release', '1', '1', '$links', '$n_inscricao', '$cat')";
		$query_ins = $wpdb->query($sql_ins);
		if($query_ins == 1){
			echo "$nome_evento inserido com sucesso.<br />";
			$idEvento = $wpdb->insert_id;
			// Insere PJ
			$agente = $ins_json["Agente responsável pela inscrição - Nome completo ou Razão Social"];
			$cpf = mask($ins_json["Agente responsável pela inscrição - CPF ou CNPJ"],"cpf");
			$empresa = addslashes($ins_json["Instituição responsável - Nome completo ou Razão Social"]);
			$cnpj = mask($ins_json["Instituição responsável - CPF ou CNPJ"],"cnpj");
			$cep = $ins_json["Instituição responsável - CEP"];
			$numero = $ins_json["Instituição responsável - Número"];
			$telefone01 = $ins_json["Instituição responsável - Telefone 1"];
			$email = $ins_json["Instituição responsável - Email Privado"];
			$obs_pf = "End PF: ".$ins_json["Agente responsável pela inscrição - Endereço"];
			$nome_artistico = $ins_json["Agente responsável pela inscrição"];	
			$email01 = $ins_json["Agente responsável pela inscrição - Email Privado"]; 
			$email02 = $ins_json["Agente responsável pela inscrição - Email Público"];
			$agente_tel01 = $ins_json["Agente responsável pela inscrição - Telefone 1"];
			$agente_tel02 = $ins_json["Agente responsável pela inscrição - Telefone 2"];
			$agente_tel03 = $ins_json["Agente responsável pela inscrição - Telefone Público"];
			$agente_email = $ins_json["Agente responsável pela inscrição - Email Privado"];
			$agente_cep = $ins_json["Agente responsável pela inscrição - CEP"];
			$agente_numero = $ins_json["Agente responsável pela inscrição - Número"];
			$hoje = date("Y-m-d");
			$rg = $ins_json["1.1 - RG do Agente Individual"];
			
			//Verifica PJ
			$sql_verifica_pj = "SELECT Id_PessoaJuridica FROM sc_pj WHERE CNPJ LIKE '$cnpj'";
			$res_verifica_pj = $wpdb->get_row($sql_verifica_pj,ARRAY_A);
			if(count($res_verifica_pj) == 0){
				//Insere PJ
				$sql_ins_pj = "INSERT INTO `sc_pj` (`RazaoSocial`, `CNPJ`, `CEP`, `Numero`, `Complemento`, `Telefone1`, `Email`, `DataAtualizacao`, `Observacao`, `IdUsuario`,  `rep_nome`, `rep_rg`, `rep_cpf`) VALUES ('$empresa', '$cnpj', '$cep', '$numero', '',  '$telefone01',  '$email', '$hoje', '$obs_pf', '1','$agente','$rg','$cpf')";
				$res_ins_pj = $wpdb->query($sql_ins_pj);
				$id_pj = $wpdb->insert_id;
				if($id_pj > 0){
					echo "PJ inserido com sucesso.<br />";
				}else{
					echo "Erro ao inserir PJ. $sql_ins_pj<br />";
				}
			}else{
				$id_pj = $res_verifica_pj['Id_PessoaJuridica'];
			}
			
			if(isset($id_pj)){
				$sql_ins_pedido = "INSERT INTO `sc_contratacao` (`idEvento`, `tipoPessoa`, `idPessoa`, `integrantesGrupo`, `valor`, `dotacao`,  `observacao`, `publicado`,  `justificativa`, `parecerArtistico`) VALUES ('$idEvento','2','$id_pj','','','142','','1','','')";
				$res_ins_pedido = $wpdb->query($sql_ins_pedido);
				if($res_ins_pedido == 1){
					echo "Pedido criado com sucesso.<br />";
				}else{
					echo "Erro ao criar pedido. $sql_ins_pedido<br />";
				}			
			}

		}else{
			echo $sql_ins."<br / >"; 
		}
	}
}
