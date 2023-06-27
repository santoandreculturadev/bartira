<?php 


// Dados para conexão com o Banco Oracle (Devem ser guardados em algum outro banco ou em algum arquivo protegido)
require "db.php";


function url_exists($url) {
    return curl_init($url) !== false;
}

function retornaDado($tabela,$nome_campo_id,$id,$nome_campo = NULL,$acervo = NULL){
	
	if($acervo == NULL){
		$conn = conexao();
	}else{
		$conn = conexao_casa();
	}
	
	$sql = "SELECT * FROM $tabela WHERE $nome_campo_id = '$id'";
	$stid = oci_parse($conn,$sql);
	oci_execute($stid);
	$x = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
	return $x[$nome_campo];

}


function retornaDados($tabela,$nome_campo_id,$id,$nome_campo = NULL,$acervo = NULL){

	if($acervo == NULL){
		$conn = conexao();
	}else{
		$conn = conexao_casa();
	}

	$conn = conexao();
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
	$conn = conexao();
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



?>