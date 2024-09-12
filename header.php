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


	<!-- Bootstrap core CSS -->
<!--
	<link href="dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/scpsa.css" rel="stylesheet">
-->
	<!-- Custom styles for this template -->
<!--	<link href="css/dashboard.css" rel="stylesheet">
	<script src="js/jquery-3.2.1.js"></script>
	<link href="css/jquery.floatingscroll.css" rel="stylesheet" type="text/css">
-->
	<title><?php echo $GLOBALS['site_title']; ?></title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">



        <!-- Custom fonts for this template-->
        <link href="./vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="./css/sb-admin-2.min.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet">
        
        <link href="./vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


        <!-- Bootstrap core JavaScript-->
        <script src="./vendor/jquery/jquery.min.js"></script>
        <script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        
    <link rel="shortcut icon" href="../img/icone1.png" type="image/x-icon">
    <link rel="icon" href="./img/icone1.ico" type="image/x-icon">



</head>
