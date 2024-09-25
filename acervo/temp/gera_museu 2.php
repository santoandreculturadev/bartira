
<h1>App para migração do acervo do Museu de Santo André para o Tainacan</h1>

<?php

if(isset($_GET['teste'])){
	$teste = " LIMIT 0,".$_GET['teste']." ";
}else{
	$teste = "";
}

require "function.php";


/* dados

Número de registro 309007 NUMERO_TOMBO (special_item_id) > é único?
 
Denominação Taça de sobremesa DS_NOME, DS_TITULO

Resumo descritivo Taça de sobremesa em prata, lisa, com borda decorada com friso estriado intercalado por "X". Em faces opostas da parte externa, gravações do logotipo "PANAIR DO BRASIL" e "A FROTA BANDEIRANTE". No fundo, logotipo gravado "FRACALANZA". DS_LEGENDA DS_DESCRICAO DS_DESCRICAO_DISTINTA

Autor Fracalanza DS_AUTOR_FABRICANTE

Técnica fundição ID_TECNICA . TAB_TECNICA ID_TECNICA

Material prata ID_MATERIAL . TAB_MATERIAL ID_MATERIAL

Forma de aquisição Doação ID_MODO_AQUISICA TAB_MODOAQUISICAO ID_MODOAQUISICAO

Fonte de aquisição Panair do Brasil S.A. DS_ORIGEM

Referência de aquisição Processo 01438.000004/2017-77 (?)

Local de produção Brasil (?)

Data de Produção 19--  (?) DS_CRONOLOGIA (?)

Classe 05 Interiores > 05.6 Utensílio de Cozinha/Mesa ID_CLASSIFICACAO TAB_CLASSIFICACAO_ACERVO ID_CLASSIFICACAO_ACERVO

Estado de conservação Bom TAB_FICHA_CATALOGRAFICA_ESTADO.ID_FICHA_CATALOGRAFICA = TAB_FICHA_CATALOGRAFICA.ID_FICHA_CATALOGRAFICA / TAB_ESTADOCONSERV.DS_NOME = TAB_FICHA_CATALOGRAFICA_ESTADO.ID_ESTADO_CONSERVACAO

Termos de Indexação AVIAÇÃO | DITADURA MILITAR | FROTA BANDEIRANTE | PANAIR DO BRASIL | SERVIÇO DE BORDO
TECNICA, LOCAL DE PRODUCAO, MATERIAL, CLASSIFICACAO, COLECAO
TAB_ASSUNTO_DESCRICAO DS_NOME



Altura (cm) 5,8
Largura (cm) 9,60 diametro
Diâmetro (cm) 9,6

Condições de reprodução Direitos reservados, ver http://mhn.acervos.museus.gov.br/uso-de-imagem/

Exposição Panair do Brasil

Referências expográficas Exposição "Nas asas da Panair", de 11 de julho a 29 de setembro de 2019, no Museu Histórico Nacional/Ibram




$dado = retornaDado("TAB_FICHA_CATALOGRAFICA","ID_FICHA_CATALOGRAFICA",10);

var_dump($dado);

"Número de registro", "Denominação", "Resumo descritivo", "Autor", "Técnica", "Material", "Forma de aquisição", "Fonte de aquisição", "Referência de aquisição", "Local de produção", "Data de Produção", "Classificacão", "Estado de conservação", "Termos de Indexação", "Altura", "Largura", "Profundidade"     

*/
$url = "https://www3.santoandre.sp.gov.br/bartira/appacervo/casadoolhar/Museu/";
$url_server = $url;
$conn = conexao();
set_time_limit(0); 	


$stid = oci_parse($conn, 'SELECT * FROM TAB_FICHA_CATALOGRAFICA ORDER BY DS_NUMERO_TOMBO');
oci_execute($stid);

//$row = oci_fetch_all($stid, $dados);

//echo $row;


//var_dump($dados);
$con = bancoMysqli();
mysqli_query($con,"TRUNCATE TABLE `app_migracao_santoandre` ");
mysqli_query($con,"TRUNCATE TABLE `app_tainacan` ");

$i = 0;
$j = 0;

/*
echo "<table border='1'>
<tr>
<td>Tombo</td>
<td>Nome</td>
<td>Título</td>
<td>Legenda</td>
<td>Tipologia</td>
<td>Classificação</td>
<td>Modo de Aquisição</td>
<td>Descritores</td>
<td>Partes</td>
<td>Coleção</td>
<td>Fabricante</td>
<td>Data</td>
<td>Técnica</td>
<td>Material</td>
<td>Cor</td>
<td>Marca</td>
<td>Transcrição Inscrição</td>
<td>Histórico</td>
<td>Bibliogrfia</td>
<td>Url Fotografia</td>

</tr>


";
*/
while (($row = oci_fetch_assoc($stid)) != false) {
	
	

	$x = retornaDado("TAB_FICHA_CATALOGRAFICA_FOTO","ID_FICHA_CATALOGRAFICA",$row['ID_FICHA_CATALOGRAFICA'],'DS_NOME_ORIGINAL');
	$y = retornaDado("TAB_FICHA_CATALOGRAFICA_FOTO","ID_FICHA_CATALOGRAFICA",$row['ID_FICHA_CATALOGRAFICA'],'DS_NOME_ARQUIVO');
	$w = retornaDados("TAB_FICHA_CATALOGRAFICA_FOTO","ID_FICHA_CATALOGRAFICA",$row['ID_FICHA_CATALOGRAFICA'],'DS_NOME_ARQUIVO');
	$p = partes($row['ID_FICHA_CATALOGRAFICA']);

	$resultado = substr($y,0,-2);
	$ultimas = substr($y,-2);
	$tainacan_id = "vzo";
	


	//var_dump($x);
	//var_dump($y);
	//var_dump($w);
	
	var_dump($w);
	/*
		if(file_exists('img/'.$arq)){				
		$arquivo = "file:https://acervoccsp.art.br/img/".$res['TOMBO'].".jpg";
	}else{
		$arquivo = "vzo";
	}
	
	if($arquivo != "vzo"){
		$fotografo = fotografo($res['TOMBO']);
		$termo = "Sim";
	}else{
		$fotografo = "vzo";
		$termo = "Não";
	}
	*/
	
	
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


	$tipologia = retornaDado("TAB_TIPOLOGIA","ID_TIPOLOGIA",$row['ID_TIPOLOGIA'],"DS_NOME");
	$modo_aquisicao = retornaDado("TAB_MODOAQUISICAO","ID_MODOAQUISICAO",$row['ID_MODO_AQUISICAO'],"DS_NOME");
	$colecao = retornaDado("TAB_COLECAO","ID_COLECAO",$row['ID_COLECAO'],"DS_NOME");
	$tecnica = retornaDado("TAB_TECNICA","ID_TECNICA",$row['ID_TECNICA'],"DS_NOME");
	$material = retornaDado("TAB_MATERIAL","ID_MATERIAL",$row['ID_MATERIAL'],"DS_NOME");
	$classificacao = retornaDado("TAB_CLASSIFICACAO_ACERVO","ID_CLASSIFICACAO_ACERVO",$row['ID_CLASSIFICACAO'],"DS_NOME");


	$sql = "INSERT INTO `app_migracao_santoandre` (`id`, `numero_tombo`, `nome`, `titulo`, `legenda`, `tipologia`, `classificacao`, `modo_aquisicao`, `descritores`, `partes`, `colecao`, `autor_fabricante`, `data`, `tecnica`, `material`, `cor`, `inscricoes_marcas`, `transcricoes`, `historico`, `bibliografia`, `special_document`) VALUES (NULL, '".$row['DS_NUMERO_TOMBO']."', '".$row['DS_NOME']."', '".$row['DS_TITULO']."', '".$row['DS_LEGENDA']."', '$tipologia', '$classificacao', '$modo_aquisicao', '$descritores', '$partes', '$colecao', '".$row['DS_AUTOR_FABRICANTE']."', '".$row['DT_DATA']."', '$tecnica', '$material', '$cor', '".$row['DS_INSCRICAO_MARCA']."', '".$row['DS_TRANSCRICAO_INSCRICAO']."', '".$row['DS_HISTORICO']."', '".$row['DS_BIBLIOGRAFIA']."','".$foto."')";


	$sql_ins = "INSERT INTO `app_tainacan` (
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
	



	if(mysqli_query($con,$sql)){
	    echo $row['DS_NUMERO_TOMBO'] . " " . $row['DS_LEGENDA'] . " inserido com sucesso<br>\n";
		echo $foto." / ".$fotourl." / ".$url.$w[$i].'.jpg'."<br />";
		$i++;
	}else{
		echo $row['DS_NUMERO_TOMBO'] . " " . $row['DS_LEGENDA'] . " não inserido<br>\n";
		echo $sql. "<br />";
		$j++;	
	};
	
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
/*
	echo "<tr>
<td>".$row['DS_NUMERO_TOMBO']."</td>
<td>".$row['DS_NOME']."</td>
<td>".$row['DS_TITULO']."</td>
<td>".$row['DS_LEGENDA']."</td>
<td>".$tipologia."</td>
<td>".$classificacao."</td>
<td>".$modo_aquisicao."</td>
<td>".$descritores."</td>
<td>".$partes."</td>
<td>".$colecao."</td>
<td>".$row['DS_AUTOR_FABRICANTE']."</td>
<td>".$row['DT_DATA']."</td>
<td>".$tecnica."</td>
<td>".$material."</td>
<td>".$cor."</td>
<td>".$row['DS_INSCRICAO_MARCA']."</td>
<td>".$row['DS_TRANSCRICAO_INSCRICAO']."</td>
<td>".$row['DS_HISTORICO']."</td>
<td>".$row['DS_BIBLIOGRAFIA']."</td>
<td>".$foto."</td>
	
	</tr>";

}

echo "</table>";

echo $i." registros<br />";
echo $j." erros de inserção<br />";
*/

oci_free_statement($stid);
oci_close($conn);


	/*

      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=data.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array("special_item_id","Tombo","Nome","Título","Legenda","Tipologia","Classificação","Modo de Aquisição","Descritores","Partes","Coleção","Fabricante","Data","Técnica","Material","Cor","Marca","Transcrição","Inscrição","Histórico","Bibliogrfia","special_document"));  
      $query = "SELECT * from migracao_santoandre";  
      $result = mysqli_query($con, $query);  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output); 
*/

/*
$conn = bancoMysqliObj();
$date=date('Y-m-d'); //this would be $_POST['date'] from the form
$q = "SELECT * FROM migracao_santoandre";
$stmt = $conn->prepare($q);
$stmt->bind_param('s', $date);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
   //These next 3 Lines Set the CSV header line if needed
   $data = $result->fetch_assoc();
   $csv[] = array_keys($data);
   $result->data_seek(0);
   //SET THE CSV BODY LINES
    while ($data = $result->fetch_assoc()) {
        $csv[] = array_values($data);
    }
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="myCSV.csv";');
    //You could save the file on your server
    //but we want to download it directly so we use php://output
    $f = fopen('php://output', 'w');
    foreach ($csv as $line) {
        fputcsv($f, $line, ',');
    }
    exit;
} else {
    echo 'No data to export for ' . $date;
}
*/
/*
while ($row){

	$numero_de_registro = "";
	$denominacao = "";
	$resumo_descritivo = "";
	$autor = "";
	$tecnica = "";
	$material = "";
	$forma_de_aquisicao = "";
	$fonte_de_aquisicao = "";
	$referencia_aquisicao = "";
	$local_de_producao = "";
	$data_de_producao = "";
	$classificao = "";
	$estado_de_conservacao = "";
	$termos_de_indexacao = "";
	$altura = "";
	$largura = "";
	$profundidade = "";


	$registro = array();

}

*/


