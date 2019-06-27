<?php include "header.php"; ?>

<?php 
$edital = 349;
$aval = verificaAvaliacao($user->ID,$edital);

?>

<body>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Inscrições</h1>


		<p>Para ter acesso aos detalhes dos projetos, é necessário que esteja logado no CulturAZ e que faça parte da equipe de pareceristas. <a href="http://culturaz.santoandre.sp.gov.br/autenticacao/" target="_blanck">Clique para logar</a></p>
		<p>
			<?php if(count($aval) != 0) {?>
				Você tem <strong><?php echo $aval['zeradas']?></strong> inscrições zerada(s) ou sem avaliação e <strong><?php echo $aval['anotacao']?></strong> com o campo observação em branco.
			</p>
		<!--<div><select>
		<option></option>
		<input class="btn btn-sm btn-default" type="submit" value="Filtrar" />
	</select></div>-->
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>CulturAZ</th>
					<th>Título</th>
					<th>Proponente</th>
					<th>Cat</th>
					<th>Área</th>
					<th>Valor</th>
					<th>Nota</th>
					<th>Obs</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				global $wpdb;
				$tipo = 'usuario';
				$id = $user->ID;
				$x = opcaoDados($tipo,$id);
				$g = $x['edital'][1];
				
				$edital =  editais($id,21);

				
				$sql_sel_ins = "SELECT avaliadores FROM ava_edital WHERE id_mapas = '349'";
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
						<td><?php echo somaNotas($json['inscricao'],$user->ID,$edital); ?></td>
						<td>
							<?php 
							$sql_obs = "SELECT * FROM ava_anotacao WHERE inscricao = '".$json['inscricao']."' AND edital = '349' AND usuario ='".$id."'";
							$note = $wpdb->get_results($sql_obs,ARRAY_A);
							for($i = 0;$i < count($note); $i++){
								echo "<p>: ".$note[$i]['anotacao']."</p>";
							}
							
							
							?>
							
						</td>
					</tr>
					<?php 

				} ?>	


			</tbody>
		</table>
	</div>
	
<?php }else{ ?>
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Não há inscrições para avaliar.</h1>
	</main>
<?php } ?>
<?php 
include "footer.php";
?>