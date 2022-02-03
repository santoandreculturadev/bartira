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

if(isset($_GET['pag'])){
	$pag = $_GET['pag'];
}else{
	$pag = "inicio";
}


switch($pag){
	
	case "inicio":
	
		echo "<h1>Relatórios para impressão</h1>";
	
	break;

	case "metas":

?>
<style>
.desc_meta{
	font-size: 10px;
}


</style>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">    
			<div class="col-md-offset-2 col-md-8">
				<h1>Plano Municipal de Cultura - Santo André</h1>
				<h2></h2>
				<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>
			</div>
		</div>
		<?php 
		$m = orderMeta();
		$sql_contatos = "SELECT * FROM sc_plano_municipal WHERE id IN ($m) ORDER BY meta ASC";
		$peds = $wpdb->get_results($sql_contatos,ARRAY_A);
		if(count($peds) > 0){
			?>
			
			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="row">    
					</div>
					<div >
						<table border="1px">
							<thead>
								<tr>
									<th>Objetivo</th>
									<th width='20%'>Meta</th>
									<th>Versão</th>
									<th>P %</th>
									<th>Status</th>
									<th>Data Rel</th>
									<th width='20%'>Relatório</th>
									<th width='20%'>Fórum</th>
									<th>Valor Previsto</th>
									<th>Valor/Projeto/Ficha/Ano</th>

								</tr>
							</thead>
							<tbody>
								<?php 
								for($i = 0; $i < count($peds); $i++){
									$status = statusPlano($peds[$i]['meta']);
									$orc = metaOrcamento($peds[$i]['meta']);
									$orcp = metaOrcamento($peds[$i]['meta'],true);
									?>
									<tr>
										<td><p class="desc_meta"><?php echo $peds[$i]['objetivos']; ?></p></td>
										<td><p class="desc_meta"><?php echo $peds[$i]['meta_descricao']; ?></p></td>
										<td><?php echo exibirDataBr($peds[$i]['data']); ?></td>
										<td><?php echo $status['execucao']."%"; ?></td>										
										<td><?php echo $status['status']; ?></td>										
										<td><?php echo $status['data']; ?></td>		
										<td><p class="desc_meta"><?php echo $status['relatorio']; ?></p></td>
										<td><p class="desc_meta"><?php echo $status['forum']; ?></p></td>
										<td>
										<?php 
										foreach ($orc as $chave => $valor) {
											echo dinheiroParaBr($valor)." (".$chave."),  ";
											// Na variável $chave vai ter a chave da iteração atual (cpf, titular ou saldo)
											// Na variável $valor você vai ter o valor referente à chave atual
										}
										
										?>
										
										
										</td>
										<td>
										<?php
											for($j = 0; $j < count($orcp); $j++){
												echo dinheiroparaBr($orcp[$j]['valor'])."/".$orcp[$j]['projeto']."/".$orcp[$j]['ficha']."/".$orcp[$j]['ano_base']."<br />";
											}

										?>
										
										</td>
										
										</tr>
									<?php } // fim do for?>	
									
								</tbody>
							</table>
						</div>

					</div>
				</section>		
				<?php 
		// se não existir, exibir
			}else{
				?>
				<div class="row">    
					<div class="col-md-offset-2 col-md-8">
						<center><h3>Não há metas.</h3></center>
						
					</div>
				</div>
				

				<?php 
		// fim do if existir pedido
			}
			?>
			
			
			
		</div>
	</section>


<?php 
break;

?>


<?php } //fim da switch pag ?>