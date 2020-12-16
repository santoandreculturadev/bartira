<?php include "header.php"; ?>

<?php

error_reporting(E_WARNING);
ini_set(“display_errors”, 1 );

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


		<p>Para ter acesso aos detalhes dos projetos, é necessário que esteja logado no CulturAZ e que faça parte da equipe
            de pareceristas. <a href="http://culturaz.santoandre.sp.gov.br/autenticacao/" target="_blanck">Clique para logar</a></p>
	
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>CulturAZ</th>
					<th>Proponente</th>
					<th>Título</th>
					<th>Nota Avaliador01</th>
					<th>Avaliador01</th>
					<th>Anotação Avaliador01</th>
					<th>Nota Avaliador02</th>
					<th>Avaliador02</th>
					<th>Anotação Avaliador02</th>
					<th>Nota Fase 2</th>
					<th>Nota Final (Fase 1 + Fase 2)</th>
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
				
				$edital =  editais("",27);
				
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
				
				

				$ranking = "SELECT inscricao, nota FROM ava_ranking WHERE edital = '".$_GET['edital']."' $filtro  $order";
				$res = $wpdb->get_results($ranking,ARRAY_A);
				
				//var_dump($res);
				$k = 1;
				for($i = 0; $i < count($res); $i++){
					$id_insc = $res[$i]['inscricao'];
					$sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$id_insc'";	
					$json = $wpdb->get_row($sel,ARRAY_A);	
					$res_json = converterObjParaArray(json_decode(($json['descricao'])));
					$nota = nota($res[$i]['inscricao'],$_GET['edital']);
					$anotacao = anotacao($res[$i]['inscricao'],$_GET['edital']);
					$avaliador1 = retornaUsuario($nota['pareceristas'][0]['usuario']);
					$avaliador2 = retornaUsuario($nota['pareceristas'][1]['usuario']);
					?>	
					<tr>
						<td><a href="http://culturaz.santoandre.sp.gov.br/inscricao/<?php echo substr($json['inscricao'],3); ?>" target="_blank" ><?php echo $json['inscricao']; ?> </a></td>

						<td><?php echo $res_json['Agente responsável pela inscrição - Nome completo ou Razão Social']; ?></td>
						<td><?php echo $res_json['2.1 Título do Projeto']; ?></td>
						<td><?php if(isset($nota['pareceristas'][0]['nota'])){ echo $nota['pareceristas'][0]['nota']; } ?></td>
						<td><?php if(isset($nota['pareceristas'][0]['usuario'])){ echo $avaliador1['display_name']; } ?></td>
						<td><?php if(isset($anotacao['pareceristas'][0]['anotacao'])){ echo $anotacao['pareceristas'][0]['anotacao']; } ?></td>
						<td><?php if(isset($nota['pareceristas'][1]['nota'])){ echo $nota['pareceristas'][1]['nota']; } ?></td>
						<td><?php if(isset($nota['pareceristas'][1]['usuario'])){ echo $avaliador2['display_name']; } ?></td>
						<td><?php if(isset($anotacao['pareceristas'][1]['anotacao'])){ echo $anotacao['pareceristas'][1]['anotacao']; } ?></td>
	       			    <td><?php echo retornaNota2Fase($json['inscricao'],446); ?></td>
						<td><?php echo $res[$i]['nota']; //var_dump($nota);?></td>
						<td>
						</td>
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