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
        if($user->ID == 1 OR $user->ID == 16 ){
         ?>
         <li class="nav-item">
          <a class="nav-link" href="edital2fase.php?edital=273">Inscrições</a>
        </li>
      <?php } ?>
      
      <li class="nav-item">
        <a class="nav-link" href="inscricoes.php?p=all"> Todas as Inscrições (Consulta)</a>
      </li>
      <?php 
      
      $peruser = array(2,1,5,6,7);
      if(in_array($user->ID,$peruser)){ ?>
        <li class="nav-item">
          <a class="nav-link" href="ranking.php?edital=273"> Ranking Aniversário</a>
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
