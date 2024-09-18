<?php 
// funcoes


include "acervo/db.php";




function url_exists($url) {
    return curl_init($url) !== false;
}

function dataOrableParaMysql($string){
    //28/09/2022 10:16:28
    if($string != ""){

        $data = substr($string, 0, 10);
        list ($dia, $mes, $ano) = explode ('/', $data);

        $horas = substr($string, 11, 8);
        list ($hora, $minuto, $segundo) = explode (':', $horas);

        $data_mysql = $ano.'-'.$mes.'-'.$dia.' '.$hora.':'.$minuto.":".$segundo;
        return $data_mysql;
    }else{
        return NULL;

    }
}


function retornaDadoAcervo($tabela,$nome_campo_id,$id,$nome_campo = NULL,$acervo = NULL){
	
	if($acervo == NULL){
		$conn = conexao_museu();
	}else{
		$conn = conexao_casa();
	}
	
	$sql = "SELECT * FROM $tabela WHERE $nome_campo_id = '$id'";
	$stid = oci_parse($conn,$sql);
	oci_execute($stid);
	$x = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	return $x[$nome_campo];

}


function retornaDadosAcervo($tabela,$nome_campo_id,$id,$nome_campo = NULL,$acervo = NULL){

	if($acervo == NULL){
		$conn = conexao_museu();
	}else{
		$conn = conexao_casa();
	}

	$conn = conexao_museu();
	$sql = "SELECT * FROM $tabela WHERE $nome_campo_id = '$id'";
	$stid = oci_parse($conn,$sql);
	oci_execute($stid);
	$y = array();

	$i = 0;
	while($x = oci_fetch_array($stid, OCI_BOTH)){
		$y[$i] = $x[$nome_campo];
		$i++;
	}
	return $y;
}


function partes($id,$acervo = NULL){
	
	if($acervo == NULL){
	$conn = conexao_museu();
	}else{
		$conn = conexao_casa();
	}
	$sql = "SELECT * FROM TAB_FICHA_CATALOGRAFICA_PARTE WHERE ID_FICHA_CATALOGRAFICA = '$id'";
	$stid = oci_parse($conn,$sql);
	oci_execute($stid);
	$y = array();

	$i = -1;
	while($x = oci_fetch_array($stid, OCI_BOTH)){
		$i++;
		$y[$i]['parte'] = $x['DS_PARTE'];
		$y[$i]['medida'] = $x['DS_MEDIDA'];
		$y[$i]['altura'] = $x['DS_ALTURA'];
		$y[$i]['largura'] = $x['DS_LARGURA'];
		$y[$i]['profundidade'] = $x['DS_PROFUNDIDADE'];


		$y[$i]['extenso'] = $x['DS_ALTURA']." x ".$x['DS_LARGURA'];
		if($x['DS_PROFUNDIDADE'] != NULL){
			$y[$i]['extenso'] .= " x ".$x['DS_PROFUNDIDADE'];
		}
		$y[$i]['extenso'] .= " ".$x['DS_MEDIDA']."(s)";
		

	}
	return $y;
}


// export csv
function exportMysqlToCsv($sql_query,$filename = 'export_csv.csv')
{

   $conn = bancoMysqliObj();
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    

    // Gets the data from the database
    $result = $conn->query($sql_query);

    $f = fopen('php://temp', 'wt');
    $first = true;
    while ($row = $result->fetch_assoc()) {
        if ($first) {
            fputcsv($f, array_keys($row));
            $first = false;
        }
        fputcsv($f, $row);
    } // end while

    $conn->close();

    $size = ftell($f);
    rewind($f);
}

function tomboExiste($tombo,$tabela){
    global $wpdb;
    $query = "SELECT * FROM `$tabela` WHERE `Número de Tombo` LIKE '$tombo'";
    echo $query;
    $x = $wpdb->get_row($query,ARRAY_A);
    return $x;

}

function tainacanApi($id,$action = "rec",$data = array()){ // não se esqueça de definir as contantes TAINACAN_API_URL, TAINACAN_API_USER, TAINACAN_API_TOKEN em wp-config
//https://www3.santoandre.sp.gov.br/cultura/acervosculturais/wp-json/tainacan/v2/item/
/*
action = rec (recupera item via api);
        = ins (insere os dados via api);
        = upd (atualiza os dados via api)


*/

    $url_tainacan = TAINACAN_API_URL;
    $user = TAINACAN_API_USER;
    $token = TAINACAN_API_TOKEN;

    switch($action){


        case 'ins':

        break;
        
        case 'upd':

        break;

        case 'rec':
        default:    
        $url = $url_tainacan."/wp-json/tainacan/v2/item/$id/metadata";

        $headers = array(
            'Content-Type:application/json',
            'Authorization: Basic '. base64_encode("$user:$token")
        );
        
        $request_params = array(
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers, 
            CURLOPT_URL => $url,
            //CURLOPT_POSTFIELDS => json_encode($body),
            //CURLOPT_POST => true,
        );
        $ch = curl_init();
        curl_setopt_array($ch, $request_params);
        $response_data = curl_exec($ch);
        if(curl_errno($ch)){
            // throw the an Exception.
            throw new Exception(curl_error($ch));
        }
        curl_close ($ch);
        $item = json_decode($response_data); 
        
    
        return converterObjParaArray($item);

        break;
    





    }





}




/*
    > criar tabela sc_tainancan_oracle (id, tombo, tainacan, date);   ok
    > importar as IDs do Tainacan  ok 

    rotina:
        gera tabela app_tainacan (museu e casa do olhar); ok 
        verifica se existe o tombo na tabela sc_tainacan_oracle (app_tainacan e app_tainacan_casa)
            se não existe:
                 cria e insere dados no taincan via api
            se existe:"
                compara infos de cada "data_atualizacao" | tainacan via api x app_tainacan
                atualiza no tainacan caso o campo não bata


*/


if(isset($_GET['pag'])){
    $pag = $_GET['pag'];
}else{
    $pag = "";
}


?>



<?php
 include "header.php"; 
$data_atualizacao = get_option('tainacan_update_date');

    if($data_atualizacao == ""){
        add_option('tainacan_update_date','2010-01-01');
    }
?>
<body>
	
	<?php //include "menu/me_inicio.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Acervo Oracle <> Tainacan</h1>

    <?php 
    switch($pag){   
    
        case "atualiza_museu":
        
        global $wpdb;

        set_time_limit(0);
        $antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
        echo "<h2>Atualizando os registros do Museu para a Bartira...</h2><br />";
        $hoje = date('Y-m-d H:i:s'); 



        // atualiza os dados vindos do oracle Museu
        
        $url = "http://www.santoandre.sp.gov.br/ImagensMuseu/";
        $url_server = $url;
        $conn = conexao_museu();

        $oracle_query = 'SELECT * FROM TAB_FICHA_CATALOGRAFICA ORDER BY DS_NUMERO_TOMBO';    
        $oracle_query_test = 'SELECT * FROM  ( SELECT * FROM TAB_FICHA_CATALOGRAFICA ORDER BY DS_NUMERO_TOMBO DESC) WHERE ROWNUM <= 10';
        $stid = oci_parse($conn, $oracle_query);
        oci_execute($stid);

        //$row = oci_fetch_all($stid, $dados);
        //echo $row;
        //var_dump($dados);

        //$wpdb->query("TRUNCATE TABLE `app_migracao_santoandre` "); 
        //$wpdb->query("TRUNCATE TABLE `app_tainacan` ");       
        //mysqli_query($con,"TRUNCATE TABLE `app_migracao_santoandre` ");
        //mysqli_query($con,"TRUNCATE TABLE `app_tainacan` ");

         /*
         $data_hoje 
         $data_ultima_atualizacao (2022-03-17);
         $data_insercao_registro
         $data_atualizacao_registro
         
         if($data_insercao_registro > $data_ultima_atualizacao){
            tainacan


         }else if($data_atualizacao_registro > $data_ultima_atualizacao){
            tainacan
         }



         if()



         */   

        $i = 0;
        $j = 0;

        while (($row = oci_fetch_assoc($stid)) != false) {
	
	           // update





            $x = retornaDadoAcervo("TAB_FICHA_CATALOGRAFICA_FOTO","ID_FICHA_CATALOGRAFICA",$row['ID_FICHA_CATALOGRAFICA'],'DS_NOME_ORIGINAL');
            $y = retornaDadoAcervo("TAB_FICHA_CATALOGRAFICA_FOTO","ID_FICHA_CATALOGRAFICA",$row['ID_FICHA_CATALOGRAFICA'],'DS_NOME_ARQUIVO');
            $w = retornaDadosAcervo("TAB_FICHA_CATALOGRAFICA_FOTO","ID_FICHA_CATALOGRAFICA",$row['ID_FICHA_CATALOGRAFICA'],'DS_NOME_ARQUIVO');
            $p = partes($row['ID_FICHA_CATALOGRAFICA']);
        
            $resultado = substr($y,0,-2);
            $ultimas = substr($y,-2);
            $tainacan_id = "vzo";
            
            //var_dump($x);
            //var_dump($y);
            //var_dump($w);
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
        
        
            $tipologia = retornaDadoAcervo("TAB_TIPOLOGIA","ID_TIPOLOGIA",$row['ID_TIPOLOGIA'],"DS_NOME");
            $modo_aquisicao = retornaDadoAcervo("TAB_MODOAQUISICAO","ID_MODOAQUISICAO",$row['ID_MODO_AQUISICAO'],"DS_NOME");
            $colecao = retornaDadoAcervo("TAB_COLECAO","ID_COLECAO",$row['ID_COLECAO'],"DS_NOME");
            $tecnica = retornaDadoAcervo("TAB_TECNICA","ID_TECNICA",$row['ID_TECNICA'],"DS_NOME");
            $material = retornaDadoAcervo("TAB_MATERIAL","ID_MATERIAL",$row['ID_MATERIAL'],"DS_NOME");
            $classificacao = retornaDadoAcervo("TAB_CLASSIFICACAO_ACERVO","ID_CLASSIFICACAO_ACERVO",$row['ID_CLASSIFICACAO'],"DS_NOME");
        
            echo "DTA_ULT_ALTERACAO: ".dataOrableParaMysql($row['DTA_ULT_ALTERACAO'])." <br />" ;
            echo "DT_DATA: ".dataOrableParaMysql($row['DT_DATA'])." <br />" ;
            echo "DT_DESINCORPORADO: ".dataOrableParaMysql($row['DT_DESINCORPORADO'])." <br />" ;
            echo "DT_CADASTRO: ".dataOrableParaMysql($row['DT_CADASTRO'])." <br /> <br />" ;

            // condição de data
            /*    
            if(strtotime(dataOrableParaMysql($row['DT_CADASTRO'])) > strtotime($data_atualizacao)){
                //verifica se o tombo existe no tainacan
                    // se existe -> atualiza
                    // se não existe -> insere 

                    (imagem)
    
    
             }else if(strtotime(dataOrableParaMysql($row['DTA_ULT_ALTERACAO'])) > strtotime($data_atualizacao)){
                 //verifica se o tombo existe no tainacan
                    // se existe -> atualiza
                    // se não existe -> insere
                    (imagem)
            }
    
            */

            $existe = tomboExiste($row['DS_NUMERO_TOMBO'],'app_tainacan');

            if($existe == true){ //atualizo
                  
                $sql_upd = "UPDATE `app_tainacan` SET 
                `Nome` = ".$row['DS_NOME'].",
                `Classificação` = $classificacao,
                 `Tipologia` = $tipologia,
                 `Modo de Aquisição` = $modo_aquisicao,
                 `Título` = ".$row['DS_TITULO'].",
                 `Descrição` = ".$row['DS_LEGENDA'].",
                 `Partes` =  $partes,
                 `Dimensão` = $dimensao,
                 `Coleção` = $colecao,
                 `Autor / Fabricante` = ".$row['DS_AUTOR_FABRICANTE'].",
                 `Data` = ".$row['DT_CADASTRO'].",
                 `ATUALIZACAO` = ".$row['DTA_ULT_ALTERACAO'].",
                 `Origem` = $origem,
                 `Técnica` = $tecnica,
                 `Material` = $material,
                 `Cor` = $cor,
                 `Inscrições e Marcas` = ".$row['DS_INSCRICAO_MARCA'].",
                 `Transcrições das Inscrições` = ".$row['DS_TRANSCRICAO_INSCRICAO'].",
                 `Histórico` = ".$row['DS_HISTORICO'].",
                 `Bibliografia` = ".$row['DS_BIBLIOGRAFIA'].",
                 `special_document` = $foto,
                 `special_attachments` = $fotourl
                 WHERE `Número de Tombo` = ".$row['DS_NUMERO_TOMBO']."";
                    
                
        
                    if($wpdb->query($sql_upd)){
                        echo $row['DS_NUMERO_TOMBO'] . " " . $row['DS_LEGENDA'] . " inserido com sucesso<br>\n";
                        echo $foto." / ".$fotourl."<br />";
                        $i++;
                    }else{
                        echo $row['DS_NUMERO_TOMBO'] . " " . $row['DS_LEGENDA'] . " não inserido<br>\n";
                        echo $sql_upd. "<br />";
                        $j++;	
                    };
                

            }else{ //insere
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
                    `ATUALIZACAO`,
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
                    '".$row['DT_CADASTRO']."',
                    '".$row['DTA_ULT_ALTERACAO']."',
        
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
                    
        
        
                    if($wpdb->query($sql_ins)){
                        echo $row['DS_NUMERO_TOMBO'] . " " . $row['DS_LEGENDA'] . " inserido com sucesso<br>\n";
                        echo $foto." / ".$fotourl."<br />";
                        $i++;
                    }else{
                        echo $row['DS_NUMERO_TOMBO'] . " " . $row['DS_LEGENDA'] . " não inserido<br>\n";
                        echo $sql_ins. "<br />";
                        $j++;	
                    };


            }


        }// fim do while

                
            /*
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
            `ATUALIZACAO`,
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
            '".$row['DT_CADASTRO']."',
            '".$row['DTA_ULT_ALTERACAO']."',

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
            


            if($wpdb->query($sql_ins)){
                echo $row['DS_NUMERO_TOMBO'] . " " . $row['DS_LEGENDA'] . " inserido com sucesso<br>\n";
                echo $foto." / ".$fotourl."<br />";
                $i++;
            }else{
                echo $row['DS_NUMERO_TOMBO'] . " " . $row['DS_LEGENDA'] . " não inserido<br>\n";
                echo $sql_ins. "<br />";
                $j++;	
            };

        }
 

        echo "<h2>Recriando os registros do Casa do Olhar...</h2><br />";
        
        $url = "https://www3.santoandre.sp.gov.br/bartira/appacervo/casadoolhar/";
        $url_server = $url;
        $conn = conexao_casa();
        set_time_limit(0); 	
        
        
        $stid = oci_parse($conn, 'SELECT * FROM TAB_FICHA_CATALOGRAFICA ORDER BY DS_NUMERO_TOMBO');
        oci_execute($stid);
        

        //$wpdb->query("TRUNCATE TABLE `app_migracao_santoandre_casa` ");
        $wpdb->query("TRUNCATE TABLE `app_tainacan_casa` ");
        
        $i = 0;
        $j = 0;
        
        while (($row = oci_fetch_assoc($stid)) != false) {
        
            $x = retornaDadoAcervo("TAB_FICHA_CATALOGRAFICA_FOTO","ID_FICHA_CATALOGRAFICA",$row['ID_FICHA_CATALOGRAFICA'],'DS_NOME_ORIGINAL','casa');
            $y = retornaDadoAcervo("TAB_FICHA_CATALOGRAFICA_FOTO","ID_FICHA_CATALOGRAFICA",$row['ID_FICHA_CATALOGRAFICA'],'DS_NOME_ARQUIVO','casa');
            $w = retornaDadosAcervo("TAB_FICHA_CATALOGRAFICA_FOTO","ID_FICHA_CATALOGRAFICA",$row['ID_FICHA_CATALOGRAFICA'],'DS_NOME_ARQUIVO','casa');
            $p = partes($row['ID_FICHA_CATALOGRAFICA'],'casa');
        
            $resultado = substr($y,0,-2);
            $ultimas = substr($y,-2);
            $tainacan_id = "vzo";
            
            
            
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
        
        
            $tipologia = retornaDadoAcervo("TAB_TIPOLOGIA","ID_TIPOLOGIA",$row['ID_TIPOLOGIA'],"DS_NOME",'casa');
            $modo_aquisicao = retornaDadoAcervo("TAB_MODOAQUISICAO","ID_MODOAQUISICAO",$row['ID_MODO_AQUISICAO'],"DS_NOME",'casa');
            $colecao = retornaDadoAcervo("TAB_COLECAO","ID_COLECAO",$row['ID_COLECAO'],"DS_NOME",'casa');
            $tecnica = retornaDadoAcervo("TAB_TECNICA","ID_TECNICA",$row['ID_TECNICA'],"DS_NOME",'casa');
            $material = retornaDadoAcervo("TAB_MATERIAL","ID_MATERIAL",$row['ID_MATERIAL'],"DS_NOME",'casa');
            $classificacao = retornaDadoAcervo("TAB_CLASSIFICACAO_ACERVO","ID_CLASSIFICACAO_ACERVO",$row['ID_CLASSIFICACAO'],"DS_NOME",'casa');
        
            
        
        
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
            `ATUALIZACAO`,
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
            '".$row['DT_CADASTRO']."',
            '".$row['DTA_ULT_ALTERACAO']."',
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
            
        

            if($wpdb->query($sql_ins)){
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
        $res= $wpdb->get_results($sql_lista,ARRAY_A);
       for($i = 0; $i < count($res); $i++){
        preg_match_all('/.(.*?)º/',$res[$i]['Descrição'], $salao);
        $sal = substr($salao[0][0], -4)." Salão de Arte Contemporânea - Santo André"; 
        $colecao = $res[$i]['Coleção']." || ".$sal;
        $id = $res[$i]['id'];
        
        $sql_update = "UPDATE app_tainacan_casa SET Coleção = '$colecao' WHERE id = '$id'";
        $wpdb->query($sql_update);
       }


       // Atualiza as datas em sc_tainacan_oracle
       echo "<h2>Atualizando datas em sc_tainacan_oracle</h2>";
       $sql_data = "SELECT `Número de Tombo`,`Data`,`ATUALIZACAO`  FROM `app_tainacan` ORDER BY `Número de Tombo`";

       $res_museu = $wpdb->get_results($sql_data,ARRAY_A);

       for($i = 0; $i < count($res_museu); $i++){
            $tombo = $res_museu[$i]['Número de Tombo'];
            $data_cadastro = dataOrableParaMysql($res_museu[$i]['Data']);
            $data_atualizacao = dataOrableParaMysql($res_museu[$i]['ATUALIZACAO']);

            if($data_atualizacao == NULL){
                  $data_atualizacao = $data_cadastro;      
            }

            $sql_bus = "SELECT * FROM sc_tainacan_oracle WHERE tombo = '".$res_museu[$i]['Número de Tombo']."'";
            $res_bus = $wpdb->get_row($sql_bus,ARRAY_A);

            if($res_bus['id'] > 0){ // atualiza
                $sql_atualiza = "UPDATE sc_tainacan_oracle SET data ='".$data_atualizacao."' WHERE id = '".$res_bus['id']."'  "; 
                $x = $wpdb->query($sql_atualiza);
                var_dump($x);
                echo "<br />";
                //echo $sql_atualiza."<br />";
            }else{ // insere
                $sql_insert = "INSERT INTO `sc_tainacan_oracle` (`id`, `tombo`, `tainacan`, `data`) VALUES (NULL, '".$res_museu[$i]['Número de Tombo']."', '', '".$data_atualizacao."');" ; 
                $x = $wpdb->query($sql_insert); 
                var_dump($x);
                echo "<br />";
            }


       }

      
        //echo $sql_compara;
       // echo "<pre>";
       // var_dump($res);
       // echo "</pre>";


       
       


       // Compara todos os registros com o Tainacan
       echo "<h2>Verifica alterações nos registro e atualiza...</h2>";
       
       $x =  get_option( 'tainacan_update_date' );
       $sql_compara = "SELECT * FROM sc_tainacan_oracle WHERE data > '".get_option( 'tainacan_update_date' )."'";
       $res = $wpdb->get_results($sql_compara,ARRAY_A);
       
       echo "<pre>";
       var_dump($res);
       echo "</pre>";
       
  
       $data = array();
       for($i = 0; $i < count($res); $i++){
        
            $id_tainacan = $res[$i]['tainacan'];
         
            if($id_tainacan == 0){ // insere

         
             }else{ // atualiza
                $item = tainacanApi($id_tainacan);
                echo "ID:".$id_tainacan." / ".$item[3]['value']."<br />"; // tombo
             }
        
  



       }
           


            /*
            $x = get_option( 'tainacan_update_date' );
            if($x){
                update_option( 'tainacan_update_date', date('Y-m-d H:i:s') );
            }else{
                add_option( 'tainacan_update_date', date('Y-m-d H:i:s'), '', 'yes' );
             }  
             */

             
        $depois = strtotime(date('Y-m-d H:i:s'));
        $tempo = $depois - $antes;
        echo "<br /><br /> Importação executada em $tempo segundos";

        break;

        default:
             



           ?>
           <h2></h2>
           <p>Este módulo atualiza as informações do Programa Gestor de Acervos da Secretaria de Cultura 
            na plataforma Tainacan em <strong>https://www3.santoandre.sp.gov.br/cultura/acervosculturais/</strong></p>
            <p>Última atualização em:</p>
            
               <li><a href="acervo?pag=atualizar_museu">Atualizar o acervo <strong>Museu de Santo André</a></strong></li>
               <li><a href="acervo?pag=atualizar_casa">Atualizar o acervo <strong>Casa do Olhar</a></strong></li>

                


            <?php 
            echo "<pre>";
            var_dump($data_atualizacao);
            echo "</pre>";

        break;





    }
    
    
    
    
    
    
    
    ?>





        </main>

	
<?php 
include "footer.php";
?>