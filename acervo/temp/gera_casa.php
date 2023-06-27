
<h1>App para migração do acervo da Casa do Olhar para o Tainacan</h1>

<?php

require "function_casa.php";


$url = "https://www3.santoandre.sp.gov.br/bartira/appacervo/casadoolhar/";
$url_server = $url;
$conn = conexao_casa();
set_time_limit(0); 	


$stid = oci_parse($conn, 'SELECT * FROM TAB_FICHA_CATALOGRAFICA ORDER BY DS_NUMERO_TOMBO');
oci_execute($stid);

$con = bancoMysqli();
mysqli_query($con,"TRUNCATE TABLE `app_migracao_santoandre_casa` ");
mysqli_query($con,"TRUNCATE TABLE `app_tainacan_casa` ");

$i = 0;
$j = 0;

while (($row = oci_fetch_assoc($stid)) != false) {

	$x = retornaDado("TAB_FICHA_CATALOGRAFICA_FOTO","ID_FICHA_CATALOGRAFICA",$row['ID_FICHA_CATALOGRAFICA'],'DS_NOME_ORIGINAL','casa');
	$y = retornaDado("TAB_FICHA_CATALOGRAFICA_FOTO","ID_FICHA_CATALOGRAFICA",$row['ID_FICHA_CATALOGRAFICA'],'DS_NOME_ARQUIVO','casa');
	$w = retornaDados("TAB_FICHA_CATALOGRAFICA_FOTO","ID_FICHA_CATALOGRAFICA",$row['ID_FICHA_CATALOGRAFICA'],'DS_NOME_ARQUIVO','casa');
	$p = partes($row['ID_FICHA_CATALOGRAFICA'],'casa');

	$resultado = substr($y,0,-2);
	$ultimas = substr($y,-2);
	$tainacan_id = "vzo";
	
	echo $res['DS_NUMERO_TOMBO'];
	echo "<pre>";
	var_dump($w);
	echo "</pre>";
	
	
	$fotourl = "";
	if($w != NULL){
		for($i = 0; $i < count($w); $i++){
			if($i == 0){
				if(url_exists($url_server.$w[$i].'.jpg')){				
					$foto = 'file:'.$url.$w[$i].'.jpg';
					echo $foto."<br />";
				}else{
					$foto = "vzo";
				}
				
				
			}else{
				if(url_exists($url_server.$w[$i].'.jpg')){				
					$fotourl .= $url.$w[$i].'.jpg||';
	
				}else{
					$fotourl .= " vzo ||";
				}
				 
			}
		}
	}else{
		$foto = "vzo";
	}
	

	if($fotourl == ""){
		$fotourl = 'vzo';
	}
	$descritores = 'vzo';
	$partes = "vzo";
	$dimensao = "vzo";
	if($p == NULL){
		$partes = 'vzo';
		$dimensao = 'vzo';
	}else{
		$partes = $p[0]['parte'];
		$dimensao = $p[0]['parte']." : ".$p[0]['extenso'];
		if($p[1] != NULL){
		$dimensao .= " / ". $p[1]['parte']." : ".$p[1]['extenso'];
			
		}

	}

	$cor = "vzo";
	$origem = $row['DS_ORIGEM'];


	$tipologia = retornaDado("TAB_TIPOLOGIA","ID_TIPOLOGIA",$row['ID_TIPOLOGIA'],"DS_NOME",'casa');
	$modo_aquisicao = retornaDado("TAB_MODOAQUISICAO","ID_MODOAQUISICAO",$row['ID_MODO_AQUISICAO'],"DS_NOME",'casa');
	$colecao = retornaDado("TAB_COLECAO","ID_COLECAO",$row['ID_COLECAO'],"DS_NOME",'casa');
	$tecnica = retornaDado("TAB_TECNICA","ID_TECNICA",$row['ID_TECNICA'],"DS_NOME",'casa');
	$material = retornaDado("TAB_MATERIAL","ID_MATERIAL",$row['ID_MATERIAL'],"DS_NOME",'casa');
	$classificacao = retornaDado("TAB_CLASSIFICACAO_ACERVO","ID_CLASSIFICACAO_ACERVO",$row['ID_CLASSIFICACAO'],"DS_NOME",'casa');


	//$sql = "INSERT INTO `app_migracao_santoandre_casa` (`id`, `numero_tombo`, `nome`, `titulo`, `legenda`, `tipologia`, `classificacao`, `modo_aquisicao`, `descritores`, `partes`, `colecao`, `autor_fabricante`, `data`, `tecnica`, `material`, `cor`, `inscricoes_marcas`, `transcricoes`, `historico`, `bibliografia`, `special_document`) VALUES (NULL, '".$row['DS_NUMERO_TOMBO']."', '".$row['DS_NOME']."', '".$row['DS_TITULO']."', '".$row['DS_LEGENDA']."', '$tipologia', '$classificacao', '$modo_aquisicao', '$descritores', '$partes', '$colecao', '".$row['DS_AUTOR_FABRICANTE']."', '".$row['DT_DATA']."', '$tecnica', '$material', '$cor', '".$row['DS_INSCRICAO_MARCA']."', '".$row['DS_TRANSCRICAO_INSCRICAO']."', '".$row['DS_HISTORICO']."', '".$row['DS_BIBLIOGRAFIA']."','".$foto."')";


	$sql_ins = "INSERT INTO `app_tainacan_casa` (
	`id`,
	`Número de Tombo`,
	`Nome`,
	`Classificação`,
	`Tipologia`,
	`Modo de Aquisição`,
	`Título`,
	`Descrição`,
	`Partes`,
	`Dimensão`,
	`Coleção`,
	`Autor / Fabricante`,
	`Data`,
	`Origem`,
	`Técnica`,
	`Material`,
	`Cor`, 
	`Inscrições e Marcas`,
	`Transcrições das Inscrições`,
	`Histórico`,
	`Bibliografia`,
	`special_document`,
	`special_attachments`,
	`tainacan_id`)
	VALUES (
	NULL,
	'".$row['DS_NUMERO_TOMBO']."',
	'".$row['DS_NOME']."',
	'$classificacao',
	'$tipologia',
	'$modo_aquisicao',
	'".$row['DS_TITULO']."',
	'".$row['DS_LEGENDA']."',
	'$partes',
	'$dimensao',
	'$colecao',
	'".$row['DS_AUTOR_FABRICANTE']."',
	'".$row['DT_DATA']."',
	'$origem',
	'$tecnica',
	'$material',
	'$cor',
	'".$row['DS_INSCRICAO_MARCA']."',
	'".$row['DS_TRANSCRICAO_INSCRICAO']."',
	'".$row['DS_HISTORICO']."',
	'".$row['DS_BIBLIOGRAFIA']."',
	'".$foto."',
	'".$fotourl."',
	'$tainacan_id'
	)";
	



	//if(mysqli_query($con,$sql)){
	//    echo $row['DS_NUMERO_TOMBO'] . " " . $row['DS_LEGENDA'] . " inserido com sucesso<br>\n";
	//	echo $foto." / ".$fotourl." / ".$url.$w[$i].'.jpg'."<br />";
	//	$i++;
	//}else{
	//	echo $row['DS_NUMERO_TOMBO'] . " " . $row['DS_LEGENDA'] . " não inserido<br>\n";
	//	echo $sql. "<br />";
	//	$j++;	
	//};
	
	if(mysqli_query($con,$sql_ins)){
	    echo $row['DS_NUMERO_TOMBO'] . " " . $row['DS_LEGENDA'] . " inserido com sucesso<br>\n";
		echo $foto." / ".$fotourl."<br />";
		$i++;
	}else{
		echo $row['DS_NUMERO_TOMBO'] . " " . $row['DS_LEGENDA'] . " não inserido<br>\n";
		echo $sql_ins. "<br />";
		$j++;	
	};

}


oci_free_statement($stid);
oci_close($conn);



// Gerar o salão

$sql_lista = "SELECT id, Descrição, Coleção FROM app_tainacan_casa";
$query = mysqli_query($con,$sql_lista);
while($res = mysqli_fetch_array($query)){
	//echo $res['Descrição']."</br>";
	preg_match_all('/.(.*?)º/',$res['Descrição'], $salao);
	$sal = substr($salao[0][0], -4)." Salão de Arte Contemporânea - Santo André"; 
	
	$colecao = $res['Coleção']." || ".$sal;
	$id = $res['id'];
	
	$sql_update = "UPDATE app_tainacan_casa SET Coleção = '$colecao' WHERE id = '$id'";
	mysqli_query($con, $sql_update);
	

	
}