<?php 
/*
Calendário para os eventos Pré-CulturAZ

+ Listar filtros (quais?)
+ Aplicar cores
+ 

*/
//Carrega WP como FW
require_once("../../wp-load.php");;
$user = wp_get_current_user();
if(!is_user_logged_in()): // Impede acesso de pessoas não autorizadas
      /*** REMEMBER THE PAGE TO RETURN TO ONCE LOGGED IN ***/
	  $_SESSION["return_to"] = $_SERVER['REQUEST_URI'];
      /*** REDIRECT TO LOGIN PAGE ***/
	  header("location: /");
endif;
//Carrega os arquivos de funções
require "../inc/function.php";
?>

<?php //require_once("../../wp-load.php"); ?>

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />

    <title><?php echo $GLOBALS['site_title']; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="../dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/scpsa.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
 <script src="../js/jquery-3.2.1.js"></script>
<link href='fullcalendar.min.css' rel='stylesheet' />
<link href='fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='lib/moment.min.js'></script>
<script src='lib/jquery.min.js'></script>
<script src='fullcalendar.min.js'></script>
<script src='locale/pt-br.js'></script>
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
			eventLimit: true, // allow "more" link when too many events
			events: [
			<?php 
			global $wpdb;
			if(isset($_GET['p'])){
				switch($_GET['p']){
					case "aniversario":
					$aniversario = " AND sc_evento.categoria <> '' ";
					break;
				}
			}else{
				$aniversario = "";
				
			}
			$sql_busca = "SELECT nomeEvento,data, hora FROM sc_agenda, sc_evento WHERE sc_evento.idEvento = sc_agenda.idEvento $aniversario ";
			$res = $wpdb->get_results($sql_busca,ARRAY_A);
			for($i = 0; $i < count($res); $i++){
				$title = $res[$i]['nomeEvento'];
				$data = $res[$i]['data'];
				$hora = $res[$i]['hora'];
				echo "{title: '".$title."',";
				echo "start: '".$data."T".$hora."'},";
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
		max-width: 900px;
		margin: 0 auto;
	}

</style>
</head>
<body>


<?php include "../menu/barra.php"; ?>
<br /><br />

	<div id='calendar'></div>
<?php var_dump();?>
</body>
</html>
