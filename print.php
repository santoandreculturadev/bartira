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

if(isset($_GET['usuario'])){
	?>
	<table border='1'>
		<thead>
			<tr>
				<th width="10%">CulturAZ</th>
				<th>Título</th>
				<th>Proponente</th>
				<th>Cat</th>
				<th>Área</th>
				<th>Valor</th>
				<th width="10%">Nota</th>
				<th width="35%">Anotações</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			global $wpdb;
			$tipo = 'usuario';
			$id = $_GET['usuario'];
			$x = opcaoDados($tipo,$id);
			$g = $x['edital'][1];
			
			$edital =  editais("",19);

			
			$sql_sel_ins = "SELECT avaliadores FROM ava_edital WHERE id_mapas = '273'";
			$sel = $wpdb->get_row($sql_sel_ins,ARRAY_A);

			$res = json_decode($sel['avaliadores'],true);
			$inscritos = $res[$g];
				//var_dump($res);
			for($i = 0; $i < count($res[$g]); $i++){
				$id_insc = $res[$g][$i];
				$sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$id_insc'";	
				$json = $wpdb->get_row($sel,ARRAY_A);	
				$res_json = json_decode($json['descricao'],true);


				?>	
				<tr>
					<td><a href="http://culturaz.santoandre.sp.gov.br/inscricao/<?php echo substr($json['inscricao'],3); ?>" target="_blank" ><?php echo $json['inscricao']; ?> </a></td>

					<td><?php echo $res_json['3.1 - Título']; ?></td>
					<td><?php echo $res_json['Agente responsável pela inscrição']; ?></td>
					<td><?php echo str_replace("CATEGORIA","",$res_json['3.2 - Categoria']); ?></td>
					<td><?php echo $res_json['3.3 - Determine a área principal de enquadramento da proposta']; ?></td>
					<td><?php echo $res_json['3.11 - Valor (em Reais)']; ?></td>
					<td><?php echo somaNotas($json['inscricao'],$_GET['usuario'],273); ?></td>
					<td>
						<?php $anot = retornaAnotacao($json['inscricao'],$_GET['usuario'],273); echo $anot; ?>
					</td>
				</tr>
				<?php 

			} ?>	


		</tbody>
	</table>	
	<?php
}else{
	echo "Erro";
	
}