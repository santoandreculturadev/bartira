<?php 
//Carrega WP como FW
require_once("../../wp-load.php");
$user = wp_get_current_user();
if(!is_user_logged_in()): // Impede acesso de pessoas não autorizadas
/*** REMEMBER THE PAGE TO RETURN TO ONCE LOGGED IN ***/
$_SESSION["return_to"] = $_SERVER['REQUEST_URI'];
/*** REDIRECT TO LOGIN PAGE ***/
header("location: /");
endif;
//Carrega os arquivos de funções
require "../inc/function.php";

// author: Vinicius Nune Medeiros

//https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/
// curl exemple:
// curl --insecure 'https://localhost/wp-json/tainacan/v2/collection/6/items/' -X POST -H 'Content-Type: application/json' -H 'Authorization: Basic dGFpbmFjYW46cXVQWSAwUVNFIHZFaHQgTDdMUyBXSGR2IGtyZWM=' --data-raw '{"collection_id":"6","status":"auto-draft"}'


//definição do cabeçalho das requisições utilizando o application passwords WP.
	$user = $GLOBALS['tainacan_user'];
	$token = $GLOBALS['tainacan_token'];
$headers = array(

    'Content-Type:application/json',
    'Authorization: Basic '. base64_encode("$user:$token")
);

$collection_id = 3444; // ID da coleção para criação do item




//
// ----------- Criando um Item auto-draft para receber os valores dos metadados:
//
$item_api_path = $GLOBALS['tainacan_url']."/wp-json/tainacan/v2/collection/$collection_id/items";
$body = array(
    "collection_id" => $collection_id,
    "status" => "auto-draft"
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
echo "\n \n ITEM auto-draft ID:" . $item->id . "\n\n";
echo "<pre>";
var_dump($item);
echo "</pre>";


//
// ----------- Adicionando/atualizando os valores dos metadados de um item
//

// --- array com o ID do metadado e o valor que o metadado vai ter para o item:
$metadatas = array(
    3447 => "Valor do titulo que precisa mapear", // Title
    3449 => "Descrição que precisa mapear", // Description
    3454 => 12 // Numeric
);

foreach($metadatas as $id => $value) {
    $item_metadata_api_path = $GLOBALS['tainacan_url']."/wp-json/tainacan/v2/item/$item->id/metadata/$id"; // API para atualizar o valor de um metadado especifico em um item especifico.
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
    echo "\n Metadata do item $item->id atualizado: " . $response_metadata . "\n";
}


//
// ----------- Atualizando o status do item criado anteriormente como auto-rascunho
// ----------- isso é feito somente apos atulizar os metadados para que as validações dos valores dos metadados sejam executadas.
//
$item_api_path = $GLOBALS['tainacan_url']."/wp-json/tainacan/v2/items/$item->id";
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