<?php 
function chamaAPI($url,$data){
	$get_addr = $url.'?'.http_build_query($data);
	$ch = curl_init($get_addr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$page = curl_exec($ch);
	$evento = json_decode($page,true);
	return $evento;
	echo $get_addr;
}
//retorna data mysql/date (a-m-d) de data/br (d/m/a)
function exibirDataMysql($data){ 
	list ($dia, $mes, $ano) = explode ('/', $data);
	$data_mysql = $ano.'-'.$mes.'-'.$dia;
	return $data_mysql;
}

function somarDatas($data,$dias){ 
	$data_final = date('Y-m-d', strtotime("$dias days",strtotime($data)));	
	return $data_final;
}
function exibirDataBr($data){ 
	$timestamp = strtotime($data); 
	return date('d/m/Y', $timestamp);
}
?>

<!DOCTYPE html>
<html lang="pt_br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Agenda do Prefeito</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="cover.css" rel="stylesheet">
	 <script src="js/jquery-ui.js"></script>
 <script src="js/mask.js"></script>
 <script src="js/maskMoney.js"></script> 
	
  </head>

  <body>
<?php
$mensagem = "";
if(isset($_POST['gerar'])){
	if($_POST['inicio'] == ""){
		$mensagem .= alerta("É preciso inserir uma data inicial","warning");
	}

	if($_POST['fim'] == ""){
		$mensagem .= alerta("É preciso inserir uma data final","warning");
	}
	
	
	
	
}

$url_mapas = "http://culturaz.santoandre.sp.gov.br/api/";
$url = $url_mapas."event/findByLocation";

?>
	<script type="text/javascript">
	$(function() {
    $( ".calendario" ).datepicker();
	$( ".hora" ).mask("99:99");
	$( ".min" ).mask("999");
	$( ".valor" ).maskMoney({prefix:'', thousands:'.', decimal:',', affixesStay: true});
});
</script>



 <section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">

                    <h3>Agenda do Prefeito</h3>
                    <h4><?php if(isset($mensagem)){ echo $mensagem;} ?></h4>

			</div>
		</div> 
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?p=agenda_culturaz" class="form-horizontal" role="form">

					<div class="row">
						<div class="col-6">
							<label>Data Inicial</label>
							<input type="text" class="form-control calendario" name="inicio" placeholder="dd/mm/aaaa"> 
						</div>
						<div class="col-6">
							<label>Data Final</label>
							<input type="text" class="form-control calendario" name="fim" placeholder="dd/mm/aaaa"> 
						</div>
					</div>	
					<br />
					<div class="form-group">
						<div class="col-md-offset-2">
							<input type="hidden" name="gerar" value="1" />
							<?php 
							?>
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Buscar eventos">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
		   <div class="col-md-offset-2 col-md-8">
		<?php 
		
		
		
	if($_POST['inicio'] != "" AND $_POST['fim'] != ""){

		$inicio = exibirDataMysql($_POST['inicio']);
		$fim = somarDatas(exibirDataMysql($_POST['fim']),"+1");
		while($inicio != $fim ){
			$n_eventos = 0;
			echo "<b>".exibirDataBr($inicio)."</b><br />";
			$n_semana = date('w', strtotime($inicio));
			$url_mapas = "http://culturaz.santoandre.sp.gov.br/api/";
			$url = $url_mapas."event/findByLocation";
			$data = array(
				"@from" => $inicio,
				"@to" => $inicio,
				"@select" => "id, name, occurrences",
				"@seals" => "1,2,3"
			);
			
			
			$e = chamaAPI($url,$data);
			for($i = 0; $i < count($e); $i++){

				
				for($k = 0; $k < count($e[$i]['occurrences']); $k++){
					$data_o = array(
						"@select" => "space,_startsAt,rule",
						"@seals" => "1,2,3",
						"id" => "EQ(".$e[$i]['occurrences'][$k].")"
					);
					
					$o = chamaAPI($url_mapas."eventOccurrence/find",$data_o);

			//echo "<pre>";
			//var_dump($o);
			//echo "</pre>";
					
					
					$data_l = array(
						"@select" =>  "name",
						"id" => "EQ(".$o[0]['space'].")"
					);

					$l = chamaAPI($url_mapas."space/find",$data_l);
					$b = false;
					for($t = 0; $t < 7; $t++){
						if(isset($o[0]['rule']['day'][$t]) AND $t == $n_semana){
							$b = true;
						}
					}	
					if($b == true OR $o[0]['rule']['frequency'] == 'once'){
					echo "<p align='left'>".$e[$i]['name']." - ".substr(substr($o[0]['_startsAt']['date'],0,-10),11)."<br />";
					echo $l[0]['name']."</p><br /><br />";
					
					}
				}
				
				
			}
			echo "<br />";
			
			//echo "<pre>";
			//var_dump($e);
			//echo "</pre>";
			/*
			$sql = "SELECT * FROM sc_agenda WHERE data = '".$inicio."' ORDER BY hora ASC";
			$id_evento = $wpdb->get_results($sql,ARRAY_A);
			$titulo = "";
			for($i =0; $i < count($id_evento); $i++){
				$evento = evento($id_evento[$i]['idEvento']);
				$local = tipo($id_evento[$i]['idLocal']);
				echo $evento['titulo']." - ".substr($id_evento[$i]['hora'],0,-3)."<br />";
				echo $local['tipo']."<br /><br />";
				
			}
			*/
			
			
			
			$inicio = somarDatas($inicio,"+1");
			
		}
	}
		?>
		
		</div>
	</div>
	</div>
</section>		  
		  


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
