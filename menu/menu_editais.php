<?php include "barra.php"; ?>


<div class="container-fluid">
  <div class="row">
    <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Início <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="editais.php">Editais</a>
        </li>
        
        <?php
        $jurados = array(1);
        if(in_array($user->ID,$jurados)){
         ?>
         <a class="nav-link" href="inscricoes.php?edital=423"> FASE 1 - Territórios 2019</a>
       <?php } ?>

       <?php 
       $peruser = array(1,132,134,133,26,84,79,6,45);
       if(in_array($user->ID,$peruser)){ ?>
        <li class="nav-item">
          <a class="nav-link" href="ranking.php?edital=423">Ranking Territórios 2019</a>
        </li>
      <?php } ?>
      
      <?php
      $jurados = array(1);
      if(in_array($user->ID,$jurados)){
       ?>
       <a class="nav-link" href="inscricoes.php?edital=429">FASE 1 - Aniversário 2019</a>
     <?php } ?>


     <?php 
     $peruser = array(1);
     if(in_array($user->ID,$peruser)){ ?>
      <li class="nav-item">
        <a class="nav-link" href="edital2fase_categ.php?edital=429">FASE 2 - Aniversário 2019</a>
      </li>
    <?php } ?>

    <?php 
    $peruser = array(1,5,20,70,136,137,139,6,13,146);
    if(in_array($user->ID,$peruser)){ ?>
      <li class="nav-item">
        <a class="nav-link" href="ranking_aniversario.php?edital=429">Ranking Aniversário 2019</a>
      </li>
    <?php } ?>

    <?php
    $jurados = array(1);
    if(in_array($user->ID,$jurados)){
     ?>
     <a class="nav-link" href="inscricoes.php?edital=445">FASE 1 - Fundo de Cultura 2019</a>
   <?php } ?>

   <?php 
   $peruser = array(1);
   if(in_array($user->ID,$peruser)){ ?>
    <li class="nav-item">
      <a class="nav-link" href="edital2fase.php?edital=445">FASE 2 - Fundo de Cultura 2019</a>
    </li>
  <?php } ?>

  <?php 
  $peruser = array(1,16,5,6);
  if(in_array($user->ID,$peruser)){ ?>
    <li class="nav-item">
      <a class="nav-link" href="ranking.php?edital=445">Ranking Fundo de Cultura 2019</a>
    </li>
  <?php } ?>

  <?php
  $jurados = array(1);
  if(in_array($user->ID,$jurados)){
   ?>
   <a class="nav-link" href="inscricoes.php?edital=482">FASE 1 - FIP 2019</a>
 <?php } ?>

 <?php
 $jurados = array(1,13,70);
 if(in_array($user->ID,$jurados)){
   ?>
   <a class="nav-link" href="edital2fase_categ.php?edital=482">FASE 2 - FIP 2019</a>
 <?php } ?>

 <?php 
 $peruser = array(1,68,70,77,147,148,149,5,6,13);
 if(in_array($user->ID,$peruser)){ ?>
  <li class="nav-item">
    <a class="nav-link" href="ranking_fip.php?edital=482">Ranking FIP 2019</a>
  </li>
<?php } ?>

<?php
$jurados = array(1);
if(in_array($user->ID,$jurados)){
 ?>
 <a class="nav-link" href="inscricoes.php?edital=491">FASE 1 - Marcos Simbólicos de Santo André</a>
<?php } ?>

<?php
$jurados = array(1);
if(in_array($user->ID,$jurados)){
 ?>
 <a class="nav-link" href="edital2fase.php?edital=491">Marcos Simbólicos de Santo André</a>
<?php } ?>

<?php 
$peruser = array(1,139,5,6);
if(in_array($user->ID,$peruser)){ ?>
  <li class="nav-item">
    <a class="nav-link" href="ranking_marcos.php?edital=491">Ranking Marcos Simbólicos de Santo André</a>
  </li>
<?php } ?>


<?php ?>
<li class="nav-item">
  <a class="nav-link" href="http://culturaz.santoandre.sp.gov.br/autenticacao/" target="_blanck"> Login CulturAZ</a>
</li>           
</ul>


<ul class="nav nav-pills flex-column">
  <li class="nav-item">
    <a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
  </li>
</ul>
</nav>
