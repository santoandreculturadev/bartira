<?php
// author: Vinicius Nune Medeiros

//https://make.wordpress.org/core/2020/11/05/application-passwords-integration-guide/
// curl exemple:
// curl --insecure 'https://localhost/wp-json/tainacan/v2/collection/6/items/' -X POST -H 'Content-Type: application/json' -H 'Authorization: Basic dGFpbmFjYW46cXVQWSAwUVNFIHZFaHQgTDdMUyBXSGR2IGtyZWM=' --data-raw '{"collection_id":"6","status":"auto-draft"}'


//definição do cabeçalho das requisições utilizando o application passwords WP.
$user = 'tainacan';
$token = 'quPY 0QSE vEht L7LS WHdv krec';
$headers = array(
    'Content-Type:application/json',
    'Authorization: Basic '. base64_encode("$user:$token")
);

$collection_id = 6; // ID da coleção para criação do item


//
// ----------- Criando um Item auto-draft para receber os valores dos metadados:
//
$item_api_path = "https://localhost/wp-json/tainacan/v2/collection/$collection_id/items";
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
    $item_metadata_api_path = "https://localhost/wp-json/tainacan/v2/item/$item->id/metadata/$id"; // API para atualizar o valor de um metadado especifico em um item especifico.
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
$item_api_path = "https://localhost/wp-json/tainacan/v2/items/$item->id";
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