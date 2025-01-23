<?php include "header.php"; 
// libera todas as sessions
session_unset(); 
?>

<body>

  <?php include "menu/me_inicio.php"; ?>
  
  <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
      <h1>Início</h1>
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

      <section id="inserir" class="home-section bg-white">
        <div class="container">
            <div class="row">

            <div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>

						<th>Liberação</th>
						<th>Pessoa</th>
						<th>Nome / Razão Social</th>
						<th><a href="?p=pedido<?php if(isset($_GET['order'])){ echo ""; }else{ echo "&order"; }  ?>">Objeto</a></th>
						<th>Período</th>
						<th>Valor</th>
						<th>Empenho</th>
						<th>OP</th>
						
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>

                <?php 
                 $pedido = dashboard("ultimosPedidos","1",""); 
                
                for($i = 0; $i < 6; $i++){
                ?>

						<tr>

							<td><?php if($pedido[$i]['pedido']['liberado'] != '0000-00-00'){echo exibirDataBr($pedido['liberado']);} ?></td>

							
							<td><?php echo $pedido[$i]['pedido']['tipoPessoa']; ?></td>
							<td><?php echo $pedido[$i]['pedido']['nome']; ?></td>
							<td><?php echo $pedido[$i]['pedido']['objeto']; ?></td>
							<td><?php echo $pedido[$i]['pedido']['periodo']; ?></td>
							<td><?php echo dinheiroParaBr($peds[$i]['valor']); ?></td>
							<td><?php if(isset($contabil[0]['empenho'])){echo $contabil[0]['empenho']; }?></td>
							<td><?php if(isset($contabil[0]['v_op_baixado'])){echo dinheiroParaBr($contabil[0]['v_op_baixado']); }?></td>
							
							<?php if($pedido['tipo'] == 'Pessoa Física'){ ?>
								<td>	
									<form method="POST" action="contratacao.php?p=editar_pf" class="form-horizontal" role="form">
										<input type="hidden" name="editar_pf" value="<?php echo $peds[$i]['idPessoa']; ?>" />
										<input type="submit" class="btn btn-theme btn-sm btn-block" value="Editar Pessoa">
									</form>
								</td>
							<?php }else{ ?>
								<td>	
									<form method="POST" action="contratacao.php?p=editar_pj" class="form-horizontal" role="form">
										<input type="hidden" name="editar_pj" value="<?php echo $peds[$i]['idPessoa']; ?>" />
										<input type="submit" class="btn btn-theme btn-sm btn-block" value="Ed Pessoa">
									</form>
								</td>
							<?php } ?>

							<td>	
								<form method="POST" action="contratacao.php?p=editar_pedido" class="form-horizontal" role="form">
									<input type="hidden" name="editar_pedido" value="<?php echo $peds[$i]['idPedidoContratacao']; ?>" />
									<input type="submit" class="btn btn-theme btn-sm btn-block" value="Ed Pedido">
								</form>
								<?php 
								
								?></td>
								<td>	
									
									<?php 
									
									?></td>

								</tr>
							<?php } // fim do for?>	
							
						</tbody>
					</table>
				</div>


            <div class="col-md-offset-2 col-md-8">


        </div>
                <div class="col-md-offset-2 col-md-8">
                    <?php
                    $paged = 1;
                    $loop = new WP_Query( array( 'post_type' => 'post_scpsa', 'paged' => $paged ) );
                    if ( $loop->have_posts() ) :
                        while ( $loop->have_posts() ) : $loop->the_post(); ?>
                            <div class="pindex">
                                <?php if ( has_post_thumbnail() ) { ?>
                                    <div class="pimage">
                                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                                    </div>
                                <?php } ?>
                                <div class="ptitle">
                                    <h2><?php echo get_the_title(); ?></h2>
                                </div>
                            </div>
                            <div class="ptitle">
                                <p><?php echo get_the_content(); ?></p>
                                ´<p></p>
                            </div>
                        <?php endwhile;
                        if (  $loop->max_num_pages > 1 ) : ?>
                            <div id="nav-below" class="navigation">
                                <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Previous', 'domain' ) ); ?></div>
                                <div class="nav-next"><?php previous_posts_link( __( 'Next <span class="meta-nav">&rarr;</span>', 'domain' ) ); ?></div>
                            </div>
                        <?php endif;
                    endif;
                    wp_reset_postdata();
                    ?>		
                </div>
            </div> 
        </div>
    </section>		
  
</main>
</div>
</div>


<?php 
include "footer.php";
?>