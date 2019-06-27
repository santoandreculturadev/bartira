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