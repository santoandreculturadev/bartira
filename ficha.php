<?php 
/*
Calendário para os eventos Pré-CulturAZ

+ Listar filtros (quais?)
+ Aplicar cores
+ 

*/
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

<?php //require_once("../../wp-load.php"); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8' />

	<title><?php echo $GLOBALS['site_title']; ?></title>

	<!-- Bootstrap core CSS -->
	<link href="dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/scpsa.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="css/dashboard.css" rel="stylesheet">
	<script src="js/jquery-3.2.1.js"></script>
	<link href='calendario/fullcalendar.min.css' rel='stylesheet' />
	<link href='calendario/fullcalendar.print.min.css' rel='stylesheet' media='print' />
	<script src='calendario/lib/moment.min.js'></script>
	<script src='calendario/lib/jquery.min.js'></script>
	<script src='calendario/fullcalendar.min.js'></script>
	<script src='calendario/locale/pt-br.js'></script>

	<style>

	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		max-width: 900px;
		margin: 0 auto;
		margin-top: 40px;
		
	}
	@media (min-width: 992px){
		#calendar{
			padding-left: 150px;
		}
		@media print { 
			.sidebar { display:none; } 
			body { background: #fff; }
		}
		
	}

</style>
</head>
<body>
	<?php include "menu/me_agenda.php"; ?>

	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<section id="contact" class="home-section bg-white">
			<div class="container">
				<div class="row">    
					<div class="col-md-offset-2 col-md-8">
						<h1>Caderno de Artista</h1>
						<p><a href="documentos.php?id=0&modelo=salao2018" target="_blank">Clique para gerar.</a></p>
					</div>
				</div>
			</section>		
			

			
			<?php 
			include "footer.php";
			?>
