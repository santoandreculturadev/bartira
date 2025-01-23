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
	<script>

		$(document).ready(function() {
			
			var initialLocaleCode = 'pt-br';
			
			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay,listWeek'
				},
				defaultDate: '<?php echo date('Y-m-d'); ?>',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			height: 'auto',
			eventLimit: false, // allow "more" link when too many events
			events: [
			<?php 
			
			
			$sql_busca = "SELECT * FROM sc_agenda_teatros" ;
			$res = $wpdb->get_results($sql_busca, ARRAY_A);
			//echo "<pre>";
			//var_dump($res);
			//echo "</pre>";
			
			
			for($i = 0; $i < count($res); $i++){
				$agenda = recuperaDados("sc_ocorrencia_teatro",$res[$i]['idOcorrencia'],'idOcorrencia');
				$title = addslashes($agenda['titulo']);
				
				$data = $res[$i]['data'];
				$hora = $res[$i]['hora'];
				echo "{title: '".$title."',";
				echo "start: '".$data."T".$hora."',";
				echo " url:'agendateatros.php?p=editar&id=".$res[$i]['idOcorrencia'];	
				
				if($res[$i]['idLocal'] == 273){
					echo " ', backgroundColor: 'orange'";
				}
				if($res[$i]['idLocal'] == 211){
					echo " ', backgroundColor: 'blue'";
				}
				
				
				if($res[$i]['idLocal'] == 207){
					echo "' , backgroundColor: 'green'";	
				}
				if($res[$i]['idLocal'] == 210){
					echo " ', backgroundColor: 'red'";	
				}
				if($res[$i]['idLocal'] == 235){
					echo " , backgroundColor: 'purple'";	
				}
				if($res[$i]['idLocal'] == 212){
					echo " ', backgroundColor: 'gray'";	
				}


				
				echo "},";
			}
			?>
			]
			
		});
			
		});

			
	</script>
	<style>

	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		margin: 0 auto;
		padding-left: 300px;
	}

	.fc-scroller{
		overflow: none !important;
	}

	@media (min-width: 992px){
		#calendar{
			padding-left: 270px;
		}
		@media print { 
			.sidebar { display:none; } 
			body { background: #fff; }
		}
		
	}

</style>
</head>
<body>


	<?php include "menu/me_agenda_teatros.php"; ?>
	<br/><br />

	<div id='calendar'>
		<?php //echo $sql_busca; ?>
		<br /><br />
	</div>
	

	
	<?php 
	include "footer.php";
	?>
