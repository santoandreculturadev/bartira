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




?>
<!DOCTYPE html>
<html lang="pt_br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="favicon.ico">

	<title><?php echo $GLOBALS['site_title']; ?></title>

	<!-- Bootstrap core CSS -->
	<link href="dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/scpsa.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="css/dashboard.css" rel="stylesheet">
	<script src="js/jquery-3.2.1.js"></script>
	<link href="css/jquery.floatingscroll.css" rel="stylesheet" type="text/css">

</head>
