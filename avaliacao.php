<?php include "header.php"; ?>
<?php 

if(isset($_POST['carregar'])){
	$inscricao = $_POST['carregar'];
}

if(isset($_POST['gravar'])){
	$inscricao = $_POST['carregar'];
	$usuario = $user->ID;
	$contador = 0;
	foreach($_POST as $key => $value){
		if(is_numeric($value) OR $value == ""){
			$sql_verifica = "SELECT id FROM ava_nota WHERE inscricao = '$inscricao' AND usuario = '".$user->ID."' AND criterio = '$key'";
			$res = $wpdb->get_results($sql_verifica,ARRAY_A);
			if(count($res) == 0){
				$sql_insere = "INSERT INTO `ava_nota` (`id`, `usuario`, `inscricao`, `nota`, `criterio`, `edital` ) VALUES (NULL, '$usuario', '$inscricao', '$value', '$key', '".$_GET['edital']."')";
				$ins = $wpdb->query($sql_insere);
				if($ins == 1){
					$contador++;
				}
			}else{
				
				$sql_atualiza = "UPDATE ava_nota SET nota = '$value' WHERE usuario = '$usuario' AND criterio = '$key' AND inscricao = '$inscricao'";
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
			atualizaNota($inscricao,$_GET['edital']);
		}
	}
	// passa função de valor máximo
	valorNotaMax($inscricao,$usuario);


	if($_POST['obs'] != ""){
		$sql_sel_obs = "SELECT id FROM ava_anotacao WHERE usuario = '".$user->ID."' AND inscricao = '".$inscricao."'";
		$res_obs = $wpdb->get_row($sql_sel_obs,ARRAY_A);
		if(count($res_obs) > 0){ // atualiza
			$sql_up_obs = "UPDATE ava_anotacao SET anotacao = '".addslashes($_POST['obs'])."' WHERE usuario = '".$user->ID."' AND inscricao = '".$inscricao."'";
			$res_up_obs = $wpdb->query($sql_up_obs);
		}else{ //insere
			$sql_ins_obs = "INSERT INTO `ava_anotacao` (`id`, `usuario`, `inscricao`, `anotacao`, `edital`) VALUES (NULL, '".$user->ID."', '".$inscricao."', '".addslashes($_POST['obs'])."', '".$_GET['edital']."');";

			$sql_insere = "INSERT INTO `ava_nota` (`id`, `usuario`, `inscricao`, `nota`, `criterio`, `edital` ) VALUES (NULL, '$usuario', '$inscricao', '$value', '$key', '".$_GET['edital']."')";


			$res_ins_obs = $wpdb->query($sql_ins_obs);
			
		}
	}
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
	<script language="javascript">
		function verificachars(){
			var objeto = form1.obs.value

			if(objeto.length > 600){
				alert("O limite da observação é de 600 caracteres.");
				return(false)
			}

		}
	</script>
	
	<?php include "menu/menu_editais.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Avaliação</h1>
		<?php if(isset($mensagem)){ echo $mensagem; } ?>
		<h2><a href="http://culturaz.santoandre.sp.gov.br/inscricao/<?php echo substr($inscricao,3); ?>" target="_blank" ><?php echo $inscricao; ?> </a></h2>	
		<h2></h2>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Critério</th>
						<th>Nota</th>
					</tr>
				</thead>
				<tbody>
					<form method="POST" action="?edital=<?php echo $_GET['edital']; ?>" class="form-horizontal" role="form" name="form1">
						<?php 
						
						$sql = "SELECT * FROM ava_criterios WHERE edital = '".$_GET['edital']."'";
						$res = $wpdb->get_results($sql,ARRAY_A);
						for($i = 0; $i < count($res); $i++){
							?>	
							<tr>
								<td><?php echo $res[$i]['criterio']?></td>
								<td><input type="text" class="form-control nota" name="<?php echo $res[$i]['id']; ?>" max='3.0' min = '1.0' value="<?php echo retornaNota($inscricao,$res[$i]['id'],$user->ID); ?>" > </td>
							</tr>
							
						<?php } ?>
						<tr>
							<td>
								<div class="form-group">
									<div class="col-md-offset-2">
										<label>Observação</label>
										<textarea name="obs" class="form-control" rows="10" OnKeyUp="return verificachars()" ><?php echo retornaAnotacao($inscricao,$user->ID,'491'); ?></textarea>
									</div> 
								</div>
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