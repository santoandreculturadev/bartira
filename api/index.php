<?php
//header ('Content-type: text/html; charset=utf-8');
/*
+ Acervo
+ Ações Continuadas
+ Biblioteca
+ Comunicação
+ Convocatórias
+ Eventos
+ Disciplinas, Cursos, Incentivo à Criação
+ Orçamento
+ Plataforma CulturAZ
+ Redes Sociais

*/







// carrega as funções do wordpress

require_once("../../wp-load.php");
require_once("../inc/function.php"); //o function.php dá algum pau para saída para os gráficos
set_time_limit(0);

$ano = $_GET['ano'];

if(isset($_GET['mes'])){
	$mes = " AND mes = '".$_GET['mes']."'";
}else{
	$mes = " AND mes = '0' ";
}

if(isset($_GET['total'])){
	$total = " AND total = '1' ";
}else{
	$total = "";
}


switch($_GET['src']){

	case "atendimentos":
		$sql = "SELECT * FROM sc_api WHERE ano = '$ano' AND src = 'atendimentos' $mes";
		$res = $wpdb->get_row($sql,ARRAY_A);
	 ob_end_clean(); 	
	echo $res['json'];
	
	break;

	case "bibliotecas":
		$sql = "SELECT * FROM sc_api WHERE ano = '$ano' AND src = 'bibliotecas' $mes";
		$res = $wpdb->get_row($sql,ARRAY_A);
 ob_end_clean(); 	
	echo $res['json'];
	
	break;	
	
	case "eventos":
		$sql = "SELECT * FROM sc_api WHERE ano = '$ano' AND src = 'eventos' $total $mes";
		
		$res = $wpdb->get_row($sql,ARRAY_A);
 ob_end_clean(); 	
	echo $res['json'];
	
	break;	
	case "incentivo":
		$sql = "SELECT * FROM sc_api WHERE ano = '$ano' AND src = 'incentivo' $total $mes";
		
		$res = $wpdb->get_row($sql,ARRAY_A);
 ob_end_clean(); 	
	echo $res['json'];
	
	break;	


}

