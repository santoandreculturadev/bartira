<?php include "header.php"; ?>

<body>
	<?php include "menu/barra.php"; ?> 
	<?php //include "menu/me_inicio.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Busca</h1>
		<?php 
		if(isset($_GET['p'])){
			$p = $_GET['p'];
		}else{
			$p = 'inicio';
		}
		switch($p){
			default:
			case "inicio":
			?>
			<section id="inserir" class="home-section bg-white">
				<div class="container">
					<div class="row">
						<div class="col-md-offset-2 col-md-8">

							<p>A busca compreende eventos, contratos, pessoas físicas e jurídicas e espaços</p>
							
						</div>
					</div> 
					<div class="row">
						<div class="col-md-offset-1 col-md-10">
							<form method="POST" action="?p=busca" class="form-horizontal" role="form">
								<div class="row">
									<div class="col-12">
										<label>Digite pelo menos 3 caracteres</label>
										<input type="text" name="busca" class="form-control" id="inputSubject" />
									</div>
								</div><br />
								<div class="form-group">
									<div class="col-md-offset-2">
										<input type="hidden" name="inserir_pf" value="1" />
										<?php 
										?>
										<input type="submit" class="btn btn-theme btn-lg btn-block" value="Busca">
									</div>
								</div>
							</form>
						</div>
					</section>	
					
					<?php 
					break;
					case "busca":
					if(isset($_POST['busca'])){
						$busca = $_POST['busca'];
	// eventos
						$sql_evento = "SELECT idEvento FROM sc_evento WHERE nomeEvento LIKE '%$busca%' OR
						autor  LIKE '%$busca%' OR
						nomeGrupo  LIKE '%$busca%' OR
						fichaTecnica  LIKE '%$busca%' OR
						sinopse  LIKE '%$busca%' OR
						releaseCom  LIKE '%$busca%'"; 
						$res_evento = $wpdb->get_results($sql_evento,ARRAY_A);
						
	// pessoa física
						$sql_pf = "SELECT Id_PessoaFisica FROM sc_pf WHERE Nome LIKE '%$busca%' OR
						NomeArtistico  LIKE '%$busca%'" ; 
						$res_pf = $wpdb->get_results($sql_pf,ARRAY_A);

	// pessoa jurídicas
						$sql_pj = "SELECT Id_PessoaJuridica FROM sc_pj WHERE RazaoSocial LIKE '%$busca%' OR
						rep_nome  LIKE '%$busca%'" ; 
						$res_pj = $wpdb->get_results($sql_pj,ARRAY_A);
						
						
					}else{
						
					}	
					?>	
					<section id="inserir" class="home-section bg-white">
						<div class="container">
							<div class="row">
								<div class="col-md-offset-2 col-md-8">

									

									
								</div>
							</div> 
							
							<div class="row">
								<div class="col-md-offset-1 col-md-10">
									<p>Foram encontrado(s) <?php echo count($res_evento) ?> eventos.</p>
									<ul>
										<?php 
										for($i = 0; $i < count($res_evento); $i++){
											$evento = evento($res_evento[$i]['idEvento']);
											echo "<li><a href=?p=view&tipo=evento&id=".$res_evento[$i]['idEvento']." target='_blank'>".$evento['titulo']."</a></li>";
										}
										?>
									</ul>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-offset-1 col-md-10">
									<p>Foram encontrado(s) <?php echo count($res_pf) ?> Pessoas Físicas.</p>
									<ul>
										<?php 
										for($i = 0; $i < count($res_pf); $i++){
											$evento = retornaPessoa($res_pf[$i]['Id_PessoaFisica'],1);
											echo "<li><a href=?p=view&tipo=pf&id=".$res_pf[$i]['Id_PessoaFisica']." target='_blank'>".$evento['nome']."</a></li>";
										}
										?>
									</ul>
								</div>
							</div>

							<div class="row">
								<div class="col-md-offset-1 col-md-10">
									<p>Foram encontrado(s) <?php echo count($res_pj) ?> Pessoas Jurídicas.</p>
									<ul>
										<?php 
										for($i = 0; $i < count($res_pj); $i++){
											$evento = retornaPessoa($res_pj[$i]['Id_PessoaJuridica'],2);
											echo "<li><a href=?p=view&tipo=pj&id=".$res_pj[$i]['Id_PessoaJuridica']." target='_blank'>".$evento['nome']."</a></li>";
										}
										?>
									</ul>
								</div>
							</div>	
							<br /><br />
							<div class="row">
								<div class="col-md-offset-1 col-md-10">
									<a href="?p=inicio"  class="btn btn-primary btn-block">Fazer outra busca</a>
								</div>
							</div>
						</section>		
						<?php 
						break;
						case "view":
						switch($_GET['tipo']){
							case 'evento':
							$evento = evento($_GET['id']);
							?>
							<section id="inserir" class="home-section bg-white">
								<div class="container">
									<div class="row">
										<div class="col-md-offset-2 col-md-8">

											
											<br /><br />
											
										</div>
									</div> 
									
									<div class="row">
										<div class="col-md-offset-1 col-md-10">
											<h2><?php echo $evento['titulo']; ?></h2>
											<br />
											<p>Programa : <?php echo $evento['programa']; ?> / Projeto: <?php echo $evento['projeto']; ?> <p>
												<p>Linguagem: <?php echo $evento['linguagem']; ?></p>
												<p>Responsavel: <?php echo $evento['responsavel']; ?></p>
												<p>Autor: <?php echo $evento['autor']; ?></p>
												<p>Ficha Técnica: <br /> <?php echo $evento['ficha_tecnica']; ?></p>
												<p>Sinopse: <br /><?php echo $evento['sinopse']; ?></p>
												<p>Período: <?php echo $evento['periodo']['legivel']; ?> / Local: <?php echo $evento['local']; ?></p>
												<p>Faixa etária: <?php echo $evento['faixa_etaria']?></p>
												<?php if($evento['mapas']['id'] != 0){ ?>
													<p>CulturAZ: <a href='<?php echo $GLOBALS['url_mapas']."evento/".$evento['mapas']['id']; ?>' ><?php echo $GLOBALS['url_mapas']."evento/".$evento['mapas']['id']; ?></a>
													<?php } ?>
													<hr>
													<h4>Infraestrutura ATA</h4>		
													<?php 

													if(retornaInfra($_GET['id']) != NULL){
														echo "<p>Infraestrutura: <br />";
														echo retornaInfra($_GET['id']);
														echo "</p>";

													}
													?>
													<hr>
													<h4>Produção</h4>

													<?php 
													$x = producao($_GET['id']);
													for($i = 0; $i < count($x); $i++){
														
														$y = retornaProducao($x[$i]['id_lista_producao']);
														if($y != false){					
															if($y['tipo'] == "infra"){
																if($x[$i]['valor'] != ""){	
																	echo "<li>".$y['titulo']." : ".$x[$i]['valor']."</li>";
																}
															}
														}
														
													}
													
													
													?>
													
													<hr>
													<h4>Comunicação</h4>
													<?php 
													$x = producao($_GET['id']);
													for($i = 0; $i < count($x); $i++){
														
														$y = retornaProducao($x[$i]['id_lista_producao']);
														if($y != false){					
															if($y['tipo'] == "com"){
																if($x[$i]['valor'] != ""){	
																	echo "<li>".$y['titulo']." : ".$x[$i]['valor']."</li>";
																}
															}
														}
														
													}
													
													
													?>
													<hr>
													<h4>Apoio</h4>
													<?php 
													$x = producao($_GET['id']);
													for($i = 0; $i < count($x); $i++){
														
														$y = retornaProducao($x[$i]['id_lista_producao']);
														if($y != false){					
															if($y['tipo'] == "apoio"){
																if($x[$i]['valor'] != ""){	
																	echo "<li>".$y['titulo']." : ".$x[$i]['valor']."</li>";
																}
															}
														}
														
													}
													
													
													?>
													
													<hr>
													
													
												</div>
											</div>
											<?php 
											$ped = listaPedidos($_GET['id'],'evento');
		//var_dump($ped);
											?><h4><b>Pedidos Relacionados</h4><br />
											<?php 		
											for($i = 0; $i < count($ped); $i++){
												$pedido = retornaPedido($ped[$i]['idPedidoContratacao']);
												?>
												<div class="row">
													<div class="col-md-offset-1 col-md-10">
															<li><b>Tipo:</b> <?php echo $ped[$i]['tipo'] ?>  / <b>Nome/Razão Social:</b> <a href="busca.php?p=view&tipo=pj&id=<?php echo $ped[$i]['idPessoa']?>" ><?php echo $ped[$i]['nome'] ?> </a>/ <b>Projeto/Ficha:</b> <?php echo $pedido['projeto'] ?>/<?php echo $pedido['ficha'] ?>  / <b>Valor: </b><?php echo $pedido['valor'] ?> ;
															<p></p> 
																<?php 
																$cont = retornaContabil($pedido['nProcesso']);
																if(count($cont > 0)){
																	for($k = 0; $k < count($cont);$k++){
																		?>
																		<b>Processo: </b><?php echo $cont[$k]['nProcesso']; ?>/ <b>Número da Liberação:  </b> <?php echo $pedido['nLiberacao'] ?>/ <b>Número do Empenho: </b><?php echo $cont[$k]['empenho']; ?> / <b>Ordem de Pagamento: </b><?php echo dinheiroParaBr($cont[$k]['v_op_baixado']); ?><br />
																		
																		<?php 
																	}
																}
																
																?>
																
																
															</li>
															
															
															<?php //var_dump($ped); ?>	
														<?php } ?>
														
													</p>		
												</div>
											</div>
											
											<br /><br />
											<div class="row">
												<div class="col-md-offset-1 col-md-10">
													<a href="?p=inicio"  class="btn btn-primary btn-block">Fazer outra busca</a>
												</div>
											</div>
										</section>			
										<?php 
										break;	
										case "pj":
										$pessoa = retornaPessoa($_GET['id'],2);	

										?>
										<section id="inserir" class="home-section bg-white">
											<div class="container">
												<div class="row">
													<div class="col-md-offset-2 col-md-8">

														

														
													</div>
												</div> 
												
												<div class="row">
													<div class="col-md-offset-1 col-md-10">
														<?php 
														$pessoa = retornaPessoa($_GET['id'],2);
														
														?>
														Razão Social: <?php echo $pessoa['nome']; ?><br />
														CNPJ: <?php echo $pessoa['cpf_cnpj']; ?><br />
														Email: <?php echo $pessoa['email']; ?><br />
													</div>
												</div>
												<br /><Br />
												<div class="row">
													<div class="col-md-offset-1 col-md-10">
														<?php 
														$sql_ped = "SELECT DISTINCT idPedidoContratacao FROM sc_contratacao WHERE sc_contratacao.publicado = '1' AND  tipoPessoa = '2' AND idPessoa = '".$_GET['id']."' AND idEvento IN(SELECT idEvento FROM sc_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL)";
														$res = $wpdb->get_results($sql_ped,ARRAY_A);
			 //echo $sql_ped;
			 //var_dump($res);
														?>
														<p>Pedidos de contratação (<?php echo count($res); ?>)</p>

														<?php 

														for($i = 0; $i < count($res); $i++){
															$pes = retornaPedido($res[$i]['idPedidoContratacao']);
				//echo "<pre>";
				 //var_dump($pes);
				// echo "</pre>";
															?>
															Objeto: <a href = "busca.php?p=view&tipo=evento&id=<?php echo $pes['id']; ?>" target="_blank"><?php echo $pes['objeto']; ?></a><br />
															Período: <?php echo $pes['periodo']; ?><br />
															Local: <?php echo $pes['local']; ?><br />
															Projeto / Ficha: <?php echo $pes['projeto']; ?> / <?php echo $pes['ficha']; ?><br />
															Valor: <?php echo ($pes['valor']); ?><br />
															<br /><br />
														<?php } ?>
														
													</div>
												</div>
												<br /><br />
												<div class="row">
													<div class="col-md-offset-1 col-md-10">
														<a href="?p=inicio"  class="btn btn-primary btn-block">Fazer outra busca</a>
													</div>
												</div>
											</section>	
											<?php
											break;	
											case "pf":
											$pessoa = retornaPessoa($_GET['id'],1);	

											?>	
											<section id="inserir" class="home-section bg-white">
												<div class="container">
													<div class="row">
														<div class="col-md-offset-2 col-md-8">
															<h2><a href="?p=inicio"  class="btn btn-primary btn-block">Fazer outra busca</a></h2>
															
															<br /><br />
															
														</div>
													</div> 
													
													<div class="row">
														<div class="col-md-offset-1 col-md-10">
															<h2><?php echo $pessoa['nome']; ?></h2>
															<br />

															<?php 

															?>
														</div>
													</div>
													
													<div class="row">
														<div class="col-md-offset-1 col-md-10">
															
														</div>
													</div>
													<br /><br />
													<div class="row">
														<div class="col-md-offset-1 col-md-10">
															<a href="?p=inicio"  class="btn btn-primary btn-block">Fazer outra busca</a>
														</div>
													</div>
												</section>			
												
												<?php
												break;	
												case "pedido":
												$pedido = retornaPedido($_GET['id']);
												$evento = evento($pedido['id']);

												?>	
												
												<section id="inserir" class="home-section bg-white">
													<div class="container">
														<div class="row">
															<div class="col-md-offset-2 col-md-8">

																
																<br /><br />
																
															</div>
														</div> 
														
														<div class="row">
															<div class="col-md-offset-1 col-md-10">
																<h2></h2>

															</div>
														</div>
														
														<div class="row">
															<div class="col-md-offset-1 col-md-10">
																<?php 
																echo "<pre>";
																var_dump($pedido);
																echo "</pre>";

																echo "<pre>";
																var_dump($evento);
																echo "</pre>";

																
																?>
															</div>
														</div>
														<div>
														</section>			
														<?php 
														break;	
														case "pj":
														$pessoa = retornaPessoa($_GET['id'],2);	

														?>
														<section id="inserir" class="home-section bg-white">
															<div class="container">
																<div class="row">
																	<div class="col-md-offset-2 col-md-8">
																		<h2><a href="?p=inicio"  class="btn btn-primary btn-block">Fazer outra busca</a></h2>	
																	</div>
																</div> 
																
																<div class="row">
																	<div class="col-md-offset-1 col-md-10">
																		
																		
																	</div>
																</div>
																
																<div class="row">
																	<div class="col-md-offset-1 col-md-10">
																		
																	</div>
																</div>
																<div>
																</section>		
																<?php
																break;	
	}// fim switch view


	?>


	
	<?php 
	break;
} // fim da switch p
?>		

</main>
</div>
</div>

<?php 
include "footer.php";
?>