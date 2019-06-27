<?php include "barra.php"; ?>


<div class="container-fluid">
  <div class="row">
    <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">

      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#">Módulo Dados (beta) <span class="sr-only">(current)</span></a>
        </li>
      </ul>
      

      <?php 
      
      ?>
      <ul class="nav nav-pills flex-column">
       <li class="nav-item">
        <a class="nav-link" href="dados.php?p=visaogeral">Orçamento Planejado</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="dados.php?p=eventos">Eventos</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="dados.php?p=atividades">Atividades</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#">Público</a>
      </li>
    </ul>

    <?php 
    ?>
    
    <ul class="nav nav-pills flex-column">
      <li class="nav-item">
        <a class="nav-link" href="../wp-login.php?action=logout">Sair</a>
      </li>
    </ul>
  </nav>
