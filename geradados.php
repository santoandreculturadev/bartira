<?php
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

global $wpdb;


// Lista todos as inscrições
$sql_lista = "SELECT descricao, inscricao FROM ava_inscricao";
$ins = $wpdb->get_results($sql_lista,ARRAY_A);
echo "<pre>";
var_dump($ins);
echo "</pre>";

