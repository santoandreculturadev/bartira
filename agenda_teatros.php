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
			global $wpdb;
			$local = "";
			$locala = "";
			$localb = "";	
			$linguagem = "";
			$projeto = "";

			if(isset($_GET['p'])){
				switch($_GET['p']){
					case "aniversario":
					$aniversario = " AND sc_evento.categoria <> '' ";
					break;
				}
			}else{
				$aniversario = "";
				
			}

            	if(isset($_GET['filtro'])){
				if($_GET['local'] == 0){
					$local = "";
				}else{
					$local = " AND idLocal = '".$_GET['local']."' ";
				}
				
				if($_GET['local'] == 0){
					$locala = "";
				}else{
					$locala = " AND idLocal = '".$_GET['local']."' ";
				}

				if($_GET['local'] == 212){
					$localb = "";
				}else{
					$localb = " AND idLocal = '".$_GET['local']."' ";
				}

				if($_GET['linguagem'] == 0){
					$linguagem = "";
				}else{
					$linguagem = " AND idLinguagem = '".$_GET['linguagem']."' ";
				}
				
				if($_GET['projeto'] == 0){
					$projeto = "";
				}else{
					$projeto = " AND idProjeto = '".$_GET['projeto']."' ";
				}
				
			}
			
			if(isset($_GET['status'])){
				switch($_GET['status']){
					case 1:
					$sql_status = " AND status = '2' ";
					break;
					
					case 2:
					$sql_status = " AND status = '3' ";

					break;
					
					case 4:
					$sql_status = " AND status = '4' ";
					
					break;
					
					default:
					$sql_status = "";
					break;
				}
				
				
			}else{
				$sql_status = "";
			}
			
			
			
			$sql_busca = "SELECT sc_evento.idEvento,nomeEvento,data,hora,mapas,dataEnvio,idLocal,status FROM sc_agenda, sc_evento 
                    WHERE sc_evento.idEvento = sc_agenda.idEvento AND dataEnvio IS NOT NULL $aniversario $linguagem $local $locala $localb $projeto $sql_status" ;
			$res = $wpdb->get_results($sql_busca, ARRAY_A);
			for($i = 0; $i < count($res); $i++){
				$local = tipo($res[$i]['idLocal']);
				$locala = tipo($res[$i]['idLocal']);
				$localb = tipo($res[$i]['idLocal']);
				$title = addslashes($res[$i]['nomeEvento']);
				$data = $res[$i]['data'];
				$hora = $res[$i]['hora'];
				$loc = addslashes($local['tipo']);
				$loca = addslashes($locala['tipo']);
				$locb = addslashes($localb['tipo']);
				echo "{title: '".$title."',";
				echo "start: '".$data."T".$hora."',";
				echo " url:'busca.php?p=view&tipo=evento&id=".$res[$i]['idEvento']."'";	
				if($res[$i]['status'] == 2){
					echo " , backgroundColor: 'orange'";
				}
				if($res[$i]['status'] == 3){
					echo " , backgroundColor: 'blue'";
				}
				
				
				if($res[$i]['status'] == 4){
					echo " , backgroundColor: 'green'";	
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
