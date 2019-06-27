<?php include "header.php"; ?>
<?php 
// não precisa, jogar fora.
if(isset($_GET['edital'])){
	$projeto = $_GET['edital'];
}

?>

<body>
	<link href="css/jquery-ui.css" rel="stylesheet">
	<script src="js/jquery-ui.js"></script>
	<script src="js/mask.js"></script>
	<script src="js/maskMoney.js"></script> 
	<script>
		$(function() {
			$( ".nota" ).mask("9.9");
		});
	</script>
	<?php include "menu/menu_editais.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Inscrições</h1>

		<p>Para ter acesso aos detalhes dos projetos, é necessário que esteja logado no CulturAZ e que faça parte da equipe de pareceristas. <a href="http://culturaz.santoandre.sp.gov.br/autenticacao/" target="_blanck">Clique para logar</a></p>
		<p>
			<?php 
			if(isset($_GET['filtro'])){
				$f = $_GET['filtro'];
			}else{
				$f = '0';
			}
			$sel = "SELECT DISTINCT filtro FROM `ava_ranking` WHERE edital = '$projeto' ORDER BY filtro ASC";
			$res_fil = $wpdb->get_results($sel,ARRAY_A);
			for($i = 0; $i < count($res_fil); $i++){
				if($f != $res_fil[$i]['filtro']){
					echo "<a href='edital2fase.php?edital=".$_GET['edital']."&filtro=".$res_fil[$i]['filtro']."' >".$res_fil[$i]['filtro']."</a> |  ";
				}else{
					echo $res_fil[$i]['filtro']." | ";
				}
			}
			echo "<a href='edital2fase.php?edital=".$_GET['edital']."&revisao=1' >Revisão</a>";
			
			?>
			
		</p>
		
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>CulturAZ</th>
						<th>Título</th>
						<th>Proponente</th>
						<th>Valor</th>
						<th>Nota 2ª Fase</th> 
						<th>Média Geral</th> 

						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					global $wpdb;
					$tipo = 'usuario';
					$id = 1;
					$x = opcaoDados($tipo,$id);
					$g = $x['edital'][1];
					
					$edital =  editais("",33);
					
					if(isset($_GET['order'])){
						$order = "ORDER BY nota DESC, filtro ASC";
					}else{
						$order = "ORDER BY nota DESC";
					}
					if(isset($_GET['filtro'])){
						$filtro = "AND filtro LIKE '".$_GET['filtro']."'";
				//var_dump($_GET['filtro']);

					}else{
						$filtro = "";
					}
					if(isset($_GET['revisao'])){
						$revisao = "AND revisao = '".$_GET['revisao']."'";
					}else{
						$revisao = "";
					}
					
					

					$ranking = "SELECT inscricao, nota FROM ava_ranking WHERE edital = '".$_GET['edital']."' $filtro $revisao $order";
					$res = $wpdb->get_results($ranking,ARRAY_A);
					
				//var_dump($res);
					$k = 1;
					for($i = 0; $i < count($res); $i++){
						$id_insc = $res[$i]['inscricao'];
						$sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$id_insc'";	
						$json = $wpdb->get_row($sel,ARRAY_A);	
						$res_json = converterObjParaArray(json_decode(($json['descricao'])));


						?>	
						<tr>
							<td><?php echo $k;?></td>
							<td><a href="http://culturaz.santoandre.sp.gov.br/inscricao/<?php echo substr($json['inscricao'],3); ?>" target="_blank" ><?php echo $json['inscricao']; ?> </a></td>

							<td><?php echo $res_json['5. Título do Projeto']; ?></td>
							<td><?php echo $res_json['Agente responsável pela inscrição']; ?></td>
							<td><?php echo $res_json['29. Valor total do projeto (em Reais)']; ?> </td>
							<td><?php echo retornaNota2Fase($json['inscricao'],492); ?></td> 
							<td><?php echo $res[$i]['nota']; ?></td>
							<td><?php echo listarAvaliadores($json['inscricao']); ?></td>
							
							<td>
								<form method="POST" action="avaliacao2fase.php?edital=<?php echo $projeto; ?>" class="form-horizontal" role="form">
									<input type="hidden" name="carregar" value="<?php echo $json['inscricao']; ?>" />
									<input type="submit" class="btn btn-theme btn-sm btn-block" value="Avaliar">
								</form></td>
							</tr>
							<?php 
							$k++;
						} ?>	


					</tbody>
				</table>
			</div>      </div>
		</div>
		<div>
			<?php 
			
			?>
		</div>
	</main>
	<?php 
	include "footer.php";
	?>