<?php include "header.php"; ?>

<body>
	
	<?php include "menu.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Dashboard</h1>

		
		<h2>Importa espaço</h2>
   <?php 
   global $wpdb;
   $sql = "SELECT * FROM mapas WHERE tipo = '2'";
   $res = $wpdb->get_results($sql,ARRAY_A);
   for($i = 0; $i < count($res); $i++){
    $espaco = $res[$i]['valor'];
    $dados = array('mapas' => $res[$i]['id_mapas']);
    $json = json_encode($dados);
    $sql_ins = "INSERT INTO `sc_tipo` (`id_tipo`, `tipo`, `descricao`, `abreviatura`) 
    VALUES (NULL, '$espaco', '$json', 'local')";
    $insert = $wpdb->query($sql_ins);
    var_dump($insert);
    echo $sql_ins."<br />";		
    
  }
  
  
  ?>
  
</main>
</div>
</div>

<?php 
include "footer.php";
?>