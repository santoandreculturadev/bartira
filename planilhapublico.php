<?php 
require_once("../wp-load.php");
$user = wp_get_current_user();
if(!is_user_logged_in()): // Impede acesso de pessoas não autorizadas
/*** REMEMBER THE PAGE TO RETURN TO ONCE LOGGED IN ***/
$_SESSION["return_to"] = $_SERVER['REQUEST_URI'];
/*** REDIRECT TO LOGIN PAGE ***/
header("location: /");
endif;
//Carrega os arquivos de funções
require "inc/function.php";

if(isset($_GET['ano'])){
	$ano = $_GET['ano'];
}else{
	$ano = date('Y');
}

if(isset($_GET['mes'])){
	$mes = $_GET['mes'];
}else{
	$mes = date('m');
}

$ultimo_dia = ultimoDiaMes($ano,$mes);

?>
<style>
body{
	font-size:10px;
}
.pieChart{
	float: right;
	
	
}
</style>
<table border='1'>
	<tr>
		<th>Mapas</th>
		<th>Bartira</th>
		<th>Evento</th>
		<th>Local</th>
		<th>Dias úteis</th>
		<th>Público</th>
		<th>Responsável</th>
	</tr>

	<?php 
// busca no calendário
	$sql = "SELECT DISTINCT idEvento, idLocal FROM sc_agenda WHERE idLocal <> '0' AND data >= '".$ano."-".$mes."-01' AND data <= '".$ano."-".$mes."-".$ultimo_dia."' ORDER BY idEvento";
	$e = $wpdb->get_results($sql,ARRAY_A);
	$m = array();
	for($i = 0; $i < count($e); $i++){
		$evento = evento($e[$i]['idEvento']);
		$local = tipo($e[$i]['idLocal']);

		?>
		<tr>
			<td><?php echo $evento['idMapas']; ?></td>
			<td><?php echo $e[$i]['idEvento']; ?></td>
			<td><?php echo $evento['titulo']; ?></td>
			<td><?php echo $local['tipo']; ?></td>
			<td></td>
			<td></td>
			<td><?php echo $evento['responsavel']; ?></td>



		</tr>

		<?php 	
		array_push($m,$evento['idMapas']);
	}

	?>

	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<?php 
	$url_mapas = "http://culturaz.santoandre.sp.gov.br/api/";
	$url = $url_mapas."event/findByLocation";

	$inicio = $ano."-".$mes."-01";
	$fim = $ano."-".$mes."-".$ultimo_dia;

	$n_semana = date('w', strtotime($inicio));
	$url_mapas = "http://culturaz.santoandre.sp.gov.br/api/";
	$url = $url_mapas."event/findByLocation";
	$data = array(
		"@from" => $inicio,
		"@to" => $fim,
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
				if(in_array($e[$i]['id'],$m) == FALSE){		
					echo "<tr>";
					echo "<td>".$e[$i]['id']."<td>";
					echo "<td>".$e[$i]['name']."</td>";
					echo "<td>".$l[0]['name']." - ".substr(substr($o[0]['_startsAt']['date'],0,-10),11)."</td>";
					echo "<td></td><td></td><td></td>";
					echo "</tr>";
				}
			}
		}
		
		
	}
	
	echo "<br />";
	
	?>

</table>

<?php 
echo "<pre>";
var_dump($m);
echo "</pre>";
?>


