<?php 
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

if(isset($_GET['ano'])){
	$ano = $_GET['ano'];
}else{
	$ano = date('Y');
}

$orcamento = orcamentoTotal($ano);
$projeto = array();
$w = 0;
?>
<style>
body{
	font-size:10px;
}
.pieChart{
	float: right;
	
	
}

</style>


<div class="table-responsive">
	<table border= "1" class="table table-striped">
		<thead>
			<tr>
				<th width="25%">Programa</th>
				<th>Projeto</th>

				<th width="30%">Nota</th>
				<th>Responsável</th>
				<th>Projeto/Ficha</th>
				<th width="15%">Descrição</th>
				<th>Valor Planejado</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$programa = array(); // Programa
				$sel_programa = "SELECT * FROM sc_tipo WHERE abreviatura = 'programa'";
				$res_programa = $wpdb->get_results($sel_programa,ARRAY_A);
				for($i = 0; $i < count($res_programa); $i++){
					$total_programa = 0;
					?>
					<tr>
						<td><strong><?php echo $res_programa[$i]['tipo'] ?></strong></td>
						<td></td>
						<td></td>				
						<td></td>				
						<td></td>				
						<td></td>				
						<td></td>		
					</tr>
					<?php // Projeto
					$sel_projeto = "SELECT * FROM sc_tipo WHERE abreviatura = 'projeto' AND publicado = '1' AND ano_base = '2019'";
					$res_projeto = $wpdb->get_results($sel_projeto,ARRAY_A);
					//var_dump($res_projeto);	
					for($k = 0; $k < count($res_projeto); $k++){
						$pro_json = json_decode(utf8_encode($res_projeto[$k]['descricao']),true);
						//var_dump($pro_json);
						if($pro_json['programa'] == $res_programa[$i]['id_tipo']){
							
							?>
							<tr>
								<td></td>
								<td><?php echo $res_projeto[$k]['tipo'] ?></td>

								<td><?php 
								$sql_orc = "SELECT valor,obs,idPai FROM sc_orcamento WHERE planejamento ='".$res_projeto[$k]['id_tipo']."' AND publicado = '1' AND ano_base = '$ano'";
								$res_orc = $wpdb->get_row($sql_orc,ARRAY_A);

								if(isset($res_orc['obs'])){echo $res_orc['obs'];}; ?></td>
								<td><?php 
								if($pro_json['responsavel'] != NULL){
									$pro_json['responsavel'];
									$userwp = get_userdata($pro_json['responsavel']);
									if($userwp){
										echo $userwp->first_name."".$userwp->last_name; //var_dump($orc); 
									}
								}
								?></td>	
								<?php 
								if($res_orc['idPai'] != NULL){
									$orc = recuperaDados("sc_orcamento",$res_orc['idPai'],"id");
								}else{
									$orc = array(
										'obs' => '',
										'projeto' => '',
										'ficha' => '',
										'descricao' => ''
									);
								}
								?>
								<td>
									<?php  if(isset($orc['projeto'])){echo $orc['projeto']; } ?> / <?php if(isset($orc['ficha'])){echo $orc['ficha'];} ?>
								</td>				
								<td>
									<?php  if(isset($orc['descricao'])){echo $orc['descricao']; } ?>
								</td>	<td>
									<?php
						//var_dump($orc);
									echo dinheiroParaBr($res_orc['valor']);
									if($res_orc['valor'] != NULL){
										$total_programa = $total_programa + $res_orc['valor'];
									}
									if($orc == NULL){
										$res_orc = array(
											'obs' => '',
											'projeto' => '',
											'ficha' => '',
											'descricao' => ''
										);
									}
									?>
								</td>

							</tr>
						<?php } 
						$sql_orc = "SELECT valor,obs,idPai FROM sc_orcamento WHERE planejamento ='".$res_projeto[$k]['id_tipo']."' AND publicado = '1' AND ano_base = '2019'";
						$res_orc = $wpdb->get_row($sql_orc,ARRAY_A);

						$projeto[$w]['nome'] = $res_projeto[$k]['tipo'];
						if($res_orc['valor'] == NULL){
							$projeto[$w]['valor'] = 0;
						}else{
							$projeto[$w]['valor'] = $res_orc['valor'];
						}
						$w++;
					}




					?>
					<?php 
					?>
					<tr>
						<td></td>
						<td></td>				
						<td></td>				
						<td></td>
						<td></td>
						<td><strong>Total do Programa:</strong></td>
						<td><strong><?php echo dinheiroParaBr($total_programa); ?></strong></td>
						

						<?php 
						$programa[$i]['id'] = $res_programa[$i]['id_tipo'];
						$programa[$i]['programa'] = $res_programa[$i]['tipo'];
						$programa[$i]['valor'] = $total_programa;
						?>
					</tr>
					<tr>
						<td height="50px" colspan="8"></td>


					</tr>
					<?php 
				}


				?>

			</tbody>
		</table>
	</div>

	<br /><br />	  <br /><br />


	<div>
		<table border= "1" class="table table-striped" width='100%'>
			<thead>
			</thead>
			<tbody>
				<tr>
					<td>Orçamento Aprovado</td>
					<td><?php echo dinheiroParaBr($orcamento['orcamento']); ?></td>
				</tr>
				<tr>
					<td>Contigenciado</td>
					<td><?php echo dinheiroParaBr($orcamento['contigenciado']); ?></td>
				</tr>
				<tr>
					<td>Descontigenciado</td>
					<td><?php echo dinheiroParaBr($orcamento['descontigenciado']); ?></td>
				</tr>
				<tr>
					<td>Suplementado</td>
					<td><?php echo dinheiroParaBr($orcamento['suplementado']); ?></td>
				</tr>
				<tr>
					<td>Anulado</td>
					<td><?php echo dinheiroParaBr($orcamento['anulado']); ?></td>
				</tr>
				<tr>
					<td>Revisado</td>
					<td><?php echo dinheiroParaBr($orcamento['revisado']); ?></td>
				</tr>

				<tr>
					<td>Liberado</td>
					<td><?php echo dinheiroParaBr($orcamento['liberado']); ?></td>
				</tr>
				<tr>
					<td>Planejado</td>
					<td><?php echo dinheiroParaBr($orcamento['planejado']); ?></td>
				</tr>
				<tr>
					<td>Saldo</td>
					<td><?php echo dinheiroParaBr($orcamento['revisado'] - $orcamento['liberado']); ?></td>
				</tr>

			</tbody>
		</table>
	</div> 

	<br /><br />	  <br /><br />

	<style>



	.bar {
		fill: steelblue;
	}

	.bar:hover {
		fill: brown;
	}

	.axis--x path {
		display: none;
	}

</style>
<div id="pieChart" align="center"></div>
<table border = '1' width='100%'>
	<tr>

		<th>Programa</th>
		<th>Valor Planejado</th>
		<th>Valor Executado</th>
	</tr>

	<?php 
	$tot_pla = 0;
	$tot_exe = 0;
	$tot_con = 0;

	for ($i = 0; $i < count($programa); $i++){ 
		?>
		<tr>
			<td><?php echo ($programa[$i]['programa']);?></td>
			<td align='right'><?php 
			
			echo dinheiroParaBr($programa[$i]['valor']);
			$tot_pla = $tot_pla + $programa[$i]['valor'];
			?></td>
			<td align='right'><?php 
			$e = somaPrograma($programa[$i]['id'],'2019');
			echo dinheiroParaBr($e['total']); 
			$tot_exe = $tot_exe + $e['total'];
			$tot_con = $tot_con + $e['contador'];


			
			?></td>
			

		</tr>
	<?php } ?>
	<tr>
		<td><strong>TOTAL</strong></td>
		<td align='right'><?php echo dinheiroParaBr($tot_pla); ?></td>
		<td align='right'><?php echo dinheiroParaBr($tot_exe); ?></td>
		
	</tr>

	<tr>

	</tr>

</table>

<script src="https://d3js.org/d3.v4.js"></script>
<script src="visual/d3/d3pie.js"></script>
<script>
	var pie = new d3pie("pieChart", {
		"header": {
			"title": {
				"text": "Planejamento por Programa",
				"fontSize": 24,
				"font": "open sans"
			},
			"subtitle": {
				"text": "",
				"color": "#999999",
				"fontSize": 12,
				"font": "open sans"
			},
			"titleSubtitlePadding": 9
		},
		"footer": {
			"color": "#999999",
			"fontSize": 10,
			"font": "open sans",
			"location": "bottom-left"
		},
		"size": {
			"canvasWidth": 900,
			"pieOuterRadius": "70%"
		},
		"data": {
			"sortOrder": "value-desc",
			"content": [

			<?php for ($i = 0; $i < count($programa); $i++){ ?>
				{
					"label": "<?php echo $programa[$i]['programa']?>",
					"value": <?php echo $programa[$i]['valor'] ?>,
					"color": "<?php echo '#' . dechex(rand(256,16777215)) ?>"
				},
			<?php } ?>

			]
		},
		"labels": {
			"outer": {
				"pieDistance": 32
			},
			"inner": {
				"hideWhenLessThanPercentage": 3
			},
			"mainLabel": {
				"fontSize": 11
			},
			"percentage": {
				"color": "#ffffff",
				"decimalPlaces": 0
			},
			"value": {
				"color": "#adadad",
				"fontSize": 11
			},
			"lines": {
				"enabled": true
			},
			"truncation": {
				"enabled": true
			}
		},
		"effects": {
			"pullOutSegmentOnClick": {
				"effect": "linear",
				"speed": 400,
				"size": 8
			}
		},
		"misc": {
			"gradient": {
				"enabled": true,
				"percentage": 100
			}
		}
	});
</script>


