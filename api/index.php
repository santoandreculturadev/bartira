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




if(!isset($_GET['ano'])){
	echo "
	<h1>API Bartira - Indicadores</h1>
	<p> ano = obrigatório</p>
	<p>src = 'bibliotecas','atendimentos','eventos','incentivo','orcamento'</p>
	<p>mes = 01,02,03,04,05,06,07,08,09,10,11,12</p>
	<p>total = 1 > soma de todos os meses </p>
	<p>total = 0 > retorna mês a mês </p>

	";

}else{

	$ano = $_GET['ano'];
	if(isset($_GET['mes'])){
		$mes = " AND mes = '".$_GET['mes']."'";
	}else{
		$mes = " AND mes = '0' ";
	}

	if(isset($_GET['total'])){
		$total = " AND total = '1' ";
	}else{
		$total = "AND total = '0' ";
	}

	$src = $_GET['src'];

	$sql = "SELECT * FROM sc_api WHERE ano = '$ano' AND src = '$src' $mes $total";
			$res = $wpdb->get_row($sql,ARRAY_A);
		ob_end_clean(); 	
		echo $res['json'];

}

