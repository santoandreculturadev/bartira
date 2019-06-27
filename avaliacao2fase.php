<?php include "header.php"; ?>
<?php 

if(isset($_POST['carregar'])){
	$inscricao = $_POST['carregar'];
}

if(isset($_POST['gravar'])){
	$inscricao = $_POST['carregar'];
	$usuario = $user->ID;
	$contador = 0;
	if(isset($_POST['revisao'])){
		$revisao = 1;
	}else{
		$revisao = 0;
	}
	foreach($_POST as $key => $value){
		if(is_numeric($value) OR $value == ""){
			$sql_verifica = "SELECT id FROM ava_nota WHERE inscricao = '$inscricao' AND usuario = '".$user->ID."' AND criterio = '$key'";
			$res = $wpdb->get_results($sql_verifica,ARRAY_A);
			if(count($res) == 0){
				$sql_insere = "INSERT INTO `ava_nota` (`id`, `usuario`, `inscricao`, `nota`, `criterio`, `edital`) VALUES (NULL, '$usuario', '$inscricao', '$value', '$key', '492')";
				$ins = $wpdb->query($sql_insere);
				if($ins == 1){
					$contador++;
				}
			}else{
				
				$sql_atualiza = "UPDATE ava_nota SET nota = '$value' WHERE usuario = '$usuario' AND criterio = '$key' AND inscricao = '$inscricao' AND edital = '492'";
				$ins = $wpdb->query($sql_atualiza);
				if($ins == 1){
					$contador++;
				}
			}
			if($contador > 0){
				$mensagem = "<div class='alert alert-success'><strong>Notas lançadas.</strong> </div>"	;
			}else{
				$mensagem = "<div class='alert alert-warning'><strong>Não há lançamentos novos.</strong></div>"	;
			}
			
		}
	}
	// passa função de valor máximo
	$rank = atualizaNota2Fase($inscricao,491,492);
	//valorNotaMax($inscricao,$usuario);
	

	
	$sql_filtro = "UPDATE ava_ranking SET filtro = '".$_POST['categoria']."', revisao = '$revisao'  WHERE edital = '491' AND inscricao = '$inscricao'";
	$wpdb->query($sql_filtro);

	
	
	if($_POST['obs'] != ""){
		$sql_sel_obs = "SELECT id FROM ava_anotacao WHERE usuario = '".$user->ID."' AND inscricao = '".$inscricao."' AND edital = '492'";
		$res_obs = $wpdb->get_row($sql_sel_obs,ARRAY_A);
		if(count($res_obs) > 0){ // atualiza
			$sql_up_obs = "UPDATE ava_anotacao SET anotacao = '".addslashes($_POST['obs'])."' WHERE usuario = '".$user->ID."' AND inscricao = '".$inscricao."' AND edital = '492'";
			$res_up_obs = $wpdb->query($sql_up_obs);
		}else{ //insere
			$sql_ins_obs = "INSERT INTO `ava_anotacao` (`id`, `usuario`, `inscricao`, `anotacao`, `edital`) VALUES (NULL, '".$user->ID."', '".$inscricao."', '".addslashes($_POST['obs'])."','492');";
			$res_ins_obs = $wpdb->query($sql_ins_obs);
			
		}
	}
}


$sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$inscricao'";	
$json = $wpdb->get_row($sel,ARRAY_A);	
$res_json = json_decode($json['descricao'],true);
?>


<body>
	<link href="css/jquery-ui.css" rel="stylesheet">
	<script src="js/jquery-ui.js"></script>
	<script src="js/mask.js"></script>
	<script src="js/maskMoney.js"></script> 
	<script>
		$(function() {
			$( ".nota" ).mask("99.9");
		});
	</script>
	<script language="javascript">
		function verificachars(){
			var objeto = form1.obs.value

			if(objeto.length > 600){
				alert("O limite da observação é de 600 caracteres.");
				return(false)
			}

		}
	</script>
	
	<?php include "menu/menu_editais.php"; 
	
	if(isset($_GET['edital'])){
		$projeto = $_GET['edital'];
	}
	?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Avaliação</h1>
		<?php if(isset($mensagem)){ echo $mensagem; } ?>
		<?php //if(isset($sql_filtro)){ echo $sql_filtro; } ?>
		<h2>[<a href="http://culturaz.santoandre.sp.gov.br/inscricao/<?php echo substr($inscricao,3); ?>" target="_blank" ><?php echo $inscricao; ?> </a> [ <a href="edital2fase_categ.php?edital=<?php echo $projeto; ?>&filtro=<?php  echo $res_json['3.2 - Categoria']; ?>]</h2>	
			<h2></h2>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Critério</th>
							<th width="50%">Nota</th>
						</tr>
					</thead>
					<tbody>
						<form method="POST" action="?edital=<?php echo $projeto; ?>" class="form-horizontal" role="form" name="form1">
							<?php 

							$sql = "SELECT * FROM ava_criterios WHERE edital = '492'";
							$res = $wpdb->get_results($sql,ARRAY_A);
							for($i = 0; $i < count($res); $i++){
								?>	
								<tr>
									<td>Revisão</td>
									<td><input type="checkbox" name="revisao" <?php if(retornaCheck($inscricao) == 1){echo "checked";}; ?>/></td>
								</tr>
								<tr>
									<td><?php echo $res[$i]['criterio']?></td>
									<td><input type="text" class="form-control nota" name="<?php echo $res[$i]['id']; ?>" value="<?php echo retornaNota($inscricao,$res[$i]['id'],$user->ID,'492'); ?>" ></td>
								</tr>
								
							<?php } ?>
							<tr>
								<td>Categoria Original</td>
								<td><?php 
								$sel = "SELECT descricao,inscricao FROM ava_inscricao WHERE inscricao = '$inscricao'";	
								$json = $wpdb->get_row($sel,ARRAY_A);	
								$res_json = json_decode($json['descricao'],true);
								?><?php  echo $res_json['3.2 - Categoria']; ?></td>
							</tr>
							<tr>
								<td>Recategorização (não mude caso não seja recategorizado)</td>
								<td><?php 
								$sql_cat = "SELECT DISTINCT filtro FROM ava_ranking WHERE edital = '$projeto' ORDER BY filtro ASC";
								$res_cat = $wpdb->get_results($sql_cat,ARRAY_A);
								$sql_cat_sel = "SELECT filtro FROM ava_ranking WHERE inscricao = '$inscricao'";
								$res_cat_sel = $wpdb->get_row($sql_cat_sel,ARRAY_A);
								echo "<select name='categoria' class='form-control' >";
								for($k = 0; $k < count($res_cat); $k++){
									if($res_cat[$k]['filtro'] == $res_cat_sel['filtro']){
										echo "<option value='".$res_cat[$k]['filtro']."' selected>".$res_cat[$k]['filtro']."</option>";
									}else{
										echo "<option value='".$res_cat[$k]['filtro']."'>".$res_cat[$k]['filtro']."</option>";
										
									}
									
								}
								echo "</select>";
								
								
								
								?></td>
							</tr>
							<tr>
								<td>
									<div class="form-group">
										<div class="col-md-offset-2">
											<label>Observação</label>
											<textarea name="obs" class="form-control" rows="10" OnKeyUp="return verificachars()" ><?php echo retornaAnotacao($inscricao,$user->ID,'492'); ?></textarea>
										</div> 
									</div>
								</td>
								<td>
									<?php 
									$sql_obs = "SELECT * FROM ava_anotacao WHERE inscricao = '$inscricao'";
									$note = $wpdb->get_results($sql_obs,ARRAY_A);
									for($i = 0;$i < count($note); $i++){
										$u = get_userdata($note[$i]['usuario']);
										echo "<p><b>".$u->first_name." ".$u->last_name."</b>: ".$note[$i]['anotacao']."</p>";
										
									}
									
									?>
									
									
								</td>
								
							</tr>
							
						</tbody>

					</table>
					
					<input type="hidden" name="carregar" value="<?php echo $_POST['carregar']; ?>" >
					<input type="submit" class="btn btn-theme btn-lg btn-block"  name="gravar" value="Gravar">
				</form>
			</div>
		</main>
	</div>
</div>
<div>
	<?php 
	
	?>
</div>
<?php 
include "footer.php";
?>