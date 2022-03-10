<?php
//Imprime erros com o banco
//mysqli_set_charset($con,"utf8");
require_once("../../wp-load.php");
require_once("function.php");
global $wpdb;
$cod = $_GET['ano'];
//$mes = geraMesOcorrencia($_GET['idEvento']);
$user = wp_get_current_user();
$idUsuario = $user->ID;
                if ($idUsuario != '1' AND $idUsuario != '17' AND $idUsuario != '68') {
                    $sql_lista_evento = "SELECT nomeEvento,idEvento FROM sc_evento WHERE (idUsuario = '$idUsuario' OR idResponsavel = '$idUsuario' OR idSuplente = '$idUsuario') AND status IN (3,4) AND idEvento IN (SELECT DISTINCT idEvento FROM sc_ocorrencia WHERE dataFinal = '0000-00-00' AND publicado = '1') AND ano_base = '$cod' ORDER BY nomeEvento ASC;";
                } else {
                    $sql_lista_evento = "SELECT nomeEvento,idEvento FROM sc_evento WHERE dataEnvio IS NOT NULL AND status IN (3,4) AND idEvento IN (SELECT DISTINCT idEvento FROM sc_ocorrencia WHERE dataFinal = '0000-00-00' AND publicado = '1') AND publicado ='1' AND ano_base = '$cod' ORDER BY nomeEvento ASC;";

                }
$res = $wpdb->get_results($sql_lista_evento,ARRAY_A);

//var_dump($res);

for($i = 0; $i < count($res); $i++){
	$k[] = array(	
		'nomeEvento'	=> $res[$i]['nomeEvento'],
		'idEvento'			=> $res[$i]['idEvento'],
		);
}
echo( json_encode( $k ) );
?>