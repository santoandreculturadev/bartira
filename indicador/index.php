<!DOCTYPE html>
<html lang="pt_br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../../favicon.ico">

	<title>Upload de dados para indicadores - Edital</title>

	<!-- Bootstrap core CSS -->
	<link href="bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="cover.css" rel="stylesheet">
</head>

<body>

	<div class="site-wrapper">

		<div class="site-wrapper-inner">

			<div class="cover-container">



				<div class="inner cover">
					<h1 class="cover-heading">Como gerar</h1>
					<p class="lead">Logado no CulturAZ e com autorização de administrador do projeto, salve a página em seu computador ("Save As"). Suba o arquivo neste sistema.</p>
					<p class="lead">
						<form action="#" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="upload" value='1' >
							<input type="file" name="fileUpload">
							<br />
							<select class="form-control" name="filtro">
								<option value='0'>Todos os tipos </option>
								<option value='1'>Enviados </option>
								<option value='2'>Rascunhos </option>

							</select>
							
							<input type="submit" value="Enviar">
						</p>
					</div>

					<?php 
					function mapas($id){
						$url = "http://culturaz.santoandre.sp.gov.br/api/agent/find";
						$data = array(
							"@select" => "name,email,emailPublico",
							"id" => "eq(".$id.")"
						);
						$get_addr = $url.'?'.http_build_query($data);
	//echo $get_addr;
						$ch = curl_init($get_addr);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$page = curl_exec($ch);
						$evento = json_decode($page,true);
						return $evento;
					}

					function pegaJsonMapas($url){

						$expini = "var MapasCulturais = ";
						$contini = strlen($expini);
						$inicio = strpos($url,$expini);

						$texto_inicio = substr($url,$contini+$inicio);

						$expfim = '"canRelateSeal":true};';
						$contfim = strlen($expfim);
						$fim = strpos($texto_inicio,$expfim);
						$posicao_fim = $contfim + $fim;

						$caracteres_fim = strlen($texto_inicio) - $posicao_fim;

						$texto_final = substr($texto_inicio,0,-($caracteres_fim+1));

						return $texto_final;
					}


					if(isset($_POST['upload'])){
						set_time_limit(0);
      date_default_timezone_set("Brazil/East"); //Definindo timezone padrão

      $ext = strtolower(substr($_FILES['fileUpload']['name'],-4)); //Pegando extensão do arquivo
      $new_name = date("YmdHis") . $ext; //Definindo um novo nome para o arquivo
      $dir = 'uploads/'; //Diretório para uploads

      move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo
      $tipo = $_POST['filtro'];
      $url = file_get_contents($dir.$new_name);
      $json = pegaJsonMapas($url);
      $json_array = json_decode($json,true);
      $x = $json_array['entity']['registrations'];
      
      ?>
      <table border='1'>

      	<?php
      	var_dump($x);
      	$mailing = "";
      	$ar = array();
      	$ins = 0;
      	$ras = 0;

      	for($i = 0; $i < count($x); $i++){
      		$owner = $x[$i]['owner']['id'];
      		$status = $x[$i]['status'];
	//echo $owner." / ".$status."<br />";
      		$y = mapas($owner);
      		if($status == 0){
      			$s = "Rascunho";
      			$ras++;	
      		}else{
      			$s = "Enviado";
      			$ins++;
      		}
      		$sql_insert = "";
      		echo $owner;





      	}

      	
      	
      	?>
      </table>
  <?php } ?>


  
  
  


</div>

</div>

</div>

    <!-- Bootstrap core JavaScript
    	================================================== -->
    	<!-- Placed at the end of the document so the pages load faster -->
    	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    	<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    	<script src="../../dist/js/bootstrap.min.js"></script>
    	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    	<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    </body>
    </html>
