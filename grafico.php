<?php
// requisição da classe PHPlot
//Carrega WP como FW
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


require_once 'inc/phplot/phplot.php';

function ultimoDiaMes($m,$y){

	return $y."-".$m."-".cal_days_in_month(CAL_GREGORIAN, $m , $y);
}

function pubBiblio($ano,$mes){
	global $wpdb;
	$primeiro_dia = $ano."-".$mes."-01";
	$ultimo_dia = ultimoDiaMes($mes,$ano);
	$y = array();
	$sel = "SElECT * FROM sc_ind_biblioteca WHERE periodo_fim = '$ultimo_dia'";
		//echo $sel;
	$x = $wpdb->get_results($sel,ARRAY_A);
	for($i = 0; $i < count($x); $i++){
		$y['pub_total'] = $x[$i]['pub_central'] + $x[$i]['pub_ramais'];
		$y['emp_total'] = $x[$i]['emp_central'] + $x[$i]['emp_central'];
		$y['downloads'] = $x[$i]['downloads'];
		
	}
	return $y['pub_total'];	
	
	
}

function publico ($ano, $mes){
	global $wpdb;
	$primeiro_dia = $ano."-".$mes."-01";
	$ultimo_dia = ultimoDiaMes($mes,$ano);
	
	
		  // recupero os eventos de mês
	$sql_s = "SELECT DISTINCT idEvento FROM sc_agenda WHERE data >= '$primeiro_dia' AND data <= '$ultimo_dia' AND idEvento NOT IN(SELECT DISTINCT idEvento FROM sc_indicadores WHERE periodoInicio  >= '$primeiro_dia' AND periodoInicio <= '$ultimo_dia')";
		  //echo $sql_s;
	$e = $wpdb->get_results($sql_s,ARRAY_A);
	for($i = 0; $i < count($e); $i++){
		$evento = evento($e[$i]['idEvento']);
			//echo $evento['titulo']."<br />";		
	}

	$total = 0;

	
			// soma os grupos
	$sql_op = "SELECT * FROM sc_opcoes WHERE entidade = 'grupo'";
	$op = $wpdb->get_results($sql_op,ARRAY_A);
				//var_dump($op);

	$arr_grupo = array();	
	
	for($i = 0;$i < count($op); $i++){
		$opc = json_decode($op[$i]['opcao'],true);

		
				//soma o público
		$sql_soma = "SELECT * FROM sc_indicadores WHERE periodoInicio  >= '$primeiro_dia' AND periodoInicio <= '$ultimo_dia' AND publicado = '1' AND idEvento IN(".$opc['evento'].")";
		$s = $wpdb->get_results($sql_soma,ARRAY_A);
				//echo $sql_soma;
		
		$t = 0;
		for($i = 0; $i < count($s); $i++){
			if($s[$i]['contagem'] == 1){
				$t = $t + $s[$i]['valor'];
				array_push($arr_grupo,$s[$i]['idEvento']);
						//echo $s[$i]['idEvento']." ".$s[$i]['valor'];
						//echo "<br />";
			}else{
				$t = $t + ($s[$i]['valor'] * $s[$i]['ndias'] );
				array_push($arr_grupo,$s[$i]['idEvento']);
						//echo $s[$i]['idEvento']." ".$s[$i]['valor'];
						//echo "<br />";

			}
		}
		$total = $total + ($t/count($s));
		
		
	}


		  //soma o público
	$sql_soma = "SELECT * FROM sc_indicadores WHERE periodoInicio  >= '$primeiro_dia' AND periodoInicio <= '$ultimo_dia' AND publicado = '1' AND idEvento NOT IN(".$opc['evento'].")";
	$s = $wpdb->get_results($sql_soma,ARRAY_A);

	for($i = 0; $i < count($s); $i++){
		if($s[$i]['contagem'] == 1){
			$total = $total + $s[$i]['valor'];
						//echo $s[$i]['idEvento']." ".$s[$i]['valor'];
						//echo "<br />";

		}else{
			$total = $total + ($s[$i]['valor'] * $s[$i]['ndias'] );
						//echo $s[$i]['idEvento']." ".$s[$i]['valor'];
						//echo "<br />";

		}
		
	}

	return $total;
	
}

if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = "publico";
}


switch($p){

	case "publico":

//var_dump(publico(2018,1));

	$data = array(
		array('janeiro' , publico(2018,1) ), 
		array('fevereiro' , publico(2018,2) ),
		array('marco' , publico(2018,3) ),
		array('abril' , publico(2018,4) ),
		array('maio' , publico(2018,5) )

	);



	
# Cria um novo objeto do tipo PHPlot com 500px de largura x 350px de altura                 
	$plot = new PHPlot(700 , 500);     

//$plot->SetDefaultTTFont('arial.ttf');  
// Organiza Gráfico -----------------------------
	$plot->SetTitle(utf8_decode('Público da Cultura Santo André'));
# Precisão de uma casa decimal
//$plot->SetPrecisionY(1);
# tipo de Gráfico em barras (poderia ser linepoints por exemplo)
	$plot->SetPlotType("bars");
# Tipo de dados que preencherão o Gráfico text(label dos anos) e data (valores de porcentagem)
	$plot->SetDataType("text-data");
# Adiciona ao gráfico os valores do array
	$plot->SetDataValues($data);
// -----------------------------------------------
	
// Organiza eixo X ------------------------------
# Seta os traços (grid) do eixo X para invisível
	$plot->SetXTickPos('none');
# Texto abaixo do eixo X
	$plot->SetXLabel("");
# Tamanho da fonte que varia de 1-5
	$plot->SetXLabelFontSize(2);
	$plot->SetAxisFontSize(2);
// -----------------------------------------------
	
// Organiza eixo Y -------------------------------
# Coloca nos pontos os valores de Y
	$plot->SetYDataLabelPos('plotin');
// -----------------------------------------------
	
// Desenha o Gráfico -----------------------------
	$plot->DrawGraph();
// -----------------------------------------------

	break;

	case "biblioteca":


	

	$data = array(
		array('janeiro' , pubBiblio(2018,1) ), 
		array('fevereiro' , pubBiblio(2018,2) ),
		array('marco' , pubBiblio(2018,3) ),
		array('abril' , pubBiblio(2018,4) ),
		array('maio' , pubBiblio(2018,5) )

	);     
# Cria um novo objeto do tipo PHPlot com 500px de largura x 350px de altura                 
	$plot = new PHPlot(700 , 500);     
	
// Organiza Gráfico -----------------------------
	$plot->SetTitle(utf8_decode('Publico da Biblioteca Santo André'));
# Precisão de uma casa decimal
//$plot->SetPrecisionY(1);
# tipo de Gráfico em barras (poderia ser linepoints por exemplo)
	$plot->SetPlotType("bars");
# Tipo de dados que preencherão o Gráfico text(label dos anos) e data (valores de porcentagem)
	$plot->SetDataType("text-data");
# Adiciona ao gráfico os valores do array
	$plot->SetDataValues($data);
// -----------------------------------------------
	
// Organiza eixo X ------------------------------
# Seta os traços (grid) do eixo X para invisível
	$plot->SetXTickPos('none');
# Texto abaixo do eixo X
	$plot->SetXLabel("");
# Tamanho da fonte que varia de 1-5
	$plot->SetXLabelFontSize(2);
	$plot->SetAxisFontSize(2);
// -----------------------------------------------
	
// Organiza eixo Y -------------------------------
# Coloca nos pontos os valores de Y
	$plot->SetYDataLabelPos('plotin');
// -----------------------------------------------
	
// Desenha o Gráfico -----------------------------
	$plot->DrawGraph();
// -----------------------------------------------

	break;

}

?>
