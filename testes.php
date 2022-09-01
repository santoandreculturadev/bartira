<?php include "header.php"; ?>

<body>
	
	<?php //include "menu/me_inicio.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Ambiente teste </h1>

		<?php 
     global $wpdb;   



	 $wpdb->query("TRUNCATE sc_tainacan_oracle");	
	 $sql = "SELECT * FROM `tainacan_export`";
	 $res = $wpdb->get_results($sql,ARRAY_A);
 
	
 
	 for($i = 0; $i < count($res); $i++){
		 $tainacan = $res[$i]['special_item_id'];
		 $tombo = $res[$i]['Número de tombo|text|display_no'];
		 $hoje = date('Y-m-d H:m:i');
		 $sql_insert = "INSERT INTO `sc_tainacan_oracle` (`id`, `tombo`, `tainacan`, `data`) VALUES (NULL, '$tombo', '$tainacan', '$hoje')";
		// echo $sql_insert."<br />";
		 $wpdb->query($sql_insert);
 
	 }    

	 $sql = "SELECT * FROM `tainacan_casa`";
    $res = $wpdb->get_results($sql,ARRAY_A);



    for($i = 0; $i < count($res); $i++){
        $tainacan = $res[$i]['special_item_id'];
        $tombo = $res[$i]['Número de tombo|text|display_yes'];
		$hoje = date('Y-m-d H:m:i');
		$sql_insert = "INSERT INTO `sc_tainacan_oracle` (`id`, `tombo`, `tainacan`, `data`) VALUES (NULL, '$tombo', '$tainacan', '$hoje')";
		//echo $sql_insert."<br />";
		$wpdb->query($sql_insert);

    }    


    

    
    

	
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

