<?php include "barra.php"; ?>
<!--<link rel="stylesheet" href="css/CSS.css" type="text/css"> -->

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

      <!-- Aqui começa a lista de editais dos Territórios de Cultura -->

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
          $jurados = array(1,79,134,166,167,168,169);
          if(in_array($user->ID,$jurados)){
              ?>
              <a class="nav-link" href="inscricoes.php?edital=606"> FASE 1 - Territórios 2020</a>
          <?php } ?>

          <?php
          $peruser = array(1,79,134,166,167,168,169);
          if(in_array($user->ID,$peruser)){ ?>
              <li class="nav-item">
                  <a class="nav-link" href="ranking.php?edital=606">Ranking Territórios 2020</a>
              </li>
          <?php } ?>

      <!-- Aqui começa a lista de editais do Aniversário da Cidade -->

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
    $peruser = array(1);//,5,20,70,136,137,139,6,13,146//
    if(in_array($user->ID,$peruser)){ ?>
      <li class="nav-item">
          <a class="nav-link" href="ranking_aniversario.php?edital=429">Ranking Aniversário 2019</a>
      </li>
    <?php } ?>


    <?php
      $jurados = array(1);
      if(in_array($user->ID,$jurados)){
          ?>
          <a class="nav-link" href="inscricoes.php?edital=579">FASE 1 - Aniversário 2020</a>
    <?php } ?>


    <?php
      $peruser = array(1,16,68,70);
      if(in_array($user->ID,$peruser)){ ?>
          <li class="nav-item">
              <a class="nav-link" href="edital2fase_categ.php?edital=579">FASE 2 - Aniversário 2020</a>
          </li>
    <?php } ?>

    <?php
    $peruser = array(1,16,68,70);
    if(in_array($user->ID,$peruser)){ ?>
      <li class="nav-item">
          <a class="nav-link" href="ranking_aniversario.php?edital=579">Ranking Aniversário 2020</a>
      </li>
    <?php } ?>

    <!-- Aqui começa a lista de editais do Fundo de Cultura -->
    <?php
    $jurados = array(1,16,68,164,165,172);
    if(in_array($user->ID,$jurados)){
      ?>
      <a class="nav-link" href="inscricoes.php?edital=577">FASE 1 - Fundo de Cultura 2020</a>
    <?php } ?>

    <?php
    $peruser = array(1);
    if(in_array($user->ID,$peruser)){ ?>
      <li class="nav-item">
          <a class="nav-link" href="edital2fase.php?edital=577">FASE 2 - Fundo de Cultura 2020</a>
      </li>
    <?php } ?>

      <?php
      $peruser = array(1,5,6,7,87,173,176,177,178,179);
      if(in_array($user->ID,$peruser)){ ?>
          <li class="nav-item">
              <a class="nav-link" href="ranking.php?edital=577">Ranking Fundo de Cultura 2020</a>
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
  $peruser = array(1);
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
$jurados = array(1,72,150,155,173,174,175);
if(in_array($user->ID,$jurados)){
  ?>
  <a class="nav-link" href="inscricoes.php?edital=687">FASE 1 - FIP 2020</a>
<?php } ?>

<?php
$jurados = array(1);
if(in_array($user->ID,$jurados)){
  ?>
  <a class="nav-link" href="edital2fase_categ.php?edital=687">FASE 2 - FIP 2020</a>
<?php } ?>

<?php
$peruser = array(1,72,150,155,173,174,175);
if(in_array($user->ID,$peruser)){ ?>
  <li class="nav-item">
      <a class="nav-link" href="ranking_fip.php?edital=687">Ranking FIP 2020</a>
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

          <?php
          $peruser = array(1,183,184,185,186,187,188,47,76,45,33,134,79,70);
          if(in_array($user->ID,$peruser)){ ?>
              <li class="nav-item">
                  <a class="nav-link" href="inscricoes.php?edital=797">Edital de Premios LAB</a>
              </li>
          <?php } ?>

          <?php
          $peruser = array(1);
          if(in_array($user->ID,$peruser)){ ?>
          <li class="nav-item">
              <a class="nav-link" href="ranking.php?edital=797">Ranking Edital de Premios LAB 2020</a>
          </li>
          <?php } ?>

          <?php
          $peruser = array(1,189,190,191,174,77,151,52,66,70);
          if(in_array($user->ID,$peruser)){ ?>
              <li class="nav-item">
                  <a class="nav-link" href="inscricoes.php?edital=788">Edital de Projetos LAB</a>
              </li>
          <?php } ?>

          <?php
          $peruser = array(1);
          if(in_array($user->ID,$peruser)){ ?>
              <li class="nav-item">
                  <a class="nav-link" href="ranking.php?edital=788">Ranking Edital de Projetos LAB 2020</a>
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

<script>
  /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
  var dropdown = document.getElementsByClassName("dropdown-btn");
  var i;

  for (i = 0; i < dropdown.length; i++) {
      dropdown[i].addEventListener("click", function() {
          this.classList.toggle("active");
          var dropdownContent = this.nextElementSibling;
          if (dropdownContent.style.display === "block") {
              dropdownContent.style.display = "none";
          } else {
              dropdownContent.style.display = "block";
          }
      });
  }
</script>
