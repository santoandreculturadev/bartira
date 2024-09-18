<?php include "header.php"; ?>

<body>
	
	<?php //include "menu/me_inicio.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Ambiente teste </h1>

		<?php 
		
		$array = ['usuario','planejamento','mapas','atividades','eventos'];
		$array_ordena = asort($array);
		var_dump($array_ordena);
		
   
/*
   global $wpdb;   
	$data = array();
	//$data = array("search" => "MSA-D0000181");
	//$data = array("search" => "arte");
	$url = "https://www3.santoandre.sp.gov.br/cultura/acervosculturais/wp-json/tainacan/v2/item/104948/metadata";
	//$url = "https://www3.santoandre.sp.gov.br/cultura/acervosculturais/wp-json/relevanssi/v1/search";
	//$url = "https://www3.santoandre.sp.gov.br/cultura/acervosculturais/wp-json/wp/v2/search";
	//$url = "https://www3.santoandre.sp.gov.br/cultura/acervosculturais/wp-json/tainacan/v2/items/94063";
	$x = chamaApi($url,$data);
	//	 $x = chamaAPI('https://www3.santoandre.sp.gov.br/cultura/acervosculturais/wp-json/tainacan/v2/items/107739',$data);
	 echo "<pre>";
	var_dump($x);
	echo "</pre>";

	/*
// API de escrita


// author: Vinicius Nune Medeiros

//https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/
// curl exemple:
// curl --insecure 'https://localhost/wp-json/tainacan/v2/collection/6/items/' -X POST -H 'Content-Type: application/json' -H 'Authorization: Basic dGFpbmFjYW46cXVQWSAwUVNFIHZFaHQgTDdMUyBXSGR2IGtyZWM=' --data-raw '{"collection_id":"6","status":"auto-draft"}'


//definição do cabeçalho das requisições utilizando o application passwords WP.
$user = 'tainacanapi';
$token = 'Ekt7 Yhcl mtwB 6sKD 3Jn5 WuCM';
$headers = array(
    'Content-Type:application/json',
    'Authorization: Basic '. base64_encode("$user:$token")
);

$collection_id = 107714; // ID da coleção para criação do item


//
// ----------- Criando um Item auto-draft para receber os valores dos metadados:
//
$item_api_path = "https://www3.santoandre.sp.gov.br/cultura/acervosculturais/wp-json/tainacan/v2/collection/$collection_id/items";
$body = array(
    "collection_id" => $collection_id,
    "status" => "auto-draft",
	"title" => "Teste API",
	"description" => "Teste Descricao API"
);

$request_params = array(
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers, 
    CURLOPT_URL => $item_api_path,
    CURLOPT_POSTFIELDS => json_encode($body),
    CURLOPT_POST => true,
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
echo " ITEM auto-draft ID:" . $item->id . "<br /><br />";



//
// ----------- Adicionando/atualizando os valores dos metadados de um item
//

// --- array com o ID do metadado e o valor que o metadado vai ter para o item:
$metadatas = array(
    9 => "Valor do titulo", // Title
    11 => "Descrição", // Description
    28 => 12 // Numeric
);

foreach($metadatas as $id => $value) {
    $item_metadata_api_path = "https://www3.santoandre.sp.gov.br/cultura/acervosculturais/wp-json/tainacan/v2/item/$item->id/metadata/$id"; // API para atualizar o valor de um metadado especifico em um item especifico.
    echo "\nitem_metadata_api_path: $item_metadata_api_path\n";
    $body = array(
        "values" => [$value]
    );
    $request_params = array(
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers, 
        CURLOPT_URL => $item_metadata_api_path,
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_CUSTOMREQUEST => 'PATCH'
    );
    $ch = curl_init();
    curl_setopt_array($ch, $request_params);
    $response_metadata = curl_exec($ch);
    if(curl_errno($ch)){
        throw new Exception(curl_error($ch));
    }
    curl_close ($ch);
    echo " Metadata do item $item->id atualizado: " . $response_metadata . "<br /><br />";
}


//
// ----------- Atualizando o status do item criado anteriormente como auto-rascunho
// ----------- isso é feito somente apos atulizar os metadados para que as validações dos valores dos metadados sejam executadas.
//
$item_api_path = "https://www3.santoandre.sp.gov.br/cultura/acervosculturais/wp-json/tainacan/v2/items/$item->id";
$body = array(
    "status" => "publish"
);
$request_params = array(
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers, 
    CURLOPT_URL => $item_api_path,
    CURLOPT_POSTFIELDS => json_encode($body),
    CURLOPT_CUSTOMREQUEST => 'PATCH'
);
$ch = curl_init();
curl_setopt_array($ch, $request_params);
$response_data = curl_exec($ch);
if(curl_errno($ch)){
    throw new Exception(curl_error($ch));
}
curl_close ($ch);
$item = json_decode($response_data);

echo "\n \n ITEM publicado com ID:" . $item->id . "\n\n";

/*
	 $data = array();

	 $x = chamaAPI('https://www3.santoandre.sp.gov.br/cultura/acervosculturais/wp-json/tainacan/v2/items/95760',$data);
	// echo "<pre>";
	//var_dump($x);
	//echo "</pre>";
    
	$args = array(
		'headers' => array(
		   'Authorization' => 'Basic ' . base64_encode( 'tainacanapi:Ekt7 Yhcl mtwB 6sKD 3Jn5 WuCM' )
	   ),
	   'body' => array(
			'title'   => 'My test',
		   'status'  => 'draft', // ok, we do not want to publish it immediately
		   'description' => 'lalala',
		   //'collection_id' => 107714, // category ID
		   'slug' => 'new-test-post' // part of the URL usually
		   // more body params are here:
		   // developer.wordpress.org/rest-api/reference/posts/#create-a-post
	   )
	   );
	  
	   //var_dump($args);


	$api_response = wp_remote_post( 'https://www3.santoandre.sp.gov.br/cultura/acervosculturais/wp-json/tainacan/v2/collection/107714/items/submission', $args );

	echo "<pre>"; 
	var_dump($api_response);
	echo "</pre>";
	/* lê os pedidos contratação válidos
		procura no giap o cnpj e o valor
			se acha, ele insere no pedido contratação

	$sql_contratacoes = "SELECT idPedidoContratacao, valor, idEvento, idAtividade, tipoPessoa, idPessoa FROM sc_contratacao WHERE publicado = '1' 
	AND 
	(idEvento IN (SELECT idEvento FROM sc_evento WHERE publicado = '1' AND (status = '3' OR status = '4')) 
	OR idAtividade IN (SELECT idAtividade FROM sc_atividade WHERE publicado = '1'))";
	$res = $wpdb->get_results($sql_contratacoes,ARRAY_A);
	
	for($i = 0; $i < count($res); $i++){
		$valor = $res[$i]['valor'];
		$pessoa = retornaPessoa($res[$i]['idPessoa'],$res[$i]['tipoPessoa']);
		$doc = $pessoa['cpf_cnpj'];
	
		$sql_giap = "SELECT nProcesso FROM sc_contabil WHERE doc_credor LIKE '$doc' AND v_empenho = '$valor'";
		$res_giap = $wpdb->get_results($sql_giap,ARRAY_A);
		if($res_giap){
			echo "<pre>";
			var_dump($res_giap);
			echo "</pre>";
		}	

	}


	$args = array(
		'headers' => array(
		   'Authorization' => 'Basic ' . base64_encode( 'tainacanapi:Ekt7 Yhcl mtwB 6sKD 3Jn5 WuCM' )
	   ),
	   'body' => array(
			'title'   => 'My test',
		   'status'  => 'draft', // ok, we do not want to publish it immediately
		   'content' => 'lalala',
		   'categories' => 5, // category ID
		   'tags' => '1,4,23', // string, comma separated
		   'date' => '2015-05-05T10:00:00', // YYYY-MM-DDTHH:MM:SS
		   'excerpt' => 'Read this awesome post',
		   'password' => '12$45',
		   'slug' => 'new-test-post' // part of the URL usually
		   // more body params are here:
		   // developer.wordpress.org/rest-api/reference/posts/#create-a-post
	   )
	   );
	  
	   var_dump($args);


	$api_response = wp_remote_post( 'https://www3.santoandre.sp.gov.br/cultura/acervosculturais/wp-json/wp/v2/posts', $args );
   
	var_dump($api_response);
   //$body = json_decode( $api_response['body'] );
   
   // you can always print_r to look what is inside
   // print_r( $body ); // or print_r( $api_response );
   
  // if( wp_remote_retrieve_response_message( $api_response ) === 'Created' ) {
//	   echo 'The post ' . $body->title->rendered . ' has been created successfully';
 //  }
 	*/
?>

	</main>

	
	<?php 
	include "footer.php";
	?>

